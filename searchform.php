<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<label>
			<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'wk-wow' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'wk-wow' ); ?>">
		</label>
		<span class="input-group-append">
			<input type="submit" class="search-submit btn btn-primary" value="<?php echo esc_attr_x( 'Go', 'submit button', 'wk-wow' ); ?>">
		</span>
	</div>
</form>



