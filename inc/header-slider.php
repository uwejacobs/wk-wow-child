<?php
$headers = get_uploaded_header_images();
$images = [];
?>
<div class="d-none"><?php
foreach($headers as $header) {
    $images[] = "'" . $header["url"] . "'";
    ?><img src="<?php echo $header["url"];?>" alt="<?php echo $header["alt_text"];?>" /><?php
}
?>
</div>
<img id="page-sub-header-img" class="jarallax-img" src="<?php echo str_replace("'", "", $images[0]); ?>" />
<script>
window.addEventListener('load', (event) => {
var images = new Array(<?php echo join(',', $images); ?>);
    var image_cnt = 1;
    
    setInterval(function(){
        if (++image_cnt >= images.length) {
            image_cnt = 0;
        }
<?php if (get_theme_mod('cover_slider_fade_setting', 'fade') == 'slide') { ?>
        jQuery('#page-sub-header-img').attr('src', images[image_cnt]);
<?php } else { ?>
        jQuery("#page-sub-header-img").fadeOut("slow", function() {
            jQuery('#page-sub-header-img').attr('src', images[image_cnt]);
            jQuery("#page-sub-header-img").fadeIn("slow");
        });
<?php } ?>
    }, <?php echo get_theme_mod('cover_slider_speed_setting', '4000'); ?>);
});
</script>
