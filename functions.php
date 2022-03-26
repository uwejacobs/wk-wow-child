<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

require_once dirname( __FILE__ ) . '/inc/wp_bootstrap_navwalker.php';

if (!function_exists('wkwc_chld_thm_cfg_locale_css')) {
    function wkwc_chld_thm_cfg_locale_css($uri){
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }

	add_filter('locale_stylesheet_uri', 'wkwc_chld_thm_cfg_locale_css');
}

if (!function_exists('wkwc_chld_thm_cfg_css_js')) {
    function wkwc_chld_thm_cfg_css_js() {
	wp_enqueue_style('wk-wow-bootstrap-css-child', get_stylesheet_directory_uri(). '/inc/assets/css/bootstrap.min.css');
	wp_enqueue_style('wk-wow-bootstrap-icons-css-child', get_stylesheet_directory_uri(). '/inc/assets/css/bootstrap-icons.css');
	wp_enqueue_script('wk-wow-bootstrapjs-child', get_stylesheet_directory_uri(). '/inc/assets/js/bootstrap.bundle.min.js');

	// force child theme style.css after bootstrap reload
	wp_dequeue_style('wk-wow-style');
	wp_deregister_style('wk-wow-style');
	wp_dequeue_style('wk-wow-child-style');
	wp_deregister_style('wk-wow-child-style');
	wp_enqueue_style( 'wk-wow-child-style', get_stylesheet_uri() );

	if (get_theme_mod( 'theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
	        wp_enqueue_style('wk-wow-child-'.get_theme_mod('theme_option_setting'), get_stylesheet_directory_uri() . '/inc/assets/css/presets/theme-option/'.get_theme_mod('theme_option_setting').'.css', array('wk-wow-bootstrap-css-child'));
	}
	wp_enqueue_style('wk-wow-animate-css-child', get_stylesheet_directory_uri(). '/inc/assets/css/animate.css', array(), null, "(prefers-reduced-motion: no-preference)");
	wp_enqueue_script('wk-wow-animate-visible-child', get_stylesheet_directory_uri() . '/inc/assets/js/jquery.animateVisible.js', array("jquery"), '', true);
	wp_enqueue_script('wk-wow-themejs-child', get_stylesheet_directory_uri() . '/inc/assets/js/theme-script.js', array("jquery","wk-wow-animate-visible-child"), '', true);
	wp_add_inline_script('wk-wow-themejs-child', 'const WKWC_options = ' . json_encode(array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'coverImageAni' => get_theme_mod('cover_image_ani'),
		'headerAni' => get_theme_mod('header_ani'),
		'buttonAni' => get_theme_mod('button_ani'),
		'photoSellerGalleryAni' => get_theme_mod('photo_seller_gallery_ani'),
	)), 'before' );
    }

	add_action('wp_enqueue_scripts', 'wkwc_chld_thm_cfg_css_js', 12);
}

