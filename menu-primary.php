<?php if ( has_nav_menu( 'primary' ) ) {

	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'container'       => 'nav',
			'container_id'    => 'menu-primary',
			'container_class' => 'menu',
			'menu_id'         => 'menu-primary-items',
			'menu_class'      => 'menu-items',
			'items_wrap'      => '<a href="#menu-items" id="menu-toggle" title="' . esc_attr__( 'Navigation', 'bearded' ) . '"></a><ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker' => new Bearded_Custom_Menu_Walker()
		)
	);

} else {

	echo '<nav class="menu" id="menu-primary">';
	echo '<a href="#menu-items" id="menu-toggle" title="' . esc_attr__( 'Navigation', 'bearded' ) . '"></a>';
	wp_page_menu(
		array(
			'menu_class' => 'menu-items',

		)
	);
	echo '</nav>';
} ?>