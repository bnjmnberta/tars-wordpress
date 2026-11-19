---
type: referencia
tags: [tars/producto, wordpress, sub/producto-web]
aliases: [Tema de WordPress]
---

# TARS — tema de WordPress

Tema de WordPress de [[TARS]] (TARS Soluciones Digitales). Mapa: [[MOC Clientes y Producto]]. La portada es la misma página que el sitio estático
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

- **Contacto y datos**: número de WhatsApp, mensaje inicial, Instagram, mail, ubicación, descripción para Google y el responsable de los datos (nombre y domicilio, que la ley de protección de datos exige mostrar junto al formulario y en el pie).
- **Portada**: textos del hero y de la cinta.
- **Servicios**: título y texto de las 5 tarjetas. Las palabras entre `*asteriscos*` salen resaltadas en la tipografía itálica.
- **Cómo trabajamos**: título y los 4 pasos.
- **Sección Contacto**: textos del cierre.

Los menús (**Apariencia → Menús**) tienen dos ubicaciones: el menú de pantalla completa y el pie de página.
Sin menú asignado se usan Servicios / Proceso / Contacto.

Páginas, entradas de blog, búsqueda y 404 usan el mismo estilo. Es compatible con Rank Math o Yoast para SEO.

## Medición, privacidad y buscadores

- **Google Analytics 4:** pegar el código `G-...` en *Personalizar → TARS → Contacto y datos*. Solo mide si la
  persona acepta el aviso de cookies, y no cuenta las visitas de quien edita el sitio.
- **Página de privacidad:** crearla en *Ajustes → Privacidad*. El tema la enlaza en el pie y en el aviso de cookies.
- **Vista previa al compartir:** el tema agrega las etiquetas Open Graph y Twitter (imagen `assets/og-image.jpg`) y los
  datos estructurados del estudio en la portada, salvo que haya un plugin de SEO activo.
- **Buscadores:** WordPress ya genera `/wp-sitemap.xml`. Dejar desmarcado *Ajustes → Lectura → Disuadir a los motores
  de búsqueda*.

## Seguridad

El tema cierra XML-RPC y las listas de usuarios, limita los intentos de login, manda encabezados de seguridad y
protege el formulario de Mail (nonce, campo oculto, límites y Cloudflare Turnstile opcional). Lo que hay que hacer
fuera del tema (actualizaciones, 2FA, copias, Cloudflare) está en [`SEGURIDAD.md`](SEGURIDAD.md).

## Estructura

| Archivo | Qué es |
|---|---|
| `front-page.php` | Portada (la página del sitio estático) |
| `header.php`, `footer.php` | Loader, navegación, menú, pie |
| `page.php`, `single.php`, `index.php`, `404.php` | Páginas, entradas, blog/búsqueda, error |
| `inc/content.php` | Textos por defecto y helpers |
| `inc/customizer.php` | Panel **TARS** del Personalizador |
| `inc/security.php` | Endurecimiento: XML-RPC, usuarios, login, encabezados |
| `inc/mail-send.php`, `inc/mail-box.php` | Formulario de Mail: envío y marcado |
| `SEGURIDAD.md` | Lista de seguridad para antes y después de lanzar |
| `css/style.css`, `js/`, `assets/` | Compartidos con el sitio estático, sin cambios |
| `css/wp.css` | Estilos solo de WordPress (páginas, blog, barra de admin) |
| `tools/build.py` | Arma `dist/tars.zip` |

## Actualizar desde el sitio estático

Si cambia el CSS, el JS o algún archivo de `assets/` en `tars-web`, se copian al tema y se arma el zip con:

```bash
python tools/build.py --site ../Imagenes/web
```

(`--site` apunta a la carpeta del sitio estático; requiere Pillow y NumPy para regenerar `screenshot.png`.)
