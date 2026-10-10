<?php
/**
 * TARS theme setup: features, menus, assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TARS_VERSION', '1.0.1' );

require get_template_directory() . '/inc/content.php';
require get_template_directory() . '/inc/customizer.php';

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

	wp_enqueue_style( 'tars-fonts', 'https://fonts.googleapis.com/css2?family=Archivo:wght@800;900&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap', array(), null );
	wp_enqueue_style( 'tars-site', $theme . '/css/style.css', array( 'tars-fonts' ), filemtime( $dir . '/css/style.css' ) );
	wp_enqueue_style( 'tars-wp', $theme . '/css/wp.css', array( 'tars-site' ), filemtime( $dir . '/css/wp.css' ) );

	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), null, true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), null, true );
	wp_enqueue_script( 'lenis', 'https://cdn.jsdelivr.net/npm/lenis@1.3.26/dist/lenis.min.js', array(), null, true );

	$deps = array( 'gsap', 'gsap-scrolltrigger', 'lenis' );
	if ( is_front_page() ) {
		// loading screen + the hand-written card copy only exist on the home page
		wp_enqueue_script( 'tars-loader', $theme . '/js/loader.js', array( 'gsap' ), filemtime( $dir . '/js/loader.js' ), true );
		wp_enqueue_script( 'opentype', 'https://cdn.jsdelivr.net/npm/opentype.js@1.3.4/dist/opentype.min.js', array(), null, true );
		$deps[] = 'tars-loader';
		$deps[] = 'opentype';
	}
	wp_enqueue_script( 'tars-main', $theme . '/js/main.js', $deps, filemtime( $dir . '/js/main.js' ), true );
}

add_filter( 'wp_resource_hints', 'tars_resource_hints', 10, 2 );
function tars_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}

add_action( 'wp_head', 'tars_head_extras', 2 );
function tars_head_extras() {
	echo '<noscript><style>.loader{display:none}[data-reveal]{opacity:1;transform:none}.hero__bgline i{transform:none}</style></noscript>' . "\n";

	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( get_template_directory_uri() . '/assets/favicon.png' ) . '">' . "\n";
	}

	// description fallback, only when no SEO plugin is managing it
	$seo_plugin = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' );
	if ( ! $seo_plugin && is_front_page() ) {
		echo '<meta name="description" content="' . esc_attr( tars_mod( 'seo_description' ) ) . '">' . "\n";
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
