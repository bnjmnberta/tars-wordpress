<?php
/**
 * Closes <main>, then the site footer.
 */
$tars_footer_items = tars_menu_items( has_nav_menu( 'footer' ) ? 'footer' : 'principal' );
?>
</main>

<footer class="footer">
	<div class="footer__top">
		<a href="<?php echo is_front_page() ? '#top' : esc_url( home_url( '/' ) ); ?>" class="footer__logo" aria-label="<?php bloginfo( 'name' ); ?>, volver arriba">
			<img src="<?php echo tars_uri( 'assets/logo-tars.png' ); ?>" alt="TARS Soluciones Digitales">
		</a>
		<nav class="footer__nav" aria-label="Navegación de footer">
			<?php foreach ( $tars_footer_items as $item ) : ?>
			<a href="<?php echo esc_url( $item[1] ); ?>"><?php echo esc_html( $item[0] ); ?></a>
			<?php endforeach; ?>
		</nav>
		<div class="footer__social">
			<a href="<?php echo esc_url( tars_mod( 'instagram_url' ) ); ?>" target="_blank" rel="noopener">Instagram</a>
			<a href="<?php echo esc_url( tars_whatsapp_url() ); ?>" target="_blank" rel="noopener">WhatsApp</a>
			<a href="<?php echo esc_url( tars_section_url( 'mail' ) ); ?>">Mail</a>
		</div>
	</div>
	<div class="footer__bottom">
		<span>© <span data-year><?php echo esc_html( gmdate( 'Y' ) ); ?></span> TARS — Soluciones Digitales.</span>
		<span><?php echo esc_html( tars_mod( 'location' ) ); ?><?php if ( tars_privacy_url() ) : ?> · <a href="<?php echo esc_url( tars_privacy_url() ); ?>">Privacidad</a><?php endif; ?></span>
	</div>
	<p class="footer__legal">El titular de los datos personales tiene la facultad de ejercer el derecho de acceso a los mismos en forma gratuita a intervalos no inferiores a seis meses, salvo que se acredite un interés legítimo al efecto conforme lo establecido en el artículo 14, inciso 3 de la Ley Nº 25.326. La Agencia de Acceso a la Información Pública, en su carácter de Órgano de Control de la Ley Nº 25.326, tiene la atribución de atender las denuncias y reclamos que interpongan quienes resulten afectados en sus derechos por incumplimiento de las normas vigentes en materia de protección de datos personales.</p>
</footer>

<a href="<?php echo is_front_page() ? '#top' : '#main'; ?>" class="to-top" data-to-top aria-label="Volver arriba">↑</a>

<?php wp_footer(); ?>
</body>
</html>
