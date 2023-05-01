<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <p class="form-label"><?php echo esc_attr_x('Search &hellip;', 'placeholder', 'wk-wow-child'); ?></p>
    <div class="input-group">
        <input id="search" type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'wk-wow-child'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label', 'wk-wow-child'); ?>">
        <input type="submit" value="<?php echo esc_attr_x('Go', 'submit button', 'wk-wow-child'); ?>" class="input-group-text search-submit btn btn-primary">
    </div>
</form>
