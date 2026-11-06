<?php
/**
 * Hardening that belongs to the theme: it needs no plugin and nothing in wp-config.php.
 * What cannot live here (file permissions, backups, 2FA, Cloudflare...) is in SEGURIDAD.md.
 *
 * - XML-RPC off, user lists closed (?author=N and /wp/v2/users), generic login errors.
 * - Brute-force throttle on wp-login.php: 5 failures in 15 minutes lock that visitor for 15 minutes.
 * - Security headers, no WordPress version in the page, the theme/plugin file editor disabled.
 * - tars_client_ip(): the visitor's address (also used by the mail form's own limits).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * The visitor's IP. Behind Cloudflare the connection comes from Cloudflare, and the real address
 * travels in CF-Connecting-IP; without Cloudflare that header is ignored (anyone could forge it).
 */
function tars_client_ip() {
	$remote = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '';
	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && tars_is_cloudflare_ip( $remote ) ) {
		$cf = (string) $_SERVER['HTTP_CF_CONNECTING_IP'];
		if ( filter_var( $cf, FILTER_VALIDATE_IP ) ) {
			return $cf;
		}
	}
	return filter_var( $remote, FILTER_VALIDATE_IP ) ? $remote : 'unknown';
}

/** Cloudflare's published IPv4 / IPv6 ranges (https://www.cloudflare.com/ips/). */
function tars_is_cloudflare_ip( $ip ) {
	$ranges = array(
		'173.245.48.0/20',
		'103.21.244.0/22',
		'103.22.200.0/22',
		'103.31.4.0/22',
		'141.101.64.0/18',
		'108.162.192.0/18',
		'190.93.240.0/20',
		'188.114.96.0/20',
		'197.234.240.0/22',
		'198.41.128.0/17',
		'162.158.0.0/15',
		'104.16.0.0/13',
		'104.24.0.0/14',
		'172.64.0.0/13',
		'131.0.72.0/22',
	);
	if ( ! filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
		// IPv6 behind Cloudflare: its ranges all start with these prefixes.
		return (bool) preg_match( '/^(2400:cb00|2606:4700|2803:f800|2405:b500|2405:8100|2a06:98c0|2c0f:f248):/i', $ip );
	}
	$long = ip2long( $ip );
	foreach ( $ranges as $range ) {
		list( $base, $bits ) = explode( '/', $range );
		$mask                = -1 << ( 32 - (int) $bits );
		if ( ( $long & $mask ) === ( ip2long( $base ) & $mask ) ) {
			return true;
		}
	}
	return false;
}

/* ---------- editing from inside the admin ---------- */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true ); // a stolen admin session cannot rewrite PHP files from the panel
}

/* ---------- XML-RPC ---------- */
add_filter( 'xmlrpc_enabled', '__return_false' );
// the filter above only closes the methods that need a login: answer nothing at all to xmlrpc.php
add_action(
	'init',
	function () {
		if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
			status_header( 403 );
			header( 'Content-Type: text/plain; charset=utf-8' );
			exit( 'XML-RPC desactivado.' );
		}
	},
	0
);
add_filter(
	'wp_headers',
	function ( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}
);

/* ---------- information the site gives away ---------- */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

// ?author=1 would redirect to /author/<login>/ and reveal the username
add_action(
	'template_redirect',
	function () {
		if ( ! is_user_logged_in() && isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
		if ( ! is_user_logged_in() && is_author() ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	},
	1
);

// the REST user list is public by default
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( ! is_user_logged_in() ) {
			unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
		return $endpoints;
	}
);

// the login form must not say whether the user or the password was wrong
add_filter(
	'login_errors',
	function ( $error ) {
		if ( false !== strpos( (string) $error, 'Demasiados intentos' ) ) {
			return $error; // the lock-out message below is allowed through
		}
		return 'Los datos de acceso no son correctos.';
	}
);

/* ---------- brute force on wp-login.php ---------- */
define( 'TARS_LOGIN_MAX_FAILS', 5 );
define( 'TARS_LOGIN_WINDOW', 15 * MINUTE_IN_SECONDS );

function tars_login_key() {
	return 'tars_login_' . md5( tars_client_ip() );
}

add_action(
	'wp_login_failed',
	function () {
		$key  = tars_login_key();
		$fail = (int) get_transient( $key );
		set_transient( $key, $fail + 1, TARS_LOGIN_WINDOW );
	}
);

add_filter(
	'authenticate',
	function ( $user ) {
		if ( (int) get_transient( tars_login_key() ) >= TARS_LOGIN_MAX_FAILS ) {
			return new WP_Error(
				'tars_locked',
				'Demasiados intentos. Esperá unos minutos y probá de nuevo.'
			);
		}
		return $user;
	},
	30
);

add_action(
	'wp_login',
	function () {
		delete_transient( tars_login_key() );
	}
);

/* ---------- headers ---------- */
add_action(
	'send_headers',
	function () {
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
		header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()' );
		header( 'Cross-Origin-Opener-Policy: same-origin' );
		if ( is_ssl() ) {
			header( 'Strict-Transport-Security: max-age=15552000' ); // six months; add includeSubDomains once every subdomain has https
		}
	}
);
