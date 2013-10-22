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

add_action( 'widgets_init', 'bearded_load_services_widget' );

function bearded_load_services_widget() {
	register_widget( 'Bearded_Widget_Services' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class Bearded_Widget_Services extends WP_Widget {

	

	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/
	function __construct() {

		$widget_ops = array( 'classname' => 'bearded-services-widget', 'description' => __('Show Services Info. Best use in homepage widget.', 'bearded') );
		$control_ops = array();
		$this->WP_Widget('bearded-services', __('Bearded Services', 'bearded'), $widget_ops, $control_ops);

	}



	function widget( $args, $instance ) {

		extract($args);
		/* Display widget ---------------------------------------------------------------*/
		echo $before_widget; ?>

		<div class="bearded-services-container row">

			<?php for( $i = 1; $i <= 3; $i++ ){ ?>

				<div class="column large-4">

					<div class="services-icon">
						<?php if( $instance['link_'.$i] ) { ?>
						<a href="<?php echo $instance['link_'.$i]; ?>"  title="<?php echo $instance['title_'.$i]; ?>">
						<?php } ?>
							<?php if( !empty( $instance['icon_'.$i] ) ) { ?>

								<img src="<?php echo $instance['icon_'.$i]; ?>" alt="<?php echo $instance['title_'.$i]; ?>" />

							<?php } else if( !empty( $instance['icon_class_'.$i] ) ) { ?>

								<i class="<?php echo $instance['icon_class_'.$i]; ?>"></i>

							<?php } ?>
						<?php if( $instance['link_'.$i] ) { ?>
							</a>
						<?php } ?>
					</div>

					<h3 class="services-title">
						<?php if( $instance['link_'.$i] ) { ?>
							<a href="<?php echo $instance['link_'.$i]; ?>"  title="<?php echo $instance['title_'.$i]; ?>">
						<?php } ?>
							<?php echo $instance['title_'.$i]; ?>
						<?php if( $instance['link_'.$i] ) { ?>
							</a>
						<?php } ?>
					</h3>

					<div class="services-content">
						<?php echo wpautop( $instance['content_'.$i] ); ?>
					</div>
				</div>

			<?php } ?>
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

		for( $i = 1; $i <=3; $i++ ) {
			$instance['title_'.$i]   = strip_tags( $new_instance['title_'.$i] );
			$instance['link_'.$i]    = esc_url( strip_tags( $new_instance['link_'.$i] ) );
			$instance['icon_'.$i]   = esc_url( strip_tags( $new_instance['icon_'.$i] ) );
			$instance['icon_class_'.$i]   = strip_tags( $new_instance['icon_class_'.$i] );

			if ( current_user_can('unfiltered_html') )
				$instance['content_'.$i] =  $new_instance['content_'.$i];
			else // wp_filter_post_kses()expects slashed
				$instance['content_'.$i] = stripslashes( wp_filter_post_kses( addslashes($new_instance['content_'.$i]) ) ); 
		}

	
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings (Displays the widget settings controls on the widget panel)
	/*-----------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings ------------------------------------------*/
		$defaults = array(
			'title_1' => 'Service #1',
			'title_2' => 'Service #2',
			'title_3' => 'Service #3',
			'content_1' => '',
			'content_2' => '',
			'content_3' => '',
			'link_1' => '',
			'link_2' => '',
			'link_3' => '',
			'icon_1' => '',
			'icon_2' => '',
			'icon_3' => '',
			'icon_class_1' => '',
			'icon_class_2' => '',
			'icon_class_3' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form ---------------------------------------------------------------*/
		?>

		<?php for( $i = 1; $i <=3; $i++ ) { ?>


		<p>
			<label for="<?php echo $this->get_field_id( 'title_'.$i ); ?>"><code><?php _e('Title', 'bearded') ?> <?php echo $i; ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title_'.$i ); ?>" name="<?php echo $this->get_field_name( 'title_'.$i ); ?>" value="<?php echo $instance['title_'.$i]; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link_'.$i ); ?>"><code><?php _e('Link', 'bearded') ?> <?php echo $i; ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link_'.$i ); ?>" name="<?php echo $this->get_field_name( 'link_'.$i ); ?>" value="<?php echo $instance['link_'.$i]; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'icon_'.$i ); ?>"><code><?php _e('Icon URL', 'bearded') ?> <?php echo $i; ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'icon_'.$i ); ?>" name="<?php echo $this->get_field_name( 'icon_'.$i ); ?>" value="<?php echo $instance['icon_'.$i]; ?>" />
			<span><?php _e('Custom URL for the icon. If filled this will be used instead of icon class.', 'bearded'); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'icon_class_'.$i ); ?>"><code><?php _e('Icon Class', 'bearded') ?> <?php echo $i; ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'icon_class_'.$i ); ?>" name="<?php echo $this->get_field_name( 'icon_class_'.$i ); ?>" value="<?php echo $instance['icon_class_'.$i]; ?>" />

			<span><?php _e('Use icon class from FontAwesome', 'bearded'); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_'.$i ); ?>"><code><?php _e('Content', 'bearded') ?> <?php echo $i; ?></code></label>
			<textarea class="widefat" cols="10" rows="10" name="<?php echo $this->get_field_name( 'content_'.$i ); ?>" id="<?php echo $this->get_field_id( 'content_'.$i ); ?>"><?php echo $instance['content_'.$i]; ?></textarea>
			
		</p>

		<?php } ?>

		
			
		<?php
		}
}
?>