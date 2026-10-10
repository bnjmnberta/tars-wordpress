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
		<span><?php echo esc_html( tars_mod( 'location' ) ); ?></span>
	</div>
</footer>

<a href="<?php echo is_front_page() ? '#top' : '#main'; ?>" class="to-top" data-to-top aria-label="Volver arriba">↑</a>

<?php wp_footer(); ?>
</body>
</html>
