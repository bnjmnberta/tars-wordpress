# Seguridad del sitio TARS

Lo que el tema ya hace solo (`inc/security.php` y `inc/mail-send.php`) y lo que queda por hacer en el
hosting y en WordPress. Antes de lanzar, repasá la lista completa.

## Ya lo hace el tema

- XML-RPC apagado (`xmlrpc.php` responde 403).
- Las listas de usuarios están cerradas: `?author=1` redirige al inicio y `/wp-json/wp/v2/users` no existe para
  quien no entró.
- Los errores del login son genéricos: no dicen si falló el usuario o la clave.
- Límite de intentos en `wp-login.php`: 5 fallos en 15 minutos bloquean a esa persona durante 15 minutos.
- Encabezados de seguridad: `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`,
  `Permissions-Policy`, `Cross-Origin-Opener-Policy` y `Strict-Transport-Security` (solo con https).
- Sin la versión de WordPress en la página.
- Editor de archivos del panel desactivado (`DISALLOW_FILE_EDIT`).
- Formulario de Mail: nonce, campo oculto contra bots, un mensaje cada 20 segundos y cinco por hora por visitante,
  y un tope de 100 mensajes por día en todo el sitio. Con Cloudflare Turnstile activado, también verifica que sea una
  persona.

## Lo que hay que hacer (una sola vez)

### Antes de lanzar
1. **Actualizar** WordPress, el tema y los plugins. En Hostinger: activar las actualizaciones automáticas inteligentes.
2. **Cuenta de administrador:** sin el usuario `admin`, con contraseña larga y única (administrador de contraseñas).
3. **Verificación en dos pasos (2FA)** para todos los administradores: plugin WP 2FA o similar. Guardar los
   códigos de respaldo.
4. **Pocos plugins, y solo de wordpress.org.** Nunca plugins ni temas "nulled" o crackeados. Borrar lo que no se use.
5. **Https obligatorio** (Hostinger incluye el certificado) y redirigir http a https.
6. **Copias de seguridad** fuera del hosting (por ejemplo UpdraftPlus a Google Drive) y probar restaurar una vez.
   En el plan Premium las copias de Hostinger son semanales.
7. **Archivos:** carpetas en 755 y archivos en 644; `wp-config.php` en 440 o 400.
8. **Base de datos:** una base y un usuario propios para este sitio, con contraseña distinta a la de otros sitios.
9. **Correo del dominio:** registros SPF, DKIM y DMARC (Hostinger los muestra en la sección de correo).
10. **Borrar** `readme.html` y `license.txt` de la raíz de WordPress.

### Cloudflare (necesita el dominio propio)
1. Crear la cuenta gratis, agregar el dominio y delegar los servidores de nombres en NIC Argentina.
2. En SSL/TLS, modo **Full (strict)**.
3. En Seguridad → Reglas WAF → Límite de pedidos: 10 pedidos por minuto por IP a `/wp-login.php`.
4. Activar **Bot Fight Mode**.
5. Turnstile (anti-bots del formulario): crear un sitio en Cloudflare → Turnstile, y pegar las dos claves en
   Apariencia → Personalizar → TARS → Contacto y datos.

### Después de lanzar
- Un aviso si el sitio se cae: UptimeRobot (gratis).
- Registro de errores: activar `WP_DEBUG_LOG` solo mientras se investiga algo, y mirar los registros del hosting.
- Revisar una vez por semana si hay actualizaciones pendientes.
- Pasar el sitio por **securityheaders.com**, **Mozilla Observatory** y **SSL Labs** y mirar la nota.

## Si algo sale mal
1. No borrar nada todavía: sacar una copia de lo que hay.
2. Cambiar todas las contraseñas (WordPress, Hostinger, base de datos, correo).
3. Restaurar la última copia limpia.
4. Actualizar todo y repasar los usuarios del panel.
