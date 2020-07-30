<?php

// Load widget base.
require_once get_template_directory() . '/inc/widgets/widgets-base.php';

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widgets-register-sidebars.php';

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widgets-common-functions.php';

/* Theme Widgets*/
/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/widgets/widget-product-grid.php';
    require get_template_directory() . '/inc/widgets/widget-product-carousel.php';
    require get_template_directory() . '/inc/widgets/widget-product-slider.php';
    require get_template_directory() . '/inc/widgets/widget-product-tabbed.php';
    require get_template_directory() . '/inc/widgets/widget-product-category-grid.php';
    require get_template_directory() . '/inc/widgets/widget-product-express-category.php';
}


require get_template_directory() . '/inc/widgets/widget-posts-latest.php';
require get_template_directory() . '/inc/widgets/widget-posts-tabbed.php';
require get_template_directory() . '/inc/widgets/widget-store-author-info.php';
require get_template_directory() . '/inc/widgets/widget-store-call-to-action.php';
require get_template_directory() . '/inc/widgets/widget-store-features.php';
require get_template_directory() . '/inc/widgets/widget-store-offers.php';
require get_template_directory() . '/inc/widgets/widget-store-testimonial.php';
require get_template_directory() . '/inc/widgets/widget-store-brands.php';
require get_template_directory() . '/inc/widgets/widget-social-contacts.php';
require get_template_directory() . '/inc/widgets/widget-social-mailchimp.php';
require get_template_directory() . '/inc/widgets/widget-social-instagram.php';
require get_template_directory() . '/inc/widgets/widget-store-youtube-video-slider.php';
require get_template_directory() . '/inc/widgets/widget-store-faq.php';



/* Register site widgets */
if ( ! function_exists( 'storecommerce_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function storecommerce_widgets() {

        /**
         * Load WooCommerce compatibility file.
         */
        if ( class_exists( 'WooCommerce' ) ) {
            register_widget( 'StoreCommerce_Product_Grid' );
            register_widget( 'StoreCommerce_Product_Carousel' );
            register_widget( 'StoreCommerce_Product_Slider' );
            register_widget( 'StoreCommerce_Products_Tabbed' );
            register_widget( 'StoreCommerce_Product_Category_Grid' );
            register_widget( 'StoreCommerce_Product_Express_Category' );
        }


        register_widget( 'StoreCommerce_Posts_Latest' );
        register_widget( 'StoreCommerce_Tabbed_Posts' );
        register_widget( 'StoreCommerce_Store_Author_Info' );
        register_widget( 'StoreCommerce_Store_Call_to_Action' );
        register_widget( 'StoreCommerce_Store_Features' );
        register_widget( 'StoreCommerce_Store_Offers' );
        register_widget( 'StoreCommerce_Store_Testimonial' );
        register_widget( 'StoreCommerce_Store_Brands' );
        register_widget( 'StoreCommerce_Social_Contacts' );
        register_widget( 'StoreCommerce_Social_MailChimp' );
        register_widget( 'StoreCommerce_Social_Instagram' );
        register_widget( 'StoreCommerce_Youtube_Video_Slider' );
        register_widget( 'StoreCommerce_Store_Faq' );

    }
endif;
add_action( 'widgets_init', 'storecommerce_widgets' );
