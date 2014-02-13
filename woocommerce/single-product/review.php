<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
$rating = esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="comment-side">
			<?php echo hybrid_avatar(); ?>
		</div>
		<span class="comment-author vcard">
			<cite class="fn" itemprop="author">
				<?php comment_author(); ?>
				<?php
				if ( get_option('woocommerce_review_rating_verification_label') == 'yes' ) {
					if ( woocommerce_customer_bought_product( $GLOBALS['comment']->comment_author_email, $GLOBALS['comment']->user_id, $post->ID ) ) {
						echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';
					}
				}
				?>
			</cite>
			
		</span>

		<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>

			<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $rating) ?>">
				<span style="width:<?php echo ( intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
			</div>

		<?php endif; ?>
		<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-published][comment-edit-link before="<span class=\'comment-meta-divider\'>/</span>"]</div>' ); ?>


		<div class="comment-content comment-text">


			<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>

				<?php echo apply_atomic_shortcode( 'comment_moderation', '<p class="alert moderation">' . __( 'Your comment is awaiting moderation.', 'woocommerce' ) . '</p>' ); ?>
			
			<?php endif; ?>

				<div itemprop="description" class="description"><?php comment_text(); ?></div>
				<div class="clear"></div>
			</div>
		<div class="clear"></div>
	</div>
