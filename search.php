<?php get_header(); // Loads the header.php template. ?>
	
	<?php
		$layout = get_theme_mod('theme_layout');
		$col_class = 'large-8';

		if($layout === '1c') {
			$col_class = 'large-12';
		} 
	?>

	<div id="content" class="hfeed column <?php echo $col_class; ?>">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<header class="entry-header">
			<?php bearded_post_thumbnail(); ?>
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
			<?php get_template_part('entry', 'side'); ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'bearded' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-summary -->

						<footer class="entry-footer">
							<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . sprintf( __( '[entry-published] &mdash; <code>%s</code>', 'chun' ), get_permalink() ) . '</div>' ); ?>
						</footer><!-- .entry-footer -->

					</article><!-- .hentry -->

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>


		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>