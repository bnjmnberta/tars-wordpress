<?php
/**
 * TARS theme setup: features, menus, assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TARS_VERSION', '1.0.12' );

require get_template_directory() . '/inc/content.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/security.php';
require get_template_directory() . '/inc/mail-send.php';

add_action( 'after_setup_theme', 'tars_setup' );
function tars_setup() {
	add_theme_support( 'title-tag' );       // SEO plugins (Rank Math, Yoast) take over the <title>.
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'principal' => 'Menú principal (pantalla completa)',
			'footer'    => 'Menú del pie de página',
		)
	);
}

function tars_uri( $path ) {
	return esc_url( get_template_directory_uri() . '/' . $path );
}

add_action( 'wp_enqueue_scripts', 'tars_assets' );
function tars_assets() {
	$theme = get_template_directory_uri();
	$dir   = get_template_directory();

	// fonts and libraries are served from the theme itself: no request to Google or to a CDN
	wp_enqueue_style( 'tars-fonts', $theme . '/css/fonts.css', array(), filemtime( $dir . '/css/fonts.css' ) );
	wp_enqueue_style( 'tars-site', $theme . '/css/style.css', array( 'tars-fonts' ), filemtime( $dir . '/css/style.css' ) );
	wp_enqueue_style( 'tars-wp', $theme . '/css/wp.css', array( 'tars-site' ), filemtime( $dir . '/css/wp.css' ) );

	wp_enqueue_script( 'gsap', $theme . '/js/vendor/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', $theme . '/js/vendor/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
	wp_enqueue_script( 'lenis', $theme . '/js/vendor/lenis.min.js', array(), '1.3.26', true );

	$deps = array( 'gsap', 'gsap-scrolltrigger', 'lenis' );
	if ( is_front_page() ) {
		// loading screen + the hand-written card copy only exist on the home page
		wp_enqueue_script( 'tars-loader', $theme . '/js/loader.js', array( 'gsap' ), filemtime( $dir . '/js/loader.js' ), true );
		wp_enqueue_script( 'opentype', $theme . '/js/vendor/opentype.min.js', array(), '1.3.4', true );
		$deps[] = 'tars-loader';
		$deps[] = 'opentype';
	}
	wp_enqueue_script( 'tars-main', $theme . '/js/main.js', $deps, filemtime( $dir . '/js/main.js' ), true );
	if ( tars_ga_id() ) {
		wp_enqueue_script( 'tars-analytics', $theme . '/js/analytics.js', array( 'tars-main' ), filemtime( $dir . '/js/analytics.js' ), true );
		// where the cookie notice links to ('' = no privacy page chosen yet, so no link)
		wp_add_inline_script( 'tars-analytics', 'window.TARS_PRIVACY_URL=' . wp_json_encode( tars_privacy_url() ) . ';', 'before' );
	}
	if ( is_front_page() && tars_turnstile_site_key() ) {
		// Cloudflare Turnstile: the anti-bot check of the mail form (only when both keys are set)
		wp_enqueue_script( 'turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, array( 'strategy' => 'defer', 'in_footer' => true ) );
	}
	if ( is_front_page() ) {
		// the mail composer under the contact buttons
		wp_enqueue_script( 'tars-mail', $theme . '/js/mail.js', array( 'tars-main' ), filemtime( $dir . '/js/mail.js' ), true );
	}
}

/**
 * The Google Analytics 4 ID, or '' when none is set or the visitor is someone who edits the site
 * (their own visits are not counted).
 */
function tars_ga_id() {
	if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
		return '';
	}
	return (string) tars_mod( 'ga_id' );
}

/** The privacy policy page chosen in Ajustes → Privacidad, or '' when there is none yet. */
function tars_privacy_url() {
	return function_exists( 'get_privacy_policy_url' ) ? (string) get_privacy_policy_url() : '';
}

