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

add_action( 'widgets_init', 'bearded_load_clients_widget' );

function bearded_load_clients_widget() {
	register_widget( 'Bearded_Widget_Clients' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class Bearded_Widget_Clients extends WP_Widget {

	

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/
	function __construct() {

		$widget_ops = array( 'classname' => 'bearded-clients-widget', 'description' => __('Show Clients lists. Best use in homepage widget.', 'bearded') );
		$control_ops = array();
		$this->WP_Widget('bearded-clients', __('Bearded Client Lists', 'bearded'), $widget_ops, $control_ops);

	}



	function widget( $args, $instance ) {

		extract($args);

		/* Display widget ---------------------------------------------------------------*/
		echo $before_widget; ?>

		<div class="bearded-clients-container row">
			<div class="column large-12">
				<?php if ( $instance['title'] ) { echo '<h2 class="client-title">' . $instance['title'] . '</h2>'; } ?>
				<div class="row">
				<?php for( $i = 1; $i <= 4; $i++ ) { ?>

					<div class="column large-3">
						<div id="client-<?php echo $i; ?>" class="client-block">
							<a href="<?php echo $instance['link_'.$i]; ?>" title="<?php echo $instance['link_title_'.$i]; ?>">
								<img src="<?php echo $instance['image_'.$i];?>" alt="<?php echo $instance['link_title_'.$i]; ?>" />
							</a>
						</div>
					</div>

				<?php } ?>
				</div>
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

		for($i = 0; $i <= 4; $i++ ) {
			$instance['link_'.$i]    = esc_url( strip_tags( $new_instance['link_'.$i] ) );
			$instance['link_title_'.$i]   = strip_tags( $new_instance['link_title_'.$i] );
			$instance['image_'.$i]    = esc_url( strip_tags( $new_instance['image_'.$i] ) );
		}
		
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings (Displays the widget settings controls on the widget panel)
	/*-----------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings ------------------------------------------*/
		$defaults = array(
			'title' => 'Our Clients',
			'link_1' => '',
			'link_2' => '',
			'link_3' => '',
			'link_4' => '',
			'link_title_1' => '',
			'link_title_2' => '',
			'link_title_3' => '',
			'link_title_4' => '',
			'image_1' => '',
			'image_2' => '',
			'image_3' => '',
			'image_4' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form ---------------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><code><?php _e('Title', 'bearded') ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<?php for ($i = 1; $i <= 4; $i++ ) { ?>

			<p>
				<label for="<?php echo $this->get_field_id( 'link_'.$i ); ?>"><code><?php _e('Link to:', 'bearded') ?><?php echo ' ' . $i; ?></code></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link_'.$i ); ?>" name="<?php echo $this->get_field_name( 'link_'.$i ); ?>" value="<?php echo $instance['link_'.$i]; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'link_title_'.$i ); ?>"><code><?php _e('Link Title:', 'bearded') ?><?php echo ' ' . $i; ?></code></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link_title_'.$i ); ?>" name="<?php echo $this->get_field_name( 'link_title_'.$i ); ?>" value="<?php echo $instance['link_title_'.$i]; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'image_'.$i ); ?>"><code><?php _e('Image URL:', 'bearded') ?><?php echo ' ' . $i; ?></code></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'image_'.$i ); ?>" name="<?php echo $this->get_field_name( 'image_'.$i ); ?>" value="<?php echo $instance['image_'.$i]; ?>" />
			</p>

		<?php } ?>
			
		<?php
		}
}
?>