 <?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WK_Wow
 */

 function printTagline()
 {
        ?>
<div class="container">
    <p id="header-banner-title" class="header-banner-title">
         <?php
            if (get_theme_mod('header_banner_title_setting')) {
                  echo esc_html(get_theme_mod('header_banner_title_setting'));
            }
            ?>
    </p>
    <p id="header-banner-tagline" class="header-banner-tagline">
         <?php
            if (get_theme_mod('header_banner_tagline_setting')) {
                  echo esc_html(get_theme_mod('header_banner_tagline_setting'));
            }
            ?>
    </p>
    <a href="#content" class="page-scroller btn-circle"><i class="fa fa-fw fa-arrow-down"></i><span class="sr-only"><?php esc_html_e('Skip to content', 'wk-wow-child'); ?></span></a>
</div>
 <?php } ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
<?php echo wp_kses(get_theme_mod('geo_tag_meta_setting'), array('meta'=>array('name'=>array(),'content'=>array()))); ?>
<?php
    $wk_wow_validate_key = get_theme_mod('google_validate_setting');
if (!empty($wk_wow_validate_key)) {
    echo '<meta name="google-site-verification" content="' . esc_attr($wk_wow_validate_key) . '" />';
}
?>
<?php
    $wk_wow_validate_key = get_theme_mod('microsoft_validate_setting');
if (!empty($wk_wow_validate_key)) {
    echo '<meta name="msvalidate.01" content="' . esc_attr($wk_wow_validate_key) . '" />';
}
?>
<?php
    $wk_wow_facebook_pixel = get_theme_mod('facebook_pixel_setting');
if (!empty($wk_wow_facebook_pixel)) {
    echo
    '<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,"script",
  "https://connect.facebook.net/en_US/fbevents.js");
  fbq("init", "'. esc_attr($wk_wow_facebook_pixel) . '");
  fbq("track", "PageView");
</script>
<noscript>
  <img height="1" width="1" style="display:none" 
       src="https://www.facebook.com/tr?id='. esc_attr($wk_wow_facebook_pixel) . '&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->';
}
?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if (function_exists('gtm4wp_the_gtm_tag')) {
    gtm4wp_the_gtm_tag();
} ?>
<div class="preloader">
<div class="status"></div>
</div>
<?php
if (function_exists('wp_body_open')) {
    wp_body_open();
}
?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'wk-wow-child'); ?></a>
    <?php if (!is_page_template('blank-page.php') && !is_page_template('blank-page-with-container.php')) : ?>
    <header id="masthead" class="site-header <?php echo wk_wow_child_bg_class(); ?>" role="banner">
        <div class="container-fluid">
            <nav id="pageContainerMainNavMobile" class="navbar navbar-expand-xl p-0 ">
                <div class="navbar-brand">
                <div class="row">
                <div class="col custom-logo-col">
           <?php
            the_custom_logo();
            ?>
</div>
                <div class="col my-auto">
        <?php if (is_front_page() && is_home()) :
            ?>
                <a class="site-title text-decoration-none" href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                <?php
        else : ?>
                        <a class="site-title text-decoration-none" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_url(bloginfo('name')); ?></a>
        <?php endif;

        if (get_theme_mod('show_site_description', 1)) {
             $description = get_bloginfo('description', 'display');
            if ($description || is_customize_preview()) : ?>
                                <p class="site-description"><?php echo esc_html($description); ?></p>
                            <?php
            endif;
        }
        ?>
                </div>       
                </div>       
                </div>       

                <?php
                $wk_wow_child_button     = get_theme_mod('topbar_button_text_setting', '');
                $wk_wow_child_button_slug = get_theme_mod('topbar_button_slug_setting', '');
                if (substr($wk_wow_child_button_slug, 0, 1) === '#') {
                    $wk_wow_child_button_slug_link = (is_front_page() ? '' : site_url()) . $wk_wow_child_button_slug;
                } else {
                    $wk_wow_child_button_slug_arr = explode('#', $wk_wow_child_button_slug);
                    $wk_wow_child_button_slug_link = get_permalink(get_page_by_path($wk_wow_child_button_slug_arr[0]));
                    if (!empty($wk_wow_child_button_slug_arr[1])) {
                        $wk_wow_child_button_slug_link .= '#' . $wk_wow_child_button_slug_arr[1];
                    }
                }
                ?>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'wk-wow-child'); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

        <div class="collapse navbar-collapse" id="mainNav">
        <?php
                wp_nav_menu(array(
            'theme_location'  => 'primary',
            'container' => false,
            'menu_class' => '',
            'fallback_cb' => '__return_false',
            'items_wrap' => '<ul id="%1$s" class="navbar-nav ms-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
            'depth' => 2,
            'walker' => new bootstrap_5_wp_nav_menu_walker()
                ));
        if (!empty($wk_wow_child_button) && !empty($wk_wow_child_button_slug)) { ?>
            <a id="topbar-button-toggler" href="<?php echo esc_url($wk_wow_child_button_slug_link); ?>" class="btn topbar-button btn-radius d-xl-none"><?php echo esc_html($wk_wow_child_button); ?></a>
        <?php }
        ?>
        </div>
                <?php
                if (!empty($wk_wow_child_button) && !empty($wk_wow_child_button_slug)) { ?>
                    <a id="topbar-button-right" href="<?php echo esc_url($wk_wow_child_button_slug_link); ?>" class="btn topbar-button btn-radius d-xl-block d-none"><?php echo esc_html($wk_wow_child_button); ?></a>
                <?php } ?>

            </nav>

        </div>
    </header><!-- #masthead -->
        <?php do_action('wkwc_page_header_banner');
        if (is_front_page() && !empty(get_theme_mod('cover_yt_video_setting', ''))) { ?>
            <div id="page-sub-header" class="page-sub-header page-sub-header-yt-video page-sub-header-<?php echo get_theme_mod('cover_yt_video_setting', 'none'); ?>">
            <?php include dirname(__FILE__) . '/inc/header-video.php';
                printTagline(); ?>
            </div>
        <?php } elseif (is_front_page() && get_theme_mod('cover_image_setting', 'none') != 'none') { ?>
    <div id="page-sub-header" class="page-sub-header jarallax page-sub-header-<?php echo get_theme_mod('cover_image_setting', 'none'); ?>">
            <?php $print_title_tagline = true;
            if (has_header_image()) {
                if (get_theme_mod('cover_image_setting', 'none') == 'slider') {
                    include dirname(__FILE__) . '/inc/header-slider.php';
                } elseif (get_theme_mod('cover_image_setting', 'none') == 'centered-slider') {
                    include dirname(__FILE__) . '/inc/header-slider-centered.php';
                    $print_title_tagline = false;
                } else { /*single image */
                    echo wkwc_create_responsive_image(get_header_image(), "page-sub-header-img", "jarallax-img");
                }
            }
            if ($print_title_tagline) {
                printTagline();
            } ?>
        </div>
        <?php } ?>
    <div id="content" class="site-content">
        <div class="container">
            <div class="row">
    <?php endif; ?>
