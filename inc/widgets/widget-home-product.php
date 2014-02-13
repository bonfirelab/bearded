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

add_action( 'widgets_init', 'bearded_load_products_widget' );

function bearded_load_products_widget() {
	register_widget( 'Bearded_Widget_Products' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class Bearded_Widget_Products extends WP_Widget {

	
	/*-----------------------------------------------------------------------------------*/
	/*	Widget Setup
	/*-----------------------------------------------------------------------------------*/
	function __construct() {

		$widget_ops = array( 'classname' => 'bearded-products-widget', 'description' => __('Show Latest Woocommerce Products. Best use in homepage widget.', 'bearded') );
		$control_ops = array();
		$this->WP_Widget('bearded-products', __('Bearded Products', 'bearded'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {

		extract($args);

		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number      = absint( $instance['numberposts'] );
		$type        = sanitize_title( $instance['type'] );
		$orderby     = sanitize_title( $instance['orderby'] );
		$order       = sanitize_title( $instance['order'] );
		$show_hidden = $instance['show_hidden'];
		$hide_free = $instance['hide_free'];

		$query_args = array(
    		'posts_per_page' => $number,
    		'post_status' 	 => 'publish',
    		'post_type' 	 => 'product',
    		'no_found_rows'  => 1,
    		'order'          => $order == 'asc' ? 'asc' : 'desc'
    	);

    	$query_args['meta_query'] = array();

    	if ( $show_hidden ) {
			$query_args['meta_query'][] = WC()->query->visibility_meta_query();
			$query_args['post_parent']  = 0;
		}

		if ( !$hide_free ) {
    		$query_args['meta_query'][] = array(
			    'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL',
			);
    	}

	    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

    	switch ( $type ) {
    		case 'featured' :
    			$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
    			break;
    		case 'onsale' :
    			$product_ids_on_sale = wc_get_product_ids_on_sale();
				$product_ids_on_sale[] = 0;
				$query_args['post__in'] = $product_ids_on_sale;
    			break;
    	}

    	switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
    			$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
    			$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
    			$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby']  = 'date';
    	}

    	$r = new WP_Query( $query_args );

    	if ( $r->have_posts() ) {

			echo $before_widget; 
		?>

		<div class="bearded-product-container row">
			<div class="column large-12">
				<?php if( $title ) { echo $before_title . $title . $after_title; } ?>
				
					<?php wc_get_template( 'loop/loop-start.php'); ?>
						<?php
						while ( $r->have_posts()) {
							$r->the_post();
							wc_get_template( 'content-product.php' );
						}
						?>
					<?php wc_get_template( 'loop/loop-end.php'); ?>
			</div>
		</div>
		
		<?php
			echo $after_widget; wp_reset_postdata();
		}
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Update Widget
	/*-----------------------------------------------------------------------------------*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['numberposts'] = intval( $new_instance['numberposts'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		$instance['order'] = strip_tags( $new_instance['order'] );
		$instance['hide_free'] = ( isset( $new_instance['hide_free'] ) ? 1 : 0 );
		$instance['show_hidden'] = ( isset( $new_instance['show_hidden'] ) ? 1 : 0 );
	
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Widget Settings (Displays the widget settings controls on the widget panel)
	/*-----------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings ------------------------------------------*/
		$defaults = array(
			'title' => 'Latest Products',
			'type' => '',
			'numberposts' => 4,
			'orderby' => 'date',
			'order' => 'ASC',
			'hide_free' => false,
			'show_hidden' => false,
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form ---------------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><code><?php _e('Title', 'bearded') ?></code></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><code><?php _e('Type', 'bearded') ?></code></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
				<option value="" <?php selected( $instance['type'], '' ); ?>><?php _e('All Products','bearded'); ?></option>
				<option value="featured" <?php selected( $instance['type'], 'featured' ); ?>><?php _e('Featured Products','bearded'); ?></option>
				<option value="onsale" <?php selected( $instance['type'], 'onsale' ); ?>><?php _e('On Sale Products','bearded'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><code><?php _e('Order By', 'bearded') ?></code></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php _e('Date','bearded'); ?></option>
				<option value="price" <?php selected( $instance['orderby'], 'price' ); ?>><?php _e('Price','bearded'); ?></option>
				<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php _e('Random','bearded'); ?></option>
				<option value="sales" <?php selected( $instance['orderby'], 'sales' ); ?>><?php _e('Sales','bearded'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><code><?php _e('Type', 'bearded') ?></code></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?>><?php _e('Ascending','bearded'); ?></option>
				<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?>><?php _e('Descending','bearded'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'numberposts' ); ?>"><code><?php _e('Number of Post', 'bearded') ?></code></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'numberposts' ); ?>" name="<?php echo $this->get_field_name( 'numberposts' ); ?>">
				<option value="4" <?php selected( $instance['numberposts'], 4 ); ?>><?php _e('4 Posts','bearded'); ?></option>
				<option value="8" <?php selected( $instance['numberposts'], 8 ); ?>><?php _e('8 Posts','bearded'); ?></option>
				<option value="12" <?php selected( $instance['numberposts'], 12 ); ?>><?php _e('12 Posts','bearded'); ?></option>

			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'hide_free' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hide_free'], true ); ?> id="<?php echo $this->get_field_id( 'hide_free' ); ?>" name="<?php echo $this->get_field_name( 'hide_free' ); ?>" /><?php _e('Hide Free Product', 'bearded') ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_hidden' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_hidden'], true ); ?> id="<?php echo $this->get_field_id( 'show_hidden' ); ?>" name="<?php echo $this->get_field_name( 'show_hidden' ); ?>" /><?php _e('Show Hidden Product', 'bearded') ?></label>
		</p>
			
		<?php
		}
}
?>