<?php

add_action( 'init', 'bearded_woocommerce_setup' );

/**
 * @since 1.0 
 * Bearded Woocommerce Setup
 * Setup all the necessary stuff here
 *
 */
function bearded_woocommerce_setup() {

    $prefix = hybrid_get_prefix();

    add_theme_support( 'woocommerce' );

    if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    } else {
        define( 'WOOCOMMERCE_USE_CSS', false );
    }

    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

    add_action( "{$prefix}_before_shop_loop_item_title", 'bearded_open_wrap_product_button', 20 );

    add_action( "{$prefix}_before_shop_loop_item_title", 'woocommerce_template_loop_add_to_cart', 20 );

    add_action( "{$prefix}_before_shop_loop_item_title", 'bearded_wishlist_button', 20 );

    add_action( "{$prefix}_before_shop_loop_item_title", 'bearded_output_content_wrapper_end', 20 );

    add_action( 'woocommerce_before_main_content', 'bearded_output_content_wrapper', 10);

    add_action( 'woocommerce_after_main_content', 'bearded_output_content_wrapper_end', 10);

    add_action( 'woocommerce_before_single_product_summary', 'bearded_before_single_product_summary', 5 );

    add_action( 'woocommerce_after_single_product_summary', 'bearded_output_content_wrapper_end', 10 );

    add_action( 'woocommerce_after_single_product_summary', 'comments_template', 15 );

    add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );

    add_action( 'woocommerce_single_product_summary', 'bearded_single_product_summary_wrap', 1);
    
    add_action( 'woocommerce_single_product_summary', 'bearded_output_content_wrapper_end', 15 );

    add_action( 'woocommerce_cart_collaterals', 'bearded_cart_collaterals', 1 );

    add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 5 );

    add_action( 'woocommerce_cart_collaterals', 'bearded_close_cart_collaterals_cross_sell', 10 );

    add_action( 'woocommerce_after_cart', 'bearded_close_cart_collaterals', 30 );

    add_action( "{$prefix}_before_nav", 'bearded_woocommerce_nav', 20 );

    add_action( "{$prefix}_before_nav", 'bearded_shopping_cart', 10 );

    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 35 );

    add_filter( 'woocommerce_pagination_args', 'bearded_woocommerce_pagination' );

    add_filter( 'woocommerce_product_add_to_cart_text', 'bearded_add_to_cart_text', 10, 2 );

    add_filter( 'woocommerce_params', 'bearded_params');

    add_filter( 'woocommerce_product_tabs', 'bearded_product_tabs' );

    add_filter( 'woocommerce_breadcrumb_defaults', 'bearded_change_breadcrumb_delimiter' );

    add_filter( 'add_to_cart_fragments', 'bearded_add_to_cart_fragment'); // The cart fragment

}

function bearded_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    bearded_cart_button();
    $fragments['a.cart-button'] = ob_get_clean();
    return $fragments;
}

