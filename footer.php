<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WK_Wow
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer <?php echo wk_wow_bg_class(); ?>" role="contentinfo">
		<div class="container pt-3 pb-3">
            <div class="site-info">
                Copyright &copy; <?php
							echo date_i18n(
								/* translators: Copyright date format, see https://www.php.net/date */
								_x( 'Y', 'copyright date format', 'wk-wow-child' )
							);
							?>
                <span class="sep"> | </span> 

							<?php
							$copyright_text = get_theme_mod( 'copyright_text_setting', __('Uwe Jacobs - All Rights Reserved.', 'wk-wow-child' ) );
							echo wp_kses_post( $copyright_text ); ?>

							<div class="">
							    <a href="<?php echo esc_url( __( 'https://web-komp.eu/theme/wow/', 'wk-wow-child' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php _e( 'Theme Wow by WebKomp', 'wk-wow-child' ); ?></a>
								<span class="sep"> | </span> 
							    <a href="<?php echo esc_url( __( 'https://ujsoftware.com', 'wk-wow-child' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php _e( 'Design and Marketing by UJ Software', 'wk-wow-child' ); ?></a>
							</div>
            </div><!-- close .site-info -->
		</div>
	</footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<a href="#" class="btn-light btn-lg topbutton" role="button" title="Go to top"><i class="fas fa-chevron-up"></i><span class="sr-only">Go to top</span></a>

<?php wp_footer(); ?>
</body>
</html>
