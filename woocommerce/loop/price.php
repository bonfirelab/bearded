<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ( $price_html = woocommerce_price( $product->get_price() ) ) : ?>
	<span class="price"><?php echo $price_html; ?></span>
<?php endif; ?>