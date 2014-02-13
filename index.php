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

				<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>

				<?php if ( is_singular() ) { 

						if( !function_exists( 'is_account_page') ) {
							comments_template();
						} else if ( !is_account_page() && !is_checkout() && !is_cart() ) {
							comments_template();
						}
					}
				?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>