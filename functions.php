<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Bearded
 * @subpackage Functions
 * @version    1.0.0
 * @since      0.1.0
 * @author     Hermanto Lim <hermanto@bonfirelab.com>
 * @copyright  Copyright (c) 2013, Hermanto Lim
 * @link       http://bonfirelab.com/themes/bearded
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();


if(!defined("BEARDED_IMAGES")) {
	define("BEARDED_IMAGES", trailingslashit( get_template_directory_uri() ) . 'assets/images/');
}
if(!defined("BEARDED_CSS")) {
	define("BEARDED_CSS", trailingslashit( get_template_directory_uri() ) . 'assets/css/');
}
if(!defined("BEARDED_JS")) {
	define("BEARDED_JS", trailingslashit( get_template_directory_uri() ) . 'assets/js/');
}
if(!defined("BEARDED_INC")) {
	define("BEARDED_INC", trailingslashit( get_template_directory() ) . 'inc/');
}

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'bearded_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Register menus. */
	add_theme_support( 
		'hybrid-core-menus', 
		array( 'primary' ) 
	);

	/* Register sidebars. */
	add_theme_support( 
		'hybrid-core-sidebars', 
		array( 'primary') 
	);

	/* Load scripts. */
	add_theme_support( 
		'hybrid-core-scripts', 
		array( 'comment-reply' ) 
	);

	/* Load styles. */
	add_theme_support( 
		'hybrid-core-styles', 
		array( 'gallery', 'style' )
	);

	add_theme_support( 
		'hybrid-core-theme-settings',
		array( 'about', 'footer' )
	);

	add_theme_support( 
		'animate-slider',
		array(  'link', 'button', 'caption-style', 'caption-position', 'background')
	);

	if ( is_admin() )
		require_once( trailingslashit( BEARDED_INC ) . 'functions-admin.php' );

	add_theme_support( 'post-thumbnails' );
	
	/* Load widgets. */
	add_theme_support( 'hybrid-core-widgets' );

	/* Load shortcodes. */
	add_theme_support( 'hybrid-core-shortcodes' );

	/* Load the media grabber. */
	add_theme_support( 'hybrid-core-media-grabber' );

	/* Enable theme layouts (need to add stylesheet support). */
	add_theme_support( 
		'theme-layouts', 
		array( '1c', '2c-l', '2c-r' ), 
		array( 'default' => '2c-l', 'customizer' => true ) 
	);

	/* Support pagination instead of prev/next links. */
	add_theme_support( 'loop-pagination' );

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );

	/* Nicer [gallery] shortcode implementation. */
	add_theme_support( 'cleaner-gallery' );

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Automatically add feed links to <head>. */
	add_theme_support( 'automatic-feed-links' );

	/* Post formats. */
	add_theme_support( 
		'post-formats', 
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/* Custom background. */
	add_theme_support( 
		'custom-background',
		array( 'default-color' => 'f3f3f3' )
	);

	add_action( 'init', 'bearded_image_size' );


	add_action( 'widgets_init', 'bearded_footer_sidebar', 50);

	add_filter( "{$prefix}_sidebar_defaults", 'bearded_sidebar_default_setting', 10);

	add_filter( 'wp_tag_cloud', 'bearded_no_inline_style_tag_cloud' );

	add_filter( "{$prefix}_list_comments_args", 'bearded_filter_comment_args', 10);

	add_filter('post_class', 'bearded_post_class_last', 10, 3);

	add_shortcode( 'gallery-carousel' , 'bearded_gallery_carousel_shortcode' );

	add_action( 'ccp_item_info_meta_box', 'bearded_portfolio_metabox', 10, 2 );

	add_action( 'save_post', 'bearded_save_portfolio_meta', 10, 2 );

	add_action( 'admin_enqueue_scripts', 'bearded_enqueue_portfolio_script' );

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 570 );

	add_filter( 'embed_defaults', 'bearded_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'bearded_disable_sidebars' );

	add_action( 'template_redirect', 'bearded_set_column' );

	add_action( "{$prefix}_open_main_row", "bearded_open_main_row_hook", 1 );

	add_action( "{$prefix}_close_main_row", "bearded_close_main_row_hook", 1 );

	add_theme_support( 'color-palette', array( 'callback' => 'bearded_register_colors' ) );

	add_action( 'wp_head', 'bearded_wp_head_shadow_css' );

	add_filter( "{$prefix}_footer_content", "bearded_footer_content" );

	if( function_exists( 'is_woocommerce') ) {
		require_once( BEARDED_INC . 'functions-woocommerce.php');
		require_once( BEARDED_INC . 'widgets/widget-home-product.php');
	}

	add_action('init', 'bearded_setup_admin_bar');

}


