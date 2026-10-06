# TARS — tema de WordPress

Tema de WordPress de TARS Soluciones Digitales. La portada es la misma página que el sitio estático
([bnjmnberta/tars-web](https://github.com/bnjmnberta/tars-web)): mismo HTML, CSS, animaciones y
archivos. Los textos, el WhatsApp, el mail y los menús se editan desde el panel de WordPress.

## Instalar

1. Descargar `tars.zip` de la última versión en **Releases** (o generarlo con `python tools/build.py`).
2. En WordPress: **Apariencia → Temas → Añadir nuevo → Subir tema**, elegir `tars.zip` y activarlo.
3. **Ajustes → Enlaces permanentes → Guardar cambios** (una vez, para que funcionen las URLs de páginas y entradas).
4. Abrir el sitio siempre con la misma dirección configurada en **Ajustes → Generales** (con o sin `www`,
   con `https`). Si no coinciden, el navegador bloquea las tipografías y no se dibujan los textos de las tarjetas.

## Editar contenido

**Apariencia → Personalizar → TARS**:

- **Contacto y datos**: número de WhatsApp, mensaje inicial, Instagram, mail, ubicación y descripción para Google.
- **Portada**: textos del hero y de la cinta.
- **Servicios**: título y texto de las 5 tarjetas. Las palabras entre `*asteriscos*` salen resaltadas en la tipografía itálica.
- **Cómo trabajamos**: título y los 4 pasos.
- **Sección Contacto**: textos del cierre.

Los menús (**Apariencia → Menús**) tienen dos ubicaciones: el menú de pantalla completa y el pie de página.
Sin menú asignado se usan Servicios / Proceso / Contacto.

Páginas, entradas de blog, búsqueda y 404 usan el mismo estilo. Es compatible con Rank Math o Yoast para SEO.

## Estructura

| Archivo | Qué es |
|---|---|
| `front-page.php` | Portada (la página del sitio estático) |
| `header.php`, `footer.php` | Loader, navegación, menú, pie |
| `page.php`, `single.php`, `index.php`, `404.php` | Páginas, entradas, blog/búsqueda, error |
| `inc/content.php` | Textos por defecto y helpers |
| `inc/customizer.php` | Panel **TARS** del Personalizador |
| `css/style.css`, `js/`, `assets/` | Compartidos con el sitio estático, sin cambios |
| `css/wp.css` | Estilos solo de WordPress (páginas, blog, barra de admin) |
| `tools/build.py` | Arma `dist/tars.zip` |

## Actualizar desde el sitio estático

Si cambia el CSS, el JS o algún archivo de `assets/` en `tars-web`, se copian al tema y se arma el zip con:

```bash
python tools/build.py --site ../Imagenes/web
```

(`--site` apunta a la carpeta del sitio estático; requiere Pillow y NumPy para regenerar `screenshot.png`.)
