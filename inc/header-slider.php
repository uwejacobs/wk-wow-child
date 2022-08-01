<?php
$headers = get_uploaded_header_images();
$img_src = [];
$img_srcset = [];
$img_sizes = [];
$img_alt = [];
?>
<div class="d-none"><?php
foreach($headers as $header) {
    $img_id = attachment_url_to_postid( $header["url"] );
    $img_src[] = "'" . $header["url"] . "'";
    $img_srcset[] = "'" . wp_get_attachment_image_srcset( $img_id ) . "'";
    $img_sizes[] = "'" . wp_get_attachment_image_sizes( $img_id ) . "'";
    $img_alt[] = "'" . get_post_meta($img_id, '_wp_attachment_image_alt', true) . "'";
    echo wkwc_create_responsive_image( $header["url"] );
}
?>
</div>
<img id="page-sub-header-img" class="jarallax-img" src="<?php echo str_replace("'", "", $img_src[0]); ?>" />
<script>
window.addEventListener('load', (event) => {
    var images = new Array(<?php echo join(',', $img_src); ?>);
    var images_srcset = new Array(<?php echo join(',', $img_srcset); ?>);
    var images_sizes = new Array(<?php echo join(',', $img_sizes); ?>);
    var images_alt = new Array(<?php echo join(',', $img_alt); ?>);
    var image_cnt = 1;
    
    setInterval(function(){
        if (++image_cnt >= images.length) {
            image_cnt = 0;
        }
<?php if (get_theme_mod('cover_slider_fade_setting', 'fade') == 'slide') { ?>
        jQuery('#page-sub-header-img').attr('src', images[image_cnt]);
        jQuery('#page-sub-header-img').attr('srcset', images_srcset[image_cnt]);
        jQuery('#page-sub-header-img').attr('sizes', images_sizes[image_cnt]);
        jQuery('#page-sub-header-img').attr('alt', images_alt[image_cnt]);
<?php } else { ?>
        jQuery("#page-sub-header-img").fadeOut("slow", function() {
            jQuery('#page-sub-header-img').attr('src', images[image_cnt]);
            jQuery('#page-sub-header-img').attr('srcset', images_srcset[image_cnt]);
            jQuery('#page-sub-header-img').attr('sizes', images_sizes[image_cnt]);
            jQuery('#page-sub-header-img').attr('alt', images_alt[image_cnt]);
            jQuery("#page-sub-header-img").fadeIn("slow");
        });
<?php } ?>
    }, <?php echo get_theme_mod('cover_slider_speed_setting', '4000'); ?>);
});
</script>
