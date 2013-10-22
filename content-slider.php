<?php
  $button = get_post_meta( $post->ID, 'bearded-slide-button', true );
  $button = empty( $button ) ? __('Read More', 'bearded') : $button;
  $position = get_post_meta( $post->ID, 'bearded-slide-position', true );
  $link = get_post_meta( $post->ID, 'bearded-slide-link', true );
  $style = get_post_meta( $post->ID, 'bearded-slide-style', true );
  $thumb = get_post_meta( $post->ID, 'bearded-slide-thumb', true );
  $thumb = wp_get_attachment_image_src( $thumb, 'featured-slider-content');
  $thumb = $thumb[0];
  $image = '';
  $image_style = '';
  
  if (has_post_thumbnail( $post->ID ) ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-slider' );
    $image = $image[0];
  }

  if($image) {
    if($style == 'light') {
      $image_style = "background:url({$image}) no-repeat center center #222";
    } else {
      $image_style = "background:url({$image}) no-repeat center center #fff";
    }
  }

?>
<div class="slide-item slide-<?php echo $style; ?>" style="<?php echo $image_style; ?>">

    <div class="slide-caption slide-<?php echo $position; ?>" data-position="<?php echo $position; ?>">
        <h1 class="hide-for-small slide-title"><?php the_title(); ?></h1>
        <?php if($post->post_content != "") { ?>
            <div class="slide-content">
              <div class="hide-for-medium show-for-small">
                <?php the_content(); ?>
              </div>
               <?php if($link) { ?>
                  <a class="slide-more" href="<?php echo esc_url($link); ?>" title="<?php the_title_attribute(); ?>"><?php echo $button; ?></a>
              <?php } ?>
            </div>
        <?php } ?>

    </div>
    <?php if( ( $position != 'center' ) && ( !empty($thumb) ) ) { ?>

        <div class="hide-for-small slide-image slide-<?php echo $position; ?>">
          <img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" />
        </div>
        
      <?php  } ?>
</div>