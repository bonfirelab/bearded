<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php hybrid_document_title(); ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); // wp_head ?>

</head>

<body <?php hybrid_body_attributes(); ?>>

	<div id="container">
		
		<header id="header">

			<hgroup id="branding">
				<h1 id="site-title" role="logo">
					<a href="<?php echo trailingslashit( esc_url( home_url() ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<?php if ( get_theme_mod( 'bearded_logo' ) ) : ?>
					        <img src="<?php echo esc_url( get_theme_mod( 'bearded_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						<?php else : bloginfo( 'name' ); endif; ?>
					</a>
				</h1>
				<h2 id="site-description" class="hide-for-small"><?php bloginfo( 'description' ); ?></h2>
			</hgroup><!-- #branding -->

			<hgroup id="navigation" role="navigation">
				<?php get_template_part( 'menu', 'primary' ); // Loads the menu-secondary.php template. ?>
			</hgroup>
		</header><!-- #header -->

		<?php 
			if(is_page_template( 'page-templates/home.php' ) || is_front_page() ) {
				bearded_featured_slider();
			}
		?>
		

		<div id="main<?php echo (is_page_template( 'page-templates/home.php' ) ? '-home' : '' ); ?>">
			<?php if(!is_page_template( 'page-templates/home.php' ) ) { ?> 
			<div class="row">
			<?php } ?>
			
				<?php do_atomic('open_main_row'); ?>
			