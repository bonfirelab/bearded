<article <?php hybrid_post_attributes(); ?>>

	<?php if ( is_singular( get_post_type() ) ) { ?>

		<header class="entry-header">
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
			<div class="featured-image">
				<?php echo ( $audio = hybrid_media_grabber( array( 'type' => 'audio' ) ) ); ?>
			</div>
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
			<?php get_template_part('entry', 'side'); ?>
		</header><!-- .entry-header -->

		<?php if ( has_excerpt() ) { ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php } elseif ( empty( $audio ) ) { ?>

			<div class="entry-content">
				<?php the_content( __( 'Read more &rarr;', 'bearded' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'bearded' ), 'after' => '</p>' ) ); ?>
			</div><!-- .entry-content -->

		<?php } ?>
		

	<?php } ?>

</article><!-- .hentry -->