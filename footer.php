			
				<?php do_atomic('close_main_row'); ?>
			<?php if(!is_page_template( 'page-templates/home.php' ) ) { ?> 
				</div>
			<?php } ?>
		</div><!-- #main -->

		<footer id="footer">

			<div class="footer-widgets-container row">

				<?php for( $i = 1; $i <= 3; $i++ ) { ?>
				<div class="footer-widget column large-4" id="footer-widget-<?php echo $i; ?>">
					<?php if ( is_active_sidebar( 'footer-'.$i ) ) { ?>

							<?php dynamic_sidebar( 'footer-'.$i ); ?>

					<?php } ?>
				</div>
				<?php } ?>

			</div>

			<div class="footer-content row">
				<div class="column large-12">
					<?php 
							$social_lists = bearded_get_social_lists(); 
							if(is_array($social_lists) && !empty($social_lists)) {

					?>
					<ul class="footer-social">
						
						<?php
							foreach($social_lists as $key => $value) {
								if(!empty($value)) {
									if($key === 'github') {
										$key = 'github-alt';
									}
									echo '<li><a href="'.$value.'"><i class="icon-'.$key.'"></i></a></li>';
								}
							}
						?>

					</ul>
					<?php } ?>
					<?php 
						echo apply_atomic_shortcode( 'footer_content', '<p class="credit">' . __( 'Copyright &copy; [the-year] [site-link]. Powered by [wp-link] and [theme-link].', 'hybrid-base' ) . '</p>' );
						
					?>
				</div>
			</div><!-- .footer-content -->


		</footer><!-- #footer -->

	</div> <!-- end main-wrapper -->

	</div><!-- #container -->

	<?php wp_footer(); // wp_footer ?>

</body>
</html>