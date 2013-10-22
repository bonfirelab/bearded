<?php
/**
 * Featured Slider Class for adding custom post type and metabox in featured slider
 *
 * @since 1.0.0
 * @package Bearded
 * @author Hermanto Lim
 **/
class Bearded_Featured_Slider {

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $post_type_name = 'slider';

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $meta_key_position = 'bearded-slide-position';

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $meta_key_button = 'bearded-slide-button';
	

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $meta_key_link = 'bearded-slide-link';

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $meta_key_thumb = 'bearded-slide-thumb';

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $meta_key_style = 'bearded-slide-style';

	/**
	 * @var string
	 * @since 1.0.0
	 * 
	 */
	public $meta_key_nonce = 'bearded-slider-meta';
	

	/*
	 * Class Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'add_post_type' ) );
		add_action( 'after_switch_theme', array( $this, 'rewrite_flush' ) );
		add_action( 'save_post', array($this, 'save_meta'), 10, 2 );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_script') );
	}

	public function add_post_type() {

		$labels = array(
		    'name'               => __('Sliders','bearded'),
		    'singular_name'      => __('Slider','bearded'),
		    'add_new'            => __('Add New','bearded'),
		    'add_new_item'       => __('Add New Slider','bearded'),
		    'edit_item'          => __('Edit Slider','bearded'),
		    'new_item'           => __('New Slider','bearded'),
		    'all_items'          => __('All Sliders','bearded'),
		    'view_item'          => __('View Slider','bearded'),
		    'search_items'       => __('Search Sliders','bearded'),
		    'not_found'          => __('No Slider Found','bearded'),
		    'not_found_in_trash' => __('No slider found in Trash','bearded'),
		    'menu_name'          => __('Featured Slider', 'bearded')
	  	);

	  	$args = array(
		    'labels'               => $labels,
		    'public'			   => false,
		    'show_in_nav_menus'    => false,
		    'show_ui'              => true,
		    'show_in_menu'		   => true,
		    'exclude_from_search'  => true,
		    'supports'             => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
		    'register_meta_box_cb' => array($this, 'register_metabox')
  		);

  		register_post_type( $this->post_type_name, $args );

	}

	public function register_metabox() {

		add_meta_box( 'slider-options', __('Slider Options','bearded'), array($this, 'render_metabox'), $this->post_type_name, 'normal', 'high' );
	}

	public function render_metabox( $object, $box ) { 

		wp_nonce_field( basename( __FILE__ ), $this->meta_key_nonce ); ?>
		<div class="bearded-meta-box">
			<p>
				<label for="<?php echo $this->meta_key_link; ?>" style="display:inline-block;width: 120px"><?php _e( 'Link:', 'bearded' ); ?></label>
				<input type="text" name="<?php echo $this->meta_key_link; ?>" size="100" id="<?php echo $this->meta_key_link; ?>" value="<?php echo esc_attr(get_post_meta( $object->ID, $this->meta_key_link, true)); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->meta_key_button; ?>" style="display:inline-block;width: 120px"><?php _e( 'Button Label:', 'bearded' ); ?></label>
				<input type="text" name="<?php echo $this->meta_key_button; ?>" size="30" id="<?php echo $this->meta_key_button; ?>" value="<?php echo esc_attr(get_post_meta( $object->ID, $this->meta_key_button, true)); ?>" />
			</p>
			<p>
				<?php $selected = get_post_meta( $object->ID, $this->meta_key_position, true); ?>
				<label for="<?php echo $this->meta_key_position; ?>" style="display:inline-block;width: 120px"><?php _e( 'Caption Position:', 'bearded' ); ?></label>
				<select id="<?php echo $this->meta_key_position; ?>" name="<?php echo $this->meta_key_position; ?>">
					<option value="left" <?php selected( $selected, 'left'); ?>><?php _e('Left','bearded'); ?></option>
					<option value="right" <?php selected( $selected, 'right'); ?>><?php _e('Right','bearded'); ?></option>
					<option value="center" <?php selected( $selected, 'center'); ?>><?php _e('Center','bearded'); ?></option>
				</select>
			</p>
			<p>
				<?php $selected_style = get_post_meta( $object->ID, $this->meta_key_style, true); ?>
				<label for="<?php echo $this->meta_key_style; ?>" style="display:inline-block;width: 120px"><?php _e( 'Caption Style:', 'bearded' ); ?></label>
				<select id="<?php echo $this->meta_key_style; ?>" name="<?php echo $this->meta_key_style; ?>">
					<option value="light" <?php selected( $selected_style, 'light'); ?>><?php _e('Light','bearded'); ?></option>
					<option value="dark" <?php selected( $selected_style, 'dark'); ?>><?php _e('Dark','bearded'); ?></option>
				</select>
			</p>
			<p class="metabox-image">
				<?php 
					$image = '';
					$thumb = get_post_meta( $object->ID, $this->meta_key_thumb, true); 
					if($thumb) {
						$image = wp_get_attachment_image_src( intval( $thumb ), 'thumbnail' );
						$image = $image[0];
					}
				?>
				<label for="<?php echo $this->meta_key_thumb; ?>" style="display:inline-block;width: 120px"><?php _e( 'Thumbnail:', 'bearded' ); ?></label>
				<span class="meta-thumbnail" id="<?php echo $this->meta_key_thumb; ?>-preview"><img src="<?php echo $image; ?>" alt=""/></span>
				<button data-id="<?php echo $this->meta_key_thumb; ?>" class="button bearded-meta-upload"><?php _e('Choose Image','bearded'); ?></button>
				<input type="hidden" name="<?php echo $this->meta_key_thumb; ?>" id="<?php echo $this->meta_key_thumb; ?>" value="<?php echo $thumb; ?>" />
				<button data-id="<?php echo $this->meta_key_thumb; ?>" class="button bearded-remove-image"><?php _e('Remove Image','bearded'); ?></button>
				<br/><code style="margin-left: 120px;"><?php _e('Thumbnail / image for the slide. For background set the featured image.', 'bearded'); ?></code>
			</p>
		</div>	

	<?php }
 
	public function save_meta( $post_id, $post = '' ) {

		/* Fix for attachment save issue in WordPress 3.5. @link http://core.trac.wordpress.org/ticket/21963 */
		if ( !is_object( $post ) )
			$post = get_post();

		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST[$this->meta_key_nonce] ) || !wp_verify_nonce( $_POST[$this->meta_key_nonce], basename( __FILE__ ) ) )
			return $post_id;

		$meta = array(
			$this->meta_key_position => sanitize_text_field( esc_attr( $_POST[$this->meta_key_position] ) ),
			$this->meta_key_link => esc_url( $_POST[$this->meta_key_link] ),
			$this->meta_key_button => sanitize_text_field( esc_attr( $_POST[$this->meta_key_button] ) ),
			$this->meta_key_style => sanitize_text_field( esc_attr( $_POST[$this->meta_key_style] ) ),
			$this->meta_key_thumb => sanitize_text_field( $_POST[$this->meta_key_thumb] ),
		);

		foreach ( $meta as $meta_key => $new_meta_value ) {

			/* Get the meta value of the custom field key. */
			$meta_value = get_post_meta( $post_id, $meta_key, true );

			/* If there is no new meta value but an old value exists, delete it. */
			if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value )
				delete_post_meta( $post_id, $meta_key, $meta_value );

			/* If a new meta value was added and there was no previous value, add it. */
			elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value )
				add_post_meta( $post_id, $meta_key, $new_meta_value, true );

			/* If the new meta value does not match the old value, update it. */
			elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $new_meta_value && $new_meta_value != $meta_value )
				update_post_meta( $post_id, $meta_key, $new_meta_value );
		}
	}

	public function enqueue_script( $hook ) {
		global $post;
		if( ($hook == 'post-new.php' || $hook == 'post.php') && $post->post_type === $this->post_type_name ) {
			wp_enqueue_script( 'bearded-uploader', BEARDED_JS . 'admin/uploader.js' , array('jquery') , '1.0' );
		}
	}

	public function rewrite_flush() {
	    flush_rewrite_rules();
	}

}

new Bearded_Featured_Slider();
?>