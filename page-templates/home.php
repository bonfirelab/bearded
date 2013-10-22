<?php 
/*Template Name: Home */
get_header();
?>
	

<div id="content-home">

<?php if ( is_active_sidebar( 'homepage' ) ) { ?>

	<?php dynamic_sidebar( 'homepage' ); ?>

<?php } ?>

</div><!-- #content -->

<?php get_footer();?>