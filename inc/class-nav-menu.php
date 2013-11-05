<?php
/**
 * Adding Iconic Menu Functionality into WordPress Navigation Menu for backend and frontend 
 * 
 * 
 *
 * @package default
 * @author 
 **/
class Bearded_Custom_Nav_Menu {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function __construct() {

		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_field' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_field'), 10, 3 );
		
		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker'), 10, 2 );

		// admin script
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_scripts' ) );
	}

	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function add_field( $menu_item ) {


	    $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );

	    return $menu_item;
	    
	}

	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function update_field( $menu_id, $menu_item_db_id, $args ) {

	    // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-icon'] ) && is_array( $_REQUEST['menu-item-icon'] ) ) {
	        $icon_val = $_REQUEST['menu-item-icon'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_val );
	    }
	    
	}


	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function edit_walker($walker,$menu_id) {
	
	    return 'Bearded_Walker_Nav_Menu_Edit_Custom';
	    
	}

	function _admin_scripts($hook) {
		if($hook == 'nav-menus.php') {
			global $is_IE;
			
			wp_enqueue_style( 'font-awesome', BEARDED_CSS . 'font-awesome.css' );
			wp_enqueue_style( 'bearded-admin-menu', BEARDED_CSS . 'admin/menu.css' );

			if($is_IE) {
				wp_enqueue_style( 'font-awesome-ie7', BEARDED_CSS . 'font-awesome-ie7.css');
			}

			wp_enqueue_script( 'bearded-admin-menu', BEARDED_JS . 'admin/menu.js', array('jquery'), '1.0.0', true );
			wp_localize_script( 'bearded-admin-menu', 'bearded_ajax', array('url' => admin_url('admin-ajax.php')) );
		}
	}

} // END class 


// instantiate plugin's class
$GLOBALS['bearder_custom_nav'] = new Bearded_Custom_Nav_Menu();


include_once( 'class-custom-edit-walker.php' );
include_once( 'class-custom-menu-walker.php' );

?>