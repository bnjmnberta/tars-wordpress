<?php
/**
 * Page not found.
 */
get_header();
?>
<section class="wp-page wp-page--404">
	<header class="wp-page__head">
		<p class="wp-page__label">Error 404</p>
		<h1 class="wp-page__title">Esta página no existe.</h1>
	</header>
	<div class="wp-entry">
		<p>Puede que el link esté mal o que la página se haya movido.</p>
		<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Volver al inicio <span aria-hidden="true">→</span></a></p>
	</div>
</section>
<?php
get_footer();