/**
 * Set up image size for bearded
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_image_size() {
	set_post_thumbnail_size( 575, 350, true);
	add_image_size( 'featured-slider', 1160, 480, true);
	add_image_size( 'featured-slider-content',530,480,true);
	add_image_size( 'home-thumbnail',300,300);
	add_image_size( 'portfolio-thumbnail',500,500);
}

/**
 * remove inline style in tag cloud
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function bearded_no_inline_style_tag_cloud( $list ) { 
    $list = preg_replace('/style=("|\')(.*?)("|\')/','',$list); 
    return $list; 
}

/**
 * Filter sidebar default before_title and after_title
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_sidebar_default_setting( $defaults ) {
	$defaults['before_title'] = '<h3 class="widget-title"><span>';
	$defaults['after_title'] = '</span></h3>';
	return $defaults;
}


/**
 * Register sidebar widget in footer
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_footer_sidebar() {
	$sidebars = array(
		'footer-1' => array(
							'id' => 'footer-1',
							'name' => _x( 'Footer 1', 'sidebar', 'bearded' ),
						),
		'footer-2' => array(
							'id' => 'footer-2',
							'name' => _x( 'Footer 2', 'sidebar', 'bearded' ),
						),
		'footer-3' => array(
							'id' => 'footer-3',
							'name' => _x( 'Footer 3', 'sidebar', 'bearded' ),
						)
	);


	/* Set up some default sidebar arguments. */
	$defaults = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	);


	$home_sidebar = array(
		'id' => 'homepage',
		'name' => _x( 'Home Page', 'sidebar', 'bearded' ),
	);

	$shop_sidebar = array(
		'id' => 'shop',
		'name' => _x( 'Shop', 'sidebar', 'bearded'),
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>'
	);

	$home_sidebar = wp_parse_args( $home_sidebar, $defaults );
	$shop_sidebar = wp_parse_args( $shop_sidebar, $defaults );

	register_sidebar($home_sidebar);
	register_sidebar($shop_sidebar);
	
	/* Parse the sidebar arguments and defaults. */
	for( $i = 1; $i <= 3; $i++ ) {

		$args = wp_parse_args( $sidebars[ 'footer-'. $i ], $defaults );
		/* Register the sidebar. */
		register_sidebar( $args );
	}

	
}

/**
 * Enqueue Bearded required javascript files
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_enqueue_scripts() {
	if(!is_admin()) {
		wp_enqueue_script( 'modernizer', BEARDED_JS . 'libs/custom.modernizr.js' , array(), false, false );
		wp_enqueue_script( 'imagesloaded', BEARDED_JS . 'libs/imagesloaded.min.js' , array('jquery'), '3.0.4', true );
		wp_enqueue_script( 'shuffle', BEARDED_JS . 'libs/jquery.shuffle.min.js' , array('jquery'), false, true );
		wp_enqueue_script( 'fitvids', BEARDED_JS . 'libs/jquery.fitvids.js' , array('jquery'), false, true );

		if( wp_script_is( 'bxslider', 'registered' ) === false ) {
			wp_register_script( 'bxslider', BEARDED_JS . 'libs/jquery.bxslider.min.js', array('jquery'), '', true );
		}

		wp_enqueue_script( 'custom', BEARDED_JS . 'custom.js' , array('jquery'), '0.1', true );

		wp_enqueue_style( 'font-awesome', BEARDED_CSS . 'font-awesome.css' , '', '3.0', 'all'  );

		$params = array(
			'i18n_add_wishlist' => esc_attr__( 'Add to wishlist', 'bearded' ),
			'i18n_exists_wishlist' => esc_attr__( 'Product already in the wishlist', 'bearded' ),
			'i18n_added_wishlist' => esc_attr__( 'Product added to wishlist', 'bearded' ),
		);

		wp_localize_script( 'custom', 'bearded_woocommerce', apply_filters( 'bearded_woocommerce', $params ) );

	}


}
add_action('wp_enqueue_scripts', 'bearded_enqueue_scripts');


/**
 * Filters the first and last nav menu objects in your menus
 * to add custom classes.
 *
 * This also supports nested menus.
 *
 * @since 0.1.0
 * @access public
 * @param array $objects An array of nav menu objects
 * @param object $args Nav menu object args
 * @return object $objects Amended array of nav menu objects with new class
 */
