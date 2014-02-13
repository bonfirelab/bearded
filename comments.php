<?php
/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) ) :
		return; endif; 
?>

<section id="comments">

	<?php if ( have_comments() ) : ?>

		<ol class="comment-list">
			<?php wp_list_comments( hybrid_list_comments_args() ); ?>
		</ol><!-- .comment-list -->

		<?php if ( get_option( 'page_comments' ) && 1 < get_comment_pages_count() ) : ?>

			<div class="comments-nav">
				<?php previous_comments_link( __( '&larr; Previous', 'bearded' ) ); ?>
				<span class="page-numbers"><?php printf( __( 'Page %1$s of %2$s', 'bearded' ), ( get_query_var( 'cpage' ) ? absint( get_query_var( 'cpage' ) ) : 1 ), get_comment_pages_count() ); ?></span>
				<?php next_comments_link( __( 'Next &rarr;', 'bearded' ) ); ?>
			</div><!-- .comments-nav -->

		<?php endif; ?>
		
	<?php endif; ?>

	<?php if ( pings_open() && !comments_open() ) : ?>

		<p class="comments-closed pings-open">
			<?php printf( __( 'Comments are closed, but <a href="%s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.', 'bearded' ), esc_url( get_trackback_url() ) ); ?>
		</p><!-- .comments-closed .pings-open -->

	<?php elseif ( !comments_open() ) : ?>

		<p class="comments-closed">
			<?php _e( 'Comments are closed.', 'bearded' ); ?>
		</p><!-- .comments-closed -->

	<?php endif; ?>

	<?php $fields = array(
            'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="12" aria-required="true"></textarea></p>',
            'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'bearded' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'bearded' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'title_reply' => __('Leave a Reply', 'bearded'),
            'title_reply_to' => __('Leave a Reply to %s', 'bearded'),
            'cancel_reply_link' => __('Cancel Reply', 'bearded'),
            'label_submit' => __('Submit Comment', 'bearded')
	    );

	?>

	<?php comment_form($fields); // Loads the comment form. ?>

</section><!-- #comments -->