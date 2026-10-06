<?php
/**
 * Document head, loading screen (home only), nav bar and the full-screen menu.
 */
$tars_hues = array( 'var(--c-green)', 'var(--c-cyan)', 'var(--c-yellow)', 'var(--c-blue)', 'var(--c-white)' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main">Saltar al contenido</a>

<?php if ( is_front_page() ) : ?>
<div class="loader" id="loader" role="status" aria-live="polite" aria-label="Cargando <?php bloginfo( 'name' ); ?>">
	<!-- the TARS mark, traced 1:1 (same paths as the Logos card), listed back to front -->
	<svg class="loader__mark" viewBox="150 100 785 895" width="150" height="171" aria-hidden="true">
		<path class="bar" d="M241.5,165.3 L390,123 L593.1,813.8 L440.8,857.1 Z"/>
		<circle class="dot" cx="323.1" cy="307.2" r="11.6"/>
		<path class="bar bar--solid" d="M776.4,235.7 L912.5,311.8 L532.3,973.8 L396.2,897 Z"/>
		<path class="bar" d="M445.3,161.6 L598.9,116.4 L820.7,859.6 L666.9,904.9 Z"/>
		<path class="bar" d="M552.6,144 L684.6,217.2 L298.5,906.8 L167.5,834.6 Z"/>
	</svg>
</div>
<?php endif; ?>

<div class="grain-overlay" aria-hidden="true"></div>

<header class="nav" data-nav>
	<a href="<?php echo is_front_page() ? '#top' : esc_url( home_url( '/' ) ); ?>" class="nav__logo" aria-label="<?php bloginfo( 'name' ); ?>, inicio">
		<img src="<?php echo tars_uri( 'assets/logo-mark-nav.png' ); ?>" alt="" width="34" height="34">
		<span>TARS</span>
	</a>
	<a href="<?php echo esc_url( tars_section_url( 'contacto' ) ); ?>" class="btn btn--nav">Hablemos <span aria-hidden="true">→</span></a>
	<button class="nav__menu" type="button" data-menu-toggle aria-expanded="false" aria-controls="menu" aria-label="Abrir menú">
		<span class="nav__menu-label" data-menu-label>Menú</span>
		<span class="nav__menu-icon" aria-hidden="true"><i></i><i></i></span>
	</button>
</header>

<div class="menu" id="menu" data-menu role="dialog" aria-modal="true" aria-label="Menú principal" inert>
	<nav class="menu__nav" aria-label="Navegación principal">
		<?php foreach ( tars_menu_items( 'principal' ) as $i => $item ) : ?>
		<a class="menu__link" href="<?php echo esc_url( $item[1] ); ?>" data-menu-link style="--i:<?php echo (int) $i; ?>;--hue:<?php echo esc_attr( $tars_hues[ $i % count( $tars_hues ) ] ); ?>">
			<span class="menu__txt"><span class="menu__txt-in"><?php echo esc_html( $item[0] ); ?></span></span>
			<span class="menu__arrow" aria-hidden="true">→</span>
		</a>
		<?php endforeach; ?>
	</nav>
	<div class="menu__foot">
		<a class="menu__social" href="<?php echo esc_url( tars_whatsapp_url() ); ?>" target="_blank" rel="noopener" style="--hue:var(--c-green)"><span>WhatsApp</span><span aria-hidden="true">↗</span></a>
		<a class="menu__social" href="<?php echo esc_url( tars_mod( 'instagram_url' ) ); ?>" target="_blank" rel="noopener" style="--hue:var(--c-blue)"><span>Instagram</span><span aria-hidden="true">↗</span></a>
		<a class="menu__social" href="<?php echo tars_mailto(); ?>" style="--hue:var(--c-yellow)"><span>Mail</span><span aria-hidden="true">↗</span></a>
	</div>
</div>

<main id="main">
