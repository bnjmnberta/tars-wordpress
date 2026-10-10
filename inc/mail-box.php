<?php
/**
 * The mail composer that opens under the contact buttons (js/mail.js). Same markup as the static site.
 */
?>
    <div class="mailbox" id="mail">
      <div class="mailbox__clip">
        <div class="mailbox__inner">
          <header class="mailbox__head">
            <h3 class="mailbox__title" tabindex="-1" data-mail-title>Armá tu mail</h3>
            <p class="mailbox__lead">Completá lo que puedas y, cuando esté listo, lo abrís en tu correo o en Gmail con todo cargado.</p>
          </header>

            <form class="mailform" id="mailform" data-to="<?php echo esc_attr( sanitize_email( tars_mod( 'email' ) ) ); ?>" novalidate>

              <fieldset class="field">
                <legend>¿Qué necesitás?</legend>
                <div class="chips">
                  <label class="chip" style="--hue:var(--c-green);--ink:var(--c-black)"><input type="checkbox" name="service" value="<?php echo esc_attr( tars_mod( 'service_1_title' ) ); ?>"><span><?php echo esc_html( tars_mod( 'service_1_title' ) ); ?></span></label>
                  <label class="chip" style="--hue:var(--c-blue-deep);--ink:var(--c-white)"><input type="checkbox" name="service" value="<?php echo esc_attr( tars_mod( 'service_2_title' ) ); ?>"><span><?php echo esc_html( tars_mod( 'service_2_title' ) ); ?></span></label>
                  <label class="chip" style="--hue:var(--c-yellow);--ink:var(--c-black)"><input type="checkbox" name="service" value="<?php echo esc_attr( tars_mod( 'service_3_title' ) ); ?>"><span><?php echo esc_html( tars_mod( 'service_3_title' ) ); ?></span></label>
                  <label class="chip" style="--hue:var(--c-maroon);--ink:var(--c-white)"><input type="checkbox" name="service" value="<?php echo esc_attr( tars_mod( 'service_4_title' ) ); ?>"><span><?php echo esc_html( tars_mod( 'service_4_title' ) ); ?></span></label>
                  <label class="chip" style="--hue:var(--c-cyan);--ink:var(--c-black)"><input type="checkbox" name="service" value="<?php echo esc_attr( tars_mod( 'service_5_title' ) ); ?>"><span><?php echo esc_html( tars_mod( 'service_5_title' ) ); ?></span></label>
                  <label class="chip" style="--hue:var(--c-black);--ink:var(--c-white)"><input type="checkbox" name="service" value="Otra consulta"><span>Otra consulta</span></label>
                </div>
              </fieldset>

              <div class="field-row">
                <div class="field">
                  <label for="f-name">Tu nombre <b aria-hidden="true">*</b></label>
                  <input id="f-name" name="name" type="text" autocomplete="name" required aria-describedby="e-name">
                  <p class="field__error" id="e-name" hidden>Decinos cómo te llamás.</p>
                </div>
                <div class="field">
                  <label for="f-company">Negocio o proyecto</label>
                  <input id="f-company" name="company" type="text" autocomplete="organization">
                </div>
              </div>

              <div class="field-row">
                <div class="field">
                  <label for="f-email">Tu mail</label>
                  <input id="f-email" name="email" type="email" autocomplete="email" inputmode="email">
                </div>
                <div class="field">
                  <label for="f-phone">WhatsApp o teléfono</label>
                  <input id="f-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel">
                </div>
              </div>

              <div class="field">
                <label for="f-subject">Título del mail</label>
                <input id="f-subject" name="subject" type="text" placeholder="Ej: Quiero un logo para mi negocio" aria-describedby="h-subject">
                <p class="field__hint" id="h-subject">Si lo dejás vacío lo armamos con lo que elegiste y tu nombre.</p>
              </div>

              <div class="field">
                <label for="f-message">Tu mensaje <b aria-hidden="true">*</b></label>
                <textarea id="f-message" name="message" rows="7" required aria-describedby="h-message e-message" placeholder="Contanos qué necesitás, para quién es y qué querés lograr. Si ya tenés algo hecho (logo, redes, web), mencionalo."></textarea>
                <p class="field__hint" id="h-message">Cuanto más detalle, más rápido te respondemos con una propuesta.</p>
                <p class="field__error" id="e-message" hidden>Escribí un mensaje para poder armar el mail.</p>
              </div>

              <div class="field-row">
                <div class="field">
                  <label for="f-when">¿Para cuándo lo necesitás?</label>
                  <select id="f-when" name="when">
                    <option value="">Sin definir</option>
                    <option>Lo antes posible</option>
                    <option>En 1 o 2 semanas</option>
                    <option>Este mes</option>
                    <option>Sin apuro</option>
                  </select>
                </div>
                <div class="field">
                  <label for="f-links">Referencias o links</label>
                  <input id="f-links" name="links" type="text" placeholder="Instagram, web, ejemplos que te gusten" autocomplete="off">
                </div>
              </div>

              <div class="mailactions">
                <button type="button" class="btn btn--primary" data-act="mailto"><span>Abrir en mi correo</span> <span aria-hidden="true">→</span></button>
                <button type="button" class="btn" data-act="gmail"><span>Abrir en Gmail</span> <span aria-hidden="true">↗</span></button>
                <button type="button" class="btn" data-act="copy"><span>Copiar mensaje</span></button>
              </div>
              <p class="mailstatus" role="status" aria-live="polite" data-status></p>
              <div class="mailfoot">
                <p>¿Preferís hablar? Escribinos por <a href="<?php echo esc_url( tars_whatsapp_url( true ) ); ?>" target="_blank" rel="noopener">WhatsApp</a>.</p>
                <button type="reset" class="mailform__reset">Borrar todo</button>
              </div>
            </form>
        </div>
      </div>
    </div>