function bearded_shopping_cart() {
   
}
function bearded_woocommerce_nav() {
    global $wp, $post, $yith_wcwl;
    if ( function_exists( 'is_woocommerce' ) ) : ?>
    <nav class="shop-nav">
        <ul class="account-menu">
            <?php if ( is_user_logged_in() ) { ?> 
            <li class="my-account <?php echo ( !empty($post) && $post->ID == wc_get_page_id('myaccount') && !array_key_exists( get_option( 'woocommerce_myaccount_edit_account_endpoint'), $wp->query_vars) ) ? 'active' : ''; ?>">
                <a class="tiptip icon-user" title="<?php _e('My Account','bearded'); ?>" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                    <span class="link-title"><?php _e('My Account','bearded'); ?></span>
                </a>
            </li>
            <li class="edit-account <?php echo ( !empty($post) && $post->ID == wc_get_page_id('myaccount') && array_key_exists( get_option( 'woocommerce_myaccount_edit_account_endpoint'), $wp->query_vars) ) ? 'active' : '';?>">
                <a class="tiptip icon-pencil" title="<?php _e('Edit Account','bearded'); ?>" href="<?php echo wc_customer_edit_account_url(); ?>">
                    <span class="link-title"><?php _e('Edit Account','bearded'); ?></span>
                </a>
            </li>
            <li class="visit-shop <?php echo ( get_query_var( 'post_type' ) == 'product' ) ? 'active' : '';?>">
                <a class="tiptip icon-home" title="<?php _e('Visit Shop','bearded'); ?>" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
                    <span class="link-title"><?php _e('Visit Shop','bearded'); ?></span>
                </a>
            </li>
            <?php if ($yith_wcwl) { ?>
            <li class="wishlist <?php echo ( !empty($post) && $post->ID == get_option( 'yith_wcwl_wishlist_page_id' ) ) ? 'active' : '';?>">
                <a class="tiptip icon-magic" title="<?php _e('View Wishlist','bearded'); ?>" href="<?php echo $yith_wcwl->get_wishlist_url(); ?>">
                    <span class="link-title"><?php _e('View Wishlist','bearded'); ?></span>
                </a>
            </li>
            <?php } ?>
            <li class="logout">
                <a class="tiptip icon-signout" title="<?php _e('Logout','bearded'); ?>" href="<?php echo wp_logout_url(($_SERVER['REQUEST_URI'])); ?>">
                    <span class="link-title"><?php _e('Logout','bearded'); ?></span>
                </a>
            </li>
            <?php } else { ?>
            <li class="visit-shop <?php echo ( get_query_var( 'post_type' ) == 'product' ) ? 'active' : '';?>">
                <a class="tiptip icon-home" title="<?php _e('Visit Shop','bearded'); ?>" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
                    <span class="link-title"><?php _e('Visit Shop','bearded'); ?></span>
                </a>
            </li>
            <li class="login <?php echo ( !empty($post) && $post->ID == wc_get_page_id('myaccount') && !array_key_exists( get_option( 'woocommerce_myaccount_lost_password_endpoint' ) , $wp->query_vars) ) ? 'active' : '';?>">
                <a class="tiptip icon-signin" title="<?php _e('Login','bearded'); ?>" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                    <span class="link-title"><?php _e('Login','bearded'); ?></span>
                </a>
            </li>
            <li class="lost-password <?php echo ( !empty($post) && $post->ID == wc_get_page_id('myaccount') && array_key_exists( get_option( 'woocommerce_myaccount_lost_password_endpoint' ), $wp->query_vars) ) ? 'active' : '';?>">
                <a class="tiptip icon-key" title="<?php _e('Lost Password','bearded'); ?>" href="<?php echo wc_lostpassword_url(); ?>">
                    <span class="link-title"><?php _e('Lost Password','bearded'); ?></span>
                </a>
            </li>
            <?php } ?>
            
        </ul>
        <ul class="cart">
            <li class="cart-container">
                <?php bearded_cart_widget(); ?>
            </li>
        </ul>
    </nav>
    <?php endif;
}

function bearded_close_cart_collaterals_cross_sell() {
    echo '</div><div class="column large-6">';
}
function bearded_close_cart_collaterals() {
    echo '</div></div>';
}

function bearded_cart_collaterals() {
    echo '<div class="row"><div class="column large-6">';
}

function bearded_single_product_summary_wrap() {
    echo '<div class="singular-title-wrap">';
}


/**
 * Setup Add to Cart text based on theme layout, if it's smaller set only a word.
 *
 * @since 1.2.0
 * @return string
 */
function bearded_add_to_cart_text( $text, $product ) {
    if( $product->product_type == 'variable' ) {
        return $text;
    }  

    return __('Add', 'bearded');
}

/**
 * Filter woocommerce pagination argument for paginate_link
 *
 * @since 1.2.0
 * @return array
 */
function bearded_woocommerce_pagination( $args ) {
    $args['prev_text'] = __('Previous', 'bearded');
    $args['next_text'] = __('Next', 'bearded');
    $args['type'] = 'plain';
    $args['end_size'] = 1;
    $args['mid_size'] = 1;
    return $args;
}

/**
 * Output product action wrapper before button
 *
 * @since 1.2.0
 * @return void
 */
function bearded_open_wrap_product_button() {
    echo '<div class="product-actions">';
}

/**
 * Output wishlist button on product archive only if yith_wcwl_add_to_wishlist plugin is installed
 *
 * @since 1.2.0
 * @return void
 */
