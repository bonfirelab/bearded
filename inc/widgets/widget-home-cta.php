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

add_action( 'widgets_init', 'bearded_load_cta_widget' );

function bearded_load_cta_widget() {
	register_widget( 'Bearded_Widget_Cta' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class Bearded_Widget_Cta extends WP_Widget {

	

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/
	function __construct() {

		$widget_ops = array( 'classname' => 'bearded-cta-widget', 'description' => __('Show Call to Action. Best use in homepage widget.', 'bearded') );
		$control_ops = array();
		$this->WP_Widget('bearded-cta', __('Bearded Call to Action', 'bearded'), $widget_ops, $control_ops);

	}



	function widget( $args, $instance ) {

		extract($args);
		extract($instance);
		/* Display widget ---------------------------------------------------------------*/
		echo $before_widget; ?>

		<div class="bearded-cta-container row">
			<div class="column large-8">
				<h1 class="cta-widget-title"><?php echo $title; ?></h1>
				<?php echo wptexturize( wpautop( $content ) ); ?>
			</div>
			<div class="column large-4">
				<a class="button radius hover-light alignright" href="<?php echo $link; ?>" title="<?php echo $label; ?>"><?php echo $label; ?></a>
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
		$instance['link']    = esc_url( strip_tags( $new_instance['link'] ) );
		$instance['label']   = strip_tags( $new_instance['label'] );

		if ( current_user_can('unfiltered_html') )
			$instance['content'] =  $new_instance['content'];
		else // wp_filter_post_kses()expects slashed
			$instance['content'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['content']) ) ); 

	
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings (Displays the widget settings controls on the widget panel)
	/*-----------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings ------------------------------------------*/
		$defaults = array(
			'title' => 'Call to Action Banner',
			'content' => '',
			'link' => '',
			'label' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form ---------------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><code><?php _e('Title', 'bearded') ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><code><?php _e('Link to:', 'bearded') ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><code><?php _e('Button Label', 'bearded') ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" value="<?php echo $instance['label']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><code><?php _e('Content', 'bearded') ?></code></label>
			<textarea class="widefat" cols="10" rows="10" name="<?php echo $this->get_field_name( 'content' ); ?>" id="<?php echo $this->get_field_id( 'content' ); ?>"><?php echo $instance['content']; ?></textarea>
			
		</p>

		
			
		<?php
		}
}
?>