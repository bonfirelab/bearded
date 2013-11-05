<?php @header( 'HTTP/1.1 404 Not found', true, 404 );

get_header(); // Loads the header.php template. ?>

	<?php
		$layout = get_theme_mod('theme_layout');
		$col_class = 'large-8';

		if($layout === '1c') {
			$col_class = 'large-12';
		} 
	?>
	<div id="content" class="hfeed column <?php echo $col_class; ?>">


			<article id="post-0" class="<?php hybrid_entry_class(); ?>">

				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Whoah! You broke something!', 'bearded' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">

					<p>
						<?php printf( __( "Just kidding! You tried going to %s, which doesn't exist, so that means I probably broke something.", 'bearded' ), '<code>' . esc_url( home_url( esc_url( $_SERVER['REQUEST_URI'] ) ) ) . '</code>' ); ?>
					</p>
					<p>
						<?php _e( "The following is a list of the latest posts from the blog. Maybe it will help you find what you're looking for.", 'bearded' ); ?>
					</p>

					<ul>
						<?php wp_get_archives( array( 'limit' => 20, 'type' => 'postbypost' ) ); ?>
					</ul>

				</div><!-- .entry-content -->

			</article><!-- .hentry -->


	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>