function bearded_first_and_last_menu_class( $objects, $args ) {

	
   // Add first/last classes to nested menu items
    $ids        = array();
    $parent_ids = array();
    $top_ids    = array();
    foreach ( $objects as $i => $object ) {
    	
        // If there is no menu item parent, store the ID and skip over the object
        if ( 0 == $object->menu_item_parent ) {
            $top_ids[$i] = $object;
            continue;
        }

        // Add first item class to nested menus
        if ( ! in_array( $object->menu_item_parent, $ids ) ) {
            $objects[$i]->classes[] = 'first-menu-item';
            $ids[]          = $object->menu_item_parent;
        }

        // If we have just added the first menu item class, skip over adding the ID
        if ( in_array( 'first-menu-item', $object->classes ) )
            continue;

        // Store the menu parent IDs in an array
        $parent_ids[$i] = $object->menu_item_parent;
    }

    // Remove any duplicate values and pull out the last menu item
    $sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );

    // Loop through the IDs and add the last menu item class to the appropriate objects
    foreach ( $sanitized_parent_ids as $i => $id )
        $objects[$i]->classes[] = 'last-menu-item';

    $keys = array_keys( $top_ids );
    // Finish it off by adding classes to the top level menu items
    $objects[1]->classes[] = 'first-menu-item'; // We can be assured 1 will be the first item in the menu :-)
    $objects[end( $keys )]->classes[] = 'last-menu-item';

    // Return the menu objects
    return $objects;
}
add_filter('wp_nav_menu_objects', 'bearded_first_and_last_menu_class', 10 , 2);


/**
 * Social Icon list array
 *
 * @since  0.1.0
 * @access public
 * @return array()
 */
function bearded_get_social_lists() {

	$social_lists = array(
		'facebook' => esc_url( hybrid_get_setting('bearded_social_facebook') ),
		'twitter' => esc_url( hybrid_get_setting('bearded_social_twitter') ),
		'pinterest' => esc_url( hybrid_get_setting('bearded_social_pinterest') ),
		'dribbble' => esc_url( hybrid_get_setting('bearded_social_dribbble') ),
		'github' => esc_url( hybrid_get_setting('bearded_social_github') ),
		'google-plus' => esc_url( hybrid_get_setting('bearded_social_google-plus') ),
		'tumblr' => esc_url( hybrid_get_setting('bearded_social_tumblr') ),
		'linkedin' => esc_url( hybrid_get_setting('bearded_social_linkedin') ),
	);

	return $social_lists;
		
}

/**
 * Generating post format icon
 *
 * @since  0.1.0
 * @access public
 * @param $format string (post format)
 * @return string
 */
function bearded_get_post_format_icon( $format = '' ) {
	global $post;
		$o = '<a href="' . get_post_format_link( $format ) . '" title="' . sprintf( __( 'Browse %s posts','bearded' ), $format ) .'">';

		switch ($format) {

			case 'aside':
				$o .= apply_atomic( 'aside_format_icon', '<i class="icon-paper-clip"></i>' );
			break;

			case 'audio':
				$o .= apply_atomic( 'audio_format_icon', '<i class="icon-headphones"></i>' );
			break;

			case 'chat':
				$o .= apply_atomic( 'chat_format_icon', '<i class="icon-comments"></i>' );
			break;

			case 'image':
				$o .= apply_atomic( 'image_format_icon', '<i class="icon-camera"></i>' );
			break;

			case 'gallery':
				$o .= apply_atomic( 'gallery_format_icon', '<i class="icon-picture"></i>' );
			break;

			case 'link':
				$o .= apply_atomic( 'link_format_icon', '<i class="icon-link"></i>' );
			break;

			case 'quote':
				$o .= apply_atomic( 'quote_format_icon', '<i class="icon-quote-left"></i>' );
			break;

			case 'status':
				$o .= apply_atomic( 'status_format_icon', '<i class="icon-file"></i>' );
			break;

			case 'video':
				$o .= apply_atomic( 'video_format_icon', '<i class="icon-play"></i>' );
			break;

			case 'portfolio':
				$o .= apply_atomic( 'portfolio_item_icon', '<i class="icon-briefcase"></i>' );
			break;
			
			default:
				$o .= apply_atomic( 'standard_format_icon', '<i class="icon-file"></i>' );
			break;

		}
		$o .= '</a>';
		return apply_atomic('post_format_icon', $o);
}


/**
 * Echo Post format icon
 *
 * @since  0.1.0
 * @access public
 * @param $format string (post format)
 * @return string
 */
