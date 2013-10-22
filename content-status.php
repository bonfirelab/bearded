<article <?php hybrid_post_attributes(); ?>>

	<?php if ( is_singular( get_post_type() ) ) { ?>

		<header class="entry-header">
			<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'before' => '<div class="featured-image">', 'size' => 'post-thumbnail', 'after' => '</div>' ) ); ?>
			<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
			<?php get_template_part('entry', 'side'); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'bearded' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'bearded' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php } else { ?>

		<header class="entry-header">
			<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'before' => '<div class="featured-image">', 'size' => 'post-thumbnail', 'after' => '</div>' ) ); ?>
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
			<?php get_template_part('entry', 'side'); ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'bearded' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-summary -->

	<?php } ?>

</article><!-- .hentry -->