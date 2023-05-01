<?php

if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') ||
     is_active_sidebar('footer-4') || is_active_sidebar('footer-5') || is_active_sidebar('footer-6') ||
     is_active_sidebar('footer-7')) {?>
        <div id="footer-widget" class="row m-0 bg-light">
<?php }
if (is_active_sidebar('footer-4')) {?>
            <div class="container">
                <div class="row">
                    <div class="footer-4 col-12"><?php dynamic_sidebar('footer-4'); ?></div>
                </div>
            </div>
<?php }
if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) {?>
            <div class="container">
                <div class="row">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-1 col-12 col-md-4"><?php dynamic_sidebar('footer-1'); ?></div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-2 col-12 col-md-4"><?php dynamic_sidebar('footer-2'); ?></div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-3 col-12 col-md-4"><?php dynamic_sidebar('footer-3'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
<?php }
if (is_active_sidebar('footer-5') || is_active_sidebar('footer-6')) {?>
            <div class="container">
                <div class="row">
                    <?php if (is_active_sidebar('footer-5')) : ?>
                        <div class="footer-5 col-12 col-md-6"><?php dynamic_sidebar('footer-5'); ?></div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar('footer-6')) : ?>
                        <div class="footer-6 col-12 col-md-6"><?php dynamic_sidebar('footer-6'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
<?php }
if (is_active_sidebar('footer-7')) {?>
            <div class="container">
                <div class="row">
                    <div class="footer-7 col-12"><?php dynamic_sidebar('footer-7'); ?></div>
                </div>
            </div>
<?php }
if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') ||
     is_active_sidebar('footer-4') || is_active_sidebar('footer-5') || is_active_sidebar('footer-6') ||
     is_active_sidebar('footer-7')) {?>
        </div>
<?php }
