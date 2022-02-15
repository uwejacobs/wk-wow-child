<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri){
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('chld_thm_cfg_parent_css')):
    function chld_thm_cfg_parent_css() {
        //wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array('wk-wow-bootstrap-css-child'));
	wp_enqueue_style('wk-wow-bootstrap-css-child', get_stylesheet_directory_uri(). '/inc/assets/css/bootstrap.min.css');
	wp_enqueue_script('wk-wow-bootstrapjs-child', get_stylesheet_directory_uri(). '/inc/assets/js/bootstrap.bundle.min.js', array('jquery'));
	if (get_theme_mod( 'theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
	        wp_enqueue_style('wk-wow-child-'.get_theme_mod('theme_option_setting'), get_stylesheet_directory_uri() . '/inc/assets/css/presets/theme-option/'.get_theme_mod('theme_option_setting').'.css', array('wk-wow-bootstrap-css-child'));
	}
	if (empty(get_theme_mod('main_color'))) {
		remove_action( 'wp_head', 'wk_wow_customizer_css');
	}
	wp_enqueue_style('wk-wow-animate-css-child', get_stylesheet_directory_uri(). '/inc/assets/css/animate.css', array(), null, "(prefers-reduced-motion: no-preference)");
    }
endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 11);

if (!function_exists('chld_thm_dequeue_parent_css')):
    function chld_thm_dequeue_parent_css(){
		$wk_wow_fontawesome = get_theme_mod('load_fontawesome_setting');
		if (empty($wk_wow_fontawesome) || $wk_wow_fontawesome === 'no') {
			wp_dequeue_style('wk-wow-fontawesome-cdn');
			wp_deregister_style('wk-wow-fontawesome-cdn');
		}

		wp_dequeue_style('wk-wow-bootstrap-css');
		wp_deregister_style('wk-wow-bootstrap-css');
	}
endif;
add_action('wp_print_styles', 'chld_thm_dequeue_parent_css', 11);

if (!function_exists('chld_thm_dequeue_parent_js')):
    function chld_thm_dequeue_parent_js(){
		wp_dequeue_script('wk-wow-popper');
		wp_deregister_script('wk-wow-popper');
		wp_dequeue_script('wk-wow-bootstrapjs');
		wp_deregister_script('wk-wow-bootstrapjs');
	}
endif;
add_action('wp_print_scripts', 'chld_thm_dequeue_parent_js', 11);


function wk_wow_customize_register_child($wp_customize) {
    /*API keys*/
    $wp_customize->add_section(
        'api_keys',
        array(
            'title' => __('API', 'wk-wow-child'),
            'priority' => 70,
            'capability' => 'edit_theme_options',
	));
    $wp_customize->add_setting('recaptcha_key_v2_setting', array(
        'default'   => '',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
	));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'recaptcha_key_v2', array(
        'label' => __('Google reCAPTCHA key v2', 'wk-wow-child'),
        'description' => __('Google reCAPTCHA key (v2 invisible).', 'wk-wow-child'),
        'section'    => 'api_keys',
        'settings'   => 'recaptcha_key_v2_setting',
        'type' => 'text'
	)));
    $wp_customize->add_setting('recaptcha_key_v3_setting', array(
        'default'   => '',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
	));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'recaptcha_key_v3', array(
        'label' => __('Google reCAPTCHA key v3', 'wk-wow-child'),
        'description' => __('Google reCAPTCHA key (v3 invisible).', 'wk-wow-child'),
        'section'    => 'api_keys',
        'settings'   => 'recaptcha_key_v3_setting',
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
        'sanitize_callback' => 'wk_wow_sanitize_meta_tag',
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
	
    //Theme Option
    $wp_customize->add_setting( 'theme_option_setting', array(
        'default'   => 'default',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'theme_option_setting', array(
        'label' => __( 'Theme Option', 'wp-bootstrap-4-essentials' ),
        'section'    => 'typography',
        'settings'   => 'theme_option_setting',
        'type'    => 'select',
        'choices' => array(
            'default' => 'Default',
	    'blue_voltage' => 'Blue Voltage',
	    'boldstrap' => 'Boldstrap',
            'cerulean' => 'Cerulean',
            'cosmo' => 'Cosmo',
            'cyborg' => 'Cyborg',
            'darkly' => 'Darkly',
	    'darkster' => 'Darkster',
            'flatly' => 'Flatly',
	    'greyson' => 'Greyson',
	    'herbie' => 'Herbie',
            'hootstrap' => 'Hootstrap',
            'journal' => 'Journal',
            'litera' => 'Litera',
	    'lovey' => 'Lovey',
            'lumen' => 'Lumen',
            'lux' => 'Lux',
            'materia' => 'Materia',
            'minty' => 'Minty',
	    'monotony' => 'Monotony',
	    'poypull' => 'Poypull',
            'pulse' => 'Pulse',
	    'purple' => 'Purple',
            'sandstone' => 'Sandstone',
	    'signal' => 'Signal',
            'simplex' => 'Simplex',
            'sketchy' => 'Sketchy',
            'slate' => 'Slate',
            'solar' => 'Solar',
            'spacelab' => 'Spacelab',
            'superhero' => 'Superhero',
	    'tequila' => 'Tequila',
            'united' => 'United',
            'yeti' => 'Yeti',
        )
    ) ) );
	
}
add_action('customize_register', 'wk_wow_customize_register_child');

if (!function_exists('wk_wow_sanitize_meta_tag')):
	function wk_wow_sanitize_meta_tag($s) {
		return wp_kses($s, array('meta'=>array('name'=>array(),'content'=>array())));
	}
endif;





















//add_action( 'wp_enqueue_scripts', 'my_plugin_print_styles',  PHP_INT_MAX );

function my_plugin_print_styles(){
    $wp_scripts = wp_scripts();
    $wp_styles = wp_styles();
	echo "<pre>";
    print_r($wp_scripts);
    print_r($wp_styles);
	echo "</pre>";
}

//add_action( 'wp_enqueue_scripts', 'xxx',  PHP_INT_MAX );

function xxx(){
	echo "<pre>";
    print_r(get_stylesheet());
	echo "</pre>";
}

