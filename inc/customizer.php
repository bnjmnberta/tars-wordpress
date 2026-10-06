<?php
/**
 * Apariencia → Personalizar: one panel ("TARS") with a section per block of the home page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', 'tars_customize_register' );

function tars_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'tars',
		array(
			'title'       => 'TARS',
			'description' => 'Textos y datos de contacto del sitio. Para destacar palabras con la tipografía de acento (serif), escribilas entre asteriscos: *así*.',
			'priority'    => 20,
		)
	);

	$sections = array(
		'tars_contact'  => array(
			'title'  => 'Contacto y datos',
			'fields' => array(
				'whatsapp_number'  => array( 'Número de WhatsApp (con código de país, sin + ni espacios)', 'text' ),
				'whatsapp_message' => array( 'Mensaje que llega escrito al tocar WhatsApp en Contacto', 'text' ),
				'instagram_url'    => array( 'Instagram (link completo)', 'url' ),
				'email'            => array( 'Mail', 'email' ),
				'location'         => array( 'Ubicación (pie de página)', 'text' ),
				'seo_description'  => array( 'Descripción para Google (se ignora si usás Rank Math o Yoast)', 'textarea' ),
			),
		),
		'tars_hero'     => array(
			'title'  => 'Portada',
			'fields' => array(
				'hero_line_1' => array( 'Título grande — línea 1', 'text' ),
				'hero_line_2' => array( 'Título grande — línea 2', 'text' ),
				'hero_h1'     => array( 'Título para buscadores y lectores de pantalla (no se ve)', 'text' ),
				'marquee'     => array( 'Frase de la franja que corre', 'text' ),
			),
		),
		'tars_services' => array(
			'title'       => 'Servicios',
			'description' => 'Las cinco tarjetas mantienen su color y su dibujo; cambian el título y el texto.',
			'fields'      => array(),
		),
		'tars_process'  => array(
			'title'  => 'Cómo trabajamos',
			'fields' => array(
				'process_label' => array( 'Etiqueta', 'text' ),
				'process_title' => array( 'Título', 'text' ),
			),
		),
		'tars_cta'      => array(
			'title'  => 'Sección Contacto',
			'fields' => array(
				'cta_label'   => array( 'Etiqueta', 'text' ),
				'cta_title'   => array( 'Título (parte sólida)', 'text' ),
				'cta_title_2' => array( 'Título (parte en contorno)', 'text' ),
			),
		),
	);

	$cards = array( 'Logos (verde)', 'Flyers | Videos (azul)', 'Gestión de Redes (amarilla)', 'Marketing Inmobiliario (bordó)', 'Diseño Web (celeste)' );
	foreach ( $cards as $i => $name ) {
		$n = $i + 1;
		$sections['tars_services']['fields'][ "service_{$n}_title" ] = array( "Tarjeta {$n} · {$name} — título", 'text' );
		$sections['tars_services']['fields'][ "service_{$n}_text" ]  = array( "Tarjeta {$n} — texto", 'textarea' );
	}
	$sections['tars_services']['fields']['service_cta'] = array( 'Botón de la última tarjeta', 'text' );

	for ( $n = 1; $n <= 4; $n++ ) {
		$sections['tars_process']['fields'][ "step_{$n}_title" ] = array( "Paso {$n} — título", 'text' );
		$sections['tars_process']['fields'][ "step_{$n}_text" ]  = array( "Paso {$n} — texto", 'textarea' );
	}

	$defaults  = tars_defaults();
	$sanitizer = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'url'      => 'esc_url_raw',
		'email'    => 'sanitize_email',
	);
	$priority  = 0;

	foreach ( $sections as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title'       => $section['title'],
				'panel'       => 'tars',
				'description' => isset( $section['description'] ) ? $section['description'] : '',
			)
		);
		foreach ( $section['fields'] as $key => $field ) {
			list( $label, $type ) = $field;
			$wp_customize->add_setting(
				'tars_' . $key,
				array(
					'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
					'sanitize_callback' => $sanitizer[ $type ],
				)
			);
			$wp_customize->add_control(
				'tars_' . $key,
				array(
					'label'    => $label,
					'section'  => $section_id,
					'type'     => $type,
					'priority' => ++$priority,
				)
			);
		}
	}
}
