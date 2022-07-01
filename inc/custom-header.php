<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package WK_Wow
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses wk_wow_header_style()
 */
function wk_wow_child_custom_header_setup() {
	remove_theme_support( 'custom-header' );

	add_theme_support( 'custom-header', apply_filters( 'wk_wow_custom_header_args', array(
		'default-image'          => get_stylesheet_directory_uri() . '/inc/assets/images/default-cover-img.jpg',
		'default-text-color'     => '000',
		'width'                  => 1920,
		'height'                 => 1080,
		'flex-height'            => true,
		'wp-head-callback'       => 'wk_wow_child_header_style',
	
	) ) );

	register_default_headers( array(
                'desk' => array(
                        'url'           => get_stylesheet_directory_uri() . '/inc/assets/images/default-cover-img.jpg',
                        'thumbnail_url' => get_stylesheet_directory_uri() . '/inc/assets/images/default-cover-img.jpg',
                        'description'   => __( 'Desk', 'wk-wow-child' )
                ),
        ) );

}



add_action( 'after_setup_theme', 'wk_wow_child_custom_header_setup', 11 );

if ( ! function_exists( 'wk_wow_child_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see wk_wow_custom_header_setup().
 */
function wk_wow_child_header_style() {
	$header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
	 */
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
	a.site-title,
	a.site-title:hover,
	a.site-title:focus,
	a.site-title:visited,
	.site-info a,
	.site-info a:hover,
	.site-info a:focus,
	.site-info a:visited,
	.site-description {
		color: #<?php echo esc_attr( $header_text_color ); ?>;
	}
	<?php endif; ?>
	</style>
	<?php
}
endif;
