<?php
/**
 * Block Header .
 *
 * @package StoreCommerce
 */
?>
<?php
$transparency_class = '';
/*$slider_page_1 = storecommerce_get_option('slider_page_1');
if(!empty($slider_page_1)){
    $transparency_class = 'aft-transparent-header';
}*/
?>

<div id="site-primary-navigation" class="header-style-2  <?php echo esc_attr($transparency_class); ?>">
    <div class="container-wrapper">
        <div class="desktop-header clearfix">
            <div class="header-left-part">
                <div class="logo-brand">
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if (is_front_page() && is_home()) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php
                        else :
                            ?>
                            <h3 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h3>
                        <?php
                        endif;
                        $storecommerce_description = get_bloginfo('description', 'display');
                        if ($storecommerce_description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $storecommerce_description; /* WPCS: xss ok. */ ?></p>
                        <?php endif; ?>
                    </div><!-- .site-branding -->
                </div>
            </div>
            <div class="header-middle-right-part">
                <div class="header-middle-part">

                </div>
                <div class="header-right-part">
                  <div class="navigation-container">

                      <nav id="site-navigation" class="main-navigation">
                              <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                                  <span class="screen-reader-text">
                                      <?php esc_html_e('Primary Menu', 'autoshop'); ?></span>
                                   <i class="ham"></i>
                          </span>
                          <?php
                          wp_nav_menu(array(
                              'theme_location' => 'aft-primary-nav',
                              'menu_id' => 'primary-menu',
                              'container' => 'div',
                              'container_class' => 'menu main-menu'
                          ));
                          ?>
                      </nav><!-- #site-navigation -->

                  </div>
                --</div>
            </div>
        </div>
    </div>
</div>
