<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php
	$layout = get_theme_mod('theme_layout');
	$class = '';
	if( $layout !== '1c' ) {
		$class = 'small-block-grid-1 large-block-grid-3';
	} else if( is_cart() || is_checkout() ) {
		$class = 'small-block-grid-1 large-block-grid-2';
	} else {
		$class = 'small-block-grid-1 large-block-grid-4';
	}
?>
<ul class="products <?php echo $class; ?>">