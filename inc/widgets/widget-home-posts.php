<?php if ( ! defined( 'ABSPATH' ) ) exit('No direct script access allowed'); // Exit if accessed directly

/**
 * Widget Video
 *
 *
 *
 * @author		Hermanto Lim
 * @copyright	Copyright (c) Hermanto Lim
 * @link		http://bonfirelab.com
 * @since		Version 1.0
 * @package 	Bon Toolkit
 * @category 	Widgets
 *
 *
*/ 

add_action( 'widgets_init', 'bearded_load_posts_widget' );

function bearded_load_posts_widget() {
	register_widget( 'Bearded_Widget_Posts' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class Bearded_Widget_Posts extends WP_Widget {

	

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/
	function __construct() {

		$widget_ops = array( 'classname' => 'bearded-posts-widget', 'description' => __('Show Latest Blog Posts. Best use in homepage widget.', 'bearded') );
		$control_ops = array();
		$this->WP_Widget('bearded-posts', __('Bearded Latest Posts', 'bearded'), $widget_ops, $control_ops);

	}



	function widget( $args, $instance ) {

		extract($args);
		extract($instance);
		/* Display widget ---------------------------------------------------------------*/
		echo $before_widget; ?>


		<div class="bearded-posts-container row">
			<div class="column large-12">
				<?php if( $title ) { echo $before_title . $title . $after_title; } ?>
				
				<?php 

				$post_type = 'post';

				if( $type && $type == 'portfolio_item') {
					$post_type = 'portfolio_item';
				} 

				$args = array(
					'post_type' => $post_type,
					'posts_per_page' => 4,
					'ignore_sticky_posts' => true,
				);
				$loop = new WP_Query( $args );

				if( $loop->have_posts() ) : ?>

				<div class="<?php echo (!empty( $post_type ) && $post_type == 'portfolio_item' ) ? 'row collapse ' : 'row '; echo !empty( $post_type ) ? 'type-'.$post_type : 'type-post'; ?>">

					<?php while( $loop->have_posts() ) : $loop->the_post(); ?>

						<div class="column large-3 large-uncentered small-centered">

							<div class="widget-entry">
								<div class="widget-entry-thumbnail">
							<?php if(current_theme_supports( 'get-the-image' )) { get_the_image( array( 'size' => 'home-thumbnail' ) ); } ?>
								</div>
								<div class="widget-entry-title">
									<?php 
										the_title('<h3><a href="'.get_permalink().'" title="'.the_title_attribute( array('echo' => false ) ).'">', '</a></h3>'); 
									?>
								</div>
							</div>
						</div>

					<?php endwhile; ?>

				</div>

				<?php endif; wp_reset_postdata(); ?>
				
			</div>
		</div>
		
	<?php
		echo $after_widget;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Update Widget
	/*-----------------------------------------------------------------------------------*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags($new_instance['type']);

	
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings (Displays the widget settings controls on the widget panel)
	/*-----------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings ------------------------------------------*/
		$defaults = array(
			'title' => 'Latest From The Blog',
			'type' => 'post'
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form ---------------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><code><?php _e('Title', 'bearded') ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><code><?php _e('Post Type', 'bearded') ?></code></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
				<option value="post" <?php selected( $instance['type'], 'post' ); ?>><?php _e('Post','bearded'); ?></option>
				<option value="portfolio_item" <?php selected( $instance['type'], 'portfolio_item' ); ?>><?php _e('Portfolio Item','bearded'); ?></option>

			</select>
		</p>

			
		<?php
		}
}
?>