function bearded_post_format_icon( $format = '' ) {
	echo bearded_get_post_format_icon( $format );
}


/**
 * Filter avatar size in comment args
 *
 * @since  0.1.0
 * @access public
 * @param $args array()
 * @return $args array
 */
function bearded_filter_comment_args( $args ) {
	$args['avatar_size'] = 51;
	return $args;
}


/**
 * Filter post class, add post-last into the last post for each post page
 *
 * @since  0.1.0
 * @access public
 * @param $classes array()
 * @param $class string
 * @param $post_id string
 * @return array
 */
function bearded_post_class_last( $classes, $class, $post_id ) {

	global $wp_query;


	if(!is_singular() && $wp_query->post_count == $wp_query->current_post + 1) {
		$classes[] = 'post-last';
	}

	if( is_singular() && ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) ) ) {
		$classes[] = 'singular-no-comments';
	}

	return $classes;
}


/**
 * Shortcode function for running gallery-carousel
 *
 * @since  0.1.0
 * @access public
 * @param $attr array()
 * @return string
 */

function bearded_gallery_carousel_shortcode( $attr ) {

	global $post;

	if( wp_script_is('bxslider', 'enqueued') === false ) {
		wp_enqueue_script( 'bxslider' );
	}

	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$o = apply_filters('post_gallery_carousel', '', $attr);

	if ( $o != '' )
		return $o;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	$layout = get_theme_mod('theme_layout');

	$size = 'post-thumbnail';
	if($layout === '1c') {
		$size = 'featured-slider';
	}
	
	$defaults = array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'size'       => $size,
		'include'    => '',
		'exclude'    => ''
	);

	$attr = shortcode_atts( $defaults, $attr );

	extract($attr);

	$id = intval($id);

	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';



	$item = '';
	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
			$image_output = wp_get_attachment_link( $id, $size, false, false );
		elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
			$image_output = wp_get_attachment_image( $id, $size, false );
		else
			$image_output = wp_get_attachment_link( $id, $size, true, false );

		$item .= '<div class="gallery-carousel-item">';
		$item .= $image_output;

		if( !empty($attachment->post_excerpt) ) {
			$item .= '<div class="carousel-caption gallery-carousel-caption">';
			$item .= wptexturize( $attachment->post_excerpt );
			$item .= '</div>'; // close caption
		}
		
		$item .= '</div>'; // close gallery-carousel-item
	}
	

	$o .= '<div class="bearded-gallery-carousel-container">';
	$o .= '<div id="bearded-gallery-carousel-'.$instance.'" class="bearded-gallery-carousel">';

    $o .= $item;
   
    $o .= '</div>';
    $o .= '<div class="bearded-carousel-control" id="bearded-gallery-carousel-'.$instance.'-control"></div>';
    $o .= '</div>';

    return $o;
}


/**
 * Called in not singular post format gallery.
 * Turn gallery into a slideshow.
 *
 * @since  0.1.0
 * @access public
 * @return do_shortcode(gallery-carousel)
 */

function bearded_gallery_carousel() {
	global $post;

	$content = $post->post_content;

	/* Finds matches for shortcodes in the content. */
	preg_match_all( '/' . get_shortcode_regex() . '/s', $content , $matches, PREG_SET_ORDER );

	/* If matches are found, loop through them and check if they match one of WP's media shortcodes. */
	if ( !empty( $matches ) ) {

		foreach ( $matches as $shortcode ) {
			/* Call the method related to the specific shortcode found and break out of the loop. */
			if ( in_array( $shortcode[2], array( 'embed', 'gallery' ) ) ) {

					$original_media = array_shift( $shortcode );
		
					if( shortcode_exists('gallery-carousel') )	{

						$original_media = str_replace('[gallery', '[gallery-carousel', $original_media);

					}	
					
					echo apply_atomic_shortcode('gallery_carousel', $original_media );

				break;
			}
		}
	}
}

/**
 * Filter and add metabox to Portfolio Info
 *
 * @since  0.1.0
 * @access public
 * @param $object OBJECT
 * @param $box optional
 * @return void
 */
