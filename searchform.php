<div class="search">

	<form method="get" class="search-form" action="<?php echo trailingslashit( esc_url( home_url() ) ); ?>">
		<div class="row collapse">
			<div class="large-9 small-9 column">
			<input class="search-text" type="text" name="s" value="<?php if ( is_search() ) echo esc_attr( get_search_query() ); else esc_attr_e( 'Enter search terms...', 'bon' ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
			</div>
			<div class="large-3 small-3 column">
			<input class="search-submit button prefix flat" name="submit" type="submit" value="<?php esc_attr_e( 'Search', 'bon' ); ?>" />
			</div>
		</div>
	</form><!-- .search-form -->

</div><!-- .search -->