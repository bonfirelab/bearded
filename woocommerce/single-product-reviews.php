<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
global $woocommerce, $product;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! comments_open() )
	return;
?>
<div id="reviews">
	<section id="comments">
		<?php if ( get_option('woocommerce_enable_review_rating') === 'yes' && $count = $product->get_rating_count() ) { ?>

			<?php $average = $product->get_average_rating(); ?>
			<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'bearded' ), $average ); ?>">
					<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
						<strong itemprop="ratingValue" class="rating">
							<?php echo $average; ?>
						</strong> <?php _e('out of 5', 'bearded' ); ?>
					</span>
				</div>

				<h2 class="review-title">
					<?php printf( _n('%s review for %s', '%s reviews for %s', $count, 'bearded'), '<span itemprop="ratingCount" class="count">'.$count.'</span>', get_the_title() ); ?>
				</h2>
			</div>

		<?php } else { ?>

			<h2 class="review-title"><?php _e('Reviews', 'bearded'); ?></h2>

		<?php } ?>
		
		<?php if ( have_comments() ) : ?>

			<ol class="comment-list">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<div class="comments-nav">
					<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Previous', 'woocommerce' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'woocommerce' ) ); ?></div>
				</div>

			<?php endif; ?>

			
		<?php else : ?>

			<p class="noreviews"><?php _e( 'There are no reviews yet', 'woocommerce' ); ?></p>

		<?php endif; ?>

		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

			<p class="add_review"><a href="#review_form" class="inline show_review_form button" title="<?php _e( 'Add Your Review', 'woocommerce' ); ?>"><?php _e( 'Add Your Review', 'woocommerce' ); ?></a></p>
		
		<?php else : ?>

			<p class="woocommerce-verification-required woocommerce-error"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

		<?php endif; ?>

	</section>

<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>


	<div id="review_form_wrapper">

		<div id="review_form">

		<?php 
			$commenter = wp_get_current_commenter();
			$comment_form = array(
				'title_reply' => have_comments() ? __( 'Add a review', 'woocommerce' ) : __( 'Be the first to review', 'woocommerce' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
				'comment_notes_before' => '',
				'comment_notes_after' => '',
				'fields' => array(
					'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . '</label> ' . '<span class="required">*</span>' .
					            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
					'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . '</label> ' . '<span class="required">*</span>' .
					            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
				),
				'label_submit' => __( 'Submit Review', 'woocommerce' ),
				'logged_in_as' => '',
				'comment_field' => ''
			);

			if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {

				$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
					<option value="">'.__( 'Rate&hellip;', 'woocommerce' ).'</option>
					<option value="5">'.__( 'Perfect', 'woocommerce' ).'</option>
					<option value="4">'.__( 'Good', 'woocommerce' ).'</option>
					<option value="3">'.__( 'Average', 'woocommerce' ).'</option>
					<option value="2">'.__( 'Not that bad', 'woocommerce' ).'</option>
					<option value="1">'.__( 'Very Poor', 'woocommerce' ).'</option>
				</select></p>';

			}

			$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>' . $woocommerce->nonce_field('comment_rating', true, false);

			comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
			?>

		</div>
	</div>

<?php endif; ?>

	<div class="clear"></div>
</div>