function bearded_portfolio_metabox( $object, $box ) {

	$client = esc_attr(get_post_meta( $object->ID, 'ccp-portfolio-item-client', true));
	$date = esc_attr(get_post_meta( $object->ID, 'ccp-portfolio-item-date', true));
	wp_nonce_field( basename( __FILE__ ), 'ccp-portfolio-item-detail-nonce' ); ?>

	<p>
		<label for="ccp-portfolio-item-client"><?php _e( 'Client:', 'bearded' ); ?></label>
		<br />
		<input type="text" style="width:99%" name="ccp-portfolio-item-client" id="ccp-portfolio-item-client" value="<?php echo $client; ?>" />
	</p>

	<p>
		<label for="ccp-portfolio-item-date"><?php _e( 'Date:', 'bearded' ); ?></label>
		<br />
		<input type="text" style="width:99%" class="portfolio-datepicker" name="ccp-portfolio-item-date" id="ccp-portfolio-item-date" value="<?php echo $date; ?>" />
	</p>

<?php
}

/**
 * Saving Portfolio Meta
 *
 * @since  0.1.0
 * @access public
 * @param $post_id string ID
 * @param $post object
 * @return void
 */
function bearded_save_portfolio_meta( $post_id, $post = '' ) {

	/* Fix for attachment save issue in WordPress 3.5. @link http://core.trac.wordpress.org/ticket/21963 */
	if ( !is_object( $post ) )
		$post = get_post();

	/* Verify the nonce before proceeding. */
	/* The nonce is use custom nonce generated while creating the output */
	/* Dunno why cannot use default nonce by ccp looks like already used before this post is saved */
	if ( !isset( $_POST['ccp-portfolio-item-detail-nonce'] ) || !wp_verify_nonce( $_POST['ccp-portfolio-item-detail-nonce'], basename( __FILE__ ) ) )
		return $post_id;

	$meta = array(
		'ccp-portfolio-item-client' => sanitize_text_field( esc_attr( $_POST['ccp-portfolio-item-client'] ) ),
		'ccp-portfolio-item-date' => sanitize_text_field( esc_attr( $_POST['ccp-portfolio-item-date'] ) ),
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

/**
 * Enqueue scripts for use in portfolio_item post type to make the date input field into datepicker
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_enqueue_portfolio_script( $hook ) {

	global $post;

	if( ($hook == 'post-new.php' || $hook == 'post.php') && $post->post_type === 'portfolio_item') {
		wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
  		wp_enqueue_style( 'jquery-ui' );   
		wp_enqueue_script( 'bearded-portfolio-admin', trailingslashit( BEARDED_JS ) . 'admin/portfolio.js', array('jquery', 'jquery-ui-datepicker') , '1.0' );
	}
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since  0.1.0
 * @param  array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function bearded_disable_sidebars( $sidebars_widgets ) {
	global $wp_customize;

	$customize = ( is_object( $wp_customize ) && $wp_customize->is_preview() ) ? true : false;

	if ( (!is_admin() && !$customize && '1c' == get_theme_mod( 'theme_layout' )) || is_page_template( 'page-templates/home.php' ) ) {
		$sidebars_widgets['primary'] = false;
		$sidebars_widgets['shop'] = false;
	}	

	return $sidebars_widgets;
}


/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_set_column() {


	if( function_exists('is_woocommerce') && is_woocommerce() && !is_active_sidebar('shop') ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_one_column' );
	} 
	elseif( ( function_exists( 'is_cart' ) && is_cart() ) ||  ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_one_column' );
	}
	elseif( function_exists( 'is_account_page') && is_account_page() && !is_active_sidebar('shop') ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_one_column' );
	}
	elseif ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_one_column' );
	}
	elseif ( is_attachment() && wp_attachment_is_image() ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_one_column' );
	}
	elseif ( is_page_template( 'page-templates/portfolio-3.php' ) || is_page_template( 'page-templates/portfolio-4.php' ) ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_one_column' );
	}
	elseif ( is_singular() && 'default' === get_post_layout( get_queried_object_id() ) ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_theme_layout_default_column' );
	}
	elseif( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		add_filter( 'theme_mod_theme_layout', 'bearded_woocommerce_column' );
	}
	
}

/**
 * Filters custom woocommerce page.
 *
 * @since  0.1.4
 * @return boolean
 */
function bearded_is_woopage() {
	if( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_account_page' ) && is_account_page() ) ) {
		return true;
	}
}

function bearded_woocommerce_column() {

	$layout = get_post_layout( wc_get_page_id( 'shop' ) );
	return $layout;
}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since  0.1.0
 * @param  string $layout The layout of the current page.
 * @return string
 */
function bearded_theme_layout_one_column( $layout ) {
	return '1c';
}

function bearded_theme_layout_default_column( $layout ) {
	return '2c-l';
}


/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $args
 * @return array
 */
function bearded_embed_defaults( $args ) {

	$args['width'] = 570;

	if ( current_theme_supports( 'theme-layouts' ) && '1c' == get_theme_mod( 'theme_layout' ) )
		$args['width'] = 930;

	return $args;
}

/**
 * Output the featured image post thumbnail base on layout size and post format.
 *
 * @since  0.1.0
 * @access public
 * @return string html
 */
function bearded_post_thumbnail() {
	$o = '';
	$layout = get_theme_mod('theme_layout'); 
	if( current_theme_supports('get-the-image') ) {
		if($layout === '1c') {
			if( get_post_format() === 'image' ) {
				$o = get_the_image( array( 'meta_key' => false, 'link_to_post' => false, 'before' => '<div class="featured-image">', 'size' => 'featured-slider', 'after' => '</div>' ) );
			} else {
				$o = get_the_image( array( 'before' => '<div class="featured-image">', 'size' => 'featured-slider', 'after' => '</div>' ) );
			}
			
		} else {
			if( get_post_format() === 'image' ) {
				$o = get_the_image( array( 'meta_key' => false, 'link_to_post' => false, 'before' => '<div class="featured-image">', 'size' => 'post-thumbnail', 'after' => '</div>' ) );
			}
			else {
				$o = get_the_image( array( 'before' => '<div class="featured-image">', 'size' => 'post-thumbnail', 'after' => '</div>' ) );
			}
		}
	}

	echo $o;
}


function bearded_open_main_row_hook() {

	$layout = get_theme_mod('theme_layout');
	if(empty($layout)) {
		$layout = get_post_layout(get_queried_object_id());
	}
	if($layout == '2c-r' ) {

		if( ( function_exists('is_woocommerce') && is_woocommerce() ) || bearded_is_woopage() ) {
			get_sidebar( 'shop' );
		} else {
			get_sidebar( 'primary' );
		}
		
	}
}

function bearded_close_main_row_hook() {

	$layout = get_theme_mod('theme_layout');

	if(empty($layout)) {
		
		$layout = get_post_layout(get_queried_object_id());
	}
	if($layout == '2c-l' || $layout == 'default') {

		if( ( function_exists('is_woocommerce') && is_woocommerce() ) || bearded_is_woopage() ) {
			get_sidebar( 'shop' );
		} else {
			get_sidebar( 'primary' );
		}
	}
}


/**
 * Returns a link to the porfolio item URL if it has been set.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bearded_get_portfolio_item_link() {

	$url = get_post_meta( get_the_ID(), 'portfolio_item_url', true );

	if ( !empty( $url ) )
		return '<span class="project-url"><strong>' . __( 'Project <abbr title="Uniform Resource Locator">URL</abbr>:', 'bearded' ) . '</strong> <a class="portfolio-item-link" href="' . esc_url( $url ) . '">' . $url . '</a></span> ';
}


/**
 * Registers colors for the Color Palette extension.
 *
 * @since  0.1.0
 * @access public
 * @param  object  $color_palette
 * @return void
 */
function bearded_register_colors( $color_palette ) {

	/* Add custom colors. */
	$color_palette->add_color(
		array( 'id' => 'primary', 'label' => __( 'Primary Color', 'bearded' ), 'default' => 'f47e00' )
	);
	
	/* Add rule sets for colors. */

	$color_palette->add_rule_set(
		'primary',
		array(
			'color'               => '.shop-nav ul.cart > li .widget ul li a:hover, .shop-nav ul.account-menu li a:hover, .shop-nav ul.account-menu li a:focus, .added_to_cart:hover, .added_to_cart:focus, ul.products .hentry .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover, ul.products .hentry .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,.add_to_cart_button.button:hover, .product_type_variable.button:hover, ul.products .hentry .product-details h3 a:hover, a,.entry-title a:hover,.blog .format-link .entry-link:hover, .archive .format-link .entry-link:hover, .taxonomy .format-link .entry-link:hover,.page-links a:hover,.loop-pagination .page-numbers:hover, .loop-pagination .page-numbers.current,.woocommerce-pagination .page-numbers:hover, .woocommerce-pagination .page-numbers.current,.sidebar ul li a:hover,.sidebar ul li.recentcomments a:hover,.sidebar .widget_calendar table tbody td a, .sidebar .widget-calendar table tbody td a,#comments ol.comment-list .comment-author a:hover,#footer a:hover, #main-home .widget-entry-title h3 a:hover,.page-template-portfolio-4 .portfolio-entry-title a:hover, .page-template-portfolio-3 .portfolio-entry-title a:hover,#shuffle-filters li a:hover, #shuffle-filters li a.active',
			'background-color'    => '.shop-nav ul.cart > li.cart-container a.cart-button:hover, .pp_inline #respond p.stars a.active, .pp_inline #respond p.stars a:hover, .pp_inline #respond p.stars a:focus, #respond input[type="submit"], #reviews #review_form p.stars a.active, #reviews #review_form p.stars a:hover, #reviews #review_form p.stars a:focus, .shop-nav ul.account-menu li.active a, #reviews .add_review .button:hover, ul.products .hentry .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, ul.products .hentry .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a, button, .button, button.disabled, button[disabled], .button.disabled, .button[disabled],button.disabled:hover, button.disabled:focus, button[disabled]:hover, button[disabled]:focus, .button.disabled:hover, .button.disabled:focus, .button[disabled]:hover, .button[disabled]:focus,#navigation #menu-toggle:hover,.bearded-carousel-control .bx-prev:hover, .bearded-carousel-control .bx-next:hover,.hentry .entry-side .comment-count a,.hentry .entry-side .entry-client time:hover, .hentry .entry-side .entry-client a:hover, .hentry .entry-side .entry-client span:hover, .hentry .entry-side .entry-edit time:hover, .hentry .entry-side .entry-edit a:hover, .hentry .entry-side .entry-edit span:hover, .hentry .entry-side .entry-published time:hover, .hentry .entry-side .entry-published a:hover, .hentry .entry-side .entry-published span:hover, .hentry .entry-side .entry-format time:hover, .hentry .entry-side .entry-format a:hover, .hentry .entry-side .entry-format span:hover,.sidebar ul li.recentcomments a.url:hover,.sidebar .tagcloud a:hover, .sidebar .widget-tags a:hover,.sidebar .widget_calendar table caption, .sidebar .widget-calendar table caption,#footer .footer-social li a:hover,#main-home .services-icon',
			'border-left-color'   => '#navigation #menu-primary ul li > ul:before',
			'border-bottom-color' => '#navigation #menu-primary ul:before',
			'border-color'		  => 'input[type="text"]:focus,input[type="password"]:focus,input[type="date"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="month"]:focus,input[type="week"]:focus,input[type="email"]:focus,input[type="number"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="time"]:focus,input[type="url"]:focus,textarea:focus, .sidebar .widget_calendar table caption, .sidebar .widget-calendar table caption'
		)
	);
}

function bearded_wp_head_shadow_css() {
	$hex = get_theme_mod( 'color_palette_primary' );
	echo '<style>.shop-nav ul.cart > li.cart-container a.cart-button:hover .contents { background-color: #'.bearded_color_mod( $hex, 'darker', '5' ).' } .shop-nav ul.cart > li.cart-container a.cart-button .contents { background-color: #'.bearded_color_mod( $hex, 'darker', '2' ).'} a:hover, a:focus { color: #'.bearded_color_mod( $hex, 'darker', '2' ).'} #navigation #menu-primary ul { box-shadow: 0 4px 0 #'.$hex.' inset !important; -moz-box-shadow: 0 4px 0 #'.$hex.' inset !important; -webkit-box-shadow: 0 4px 0 #'.$hex.' inset  !important; } @media only screen and (min-width: 768px){ #navigation #menu-primary ul li > ul.sub-menu, #navigation #menu-primary ul li > ul.children { box-shadow: 4px 0 0 #'.$hex.' !important; -moz-box-shadow: 4px 0 0 #'.$hex.' !important; -webkit-box-shadow: 4px 0 0 #'.$hex.' !important;} }</style>';
}

class Portfolio_Walker extends Walker_Category {
    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
            extract($args);
            $cat_name = esc_attr( $category->name );
            $cat_name = apply_filters( 'list_cats', $cat_name, $category );
            $link = '<a href="' . esc_attr( get_term_link($category) ) . '" ';
            $link .= 'data-filter="' . urldecode($category->slug) . '" ';
            if ( $use_desc_for_title == 0 || empty($category->description) )
                    $link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s', 'bearded' ), $cat_name) ) . '"';
            else
                    $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
            $link .= '>';
            $link .= $cat_name . '</a>';

            if ( !empty($feed_image) || !empty($feed) ) {
                    $link .= ' ';

                    if ( empty($feed_image) )
                            $link .= '(';

                    $link .= '<a href="' . get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) . '"';

                    if ( empty($feed) ) {
                            $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s', 'bearded' ), $cat_name ) . '"';
                    } else {
                            $title = ' title="' . $feed . '"';
                            $alt = ' alt="' . $feed . '"';
                            $name = $feed;
                            $link .= $title;
                    }

                    $link .= '>';

                    if ( empty($feed_image) )
                            $link .= $name;
                    else
                            $link .= "<img src='$feed_image'$alt$title" . ' />';

                    $link .= '</a>';

                    if ( empty($feed_image) )
                            $link .= ')';
            }

            if ( !empty($show_count) )
                    $link .= ' (' . intval($category->count) . ')';

            if ( !empty($show_date) )
                    $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);

            if ( 'list' == $args['style'] ) {
                    $output .= "\t<li";
                    $class = 'cat-item cat-item-' . $category->term_id;
                    if ( !empty($current_category) ) {
                            $_current_category = get_term( $current_category, $category->taxonomy );
                            if ( $category->term_id == $current_category )
                                    $class .=  ' current-cat';
                            elseif ( $category->term_id == $_current_category->parent )
                                    $class .=  ' current-cat-parent';
                    }
                    $output .=  ' class="' . $class . '"';
                    $output .= ">$link\n";
            } else {
                    $output .= "\t$link<br />\n";
            }
    }
}

