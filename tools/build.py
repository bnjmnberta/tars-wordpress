"""Packs the TARS theme into dist/tars.zip, ready for Apariencia → Temas → Añadir nuevo → Subir tema.

The home page shares its CSS, JS and media with the static site (bnjmnberta/tars-web). With
--site, those shared files are first copied over from a checkout of that site, so a change made
there reaches the theme without editing anything twice:

    python tools/build.py                          # zip the theme as it is
    python tools/build.py --site ../Imagenes/web   # pull the site's files first, then zip
"""
import argparse
import shutil
import zipfile
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
DIST = ROOT / "dist"

# files the theme takes unchanged from the static site
SITE_FILES = [
    "css/style.css",
    "js/main.js",
    "js/loader.js",
    "js/mail.js",
    "assets/favicon.png",
    "assets/logo-mark-nav.png",
    "assets/logo-lockup.png",
    "assets/logo-tars.png",
    "assets/grain.jpg",
    "assets/hero-topo.mp4",
    "assets/hero-topo-720.mp4",
    "assets/hero-topo-poster.jpg",
]
SITE_DIRS = ["assets/fonts", "assets/trail"]

# repo files that are not part of the theme
NOT_THEME = {".git", ".gitignore", "dist", "tools", "README.md"}


def sync(site: Path) -> None:
    for rel in SITE_FILES:
        (ROOT / rel).parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(site / rel, ROOT / rel)
    for rel in SITE_DIRS:
        shutil.rmtree(ROOT / rel, ignore_errors=True)
        shutil.copytree(site / rel, ROOT / rel)
    screenshot(ROOT / "screenshot.png")
    print(f"archivos del sitio copiados desde {site}")


def screenshot(dest: Path) -> None:
    """1200x900 preview for the theme picker: the hero poster with the TARS lockup."""
    import numpy as np
    from PIL import Image, ImageDraw

    bg = Image.open(ROOT / "assets/hero-topo-poster.jpg").convert("RGB")
    w, h = 1200, 900
    scale = max(w / bg.width, h / bg.height)
    bg = bg.resize((round(bg.width * scale), round(bg.height * scale)), Image.LANCZOS)
    left, top = (bg.width - w) // 2, (bg.height - h) // 2
    bg = bg.crop((left, top, left + w, top + h))
    bg = Image.blend(Image.new("RGB", (w, h), (10, 10, 10)), bg, 0.45)
    logo = Image.open(ROOT / "assets/logo-lockup.png").convert("RGB")
    lw = 760
    logo = logo.resize((lw, round(logo.height * lw / logo.width)), Image.LANCZOS)
    # the lockup ships on black: lighten-blend it so only the white mark shows
    box = ((w - lw) // 2, (h - logo.height) // 2, (w + lw) // 2, (h + logo.height) // 2)
    region = Image.fromarray(np.maximum(np.asarray(bg.crop(box)), np.asarray(logo)))
    bg.paste(region, box[:2])
    ImageDraw.Draw(bg).rectangle([0, h - 14, w, h], fill=(0, 226, 138))
    bg.save(dest, optimize=True)


def pack() -> Path:
    DIST.mkdir(exist_ok=True)
    zip_path = DIST / "tars.zip"
    zip_path.unlink(missing_ok=True)
    with zipfile.ZipFile(zip_path, "w", zipfile.ZIP_DEFLATED) as z:
        for f in sorted(ROOT.rglob("*")):
            rel = f.relative_to(ROOT)
            if f.is_file() and rel.parts[0] not in NOT_THEME:
                z.write(f, Path("tars") / rel)
    return zip_path


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("--site", type=Path, help="checkout of the static site to copy shared files from")
    args = parser.parse_args()
    if args.site:
        sync(args.site.resolve())
    zip_path = pack()
    print(f"zip: {zip_path} ({zip_path.stat().st_size / 1e6:.1f} MB)")


if __name__ == "__main__":
    main()
