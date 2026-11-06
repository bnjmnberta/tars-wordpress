<?php
/**
 * Receives the mail composer (js/mail.js, data-mode="wp") and sends it with wp_mail() to the
 * address set in Personalizar → TARS → Contacto y datos.
 *
 * Spam guards: a WordPress nonce, a hidden honeypot field, and a per-visitor limit (one message
 * every 20 seconds, five an hour). Every field is sanitised and length-capped; the visitor's
 * address only ever goes in Reply-To, never in the From header.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_nopriv_tars_send_mail', 'tars_send_mail' );
add_action( 'wp_ajax_tars_send_mail', 'tars_send_mail' );

function tars_mail_text( $key, $max = 200 ) {
	$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- checked in tars_send_mail().
	$value = is_string( $value ) ? sanitize_text_field( $value ) : '';
	return mb_substr( $value, 0, $max );
}

function tars_send_mail() {
	if ( ! check_ajax_referer( 'tars_mail', 'nonce', false ) ) {
		wp_send_json_error( array( 'message' => 'Recargá la página e intentá de nuevo.' ), 403 );
	}

	// honeypot: real visitors never see this field. Answer "ok" so a bot learns nothing.
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success();
	}

	// the whole site accepts at most 100 messages a day, whoever sends them
	$day = (int) get_transient( 'tars_mail_day' );
	if ( $day >= 100 ) {
		wp_send_json_error( array( 'message' => 'Hoy se alcanzó el límite de mensajes.' ), 429 );
	}

	// Cloudflare Turnstile, when it is set up
	if ( tars_turnstile_site_key() && ! tars_turnstile_ok() ) {
		wp_send_json_error( array( 'message' => 'No pudimos verificar que sos una persona. Probá de nuevo.' ), 403 );
	}

	// rate limit per visitor
	$ip    = tars_client_ip();
	$key   = 'tars_mail_' . md5( $ip );
	$state = get_transient( $key );
	$state = is_array( $state ) ? $state : array(
		'count' => 0,
		'last'  => 0,
	);
	if ( time() - (int) $state['last'] < 20 || (int) $state['count'] >= 5 ) {
		wp_send_json_error( array( 'message' => 'Demasiados mensajes seguidos.' ), 429 );
	}

	$name    = tars_mail_text( 'name', 120 );
	$company = tars_mail_text( 'company', 160 );
	$phone   = tars_mail_text( 'phone', 60 );
	$when    = tars_mail_text( 'when', 80 );
	$links   = tars_mail_text( 'links', 300 );
	$email   = sanitize_email( tars_mail_text( 'email', 160 ) );
	$subject = tars_mail_text( 'subject', 160 );

	$message = isset( $_POST['message'] ) ? wp_unslash( $_POST['message'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$message = mb_substr( sanitize_textarea_field( is_string( $message ) ? $message : '' ), 0, 5000 );

	$services = array();
	if ( isset( $_POST['services'] ) && is_array( $_POST['services'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		foreach ( array_slice( wp_unslash( $_POST['services'] ), 0, 8 ) as $service ) { // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput
			$service = is_string( $service ) ? mb_substr( sanitize_text_field( $service ), 0, 80 ) : '';
			if ( '' !== $service ) {
				$services[] = $service;
			}
		}
	}

	if ( '' === $name || '' === $message || ( '' === $email && '' === $phone ) ) {
		wp_send_json_error( array( 'message' => 'Faltan datos.' ), 422 );
	}
	if ( '' === $subject ) {
		$subject = 'Consulta TARS — ' . $name;
	}

	$lines = array( 'Hola TARS,', '', $message, '', '—' );
	$sign  = array(
		'Nombre'             => $name,
		'Negocio o proyecto' => $company,
		'Necesito'           => implode( ', ', $services ),
		'Para cuándo'        => $when,
		'Referencias'        => $links,
		'Mi mail'            => $email,
		'Mi WhatsApp'        => $phone,
	);
	foreach ( $sign as $label => $value ) {
		if ( '' !== $value ) {
			$lines[] = $label . ': ' . $value;
		}
	}
	$lines[] = '';
	$lines[] = '— Enviado desde el formulario de ' . wp_parse_url( home_url(), PHP_URL_HOST );

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( '' !== $email ) {
		$headers[] = 'Reply-To: ' . str_replace( array( '"', "\r", "\n", '<', '>' ), '', $name ) . ' <' . $email . '>';
	}

	$to   = sanitize_email( tars_mod( 'email' ) );
	$sent = $to && wp_mail( $to, $subject, implode( "\n", $lines ), $headers );

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => 'No se pudo enviar.' ), 500 );
	}

	$state['count'] = (int) $state['count'] + 1;
	$state['last']  = time();
	set_transient( $key, $state, HOUR_IN_SECONDS );
	set_transient( 'tars_mail_day', $day + 1, DAY_IN_SECONDS );
	wp_send_json_success();
}

/** Checks the Turnstile token the browser sent against Cloudflare. */
function tars_turnstile_ok() {
	$token = isset( $_POST['cf-turnstile-response'] ) ? sanitize_text_field( wp_unslash( $_POST['cf-turnstile-response'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' === $token ) {
		return false;
	}
	$response = wp_remote_post(
		'https://challenges.cloudflare.com/turnstile/v0/siteverify',
		array(
			'timeout' => 8,
			'body'    => array(
				'secret'   => (string) tars_mod( 'turnstile_secret' ),
				'response' => $token,
				'remoteip' => tars_client_ip(),
			),
		)
	);
	if ( is_wp_error( $response ) ) {
		return false;
	}
	$data = json_decode( wp_remote_retrieve_body( $response ), true );
	return is_array( $data ) && ! empty( $data['success'] );
}
