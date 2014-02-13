<?php
/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Bearded_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
	
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    global $_wp_nav_menu_max_depth;
	   
	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	    ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	        'action',
	        'customlink-tab',
	        'edit-menu-item',
	        'menu-item',
	        'page-tab',
	        '_wpnonce',
	    );
	
	    $original_title = '';
	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	        if ( is_wp_error( $original_title ) )
	            $original_title = false;
	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        $original_title = $original_object->post_title;
	    }
	
	    $classes = array(
	        'menu-item menu-item-depth-' . $depth,
	        'menu-item-' . esc_attr( $item->object ),
	        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	    );
	
	    $title = $item->title;
	
	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        /* translators: %s: title of menu item which is invalid */
	        $title = sprintf( __( '%s (Invalid)', 'bearded' ), $item->title );
	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        /* translators: %s: title of menu item in draft status */
	        $title = sprintf( __('%s (Pending)', 'bearded'), $item->title );
	    }
	
	    $title = empty( $item->label ) ? $title : $item->label;
	
	    ?>
	    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
	        <dl class="menu-item-bar">
	            <dt class="menu-item-handle">
	                <span class="item-title"><?php echo esc_html( $title ); ?></span>
	                <span class="item-controls">
	                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'bearded'); ?>">&#8593;</abbr></a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'bearded'); ?>">&#8595;</abbr></a>
	                    </span>
	                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'bearded'); ?>" href="<?php
	                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
	                    ?>"><?php _e( 'Edit Menu Item', 'bearded' ); ?></a>
	                </span>
	            </dt>
	        </dl>
	
	        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
	                        <?php _e( 'URL' , 'bearded'); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
	            <p class="description description-thin">
	                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
	                    <?php _e( 'Navigation Label', 'bearded' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
	                    <?php _e( 'Title Attribute' , 'bearded'); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
	            <p class="field-link-target description">
	                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
	                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                    <?php _e( 'Open link in a new window/tab', 'bearded' ); ?>
	                </label>
	            </p>
	            <p class="field-css-classes description description-thin">
	                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
	                    <?php _e( 'CSS Classes (optional)' , 'bearded'); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
	            <p class="field-xfn description description-thin">
	                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
	                    <?php _e( 'Link Relationship (XFN)', 'bearded' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
	                    <?php _e( 'Description', 'bearded' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'bearded'); ?></span>
	                </label>
	            </p>        
	            <?php
	            /* New fields insertion starts here */
	            ?>      
	            <p class="field-custom description description-wide">
	                <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
	                    <?php _e( 'Menu Icon', 'bearded' ); ?><br />
	                    <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->icon ); ?>" />
	                </label>
	                <a class="button bearded-choose-icon" id="icon-action-<?php echo $item_id; ?>"><?php _e('Choose Icon','bearded'); ?></a>
	                <?php wp_nonce_field( 'icon_selection', $name = 'icon_nonce'); ?>
					
					<?php 
						$font_ic_class = $item->icon ? ' class="'.$item->icon.'"' : ''; 
					?>
					<a class="button remove-font-icon" id="remove-icon-<?php echo $item_id; ?>"><?php _e('Remove icon','bearded'); ?></a>
	            </p>
	            <?php
	            /* New fields insertion ends here */
	            ?>
	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( __('Original: %s', 'bearded'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
	                echo wp_nonce_url(
	                    add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => $item_id,
	                        ),
	                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                    ),
	                    'delete-menu_item_' . $item_id
	                ); ?>"><?php _e('Remove', 'bearded'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
	                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'bearded'); ?></a>
	            </div>
	
	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul>
	    <?php
	    
	    $output .= ob_get_clean();

	    }
}


