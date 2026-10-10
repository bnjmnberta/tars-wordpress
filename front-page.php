<?php
/**
 * Home page: hero, service cards, "cómo trabajamos" and contact — the same markup as the static
 * site, with every text coming from Apariencia → Personalizar (inc/content.php has the defaults).
 */
get_header();
$tars_marquee = esc_html( tars_mod( 'marquee' ) );
?>
  <section class="hero" id="top">
    <div class="hero__scene">
      <h1 class="sr-only"><?php echo esc_html( tars_mod( 'hero_h1' ) ); ?></h1>
      <video class="hero__video" data-hero-video autoplay muted loop playsinline preload="metadata" poster="<?php echo tars_uri( 'assets/hero-topo-poster.jpg' ); ?>" aria-hidden="true">
        <source src="<?php echo tars_uri( 'assets/hero-topo-720.mp4' ); ?>" type="video/mp4" media="(max-width: 900px)">
        <source src="<?php echo tars_uri( 'assets/hero-topo.mp4' ); ?>" type="video/mp4">
      </video>
      <button class="hero__pause" type="button" data-video-toggle aria-pressed="false" aria-label="Pausar video de fondo">
        <span class="hero__pause-icon" aria-hidden="true"></span>
      </button>
      <div class="hero__bgword" aria-hidden="true"><span><span class="hero__bgline"><i><?php echo esc_html( tars_mod( 'hero_line_1' ) ); ?></i></span><span class="hero__bgline"><i><?php echo esc_html( tars_mod( 'hero_line_2' ) ); ?></i></span></span></div>
      <div class="hero__frame" aria-hidden="true"></div>

      <img class="hero__brand" src="<?php echo tars_uri( 'assets/logo-lockup.png' ); ?>" alt="" data-reveal>

      <div class="hero__trail" data-trail aria-hidden="true">
        <img src="<?php echo tars_uri( 'assets/trail/i01.webp' ); ?>" alt="" width="520" height="520">
        <img src="<?php echo tars_uri( 'assets/trail/i02.webp' ); ?>" alt="" width="520" height="279">
        <img src="<?php echo tars_uri( 'assets/trail/i03.webp' ); ?>" alt="" width="434" height="520">
        <img src="<?php echo tars_uri( 'assets/trail/i04.webp' ); ?>" alt="" width="378" height="386">
        <img src="<?php echo tars_uri( 'assets/trail/i05.webp' ); ?>" alt="" width="445" height="446">
        <img src="<?php echo tars_uri( 'assets/trail/i07.webp' ); ?>" alt="" width="358" height="290">
        <img src="<?php echo tars_uri( 'assets/trail/i08.webp' ); ?>" alt="" width="520" height="520">
        <img src="<?php echo tars_uri( 'assets/trail/i10.webp' ); ?>" alt="" width="520" height="362">
        <img src="<?php echo tars_uri( 'assets/trail/i11.webp' ); ?>" alt="" width="420" height="520">
        <img src="<?php echo tars_uri( 'assets/trail/i12.webp' ); ?>" alt="" width="419" height="520">
      </div>
    </div>
  </section>

  <div class="marquee" aria-hidden="true">
    <div class="marquee__track" data-marquee>
      <span class="marquee__item"><?php echo $tars_marquee; ?><b class="marquee__sep" aria-hidden="true">/</b></span>
      <span class="marquee__item"><?php echo $tars_marquee; ?><b class="marquee__sep" aria-hidden="true">/</b></span>
      <span class="marquee__item"><?php echo $tars_marquee; ?><b class="marquee__sep" aria-hidden="true">/</b></span>
      <span class="marquee__item"><?php echo $tars_marquee; ?><b class="marquee__sep" aria-hidden="true">/</b></span>
    </div>
  </div>

  <section class="services" id="servicios" aria-labelledby="servicios-title">
    <h2 class="sr-only" id="servicios-title">Servicios</h2>
    <div class="stack">
      <div class="stack__step">
        <article class="stack__item stack__item--green">
        <div class="stack__shape">
          <div class="stack__art stack__art--logo" aria-hidden="true">
            <svg viewBox="150 100 785 895"><g class="art">
              <g data-step>
                <path d="M241.5,165.3 L390,123 L593.1,813.8 L440.8,857.1 Z"/>
                <circle class="pop" cx="323.1" cy="307.2" r="11.6"/>
              </g>
              <g data-step><path data-endfill d="M776.4,235.7 L912.5,311.8 L532.3,973.8 L396.2,897 Z"/></g>
              <g data-step><path d="M445.3,161.6 L598.9,116.4 L820.7,859.6 L666.9,904.9 Z"/></g>
              <g data-step><path d="M552.6,144 L684.6,217.2 L298.5,906.8 L167.5,834.6 Z"/></g>
            </g></svg>
          </div>
          <div class="stack__inner">
            <h3><?php echo esc_html( tars_mod( 'service_1_title' ) ); ?></h3>
            <div class="stack__expand">
              <p class="stack__why"><?php echo tars_rich( 'service_1_text' ); ?></p>
            </div>          </div>
        </div>
        </article>
      </div>

      <div class="stack__step">
        <article class="stack__item stack__item--blue">
        <div class="stack__shape">
          <div class="stack__art" aria-hidden="true">
            <svg viewBox="0 0 400 400"><g class="art">
              <g data-step transform="translate(135 175) rotate(-11)">
                <rect x="-75" y="-102" width="150" height="204"/>
                <rect x="-55" y="-82" width="110" height="38"/>
                <line x1="-55" y1="-22" x2="55" y2="-22"/>
                <line x1="-55" y1="-4" x2="35" y2="-4"/>
                <line x1="-55" y1="14" x2="45" y2="14"/>
                <line x1="-55" y1="64" x2="-5" y2="64"/>
              </g>
              <g data-step transform="translate(222 158) rotate(8)">
                <rect x="-75" y="-102" width="150" height="204"/>
                <circle cx="0" cy="-35" r="38"/>
                <line x1="-55" y1="30" x2="55" y2="30"/>
                <line x1="-55" y1="48" x2="25" y2="48"/>
                <rect x="-55" y="66" width="60" height="20"/>
              </g>
              <g data-step transform="translate(215 282) rotate(-4)">
                <rect x="-120" y="-72" width="240" height="144"/>
                <path data-endfill d="M-22,-34 L-22,26 L30,-4 Z"/>
                <line x1="-100" y1="50" x2="100" y2="50"/>
                <circle class="pop" cx="-30" cy="50" r="8"/>
              </g>
            </g></svg>
          </div>
          <div class="stack__inner">
            <h3><?php echo esc_html( tars_mod( 'service_2_title' ) ); ?></h3>
            <div class="stack__expand">
              <p class="stack__why"><?php echo tars_rich( 'service_2_text' ); ?></p>
            </div>          </div>
        </div>
        </article>
      </div>

      <div class="stack__step">
        <article class="stack__item stack__item--yellow">
        <div class="stack__shape">
          <div class="stack__art" aria-hidden="true">
            <svg viewBox="0 0 400 400"><g class="art">
              <g data-step transform="translate(150 200) rotate(-7)">
                <rect x="-78" y="-140" width="156" height="280"/>
                <line x1="-22" y1="-122" x2="22" y2="-122"/>
                <rect x="-58" y="-100" width="116" height="104"/>
                <path class="nofill" d="M-58,4 L-22,-40 L2,-14 L24,-36 L58,4"/>
                <circle cx="32" cy="-72" r="11"/>
                <line x1="-58" y1="30" x2="58" y2="30"/>
                <line x1="-58" y1="50" x2="18" y2="50"/>
                <line x1="-58" y1="70" x2="38" y2="70"/>
              </g>
              <g data-step transform="translate(285 120) rotate(5)">
                <path d="M-80,-42 L80,-42 L80,38 L-30,38 L-58,62 L-52,38 L-80,38 Z"/>
                <line x1="-58" y1="-14" x2="58" y2="-14"/>
                <line x1="-58" y1="8" x2="20" y2="8"/>
              </g>
              <g data-step transform="translate(300 250) rotate(-5)">
                <path d="M-62,-34 L62,-34 L62,30 L48,30 L54,52 L26,30 L-62,30 Z"/>
                <circle class="pop" cx="-26" cy="-2" r="7"/>
                <circle class="pop" cx="0" cy="-2" r="7"/>
                <circle class="pop" cx="26" cy="-2" r="7"/>
              </g>
              <g data-step transform="translate(110 320) rotate(-12)">
                <path data-endfill d="M0,34 C-34,8 -50,-14 -34,-34 C-21,-49 0,-42 0,-24 C0,-42 21,-49 34,-34 C50,-14 34,8 0,34 Z"/>
              </g>
            </g></svg>
          </div>
          <div class="stack__inner">
            <h3><?php echo esc_html( tars_mod( 'service_3_title' ) ); ?></h3>
            <div class="stack__expand">
              <p class="stack__why"><?php echo tars_rich( 'service_3_text' ); ?></p>
            </div>          </div>
        </div>
        </article>
      </div>

      <div class="stack__step">
        <article class="stack__item stack__item--maroon">
        <div class="stack__shape">
          <div class="stack__art" aria-hidden="true">
            <svg viewBox="0 0 400 400"><g class="art">
              <g data-step transform="translate(268 165) rotate(3)">
                <line x1="0" y1="-130" x2="0" y2="-152"/>
                <rect x="-62" y="-130" width="124" height="260"/>
                <rect x="-42" y="-108" width="18" height="22"/><rect x="-9" y="-108" width="18" height="22"/><rect x="24" y="-108" width="18" height="22"/><rect x="-42" y="-72" width="18" height="22"/><rect x="-9" y="-72" width="18" height="22"/><rect x="24" y="-72" width="18" height="22"/><rect x="-42" y="-36" width="18" height="22"/><rect x="-9" y="-36" width="18" height="22"/><rect x="24" y="-36" width="18" height="22"/><rect x="-42" y="0" width="18" height="22"/><rect x="-9" y="0" width="18" height="22"/><rect x="24" y="0" width="18" height="22"/><rect x="-42" y="36" width="18" height="22"/><rect x="-9" y="36" width="18" height="22"/><rect x="24" y="36" width="18" height="22"/>
              </g>
              <g data-step transform="translate(165 282) rotate(-3)">
                <path d="M-112,-22 L0,-100 L112,-22 L96,-22 L96,98 L-96,98 L-96,-22 Z"/>
                <rect data-endfill x="-20" y="38" width="40" height="60"/>
                <rect x="-78" y="4" width="42" height="42"/>
                <line x1="-57" y1="4" x2="-57" y2="46"/>
                <line x1="-78" y1="25" x2="-36" y2="25"/>
                <rect x="36" y="4" width="42" height="42"/>
                <line x1="57" y1="4" x2="57" y2="46"/>
                <line x1="36" y1="25" x2="78" y2="25"/>
              </g>
              <g data-step>
                <rect x="329" y="240" width="12" height="150"/>
                <g transform="translate(322 268) rotate(7)">
                  <rect x="-58" y="-34" width="116" height="68"/>
                  <line x1="-40" y1="-10" x2="40" y2="-10"/>
                  <line x1="-40" y1="10" x2="10" y2="10"/>
                </g>
              </g>
              <g data-step transform="translate(95 85) rotate(-8)">
                <line x1="-22" y1="0" x2="-52" y2="-16"/>
                <line x1="22" y1="0" x2="52" y2="-16"/>
                <ellipse cx="-52" cy="-22" rx="24" ry="6"/>
                <ellipse cx="52" cy="-22" rx="24" ry="6"/>
                <rect x="-24" y="-10" width="48" height="22"/>
                <circle class="pop" cx="0" cy="20" r="7"/>
              </g>
            </g></svg>
          </div>
          <div class="stack__inner">
            <h3><?php echo esc_html( tars_mod( 'service_4_title' ) ); ?></h3>
            <div class="stack__expand">
              <p class="stack__why"><?php echo tars_rich( 'service_4_text' ); ?></p>
            </div>          </div>
        </div>
        </article>
      </div>

      <div class="stack__step">
        <article class="stack__item stack__item--cyan">
        <div class="stack__shape">
          <div class="stack__art" aria-hidden="true">
            <svg viewBox="0 0 400 400"><g class="art">
              <g data-step transform="translate(182 175) rotate(-5)">
                <rect x="-150" y="-112" width="300" height="224"/>
                <line x1="-150" y1="-80" x2="150" y2="-80"/>
                <rect x="-70" y="-104" width="200" height="16"/>
                <circle class="pop" cx="-130" cy="-96" r="5"/>
                <circle class="pop" cx="-114" cy="-96" r="5"/>
                <circle class="pop" cx="-98" cy="-96" r="5"/>
                <rect x="-128" y="-64" width="256" height="70"/>
                <line x1="-108" y1="-40" x2="20" y2="-40"/>
                <line x1="-108" y1="-20" x2="-30" y2="-20"/>
                <rect x="-128" y="22" width="80" height="72"/>
                <rect x="-40" y="22" width="80" height="72"/>
                <rect x="48" y="22" width="80" height="72"/>
              </g>
              <g data-step transform="translate(318 268) rotate(7)">
                <rect x="-54" y="-96" width="108" height="192"/>
                <line x1="-16" y1="-82" x2="16" y2="-82"/>
                <rect x="-38" y="-66" width="76" height="52"/>
                <line x1="-38" y1="2" x2="38" y2="2"/>
                <line x1="-38" y1="18" x2="10" y2="18"/>
                <rect x="-38" y="34" width="76" height="44"/>
              </g>
              <g data-step transform="translate(200 268) rotate(-10)">
                <path data-endfill d="M0,0 L0,70 L17,54 L30,82 L44,75 L31,48 L54,48 Z"/>
              </g>
            </g></svg>
          </div>
          <div class="stack__inner">
            <h3><?php echo esc_html( tars_mod( 'service_5_title' ) ); ?></h3>
            <div class="stack__expand">
              <p class="stack__why"><?php echo tars_rich( 'service_5_text' ); ?></p>
            </div>            <div class="stack__cta">
              <a href="<?php echo esc_url( tars_section_url( 'contacto' ) ); ?>" class="btn"><?php echo esc_html( tars_mod( 'service_cta' ) ); ?> <span aria-hidden="true">→</span></a>
            </div>
          </div>
        </div>
        </article>
      </div>
    </div>
  </section>

  <section class="process" id="proceso" aria-labelledby="proceso-title">
    <div class="process__grid">
      <div class="process__intro">
        <p class="process__label"><?php echo esc_html( tars_mod( 'process_label' ) ); ?></p>
        <h2 class="process__title" id="proceso-title"><?php echo tars_rich( 'process_title' ); ?></h2>
      </div>
      <div class="process__track">
        <span class="process__rail" aria-hidden="true"><span class="process__rail-fill"></span></span>
        <ol class="process__steps">
          <li class="process__step" style="--hue:var(--c-green)">
            <span class="process__node" aria-hidden="true">
              <svg viewBox="0 0 32 32"><path d="M5 7h22v14H14l-6 5v-5H5z"/><path d="M10 12h12M10 16h8"/></svg>
            </span>
            <div class="process__body">
              <h3><?php echo esc_html( tars_mod( 'step_1_title' ) ); ?></h3>
              <p><?php echo esc_html( tars_mod( 'step_1_text' ) ); ?></p>
            </div>
          </li>
          <li class="process__step" style="--hue:var(--c-blue)">
            <span class="process__node" aria-hidden="true">
              <svg viewBox="0 0 32 32"><path d="M6 26l2-7L21 6l5 5L13 24z"/><path d="M18 9l5 5"/></svg>
            </span>
            <div class="process__body">
              <h3><?php echo esc_html( tars_mod( 'step_2_title' ) ); ?></h3>
              <p><?php echo esc_html( tars_mod( 'step_2_text' ) ); ?></p>
            </div>
          </li>
          <li class="process__step" style="--hue:var(--c-yellow)">
            <span class="process__node" aria-hidden="true">
              <svg viewBox="0 0 32 32"><path d="M6 9h20M6 16h20M6 23h20"/><circle class="knob" cx="12" cy="9" r="2.6"/><circle class="knob" cx="21" cy="16" r="2.6"/><circle class="knob" cx="14" cy="23" r="2.6"/></svg>
            </span>
            <div class="process__body">
              <h3><?php echo esc_html( tars_mod( 'step_3_title' ) ); ?></h3>
              <p><?php echo esc_html( tars_mod( 'step_3_text' ) ); ?></p>
            </div>
          </li>
          <li class="process__step" style="--hue:var(--c-cyan)">
            <span class="process__node" aria-hidden="true">
              <svg viewBox="0 0 32 32"><path d="M5 11l11-6 11 6v12l-11 6-11-6z"/><path d="M5 11l11 6 11-6M16 17v12"/></svg>
            </span>
            <div class="process__body">
              <h3><?php echo esc_html( tars_mod( 'step_4_title' ) ); ?></h3>
              <p><?php echo esc_html( tars_mod( 'step_4_text' ) ); ?></p>
            </div>
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="cta" id="contacto">
    <p class="cta__label" data-reveal><?php echo esc_html( tars_mod( 'cta_label' ) ); ?></p>
    <h2 data-reveal><?php echo esc_html( tars_mod( 'cta_title' ) ); ?> <span class="outline"><?php echo esc_html( tars_mod( 'cta_title_2' ) ); ?></span></h2>
    <div class="cta__buttons" data-reveal>
      <a href="<?php echo esc_url( tars_whatsapp_url( true ) ); ?>" class="btn btn--primary" target="_blank" rel="noopener">WhatsApp</a>
      <a href="<?php echo esc_url( tars_mod( 'instagram_url' ) ); ?>" class="btn" target="_blank" rel="noopener">Instagram</a>
      <button type="button" class="btn" data-mail-toggle aria-expanded="false" aria-controls="mail">Mail</button>
    </div>

<?php get_template_part( 'inc/mail-box' ); ?>
  </section>

<?php
get_footer();
