<?php
/**
 * Pages (Servicios, Nosotros, landing pages...): title + editor content in the site's style.
 */
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'wp-page' ); ?>>
		<header class="wp-page__head">
			<h1 class="wp-page__title"><?php the_title(); ?></h1>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="wp-page__cover"><?php the_post_thumbnail( 'large' ); ?></figure>
		<?php endif; ?>
		<div class="wp-entry">
			<?php
			the_content();
			wp_link_pages();
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
