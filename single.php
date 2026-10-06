<?php
/**
 * Blog posts.
 */
get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'wp-page' ); ?>>
		<header class="wp-page__head">
			<p class="wp-page__label"><?php echo esc_html( get_the_date() ); ?></p>
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
		<nav class="wp-pager" aria-label="Entradas">
			<?php previous_post_link( '%link', '← %title' ); ?>
			<?php next_post_link( '%link', '%title →' ); ?>
		</nav>
	</article>
	<?php
endwhile;

get_footer();