function bearded_as_bg_size($size) {
	return 'featured-slider';
}

add_filter('animate_slider_bg_size', 'bearded_as_bg_size');

function bearded_featured_slider() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if( is_plugin_active( 'animate-slider/animate-slider.php' ) ) {
		echo apply_atomic_shortcode('featured_slider', '[as-slider]');
	}
}

function bearded_footer_content( $content ) {
	$footer = hybrid_get_setting( 'footer_insert' );
	if( !empty( $footer ) ) {
		return '<p class="credit">' . wp_kses_post( $footer ) . '</p>';
	} else {
		return $content;
	}
}

function bearded_color_mod($color, $shade, $amount) {
		//remove # from the begiining if available and make sure that it gets appended again at the end if it was found
		$newcolor = "";
		$prepend = "";
		if(strpos($color,'#') !== false) 
		{ 
			$prepend = "#";
			$color = substr($color, 1, strlen($color)); 
		}
		
		//iterate over each character and increment or decrement it based on the passed settings
		$nr = 0;
	while (isset($color[$nr])) 
	{
		$char = strtolower($color[$nr]);
		
		for($i = $amount; $i > 0; $i--)
		{
			if($shade == 'lighter')
			{
				switch($char)
				{
					case 9: $char = 'a'; break;
					case 'f': $char = 'f'; break;
					default: $char++;
				}
			}
			else if($shade == 'darker')
			{
				switch($char)
				{
					case 'a': $char = '9'; break;
					case '0': $char = '0'; break;
					default: $char = chr(ord($char) - 1 );
				}
			}
		}
		$nr ++;
		$newcolor.= $char;
	}
		
	$newcolor = $prepend.$newcolor;
	return $newcolor;
}

