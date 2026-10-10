<?php
/**
 * Every editable text of the theme with its default (the copy of the original site).
 * Values come from Apariencia → Personalizar; anything left empty falls back to these.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tars_defaults() {
	static $defaults = null;
	if ( null !== $defaults ) {
		return $defaults;
	}

	$defaults = array(
		// Contacto.
		'whatsapp_number'  => '5493425226537',
		'whatsapp_message' => 'Hola TARS, quiero info',
		'instagram_url'    => 'https://instagram.com/tars.estudio',
		'email'            => 'tarssolucionesdigitales@gmail.com',
		'location'         => 'Santa Fe, Argentina.',
		'seo_description'  => 'TARS Estudio: logos, diseño web, gestión de redes, flyers/video y marketing inmobiliario.',

		// Portada.
		'hero_line_1'      => 'TARS',
		'hero_line_2'      => 'STUDIO',
		'hero_h1'          => 'TARS Studio. Diseñamos marcas que se mueven.',
		'marquee'          => 'Diseñamos marcas que se mueven.',

		// Servicios (the order is fixed: each card keeps its colour and drawing).
		'service_1_title'  => 'Logos',
		'service_1_text'   => 'Tu logo es lo primero que ven y lo último que *olvidan*. Es la firma de tu negocio en cada cartel, posteo y tarjeta: genera confianza antes de decir una sola palabra. *Genera tu marca.*',
		'service_2_title'  => 'Flyers | Videos',
		'service_2_text'   => 'En un feed lleno de ruido, una buena pieza *frena* el scroll. Cuenta tu propuesta en segundos, despierta ganas y lleva a la acción mientras la competencia pasa de largo. *Hacé ruido.*',
		'service_3_title'  => 'Gestión de Redes',
		'service_3_text'   => 'Tus redes son tu *vidriera* abierta las 24 horas. Publicar con constancia y estrategia construye comunidad y convierte seguidores en clientes, sin que le dediques tu tiempo. *Crecé todos los días.*',
		'service_4_title'  => 'Marketing Inmobiliario',
		'service_4_text'   => 'Una propiedad se vende por cómo se *ve*. Fotos, video y drone que muestran cada espacio en su mejor luz traen más consultas y cierran operaciones antes que la competencia. *Vendé más rápido.*',
		'service_5_title'  => 'Diseño Web',
		'service_5_text'   => 'Tu web trabaja mientras *dormís*. Es donde te buscan, te comparan y te eligen: rápida, clara y pensada para convertir cada visita en una venta. *Vendé online.*',
		'service_cta'      => 'Realiza tu consulta',

		// Cómo trabajamos.
		'process_label'    => 'Cómo trabajamos',
		'process_title'    => 'De una charla a tu *marca* lista para salir.',
		'step_1_title'     => 'Brief',
		'step_1_text'      => 'Nos contás tu negocio, tu público y a dónde querés llegar. Una charla, no un formulario eterno.',
		'step_2_title'     => 'Propuesta',
		'step_2_text'      => 'Te mostramos una dirección visual pensada para vos, con el porqué de cada decisión. Nada de plantillas.',
		'step_3_title'     => 'Ajustes',
		'step_3_text'      => 'Afinamos juntos cada detalle hasta que lo sientas tuyo.',
		'step_4_title'     => 'Entrega',
		'step_4_text'      => 'Recibís todo listo para usar: archivos en cada formato y una guía para aplicarlo bien.',

		// Sección de contacto.
		'cta_label'        => 'Contacto',
		'cta_title'        => '¿Charlamos de tu',
		'cta_title_2'      => 'proyecto?',
	);
	return $defaults;
}

/** A text setting, falling back to the default when empty. */
function tars_mod( $key ) {
	$defaults = tars_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	$value    = get_theme_mod( 'tars_' . $key, $default );
	return ( '' === trim( (string) $value ) ) ? $default : $value;
}

/** Escaped text where *words between asterisks* become the accent face (<em>). */
function tars_rich( $key ) {
	$text = esc_html( tars_mod( $key ) );
	return preg_replace( '/\*(.+?)\*/u', '<em>$1</em>', $text );
}

function tars_whatsapp_url( $with_message = false ) {
	$number = preg_replace( '/\D+/', '', tars_mod( 'whatsapp_number' ) );
	$url    = 'https://wa.me/' . $number;
	if ( $with_message && tars_mod( 'whatsapp_message' ) ) {
		$url .= '?text=' . rawurlencode( tars_mod( 'whatsapp_message' ) );
	}
	return $url;
}

function tars_mailto() {
	return 'mailto:' . antispambot( sanitize_email( tars_mod( 'email' ) ) );
}

/**
 * A link to a section of the home page: a bare #anchor on the home page itself (smooth-scrolled
 * by main.js), the full URL everywhere else.
 */
function tars_section_url( $anchor ) {
	return is_front_page() ? '#' . $anchor : home_url( '/#' . $anchor );
}

/**
 * Items of a menu location as [ title, url ] pairs, or the default section links when no menu is
 * assigned there. Custom links written as "#seccion" keep working from inner pages.
 */
function tars_menu_items( $location ) {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations[ $location ] ) ) {
		$items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( $items ) {
			$out = array();
			foreach ( $items as $item ) {
				if ( (int) $item->menu_item_parent ) {
					continue; // one level only, like the design.
				}
				$url = $item->url;
				if ( 0 === strpos( $url, '#' ) && ! is_front_page() ) {
					$url = home_url( '/' . $url );
				}
				$out[] = array( $item->title, $url );
			}
			return $out;
		}
	}
	return array(
		array( 'Servicios', tars_section_url( 'servicios' ) ),
		array( 'Proceso', tars_section_url( 'proceso' ) ),
		array( 'Contacto', tars_section_url( 'contacto' ) ),
	);
}