function bearded_icon_list() {

	$icons = array("icon-glass","icon-music","icon-search","icon-envelope-alt","icon-heart","icon-star","icon-star-empty","icon-user","icon-film","icon-th-large","icon-th","icon-th-list","icon-ok","icon-remove","icon-zoom-in","icon-zoom-out","icon-off","icon-signal","icon-cog","icon-trash","icon-home","icon-file-alt","icon-time","icon-road","icon-download-alt","icon-download","icon-upload","icon-inbox","icon-play-circle","icon-repeat","icon-refresh","icon-list-alt","icon-lock","icon-flag","icon-headphones","icon-volume-off","icon-volume-down","icon-volume-up","icon-qrcode","icon-barcode","icon-tag","icon-tags","icon-book","icon-bookmark","icon-print","icon-camera","icon-font","icon-bold","icon-italic","icon-text-height","icon-text-width","icon-align-left","icon-align-center","icon-align-right","icon-align-justify","icon-list","icon-indent-left","icon-indent-right","icon-facetime-video","icon-picture","icon-pencil","icon-map-marker","icon-adjust","icon-tint","icon-edit","icon-share","icon-check","icon-move","icon-step-backward","icon-fast-backward","icon-backward","icon-play","icon-pause","icon-stop","icon-forward","icon-fast-forward","icon-step-forward","icon-eject","icon-chevron-left","icon-chevron-right","icon-plus-sign","icon-minus-sign","icon-remove-sign","icon-ok-sign","icon-question-sign","icon-info-sign","icon-screenshot","icon-remove-circle","icon-ok-circle","icon-ban-circle","icon-arrow-left","icon-arrow-right","icon-arrow-up","icon-arrow-down","icon-share-alt","icon-resize-full","icon-resize-small","icon-plus","icon-minus","icon-asterisk","icon-exclamation-sign","icon-gift","icon-leaf","icon-fire","icon-eye-open","icon-eye-close","icon-warning-sign","icon-plane","icon-calendar","icon-random","icon-comment","icon-magnet","icon-chevron-up","icon-chevron-down","icon-retweet","icon-shopping-cart","icon-folder-close","icon-folder-open","icon-resize-vertical","icon-resize-horizontal","icon-bar-chart","icon-twitter-sign","icon-facebook-sign","icon-camera-retro","icon-key","icon-cogs","icon-comments","icon-thumbs-up-alt","icon-thumbs-down-alt","icon-star-half","icon-heart-empty","icon-signout","icon-linkedin-sign","icon-pushpin","icon-external-link","icon-signin","icon-trophy","icon-github-sign","icon-upload-alt","icon-lemon","icon-phone","icon-check-empty","icon-bookmark-empty","icon-phone-sign","icon-twitter","icon-facebook","icon-github","icon-unlock","icon-credit-card","icon-rss","icon-hdd","icon-bullhorn","icon-bell","icon-certificate","icon-hand-right","icon-hand-left","icon-hand-up","icon-hand-down","icon-circle-arrow-left","icon-circle-arrow-right","icon-circle-arrow-up","icon-circle-arrow-down","icon-globe","icon-wrench","icon-tasks","icon-filter","icon-briefcase","icon-fullscreen","icon-group","icon-link","icon-cloud","icon-beaker","icon-cut","icon-copy","icon-paper-clip","icon-save","icon-sign-blank","icon-reorder","icon-list-ul","icon-list-ol","icon-strikethrough","icon-underline","icon-table","icon-magic","icon-truck","icon-pinterest","icon-pinterest-sign","icon-google-plus-sign","icon-google-plus","icon-money","icon-caret-down","icon-caret-up","icon-caret-left","icon-caret-right","icon-columns","icon-sort","icon-sort-down","icon-sort-up","icon-envelope","icon-linkedin","icon-undo","icon-legal","icon-dashboard","icon-comment-alt","icon-comments-alt","icon-bolt","icon-sitemap","icon-umbrella","icon-paste","icon-lightbulb","icon-exchange","icon-cloud-download","icon-cloud-upload","icon-user-md","icon-stethoscope","icon-suitcase","icon-bell-alt","icon-coffee","icon-food","icon-file-text-alt","icon-building","icon-hospital","icon-ambulance","icon-medkit","icon-fighter-jet","icon-beer","icon-h-sign","icon-plus-sign-alt","icon-double-angle-left","icon-double-angle-right","icon-double-angle-up","icon-double-angle-down","icon-angle-left","icon-angle-right","icon-angle-up","icon-angle-down","icon-desktop","icon-laptop","icon-tablet","icon-mobile-phone","icon-circle-blank","icon-quote-left","icon-quote-right","icon-spinner","icon-circle","icon-reply","icon-github-alt","icon-folder-close-alt","icon-folder-open-alt","icon-expand-alt","icon-collapse-alt","icon-smile","icon-frown","icon-meh","icon-gamepad","icon-keyboard","icon-flag-alt","icon-flag-checkered","icon-terminal","icon-code","icon-reply-all","icon-mail-reply-all","icon-star-half-empty","icon-location-arrow","icon-crop","icon-code-fork","icon-unlink","icon-question","icon-info","icon-exclamation","icon-superscript","icon-subscript","icon-eraser","icon-puzzle-piece","icon-microphone","icon-microphone-off","icon-shield","icon-calendar-empty","icon-fire-extinguisher","icon-rocket","icon-maxcdn","icon-chevron-sign-left","icon-chevron-sign-right","icon-chevron-sign-up","icon-chevron-sign-down","icon-html5","icon-css3","icon-anchor","icon-unlock-alt","icon-bullseye","icon-ellipsis-horizontal","icon-ellipsis-vertical","icon-rss-sign","icon-play-sign","icon-ticket","icon-minus-sign-alt","icon-check-minus","icon-level-up","icon-level-down","icon-check-sign","icon-edit-sign","icon-external-link-sign","icon-share-sign","icon-compass","icon-collapse","icon-collapse-top","icon-expand","icon-eur","icon-gbp","icon-usd","icon-inr","icon-jpy","icon-cny","icon-krw","icon-btc","icon-file","icon-file-text","icon-sort-by-alphabet","icon-sort-by-alphabet-alt","icon-sort-by-attributes","icon-sort-by-attributes-alt","icon-sort-by-order","icon-sort-by-order-alt","icon-thumbs-up","icon-thumbs-down","icon-youtube-sign","icon-youtube","icon-xing","icon-xing-sign","icon-youtube-play","icon-dropbox","icon-stackexchange","icon-instagram","icon-flickr","icon-adn","icon-bitbucket","icon-bitbucket-sign","icon-tumblr","icon-tumblr-sign","icon-long-arrow-down","icon-long-arrow-up","icon-long-arrow-left","icon-long-arrow-right","icon-apple","icon-windows","icon-android","icon-linux","icon-dribbble","icon-skype","icon-foursquare","icon-trello","icon-female","icon-male","icon-gittip","icon-sun","icon-moon","icon-archive","icon-bug","icon-vk","icon-weibo","icon-renren");

	return $icons;
}

function bearded_icon_field( $item_id = '') {

	$icons = bearded_icon_list();
	$select = '<div class="font-holder">';
	foreach( $icons as $ic ) {
		$select .= '<span class="cell"><i class="'.$ic.'" title="'. ucfirst( str_replace('icon-', '', $ic) ).'"></i></span>';
  	}
  	$select .= '</div>';
  	$select .= '<button class="select-icon button" id="font-icon-'.$item_id.'">'.__('Use Icon','bearded').'</button>';

  	return $select;
}

function bearded_icon_modal() {

	if ( function_exists( 'check_ajax_referer' ) ) {				
		check_ajax_referer( 'icon_selection', 'nonce' );
	}


	if(!isset($_POST['item_id'])) {
		return false;
		exit;
	}

	$item_id = esc_attr( $_POST['item_id'] );

	$o = '<div class="font-modal"><div class="font-icon-popup">' . bearded_icon_field( $item_id ) . '<span class="close-popup">x</span></div></div>';

	echo $o;

	exit;
}

add_action( 'wp_ajax_icon_selection', 'bearded_icon_modal' );
add_action( 'wp_ajax_nopriv_icon_selection', 'bearded_icon_modal');
?>