function bearded_wishlist_button() {

    if(function_exists('shortcode_exists') && shortcode_exists('yith_wcwl_add_to_wishlist') && class_exists('YITH_WCWL') ) {

        global $yith_wcwl, $product;
        $url = $yith_wcwl->get_wishlist_url();
        $product_type = $product->product_type;
        $exists = $yith_wcwl->is_product_in_wishlist( $product->id );

        $icon = '<i class="icon-star"></i>';

        $classes = 'class="add_to_wishlist"';

        $html  = '<div class="yith-wcwl-add-to-wishlist">';
        $html .= '<div class="yith-wcwl-add-button';  // the class attribute is closed in the next row

        $html .= $exists ? ' hide" style="display:none;"' : ' show"';

        $html .= '><a href="' . esc_url( $yith_wcwl->get_addtowishlist_url() ) . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' >' . $icon . '</a>';
        $html .= '</div>';

        $html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a href="' . esc_url( $url ) . '"><i class="icon-ok"></i></a></div>';
        $html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '"><i class="icon-ok"></i></a></div>';
        $html .= '<div style="clear:both"></div><div class="yith-wcwl-wishlistaddresponse"></div>';

        $html .= '</div>';
        $html .= '<div class="clear"></div>';

        $html .= YITH_WCWL_UI::popup_message();

        echo $html;
    }
}

/**
 * Remove review tabs in product tabs
 *
 * @since 1.2.0
 * @return array
 */
function bearded_product_tabs( $tabs = array() ) {

    unset($tabs['reviews']);
    return $tabs;
}


/**
 * Output single product details open wrapper
 *
 * @since 1.2.0
 * @return void
 */
function bearded_before_single_product_summary() {
    echo '<div class="single-product-details">';
}

/**
 * Remove ugly arrow from View Cart text in woocommerce
 *
 * @since 1.2.0
 * @return array
 */
function bearded_params( $params ) {
    $params['i18n_view_cart'] = __('View Cart', 'bearded');
    return $params;
}

/**
 * Remove button label from wcwl ( bearded theme replace it with icon )
 *
 * @since 1.2.0
 * @return string
 */
function bearded_wcwl_button_label() {
    return '';
}

/**
 * Wishlist Icon
 *
 * @since 1.2.0
 * @return string
 */
function bearded_browse_wishlist_label() {
    return '<i class="icon-ok"></i>';
}

/**
 * Setup layout wrapper for the shop
 *
 * @since 1.2.0
 * @return string
 */
function bearded_output_content_wrapper() {
	$layout = get_theme_mod('theme_layout');
	$col_class = 'large-8';

	if($layout === '1c') {
		$col_class = 'large-12';
	}
	?>
	<div id="content" class="hfeed column <?php echo $col_class; ?>">
<?php
}

/**
 * Close div
 *
 * @since 1.2.0
 * @return void
 */
function bearded_output_content_wrapper_end() {
	echo '</div>';
}

/**
 * Change breadcrumb delimiter
 *
 * @since 1.2.0
 * @return array
 */
function bearded_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '<span class="separator">&rsaquo;</span>';
	return $defaults;
}



// Display the cart widget on menu
function bearded_cart_widget() {
    global $woocommerce;

    if ( ! is_cart() && ! is_checkout() ) {
        
        bearded_cart_button();
        
        if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
            the_widget( 'WC_Widget_Cart', 'title=' );
        } else {
            the_widget( 'WooCommerce_Widget_Cart', 'title=' );
        }
        
    }
}

function bearded_cart_button() {
    global $woocommerce;
    $hide_widget    = apply_filters('bearded_cart_button_hide_widget', 'yes' );
    if ( $woocommerce->cart->get_cart_contents_count() == 0 && $hide_widget == 'yes' ) {
        $visibility     = 'hidden';
    } else {
        $visibility     = 'visible';
    }
    ?>
    <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'bearded' ); ?>" class="cart-button icon-shopping-cart <?php echo esc_attr( $visibility ); ?>">
        <?php
            echo wp_kses_post( $woocommerce->cart->get_cart_total() );
            echo '<span class="contents">' . intval( $woocommerce->cart->get_cart_contents_count() ) . '</span>';
        ?>
    </a>
    <?php
}