/**
 * @since 1.0
 * Show admin bar only for role above subscriber
 *
 */
function bearded_setup_admin_bar() {
	if (!current_user_can('delete_posts') ) {
	  show_admin_bar(false);
	}
}

/**
 * @since 1.0.3
 * Show admin bar only for role above subscriber
 *
 */
function bearded_add_menu_id( $page_markup ) {

	preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);

	$divclass = $matches[1];
	$toreplace = array('<div class="'.$divclass.'">', '</div>');
	$new_markup = str_replace($toreplace, '', $page_markup);
	$new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
	return $new_markup;
}

add_filter('wp_page_menu', 'bearded_add_menu_id');

require_once( BEARDED_INC . 'widgets/widget-home-cta.php');
require_once( BEARDED_INC . 'widgets/widget-home-clients.php');
require_once( BEARDED_INC . 'widgets/widget-home-posts.php');
require_once( BEARDED_INC . 'widgets/widget-home-services.php');
require_once( BEARDED_INC . 'class-nav-menu.php');
require_once( BEARDED_INC . 'class-tgm-plugin-activation.php');


add_action( 'tgmpa_register', 'bearded_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function bearded_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

       
        array(
			'name' 		=> 'Animate Slider',
			'slug' 		=> 'animate-slider',
			'required' 	=> false,
		),
		
        array(
			'name' 		=> 'WooCommerce - excelling eCommerce',
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),

		array(
			'name' 		=> 'YITH WooCommerce Wishlist',
			'slug' 		=> 'yith-woocommerce-wishlist',
			'required' 	=> false,
		),

		array(
			'name' 		=> 'Custom Content Portfolio',
			'slug' 		=> 'custom-content-portfolio',
			'required' 	=> false,
		),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'bearded',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );

}
?>