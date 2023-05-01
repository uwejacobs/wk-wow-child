<?php
$headers = get_uploaded_header_images();
?>
<div id="frontpage-carousel-slider" class="carousel slide <?php echo (get_theme_mod('cover_slider_fade_setting', 'fade') == 'fade' ? "carousel-fade" : ""); ?> <?php echo (get_theme_mod('cover_slider_dark_setting', 'yes') == 'yes' ? "carousel-dark" : ""); ?>" data-bs-ride="carousel" data-bs-touch="true" data-bs-interval="<?php echo get_theme_mod('cover_slider_speed_setting', '4000'); ?>">
    <?php if (get_theme_mod('cover_slider_control_setting', 'yes') == "yes") { ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#frontpage-carousel-slider" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
    <button class="carousel-control-next" type="button" data-bs-target="#frontpage-carousel-slider" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
    <?php }
    if (get_theme_mod('cover_slider_indicator_setting', 'yes') == "yes") { ?>
    <div class="carousel-indicators">
        <?php for ($i=0; $i < count($headers); $i++) { ?>
        <button type="button" data-bs-target="#frontpage-carousel-slider" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo ($i==0 ? 'active' : ''); ?>" aria-label="Slide <?php echo $i; ?>" aria-current="<?php echo ($i==0 ? 'true' : ''); ?>"></button>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="carousel-inner">
    <?php $i = 0;
    foreach ($headers as $header) { ?>
        <div class="carousel-item <?php echo ($i == 0 ? 'active' : ''); ?>">
            <div class="slider-strip slider-element">
                <div class="slider-element container h-100">
                    <div class="row slider-element h-100">
                        <div class="col slider-element mx-auto text-center mb-3 col-10">
                            <div class="wp-block-image is-style-default">
                                <figure class="aligncenter size-medium">
                                    <?php echo wp_get_attachment_image($header["attachment_id"], 'slider');
                                    if (get_theme_mod('cover_slider_caption_setting', 'no') == "yes") { ?>
                                        <figcaption class="figure-caption d-none d-md-block"><?php echo wp_get_attachment_caption($header["attachment_id"]); ?>&nbsp;</figcaption>
                                    <?php } ?>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ++$i;
    } ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php if (get_theme_mod('header_banner_title_setting') || get_theme_mod('header_banner_tagline_setting')) { ?>
<div class="container">
    <?php if (get_theme_mod('header_banner_title_setting')) { ?>
    <p id="header-banner-title" class="has-text-align-center h1"><?php echo esc_html(get_theme_mod('header_banner_title_setting')); ?></p>
    <?php }
    if (get_theme_mod('header_banner_tagline_setting')) { ?>
    <p id="header-banner-tagline" class="has-text-align-center"><?php echo esc_html(get_theme_mod('header_banner_tagline_setting')); ?></p>
    <?php } ?>
</div>
<?php } ?>