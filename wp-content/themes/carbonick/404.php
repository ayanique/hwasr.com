<?php

/**
 * The template for displaying 404 page
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package    WordPress
 * @subpackage Carbonick
 * @since      1.0
 * @version    1.0
 */

 
get_header();

$main_bg_color = Carbonick_Theme_Helper::get_option('404_page_main_bg_image')['background-color'];
$bg_render = Carbonick_Theme_Helper::bg_render('404_page_main');
$line_enable = Carbonick_Theme_Helper::get_option('404_line_switcher');

$styles = !empty($main_bg_color) ? 'background-color:' . $main_bg_color . ';' : '';
$styles .= $bg_render ?: '';
$styles = $styles ? $styles : '';

?>
<div class="wgl-container full-width">
    <div class="row">
        <div class="wgl_col-12">
            <section class="page_404_wrapper"  style="<?php echo esc_attr($styles); ?>">
                <div class="page_404_wrapper-container">
                    <div class="row">
                        <div class="wgl_col-12 wgl_col-md-12">
                            <div class="main_404-wrapper">
                                <div class="banner_404"><img src="<?php echo esc_url(get_template_directory_uri() . "/img/404.png"); ?>" alt="<?php echo esc_attr__('404', 'carbonick'); ?>"></div>
                                <h2 class="banner_404_title"><span><?php echo esc_html__('Error! Page Not Found', 'carbonick'); ?></span></h2>
                                <p class="banner_404_text"><?php echo esc_html__('The page you are looking for was moved, removed, renamed or never existed.', 'carbonick'); ?></p>
                                <div class="carbonick_404_search">
                                    <?php get_search_form(); ?>
                                </div>
                                <div class="carbonick_404__button">
                                    <a class="carbonick_404__link wgl-button elementor-button button-size-xl" href="<?php echo esc_url(home_url('/')); ?>">
                                        <?php esc_html_e('Take Me Home', 'carbonick'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                            if(!empty($line_enable)):
                        ?>
                            <div class="wgl-animate_bg">
                                <div class="animate_bg-line"></div>
                                <div class="animate_bg-line"></div>
                            </div>
                        <?php
                            endif;
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php get_footer();
