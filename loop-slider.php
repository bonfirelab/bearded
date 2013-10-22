<?php 

  $slider_post_per_page = get_option('slider_post_per_page', 5);
  $loop = new WP_Query(
    array(
        'post_type'      => 'slider',
        'posts_per_page' => $slider_post_per_page,
        'order_by'       => 'menu_order',
        'order'          => 'ASC'
      )
  );

if ( $loop->have_posts() ) : 

?>
	<div id="featured-slider-container">

		<div id="featured-slider" class="slides">

			<?php while( $loop->have_posts() ) : $loop->the_post(); ?>

				<?php get_template_part('content','slider'); ?>

			<?php endwhile; ?>
			
		</div>

		<div id="featured-slider-control">
	    </div>

	</div>

<?php endif; wp_reset_postdata(); ?>