add_action( 'wp_head', 'tars_head_extras', 2 );
function tars_head_extras() {
	echo '<meta name="theme-color" content="#0a0a0a">' . "\n";
	if ( tars_ga_id() ) {
		echo '<meta name="tars-ga" content="' . esc_attr( tars_ga_id() ) . '">' . "\n";
	}
	echo '<noscript><style>.loader{display:none}[data-reveal]{opacity:1;transform:none}.hero__bgline i{transform:none}</style></noscript>' . "\n";

	if ( ! has_site_icon() ) {
		$icons = get_template_directory_uri() . '/assets';
		echo '<link rel="icon" href="' . esc_url( $icons . '/favicon.png' ) . '" sizes="64x64" type="image/png">' . "\n";
		echo '<link rel="icon" href="' . esc_url( $icons . '/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( $icons . '/apple-touch-icon.png' ) . '">' . "\n";
	}

	// description fallback, only when no SEO plugin is managing it
	$seo_plugin = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' );
	if ( ! $seo_plugin && is_front_page() ) {
		echo '<meta name="description" content="' . esc_attr( tars_mod( 'seo_description' ) ) . '">' . "\n";

		// link-preview tags (WhatsApp, Instagram, X) and the structured data of the studio
		$home  = home_url( '/' );
		$image = get_template_directory_uri() . '/assets/og-image.jpg';
		$title = 'TARS — Soluciones Digitales';
		$desc  = (string) tars_mod( 'seo_description' );
		$og    = array(
			'og:type'         => 'website',
			'og:locale'       => 'es_AR',
			'og:site_name'    => 'TARS Estudio',
			'og:title'        => $title,
			'og:description'  => $desc,
			'og:url'          => $home,
			'og:image'        => $image,
			'og:image:width'  => '1200',
			'og:image:height' => '630',
			'og:image:alt'    => 'TARS Estudio, estudio digital de ' . tars_mod( 'location' ),
		);
		foreach ( $og as $prop => $value ) {
			echo '<meta property="' . esc_attr( $prop ) . '" content="' . esc_attr( $value ) . '">' . "\n";
		}
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";

		$schema = array(
			'@context'      => 'https://schema.org',
			'@type'         => 'ProfessionalService',
			'name'          => 'TARS Estudio',
			'alternateName' => $title,
			'url'           => $home,
			'logo'          => get_template_directory_uri() . '/assets/logo-tars.png',
			'image'         => $image,
			'description'   => $desc,
			'areaServed'    => 'AR',
			'address'       => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => 'Santa Fe',
				'addressRegion'   => 'Santa Fe',
				'addressCountry'  => 'AR',
			),
		);
		if ( tars_mod( 'instagram_url' ) ) {
			$schema['sameAs'] = array( (string) tars_mod( 'instagram_url' ) );
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
}

// The home page is built by hand, not with blocks: drop the block editor's front-end CSS there
// so nothing but css/style.css styles it, exactly like the static site.
add_action( 'template_redirect', 'tars_trim_front_page_css' );
function tars_trim_front_page_css() {
	if ( ! is_front_page() ) {
		return;
	}
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
	add_action(
		'wp_enqueue_scripts',
		function () {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'classic-theme-styles' );
			wp_dequeue_style( 'global-styles' );
		},
		100
	);
}

// Same <title> as the static site: "TARS — Soluciones Digitales".
add_filter( 'document_title_separator', 'tars_title_separator' );
function tars_title_separator() {
	return '—';
}
add_filter( 'document_title_parts', 'tars_title_parts' );
function tars_title_parts( $parts ) {
	if ( is_front_page() && empty( $parts['tagline'] ) ) {
		$parts['tagline'] = 'Soluciones Digitales';
	}
	return $parts;
}

// The site is written in Spanish: keep lang="es" even if WordPress itself runs in another language.
add_filter( 'language_attributes', 'tars_language_attributes' );
function tars_language_attributes( $output ) {
	if ( 0 !== strpos( get_locale(), 'es' ) ) {
		$output = preg_replace( '/lang="[^"]*"/', 'lang="es"', $output );
	}
	return $output;
}

// The site uses no emoji: skip WordPress's emoji script and styles.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/** The Turnstile site key, only when the secret key is set too. */
function tars_turnstile_site_key() {
	$site   = preg_replace( '/[^A-Za-z0-9_\-]/', '', (string) tars_mod( 'turnstile_site' ) );
	$secret = (string) tars_mod( 'turnstile_secret' );
	return ( $site && $secret ) ? $site : '';
}