if (!function_exists('wkwc_chld_thm_dequeue_parent_css')) {
    function wkwc_chld_thm_dequeue_parent_css(){
		$wk_wow_fontawesome = get_theme_mod('load_fontawesome_setting');
		if (empty($wk_wow_fontawesome) || $wk_wow_fontawesome === 'no') {
			wp_dequeue_style('wk-wow-fontawesome-cdn');
			wp_deregister_style('wk-wow-fontawesome-cdn');
		}

		wp_dequeue_style('wk-wow-bootstrap-css');
		wp_deregister_style('wk-wow-bootstrap-css');
		remove_action('wp_head', 'wk_wow_customizer_css');
		if (get_theme_mod('theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
			wp_dequeue_style('wk-wow-'.get_theme_mod( 'theme_option_setting' ));
			wp_deregister_style('wk-wow-'.get_theme_mod( 'theme_option_setting' ));
		}
	}

	add_action('wp_print_styles', 'wkwc_chld_thm_dequeue_parent_css', 11);
}

if (!function_exists('wkwc_chld_thm_dequeue_parent_js')) {
    function wkwc_chld_thm_dequeue_parent_js(){
		wp_dequeue_script('wk-wow-popper');
		wp_deregister_script('wk-wow-popper');
		wp_dequeue_script('wk-wow-bootstrapjs');
		wp_deregister_script('wk-wow-bootstrapjs');
	}

	add_action('wp_print_scripts', 'wkwc_chld_thm_dequeue_parent_js', 11);
}

if (!function_exists('wk_wow_child_password_form')) {
	remove_filter( 'the_password_form', 'wk_wow_password_form' );
	function wk_wow_child_password_form() {
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<div class="d-block mb-3">' . __( "To view this protected post, enter the password below:", 'wk-wow-child' ) . '</div>
		<div class="input-group"><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control me-2" /> <input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'wk-wow-child' ) . '" class="input-group-text btn btn-primary" /></div>
		</form>';
		return $o;
	}
	add_filter( 'the_password_form', 'wk_wow_child_password_form', 11 );
}

if (!function_exists('wkwc_customize_register_child')) {
	function wkwc_customize_register_child($wp_customize) {
		/*API keys*/
		$wp_customize->add_section(
			'api_keys',
			array(
				'title' => __('API', 'wk-wow-child'),
				'priority' => 70,
				'capability' => 'edit_theme_options',
		));
		$wp_customize->add_setting('recaptcha_site_key_v2_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'recaptcha_site_key_v2', array(
			'label' => __('Google reCAPTCHA site key v2', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'recaptcha_site_key_v2_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('recaptcha_secret_key_v2_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'recaptcha_secret_key_v2', array(
			'label' => __('Google reCAPTCHA secret key v2', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'recaptcha_secret_key_v2_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('recaptcha_site_key_v3_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'recaptcha_site_key_v3', array(
			'label' => __('Google reCAPTCHA site key v3', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'recaptcha_site_key_v3_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('recaptcha_secret_key_v3_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'recaptcha_secret_key_v3', array(
			'label' => __('Google reCAPTCHA secret key v3', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'recaptcha_secret_key_v3_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('google_maps_key_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'google_maps_maps_key', array(
			'label' => __('Google Maps API key', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'recaptcha_key_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('facebook_pixel_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'facebook_pixel', array(
			'label' => __('Facebook Meta Pixel Code', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'facebook_pixel_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('google_validate_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'google_validate', array(
			'label' => __('Google Search Console validation code', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'google_validate_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('microsoft_validate_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'microsoft_validate', array(
			'label' => __('Microsoft Bing Webmaster validation code', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'microsoft_validate_setting',
			'type' => 'text'
		)));
		$wp_customize->add_setting('geo_tag_meta_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wkwc_sanitize_meta_tag',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'geo_tag_meta', array(
			'label' => __('Geo Meta Tags', 'wk-wow-child'),
			'description' => __('Generate with the <a href="https://www.geo-tag.de/generator/en.html" target="_blank">HTML Geo-Tag Generator</a>.', 'wk-wow-child'),
			'section'    => 'api_keys',
			'settings'   => 'geo_tag_meta_setting',
			'type' => 'textarea',
		)));

		/*FontAwesome*/
		$wp_customize->add_setting('load_fontawesome_setting', array(
			'default' => __('no','wk-wow-child'),
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control(
			'load_fontawesome',
			array(
				'label' => __('Load FontAwesome', 'wk-wow-child'),
				'description' => __('Load FontAwesome CSS and Fonts. Turn off when using the FontAwesome plugin.', 'wk-wow-child'),
				'section' => 'site_name_text_color',
				'settings' => 'load_fontawesome_setting',
					'type'    => 'select',
					'choices' => array(
						'yes' => __('Yes', 'wk-wow-child'),
						'no' => __('No', 'wk-wow-child'),
					),
			'priority' => 20,
		));

		/*Copyright Text*/
		$wp_customize->add_setting('copyright_text_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_post_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'copyright_text', array(
			'label' => __('Copyright', 'wk-wow-child'),
			'description' => __('Copyright Text to show after the Year in Footer.', 'wk-wow-child'),
			'section'    => 'site_name_text_color',
			'settings'   => 'copyright_text_setting',
			'type' => 'textarea',
			'priority' => 40,
		)));

		// Topbar Button Text
		$wp_customize->add_setting(
				'topbar_button_text_setting',
				array(
						'default'           => esc_html__( 'Contact Us', 'wk-wow-child' ),
						'capability'        => 'edit_theme_options',
						'sanitize_callback' => 'sanitize_text_field',
				)
		);
		$wp_customize->add_control(
				'topbar_button_text',
				array(
						'type'     => 'text',
						'label'    => esc_html__( 'Topbar Button Text:', 'wk-wow-child' ),
						'section'  => 'site_name_text_color',
						'settings' => 'topbar_button_text_setting',
						'priority' => 30,
				)
		);

		// Topbar Button Slug
		$wp_customize->add_setting(
				'topbar_button_slug_setting',
				array(
						'default'           => esc_html__( 'contact-us', 'wk-wow-child' ),
						'capability'        => 'edit_theme_options',
						'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
		);
		$wp_customize->add_control(
				'topbar_button_slug',
				array(
						'type'     => 'text',
						'label'    => esc_html__( 'Topbar Button Slug:', 'wk-wow-child' ),
						'section'  => 'site_name_text_color',
				'settings' => 'topbar_button_slug_setting',
						'priority' => 30,
				)
		);

		/*Site owner*/
		$wp_customize->add_section(
			'site_owner',
			array(
				'title' => __('Site Owner Info', 'wk-wow-child'),
				'priority' => 15,
				'capability' => 'edit_theme_options',
		));

		$wp_customize->add_setting('site_owner_company_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_company', array(
			'label' => __('Company name', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_company_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('site_owner_email_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_email',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_email', array(
			'label' => __('Email address', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_email_setting',
			'type' => 'text',
			'priority' => 20,
		)));

		$wp_customize->add_setting('site_owner_phone_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_phone', array(
			'label' => __('Phone number', 'wk-wow-child'),
			'description' => __('Format the phone number for readability.', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_phone_setting',
			'type' => 'text',
			'priority' => 20,
		)));

		$wp_customize->add_setting('site_owner_location_address_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_textarea_field',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_location_address', array(
			'label' => __('Location address', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_location_address_setting',
			'type' => 'textarea',
			'priority' => 20,
		)));

		$wp_customize->add_setting('site_owner_mailing_address_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_textarea_field',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_mailing_address', array(
			'label' => __('Mailing address', 'wk-wow-child'),
			'description' => __('If different from location address.', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_mailing_address_setting',
			'type' => 'textarea',
			'priority' => 20,
		)));
		
		$wp_customize->add_setting('site_owner_contact1_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact1', array(
			'label' => __('Contact 1 name', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact1_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact1_email_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_email',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact1_email', array(
			'label' => __('Contact 1 email address', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact1_email_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact1_phone_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact1_phone', array(
			'label' => __('Contact 1 phone number', 'wk-wow-child'),
			'description' => __('Format the phone number for readability.', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact1_phone_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact2_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact2', array(
			'label' => __('Contact 2 name', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact2_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact2_email_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_email',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact2_email', array(
			'label' => __('Contact 2 email address', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact2_email_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact2_phone_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact2_phone', array(
			'label' => __('Contact 2 phone number', 'wk-wow-child'),
			'description' => __('Format the phone number for readability.', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact2_phone_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact3_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact3', array(
			'label' => __('Contact 3 name', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact3_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact3_email_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_email',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact3_email', array(
			'label' => __('Contact 3 email address', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact3_email_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		$wp_customize->add_setting('site_owner_contact3_phone_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_owner_contact3_phone', array(
			'label' => __('Contact 3 phone number', 'wk-wow-child'),
			'description' => __('Format the phone number for readability.', 'wk-wow-child'),
			'section'    => 'site_owner',
			'settings'   => 'site_owner_contact3_phone_setting',
			'type' => 'text',
			'priority' => 30,
		)));

		/*Social accounts*/
		$wp_customize->add_section(
			'social',
			array(
				'title' => __('Social accounts', 'wk-wow-child'),
				'priority' => 20,
				'capability' => 'edit_theme_options',
		));

		$wp_customize->add_setting('social_google_my_business_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_google_my_business', array(
			'label' => __('Google My Business URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_google_my_business_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_bing_places_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_bing_places', array(
			'label' => __('Microsoft Bing Places for Business URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_bing_places_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_yelp_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_yelp', array(
			'label' => __('Yelp URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_yelp_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_facebook_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_facebook', array(
			'label' => __('Facebook URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_facebook_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_instagram_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_instagram', array(
			'label' => __('Instagram URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_instagram_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_youtube_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_youtube', array(
			'label' => __('Youtube URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_youtube_setting',
			'type' => 'text',
			'priority' => 10,
		)));
		
		$wp_customize->add_setting('social_twitter_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_twitter', array(
			'label' => __('Twitter URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_twitter_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_linkedin_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_linkedin', array(
			'label' => __('LinkedIn URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_linkedin_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		$wp_customize->add_setting('social_nextdoor_setting', array(
			'default'   => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_nextdoor', array(
			'label' => __('nextdoor URL', 'wk-wow-child'),
			'section'    => 'social',
			'settings'   => 'social_nextdoor_setting',
			'type' => 'text',
			'priority' => 10,
		)));

		//Theme Option
		$wp_customize->add_setting( 'theme_option_setting', array(
			'default'   => 'default',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'theme_option_setting', array(
			'label' => __( 'Theme Option', 'wk-wow-child' ),
			'description' => __('Don\'t forget to empty all settings in the Colors section if you choose a theme option other than Default.', 'wk-wow-child'),
			'section'    => 'typography',
			'settings'   => 'theme_option_setting',
			'type'    => 'select',
			'choices' => array(
			'default' => 'Default',
			'agency' => 'Agency',
			'cerulean' => 'Cerulean',
			'cosmo' => 'Cosmo',
			'creative' => 'Creative',
			'cyborg' => 'Cyborg',
			'darkly' => 'Darkly',
			'flatly' => 'Flatly',
			'freelancer' => 'Freelancer',
			'grayscale' => 'Grayscale',
			'journal' => 'Journal',
			'litera' => 'Litera',
			'lumen' => 'Lumen',
			'lux' => 'Lux',
			'materia' => 'Materia',
			'minty' => 'Minty',
			'morph' => 'Morph',
			'pulse' => 'Pulse',
			'sandstone' => 'Sandstone',
			'simplex' => 'Simplex',
			'simply' => 'Simply',
			'sketchy' => 'Sketchy',
			'slate' => 'Slate',
			'solar' => 'Solar',
			'spacelab' => 'Spacelab',
			'superhero' => 'Superhero',
			'united' => 'United',
			'vapor' => 'Vapor',
			'yeti' => 'Yeti',
			'zephyr' => 'Zephyr',
			)
		) ) );

		/*Animations*/
		$wp_customize->add_section(
			'animations',
			array(
				'title' => __('Animations', 'wk-wow-child'),
				'priority' => 35,
				'capability' => 'edit_theme_options',
		));

		$wkwc_animations = array(
			'none' =>'No animations',
			'flip-in-hor-bottom'   => 'Flip in horizontal bottom',
			'flip-in-hor-top'      => 'Flip in horizontal top',
			'flip-in-ver-left'     => 'Flip in vertical left',
			'flip-in-ver-right'    => 'Flip in vertical right',
			'focus-in-expand'      => 'Focus in expand',
			'focus-in-contract'    => 'Focus in contract',
			'kenburns-top'         => 'Ken Burns top',
			'kenburns-bottom'      => 'Ken Burns bottom',
			'scale-in-bottom'      => 'Scale in bottom',
			'scale-in-center'      => 'Scale in center',
			'scale-in-hor-center'  => 'Scale in horizontal center',
			'scale-in-top'         => 'Scale in top',
			'scale-in-ver-center'  => 'Scale in vertical center',
			'scale-up-center'      => 'Scale up center',
			'scale-up-hor-center'  => 'Scale up horizontal center',
			'scale-up-ver-center'  => 'Scale up vertical center', 
			'shake-horizontal'     => 'Shake horizontal',
			'shake-vertical'       => 'Shake vertical',
			'slide-bck-center'     => 'Slide back center',
			'slide-in-fwd-center'  => 'Slide in forward center',
			'slide-in-left'        => 'Slide in left',
			'slide-in-right'       => 'Slide in right',
			'slit-in-horizontal'   => 'Slit in horizontal',
			'slit-in-vertical'     => 'Slit in vertical',
			'swing-in-bottom-bck'  => 'Swing in bottom back',
			'swing-in-bottom-fwd'  => 'Swing in bottom forward',
			'swing-in-top-bck'     => 'Swing in top back',
			'swing-in-top-fwd'     => 'Swing in top forward',
			'tracking-in-contract' => 'Tracking in contract',
			'tracking-in-expand'   => 'Tracking in expand',
		);
		$wp_customize->add_setting( 'cover_image_ani', array(
			'default'   => 'kenburns-top',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'cover_image_ani', array(
			'label' => __( 'Cover image', 'wk-wow-child' ),
			'description' => __('The Ken Burns animations work best.', 'wk-wow-child'),
			'section'    => 'animations',
			'settings'   => 'cover_image_ani',
			'type'    => 'select',
			'choices' => $wkwc_animations
		) ) );

		$wp_customize->add_setting( 'header_ani', array(
			'default'   => 'tracking-in-expand',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'header_ani', array(
			'label' => __( 'Header (h1-h6)', 'wk-wow-child' ),
			'description' => __('The Tracking and Focus animations work best.', 'wk-wow-child'),
			'section'    => 'animations',
			'settings'   => 'header_ani',
			'type'    => 'select',
			'choices' => $wkwc_animations
		) ) );

		$wp_customize->add_setting( 'button_ani', array(
			'default'   => 'shake-horizontal',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'button_ani', array(
			'label' => __( 'Button Hover', 'wk-wow-child' ),
			'description' => __('The Shake animations work best.', 'wk-wow-child'),
			'section'    => 'animations',
			'settings'   => 'button_ani',
			'type'    => 'select',
			'choices' => $wkwc_animations
		) ) );

		$wp_customize->add_setting( 'photo_seller_gallery_ani', array(
			'default'   => 'slit-in-vertical',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'photo_seller_gallery_ani', array(
			'label' => __( 'WP Photo Seller Gallery Image', 'wk-wow-child' ),
			'description' => __('The Flip, Scale, Slide, Slit and Swing animations work best.', 'wk-wow-child'),
			'section'    => 'animations',
			'settings'   => 'photo_seller_gallery_ani',
			'type'    => 'select',
			'choices' => $wkwc_animations
		) ) );

		$wp_customize->remove_control('cdn_assets');
		$wp_customize->get_control('preset_style_setting')->description = __('Most Theme Options, other than Default, overwrite the Typography.', 'wk-wow-child');
		$wp_customize->get_section('main_color_section')->description = __('These colors only affect the Default Preset Style.', 'wk-wow-child');
		$wp_customize->get_control('header_textcolor')->description = __('Color for site title and description in header when Main Color is empty. Ignored if same as default text color.', 'wk-wow-child');
		$wp_customize->get_control('header_bg_color')->description = __('Color for header background when Header Image is not selected.', 'wk-wow-child');
		$wp_customize->get_control('background_color')->description = __('Background color for body, except footer and copyright.', 'wk-wow-child');
		$wp_customize->get_control('main_color')->description = __('Color for main elements.', 'wk-wow-child');
	}

	add_action('customize_register', 'wkwc_customize_register_child', 99);
}

if (!function_exists('wk_wow_child_widgets_init')) {
	function wk_wow_child_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'wk-wow-child' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here.', 'wk-wow-child' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 5', 'wk-wow-child' ),
			'id'            => 'footer-5',
			'description'   => esc_html__( 'Add widgets here.', 'wk-wow-child' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 6', 'wk-wow-child' ),
			'id'            => 'footer-6',
			'description'   => esc_html__( 'Add widgets here.', 'wk-wow-child' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 7', 'wk-wow-child' ),
			'id'            => 'footer-7',
			'description'   => esc_html__( 'Add widgets here.', 'wk-wow-child' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	add_action('widgets_init', 'wk_wow_child_widgets_init');
}

if (!function_exists('wkwc_customizer_css')) {
	function wkwc_customizer_css()
	{
		?>
	<style id="wk_wow_child_customizer_css" type="text/css">
	<?php if (!empty(get_theme_mod('header_bg_color_setting'))) { ?>
	#page-sub-header {
		background-color: <?php echo esc_html(get_theme_mod('header_bg_color_setting', '#000')); ?>;
	}
	<?php }
		  if (!empty(get_theme_mod('main_color')) && get_theme_mod('main_color') !== '#ca4e07') {
			  $main_color = get_theme_mod('main_color'); ?>
	#footer-widget .widget-title:after,
	#wp-calendar #today,
	#secondary .widget-title:after,
	.navbar-toggler,
	.navbar-nav .nav-link:before,
	.wpcf7 input[type="submit"],
	.wpcf7 input:hover[type="submit"],
	.newsletter-subscribe .form-group .subscribe-submit,
	.woocommerce nav.woocommerce-pagination ul li a:focus,
	.woocommerce nav.woocommerce-pagination ul li a:hover,
	.woocommerce nav.woocommerce-pagination ul li span.current,
	.woocommerce span.onsale,
	.woocommerce div.product form.cart .button,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce button.button,
	.woocommerce-info,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.single-contact i.fa,
	.single-service:before,
	.single-service:after,
	.single-service:hover i.fa,
	.section-title h4:after,
	.single-service:hover i.fab,
	.woocommerce-account .woocommerce a.button,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
	.woocommerce .widget_shopping_cart .buttons a,
	.woocommerce.widget_shopping_cart .buttons a,
	.woocommerce #respond input#submit:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover, .nav-link:before {
	  background-color: <?php echo esc_html($main_color);?>;
	}

	.dropdown-item:hover, .dropdown-item:focus {
		 background-color: <?php echo esc_html($main_color);?>!important;
	}

	.btn-circle,
	.widget_tag_cloud .tagcloud a,
	.single-service:hover i.fa,
	.single-service:hover i.fab {
	   border-color: <?php echo esc_html($main_color);?>;
	}

	div[id^="mailpoet_form_"] {
	   border-color: <?php echo esc_html($main_color);?>!important;
	}

	.preloader div {
	   border-top-color: <?php echo esc_html($main_color);?>;
	}

	h1,h2,h3,h4,h5,h6,.display-1,.display-2,.display-3,.display-4, display-5, display-6,
	a,
	a:hover,
	a:focus,
	a:active,
	#secondary ul li a[aria-current=page],
	#secondary ul a:hover,
	#secondary ul a:focus,
	.btn-circle:hover,
	.btn-circle:focus,
	.woocommerce-Price-amount {
	  color: <?php echo esc_html($main_color);?>;
	}

	@media screen and (min-width: 1200px){
		 .navbar-nav .nav-link:before {
			 background-color: <?php echo esc_html($main_color);?>;
		}
	}
	<?php
	require_once dirname( __FILE__ ) . '/inc/color-css.php';
	echo wkwc_generateColorCSS(get_theme_mod('main_color'), "primary");
	}
	?>
	</style>
	<?php
	}

	if (get_theme_mod( 'theme_option_setting') && get_theme_mod('theme_option_setting') === 'default') {
		add_action( 'wp_head', 'wkwc_customizer_css', 11);
	}
}

if (!function_exists('wkwc_sanitize_meta_tag')) {
	function wkwc_sanitize_meta_tag($s) {
		return wp_kses($s, array('meta'=>array('name'=>array(),'content'=>array())));
	}
}


// Expire bookings
if (!function_exists('ujcf_save_post_bookings_callback')) {
	function ujcf_save_post_bookings_callback($post_id, $post, $update){
		if (empty($_POST['acf']))
			return;

		if (isset($_POST['acf']['field_621eb0e90d330']) || isset($_POST['acf']['field_621eb287b16e3'])) {
			remove_action( 'save_post', 'expirationdate_update_post_meta');

			// Check if the post has a end or start date value
			if (!empty($_POST['acf']['field_621eb287b16e3'])) {
				$date = $_POST['acf']['field_621eb287b16e3'];
				ujcf_expirationdate_update_post_meta_acf($post_id, $date);
			}
			else if (!empty($_POST['acf']['field_621eb0e90d330'])) {
				$date = $_POST['acf']['field_621eb0e90d330'];
				ujcf_expirationdate_update_post_meta_acf($post_id, $date);
			}
			else {
				// Unschedule any existing event if the field is blank
				postexpirator_unschedule_event($post_id);
			}
		}
	}

	add_action('save_post','ujcf_save_post_bookings_callback', 10, 3);

	if (!function_exists('ujcf_expirationdate_update_post_meta_acf')) {
		function ujcf_expirationdate_update_post_meta_acf($post_id, $date) {
			// don't run the echo if this is an auto save
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			// don't run the echo if the function is called for saving revision.
			$posttype = get_post_type($post_id);
			if ($posttype !== 'bookings')
				return;

			$formatted_date = new DateTime($date);
			$formatted_date->modify('first day of next month');
			$month   = intval($formatted_date->format('m'));
			$day     = intval($formatted_date->format('d'));
			$year    = intval($formatted_date->format('y'));

			$ts = get_gmt_from_date("$year-$month-$day 00:00:00",'U');
			$opts = [];
			$opts['expireType'] = 'draft';
			$opts['id'] = $post_id;

			postexpirator_schedule_event($post_id,$ts,$opts);
		}
	}
}

if (!function_exists('wk_wow_child_bg_class')) {
function wk_wow_child_bg_class() {
    switch (get_theme_mod( 'theme_option_setting' )) {
        case "cerulean":
            return 'navbar-dark bg-primary';
            break;
        case "cosmo":
            return 'navbar-dark bg-primary';
            break;
        case "cyborg":
            return 'navbar-dark bg-dark';
            break;
        case "darkly":
            return 'navbar-dark bg-primary';
            break;
        case "flatly":
            return 'navbar-dark bg-primary';
            break;
        case "freelancer":
            return 'navbar-dark bg-primary';
            break;
        case "journal":
            return 'navbar-light bg-light';
            break;
        case "litera":
            return 'navbar-light bg-light';
            break;
        case "lumen":
            return 'navbar-light bg-light';
            break;
        case "lux":
            return 'navbar-light bg-light';
            break;
        case "materia":
            return 'navbar-dark bg-primary';
            break;
        case "minty":
            return 'navbar-dark bg-primary';
            break;
        case "pulse":
            return 'navbar-dark bg-primary';
            break;
        case "sandstone":
            return 'navbar-dark bg-primary';
            break;
        case "simplex":
            return 'navbar-light bg-light';
            break;
        case "sketchy":
            return 'navbar-light bg-light';
            break;
        case "slate":
            return 'navbar-dark bg-primary';
            break;
        case "solar":
            return 'navbar-dark bg-dark';
            break;
        case "spacelab":
            return 'navbar-light bg-light';
            break;
        case "superhero":
            return 'navbar-dark bg-dark';
            break;
        case "united":
            return 'navbar-dark bg-primary';
            break;
        case "yeti":
            return 'navbar-dark bg-primary';
            break;
        default:
            return 'navbar-light bg-light';
    }
}
}
