<div class="entry-side show-for-large-up">
	

	<?php if(get_post_format() != 'aside') { ?>

		<?php $avatar = get_avatar( get_the_author_meta( 'ID' ), 71, trailingslashit( BEARDED_IMAGES ) . 'avatar.png' , sprintf( __('Posted by: %1$s', 'bearded'), get_the_author_meta( 'display_name' ) )  ); ?>
		<?php echo '<figure class="author-bio vcard clear"><a href="'. esc_url( get_author_posts_url( get_the_author_meta('ID') ) ) .'" title="'.sprintf( __('Posted by: %1$s', 'bearded'), get_the_author_meta( 'display_name' ) ).'">'. $avatar . '</a></figure>'; ?>
		<?php if($post->comment_count <= '99' ) { ?>
			<span class="comment-count">
				<?php echo '<a class="permalink" href="' . esc_url( get_comments_link() ) . '" title="' . sprintf( esc_attr__( 'Comments on %1$s', 'bearded' ), get_the_title() ) . '">' . $post->comment_count . '</a>'; ?>
			</span>
		<?php } ?>

	<?php } ?>

	<?php 
		if( post_type_supports( get_post_type(), 'post-formats' ) ) {
			echo '<div class="entry-format">';
			bearded_post_format_icon( get_post_format() ); 
			echo '</div>';
		}
	?>

	<?php 
		if( get_post_type() === 'portfolio_item' && !is_singular( 'portfolio_item' )) {
			echo '<div class="entry-format">';
			bearded_post_format_icon( 'portfolio' ); 
			echo '</div>';
		}
	?>
	
	<?php if( get_post_format() != 'quote' && get_post_format() != 'audio'  && get_post_format() != 'link'   && get_post_format() != 'status'   && get_post_format() != 'aside'
	 && get_post_format() != 'audio'  && get_post_format() != 'chat')  { ?>

		<div class="entry-published">
			<?php 
				$the_time = get_the_time( 'Y-m-d\TH:i:sP' ); 
				$the_time_title = get_the_time( esc_attr__( 'l, F jS, Y, g:i a', 'bearded' ) );

				if( get_post_type() == 'portfolio_item' ) {
					$time_meta = esc_attr( get_post_meta( get_the_ID(), 'ccp-portfolio-item-date', true ) );
					if(!empty($time_meta)) {
						$the_time = $time_meta;
						$the_time_title = sprintf(__('Project Created on %1$s', 'bearded'), $time_meta);
					}
				}
			?>
			<time id="time" class="bearded-tip" datetime="<?php echo $the_time; ?>" title="<?php echo $the_time_title; ?>">
				<i class="icon-time"></i>
			</time>
		</div>

	<?php } ?>

	<?php 
		$post_type = get_post_type_object( get_post_type() ); 
		if ( current_user_can( $post_type->cap->edit_post, get_the_ID() ) && is_singular() ) { 
	?>
		<div class="entry-edit">
			<a class="post-edit-link" href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>" title="<?php printf( esc_attr__( 'Edit %1$s', 'bearded' ), $post_type->labels->singular_name ) ; ?>"><i class="icon-pencil"></i></a>
		</div>
	<?php } ?>

	<?php if( is_singular( 'portfolio_item' )) { ?>

		<div class="entry-client">
			<span id="client" class="client bearded-tip" title="<?php echo __('Client: ','bearded') . get_post_meta( get_the_ID(),'ccp-portfolio-item-client', true );?>">
				<i class="icon-user"></i>
			</span>
		</div>

	<?php } ?>
</div>