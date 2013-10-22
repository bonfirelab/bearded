<?php
/**
 * Pingback Comment Template
 *
 * The pingback comment template displays an individual pingback comment.
 *
 * @package Chun
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/chun
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

	global $post, $comment;
?>

	<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

		<?php do_atomic( 'open_comment' ); // chun_open_comment ?>

		<div class="comment-side">
			<?php echo hybrid_avatar(); ?>
		</div>

		<?php echo apply_atomic_shortcode( 'comment_author', '[comment-author]'); ?>
		<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-published][comment-permalink before="<span class=\'comment-meta-divider\'>/</span>"][comment-edit-link before="<span class=\'comment-meta-divider\'>/</span>"]</div>' ); ?>


		<?php do_atomic( 'close_comment' ); // chun_close_comment ?>

	<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>