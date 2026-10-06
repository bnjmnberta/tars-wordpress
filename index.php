<?php
/**
 * Blog index and any archive (categories, search, ...).
 */
get_header();
?>
<section class="wp-page">
	<header class="wp-page__head">
		<p class="wp-page__label">Blog</p>
		<h1 class="wp-page__title">
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} elseif ( is_search() ) {
				echo 'Resultados para “' . esc_html( get_search_query() ) . '”';
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				bloginfo( 'name' );
			}
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="wp-posts">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<a <?php post_class( 'wp-card' ); ?> href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<span class="wp-card__media"><?php the_post_thumbnail( 'medium_large' ); ?></span>
					<?php endif; ?>
					<span class="wp-card__date"><?php echo esc_html( get_the_date() ); ?></span>
					<span class="wp-card__title"><?php the_title(); ?></span>
					<span class="wp-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></span>
				</a>
			<?php endwhile; ?>
		</div>
		<nav class="wp-pager" aria-label="Páginas">
			<?php
			previous_posts_link( '← Más nuevas' );
			next_posts_link( 'Más viejas →' );
			?>
		</nav>
	<?php else : ?>
		<div class="wp-entry"><p>Todavía no hay nada publicado acá.</p></div>
	<?php endif; ?>
</section>
<?php
get_footer();
