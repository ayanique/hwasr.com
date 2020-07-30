<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


/**
 * Customizer
 *
 * @class   storecommerce
 */

if (!function_exists('storecommerce_custom_style')) {

    function storecommerce_custom_style()
    {
        $storecommerce_preloader_background = storecommerce_get_option('site_preloader_background');
        $storecommerce_preloader_spinner_color = storecommerce_get_option('site_preloader_spinner_color');

        $top_header_background = storecommerce_get_option('top_header_background_color');
        $top_text_color = storecommerce_get_option('top_header_text_color');


        global $storecommerce_google_fonts;
        $storecommerce_primary_color = storecommerce_get_option('primary_color');
        $storecommerce_secondary_color = storecommerce_get_option('secondary_color');

        $secondary_background_color = storecommerce_get_option('secondary_background_color');
        $tertiary_background_color = storecommerce_get_option('tertiary_background_color');

        $storecommerce_primary_title_color = storecommerce_get_option('primary_title_color');
        $storecommerce_secondary_title_color = storecommerce_get_option('secondary_title_color');
        $storecommerce_tertiary_title_color = storecommerce_get_option('tertiary_title_color');

        $link_color = storecommerce_get_option('link_color');


        $storecommerce_primary_footer_background_color = storecommerce_get_option('primary_footer_background_color');
        $storecommerce_primary_footer_texts_color = storecommerce_get_option('primary_footer_texts_color');
        $storecommerce_secondary_footer_background_color = storecommerce_get_option('secondary_footer_background_color');
        $storecommerce_secondary_footer_texts_color = storecommerce_get_option('secondary_footer_texts_color');
        $storecommerce_footer_credits_background_color = storecommerce_get_option('footer_credits_background_color');
        $storecommerce_footer_credits_texts_color = storecommerce_get_option('footer_credits_texts_color');

        $storecommerce_mainbanner_silder_caption_font_size = storecommerce_get_option('main_banner_silder_caption_font_size');
        $storecommerce_primary_title_font_size = storecommerce_get_option('storecommerce_primary_title_font_size');
        $storecommerce_secondary_title_font_size = storecommerce_get_option('storecommerce_secondary_title_font_size');
        $storecommerce_tertiary_title_font_size = storecommerce_get_option('storecommerce_tertiary_title_font_size');


        $storecommerce_mailchimp_background_color = storecommerce_get_option('footer_mailchimp_background_color');
        $storecommerce_mailchimp_filed_border_color = storecommerce_get_option('footer_mailchimp_field_border_color');

        $main_navigation_background_color = storecommerce_get_option('main_navigation_background_color');
        $main_navigation_link_color = storecommerce_get_option('main_navigation_link_color');
        $main_navigation_badge_background = storecommerce_get_option('main_navigation_badge_background');
        $main_navigation_badge_color = storecommerce_get_option('main_navigation_badge_color');
        $storecommerce_title_color = storecommerce_get_option('title_link_color');
        $storecommerce_title_over_image_color = storecommerce_get_option('title_over_image_color');


        $storecommerce_primary_font = $storecommerce_google_fonts[storecommerce_get_option('primary_font')];
        $storecommerce_secondary_font = $storecommerce_google_fonts[storecommerce_get_option('secondary_font')];
        $storecommerce_letter_spacing = storecommerce_get_option('letter_spacing');
        $storecommerce_line_height = storecommerce_get_option('line_height');
        $storecommerce_font_weight= storecommerce_get_option('font_weight');

        ob_start();
        ?>


        <?php if (!empty($top_header_background)): ?>
        body .top-header {
        background-color: <?php echo $top_header_background; ?>;
        }


    <?php endif; ?>

        <?php if (!empty($storecommerce_preloader_background)): ?>
        body #af-preloader

        {
        background-color: <?php echo $storecommerce_preloader_background; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_preloader_spinner_color)): ?>
        body .spinner-container .path

        {
        stroke: <?php echo $storecommerce_preloader_spinner_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($top_text_color)): ?>
        body .top-header,
        body .top-header a,
        body .top-header a:hover,
        body .top-header a:active,
        body .top-header a:visited

        {
        color: <?php echo $top_text_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_primary_color)): ?>
        body .offcanvas-menu span,
        body .data-bg,
        body .primary-color
        {
        background-color: <?php echo $storecommerce_primary_color; ?>;
        }

        body,
        .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,
        body .title-role,
        .tagcloud a:hover,
        p.stars:hover a:before,
        body .section-subtitle,
        body .woocommerce-info,
        body .support-content p,
        body .woocommerce-error,
        body .woocommerce-message,
        .product-wrapper ul.product-item-meta.verticle .yith-btn a:before,
        body .style-3-search button,
        body .testi-details span.expert,
        body .style-3-search .search-field,
        body .style-3-search .cate-dropdown,
        p.stars.selected a.active:before,
        p.stars.selected a:not(.active):before,
        body .style-3-search .search-field::placeholder,
        .input-text::placeholder,
        input[type="text"]::placeholder, 
        input[type="email"]::placeholder, 
        input[type="url"]::placeholder, 
        input[type="password"]::placeholder, 
        input[type="search"]::placeholder, 
        input[type="number"]::placeholder, 
        input[type="tel"]::placeholder, 
        input[type="range"]::placeholder, 
        input[type="date"]::placeholder, 
        input[type="month"]::placeholder, 
        input[type="week"]::placeholder, 
        input[type="time"]::placeholder, 
        input[type="datetime"]::placeholder, 
        input[type="datetime-local"]::placeholder, 
        input[type="color"]::placeholder, 
        textarea::placeholder,
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="url"]:focus,
        input[type="password"]:focus,
        input[type="search"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        input[type="range"]:focus,
        input[type="date"]:focus,
        input[type="month"]:focus,
        input[type="week"]:focus,
        input[type="time"]:focus,
        input[type="datetime"]:focus,
        input[type="datetime-local"]:focus,
        input[type="color"]:focus,
        textarea:focus
        input[type="text"],
        input[type="email"], 
        input[type="url"], 
        input[type="password"], 
        input[type="search"], 
        input[type="number"], 
        input[type="tel"], 
        input[type="range"], 
        input[type="date"], 
        input[type="month"], 
        input[type="week"], 
        input[type="time"], 
        input[type="datetime"], 
        input[type="datetime-local"], 
        input[type="color"], 
        textarea,
        ul.product-item-meta li:hover a.added_to_cart,
        .inner-suscribe input,
        #add_payment_method #payment div.payment_box, 
        .woocommerce-cart #payment div.payment_box, 
        .woocommerce-checkout #payment div.payment_box,
        .woocommerce nav.woocommerce-breadcrumb, nav.woocommerce-breadcrumb,
        span#select2-billing_country-container,
        body.woocommerce ul.products li.product .price del,
        .header-style-3 .header-left-part .account-user a,
        ul.product-item-meta li a,
        .testimonial-slider .owl-nav button span,.owl-nav button span,
        body .woocommerce-product-details__short-description p
        {
        color: <?php echo $storecommerce_primary_color; ?>;
        }

        body .owl-theme .owl-dots .owl-dot span{
        background: <?php echo $storecommerce_primary_color; ?>;
        opacity: 0.5;
        }

        body .owl-theme .owl-dots .owl-dot span:hover{
        background: <?php echo $storecommerce_primary_color; ?>;
        opacity: 0.75;
        }

        body .owl-theme .owl-dots .owl-dot.active span{
        background: <?php echo $storecommerce_primary_color; ?>;
        opacity: 1;
        }

        body .price del,
        body .cat-links a,
        body .cat-links a:active,
        body .cat-links a:visited,
        body .cat-links li a,
        body .cat-links li a:active,
        body .cat-links li a:visited,
        body .entry-meta > span:after,
        body .cat-links li:after,
        body span.tagged_as a,
        body span.tagged_as a:active,
        body span.tagged_as a:visited,
        body span.posted_in a,
        body span.posted_in a:active,
        body span.posted_in a:visited,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a:active,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a:visited
        {
        color: <?php echo $storecommerce_primary_color; ?>;
        opacity: 0.75;
        }

        ins,
        select,
        span.price,
        .woocommerce .quantity .qty,
        
        .woocommerce ul.products li.product .price,
        .blog-content span p,
        .woocommerce div.product p.price ins, .woocommerce div.product span.price ins,
        .insta-feed-head a .instagram-username,
        body .cat-links a:hover,
        body .cat-links li a:hover,
        body span.tagged_as a:hover,
        body span.posted_in a:hover,
        .nav-tabs>li>a:hover,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover
        {
        color: <?php echo $storecommerce_primary_color; ?>;
        opacity: 1;
        }

        .woocommerce div.product .woocommerce-tabs ul.tabs li.active{
        border-color: <?php echo $storecommerce_primary_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_secondary_color)): ?>
        body .secondary-color,
        .horizontal ul.product-item-meta li a:hover,
        .aft-notification-button a,
        .aft-notification-button a:hover,
        .nav-tabs>li>a:hover,
        .product-wrapper ul.product-item-meta.verticle .yith-btn .yith-wcwl-wishlistexistsbrowse.show a:before,
        .woocommerce table.shop_table.cart.wishlist_table a.button:hover,
        body button,
        body input[type="button"],
        body input[type="reset"],
        body input[type="submit"],
        body .site-content .search-form .search-submit,
        body .site-footer .search-form .search-submit,
        .woocommerce a.button,
        body span.header-after:after,
        body #secondary .widget-title span:after,
        body .af-tabs.nav-tabs > li.active > a:after,
        body .af-tabs.nav-tabs > li > a:hover:after,
        body .exclusive-posts .exclusive-now,
        body span.trending-no,
        body .tagcloud a:hover,
        body .wpcf7-form .wpcf7-submit,
        body .express-off-canvas-panel a.offcanvas-nav i,
        body #scroll-up,
        body .sale-background.no-image,
        body .storecommerce-post-format,
        body .btn-style1 a,
        body .btn-style1 a:visited,
        body .woocommerce .btn-style1 a.button,
        body .btn-style1 a:focus,
        body span.offer-time.btn-style1 a:hover,
        body .content-caption .aft-add-to-wishlist.btn-style1 a:hover,
        body ul.product-item-meta li:hover,
        
        .woocommerce #respond input#submit:hover,
        table.compare-list .add-to-cart td a,
        .woocommerce .widget_shopping_cart_content a.button.wc-forward, 

        .woocommerce .widget_shopping_cart_content a.button.checkout,
        .yith-woocompare-widget a.compare:hover,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
        .woocommerce button.button,
        .woocommerce button.button.alt,
        .woocommerce a.button.alt,
        .woocommerce a.button.alt:hover,
        .woocommerce button.button:disabled:hover,
        .woocommerce button.button:disabled,
        .woocommerce button.button:disabled[disabled]:hover,
        .woocommerce button.button:disabled[disabled],
        .woocommerce button.button,
        .woocommerce button.button:hover,
        .yith-wcwl-wishlistaddedbrowse a,
        .yith-wcwl-wishlistexistsbrowse a,
        .yith-wcwl-add-button a.add_to_wishlist:hover,
        .inner-suscribe input[type=submit]:hover,
        .woocommerce-page .woocommerce-message a.button,
        .product-wrapper ul.product-item-meta.verticle .yith-btn a:hover:before,
        ul.product-item-meta li a.added_to_cart:hover,
        body.single-product .entry-summary .button.compare:hover,
        body.single-product .entry-summary .yith-wcwl-add-to-wishlist a:hover,
        body.woocommerce button.button.alt.disabled:hover,
        body.woocommerce button.button.alt.disabled,
        body.woocommerce #respond input#submit.alt:hover,
        body.woocommerce a.button.alt:hover,
        body.woocommerce button.button.alt:hover,
        body.woocommerce input.button.alt:hover,
        body.woocommerce #respond input#submit.alt,
        body.woocommerce a.button.alt,
        body.woocommerce button.button:hover,
        body.woocommerce button.button,
        body.woocommerce button.button.alt,
        body.woocommerce input.button.alt,
        body.woocommerce #respond input#submit,
        body.woocommerce a.button,
        body.woocommerce button.button,
        body.woocommerce input.button,
        body.woocommerce .widget_shopping_cart_content a.button.wc-forward,
        body.woocommerce .widget_shopping_cart_content a.button.checkout,
        body #secondary .nav-tabs>li.active>a.font-family-1,
        body .site-footer .nav-tabs>li.active>a.font-family-1,
        body .nav-tabs>li.active>a.font-family-1,
        body .nav-tabs>li.active>a,
        body .comment-form .submit,
        body input.search-submit
        {
        background: <?php echo $storecommerce_secondary_color; ?>;
        border-color: <?php echo $storecommerce_secondary_color; ?>;
        }


        body .product-wrapper ul.product-item-meta.verticle .yith-btn .yith-wcwl-wishlistexistsbrowse.show a:before{
        color: #fff;
        background: <?php echo $storecommerce_secondary_color; ?>;
        border-color: <?php echo $storecommerce_secondary_color; ?>;
        }



        body.single-product .entry-summary .button.compare,
        body.single-product .entry-summary .yith-wcwl-add-to-wishlist a
        {
        border-color: #e4e4e4;

        }

        

        body a:hover,
        body a:focus,
        body a:active
        {
        color: <?php echo $storecommerce_secondary_color; ?>;
        }


        body #loader:after {

        border-left-color: <?php echo $storecommerce_secondary_color; ?>;

        }


    <?php endif; ?>


        <?php if (!empty($link_color)): ?>


        a{
        color: <?php echo $link_color; ?>;

        }


        .social-widget-menu ul li a,
        .em-author-details ul li a,
        .tagcloud a {
        border-color: <?php echo $link_color; ?>;
        }

        a:visited{
        color: <?php echo $link_color; ?>;
        }
    <?php endif; ?>


        <?php if (!empty($tertiary_background_color)): ?>
        #add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment,    
        body .storecommerce_video_slider_widget,
        body .storecommerce_store_brands_widget,
        body .product_store_faq_widget
        {
        background-color: <?php echo $tertiary_background_color; ?>;

        }
    <?php endif; ?>

        <?php if (!empty($secondary_background_color)): ?>

        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"],    
        .woocommerce table.shop_table, body.woocommerce-js form.woocommerce-checkout, body.woocommerce-js form.woocommerce-cart-form,
        .horizontal ul.product-item-meta li a,
        select option,  
        .inner-suscribe input,.inner-suscribe input[type=submit],  

        .nav-tabs>li>a,
        .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,
        .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,
        .woocommerce-MyAccount-content, nav.woocommerce-MyAccount-navigation,
        .style-3-search,
        .style-3-search .search-field,
        .style-3-search button,
        
        .panel,
        .woocommerce-message, address,
        .woocommerce ul.woocommerce-error,
        .woocommerce-info,
        .entry-wrapper, 
        .comments-area,   
        #secondary .widget,
        .woocommerce-tabs.wc-tabs-wrapper,
        .storecommerce-product-summary-wrap.clearfix,
        .posts_latest_widget .blog-details,    
        .product-wrapper ul.product-item-meta.verticle .yith-btn a:before,    
        ul.product-item-meta li,  
        ul.product-item-meta li a.added_to_cart,  
        body .product-wrapper
        {
        background-color: <?php echo $secondary_background_color; ?>;

        }
        .nav-tabs>li>a{
        border-color: <?php echo $secondary_background_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_primary_title_color)): ?>
        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6,
        body #primary .widget-title,
        body .section-title,
        body #sidr .widget-title,
        body #secondary .widget-title,
        body .page-title,
        body.blog h1.page-title,
        body.archive h1.page-title,
        body.woocommerce-js article .entry-title,
        body.blog article h2 a,
        body.archive article h2 a
        {
        color: <?php echo $storecommerce_primary_title_color; ?>;

        }
    <?php endif; ?>

        <?php if (!empty($storecommerce_secondary_title_color)): ?>

        body .product_store_faq_widget .ui-accordion .ui-accordion-header{

        color: <?php echo $storecommerce_secondary_title_color; ?>;
        opacity: 0.75;
        }
        .aft-notification-title,
        .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item a, 
        .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item span,
        body .product-title a,
        

        body .product_store_faq_widget .ui-accordion .ui-accordion-header[aria-expanded="true"],
        body .product_store_faq_widget .ui-accordion .ui-accordion-header[aria-expanded="true"]:before,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header.ui-accordion-header-active,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header:hover,
        body .support-content h5,
        body .blog-title h4 a,
        .woocommerce ul.product_list_widget li a,
        body.single-product .entry-summary .button.compare,
        body.single-product .entry-summary .yith-wcwl-add-to-wishlist a,
        body h3.article-title.article-title-1 a:visited,
        body .trending-posts-carousel h3.article-title a:visited,
        body .exclusive-slides a:visited,
        body .nav-tabs>li>a,
        #secondary .widget > ul > li a
        {
        color: <?php echo $storecommerce_secondary_title_color; ?>;
        opacity: 1;
        }
    <?php endif; ?>


        <?php if (!empty($storecommerce_tertiary_title_color)): ?>

        .woocommerce table.shop_table.cart.wishlist_table a.button,    
        .woocommerce table.shop_table.cart.wishlist_table a.button:hover,    
        ul.product-item-meta li a.added_to_cart:hover,    
        .btn-style1 a, .btn-style1 a:visited, .woocommerce .btn-style1 a.button, .btn-style1 a:focus, 
        .inner-suscribe input[type=submit]:hover,   
        .woocommerce #respond input#submit,
        .woocommerce #respond input#submit:hover,
        .comment-form .submit, input.search-submit,
        .comment-form .submit:hover, input.search-submit:hover,
        .horizontal ul.product-item-meta li a:hover,
        .aft-notification-button a:hover,    
        .aft-notification-button a,    
        .nav-tabs>li>a:hover, 
        #secondary .nav-tabs>li.active>a.font-family-1, 
        .site-footer .nav-tabs>li.active>a.font-family-1, 
        .nav-tabs>li.active>a.font-family-1, .nav-tabs>li.active>a,   
        span.offer-time.btn-style1 a,    
        body .sale-title,
        body .sale-info span.item-count,
        body .storecommerce_social_mailchimp_widget h4.section-title,
        body #primary .call-to-action .widget-title.section-title,
        body .storecommerce_social_mailchimp_widget .section-subtitle,
        body .call-to-action,
        body .call-to-action .section-title,
        body .call-to-action .section-subtitle,
        body .sale-single-wrap
        {
        color: <?php echo $storecommerce_tertiary_title_color; ?>;
        }

        span.offer-time.btn-style1 a{
        border-color: <?php echo $storecommerce_tertiary_title_color; ?>;
        }    

    <?php endif; ?>

        <?php if (!empty($storecommerce_line_height)): ?>
        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6 {
        line-height: <?php echo $storecommerce_line_height; ?>;
        }
    <?php endif; ?>

        <?php if (!empty($storecommerce_line_height)): ?>
        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6 {
        font-weight: <?php echo $storecommerce_font_weight; ?>;
        }
    <?php endif; ?>

        <?php if (!empty($main_navigation_background_color)): ?>
        .top-cart-content.primary-bgcolor,    
        .main-navigation ul .sub-menu, 
        .main-navigation .menu ul ul,   
        body.home .header-style-2.aft-transparent-header.aft-sticky-navigation,
        body.home .header-style-2.aft-transparent-header.aft-sticky-navigation,
        .header-style-2:before,    

        body .header-style-3-1 .navigation-section-wrapper,
        body .header-style-3 .navigation-section-wrapper
        {
        background-color: <?php echo $main_navigation_background_color; ?>;
        }

        @media screen and (max-width: 992em){
        .main-navigation .menu .menu-mobile {
            background-color: <?php echo $main_navigation_background_color; ?>;
        }
        }

    <?php endif; ?>


        <?php if (!empty($main_navigation_link_color)): ?>
        
        .woocommerce ul.cart_list li a,
        .header-right-part .cart-shop span,
        p.woocommerce-mini-cart__empty-message,
        .woocommerce .widget_shopping_cart .total strong,
        .woocommerce.widget_shopping_cart .total strong,
        body .main-navigation ul .sub-menu li a,
        body.home .header-style-2.aft-transparent-header .cart-shop,
        body.home .header-style-2.aft-transparent-header .account-user a,
        body.home .header-style-2.aft-transparent-header .open-search-form,
        body.home .header-style-2.aft-transparent-header .aft-wishlist-trigger,
        body.home .header-style-2.aft-transparent-header .main-navigation .menu > li > a,
        body .main-navigation .menu ul.menu-desktop > li > a,
        body .header-style-2.aft-transparent-header.aft-sticky-navigation .main-navigation .menu ul.menu-desktop > li > a:visited,
        body .header-right-part > div  i,
        body .main-navigation .menu ul.menu-desktop > li > a:visited,
        body .af-cart-icon-and-count:after,
        body .header-style-2.aft-transparent-header .main-navigation .menu > li > a,
        body.home .header-style-2.aft-transparent-header .main-navigation .menu > li > a,
        body.home .header-style-2.aft-transparent-header.aft-sticky-navigation .main-navigation .menu > li > a,
        body.home .header-style-2.aft-transparent-header .af-cart-icon-and-count:after,
        body.home .header-style-2.aft-transparent-header.aft-sticky-navigation .af-cart-icon-and-count:after
        {
        color: <?php echo $main_navigation_link_color; ?>;
        }
        .ham,.ham:before, .ham:after
        {
        background-color: <?php echo $main_navigation_link_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($main_navigation_badge_background)): ?>

        .posts_latest_widget .posts-date, 
        span.offer-date-counter > span,    
        body span.menu-description,
        body span.title-note,
        body .badge-wrapper span.onsale,
        body .header-right-part .aft-wooicon .aft-woo-counter,
        body .header-right-part .af-cart-icon-and-count .item-count,
        body span.product-count span.item-texts,
        body .post-thumbnail-wrap .posts-date,
        body .posts_latest_widget .posts-date,
        body .main-navigation .menu > li > a:before
        {
        background: <?php echo $main_navigation_badge_background; ?>;
        }

        span.offer-date-counter > span{
        border-color: <?php echo $main_navigation_badge_background; ?>;
        }

        

        body span.menu-description:after,
        body span.title-note:after,
        body span.title-note:after
        {
        border-top: 5px solid <?php echo $main_navigation_badge_background; ?>;
        }

        body span.product-count span.item-texts:after{
        border-top: 10px solid <?php echo $main_navigation_badge_background; ?>;
        }
    <?php endif; ?>

        <?php if (!empty($main_navigation_badge_color)): ?>

        .header-right-part .aft-wooicon .aft-woo-counter, 
        .header-right-part .af-cart-icon-and-count .item-count,    
        .sale-info span.item-count, 
        span.offer-date-counter > span .text,    
        span.offer-date-counter > span .number,    
        span.offer-date-counter > span,    
        .badge-wrapper .onsale,
        .woocommerce span.onsale,
        span.product-count span.item-texts,
        .menu-description,
        span.title-note,
        body span.menu-description,
        body .post-thumbnail-wrap .posts-date,
        body .posts_latest_widget .posts-date
        {
        color: <?php echo $main_navigation_badge_color; ?>;
        }

    <?php endif; ?>


        <?php if (!empty($storecommerce_title_over_image_color)): ?>
        body .slider-figcaption-1 .slide-title a,
        body .categorized-story .title-heading .article-title-2 a,
        body .full-plus-list .spotlight-post:first-of-type figcaption h3 a{
        color: <?php echo $storecommerce_title_over_image_color; ?>;
        }

        body .slider-figcaption-1 .slide-title a:visited,
        body .categorized-story .title-heading .article-title-2 a:visited,
        body .full-plus-list .spotlight-post:first-of-type figcaption h3 a:visited{
        color: <?php echo $storecommerce_title_over_image_color; ?>;
        }


    <?php endif; ?>

        <?php if (!empty($storecommerce_postformat_color)): ?>
        body .figure-categories-bg .em-post-format{
        background: <?php echo $storecommerce_postformat_color; ?>;
        }
        body .em-post-format{
        color: <?php echo $storecommerce_postformat_color; ?>;
        }

    <?php endif; ?>


        <?php if (!empty($storecommerce_primary_font)): ?>
        body,
        body button,
        body input,
        body select,
        body optgroup,
        body textarea {
        font-family: <?php echo $storecommerce_primary_font; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_secondary_font)): ?>
        body h1,
        body h2,
        body h3,
        body h4,
        body h5,
        body h6,
        body .main-navigation a,
        body .font-family-1,
        body .site-description,
        body .trending-posts-line,
        body .exclusive-posts,
        body .widget-title,
        body .em-widget-subtitle,
        body .grid-item-metadata .item-metadata,
        body .af-navcontrols .slide-count,
        body .figure-categories .cat-links,
        body .nav-links a {
        font-family: <?php echo $storecommerce_secondary_font; ?>;
        }

    <?php endif; ?>


        <?php if (!empty($storecommerce_line_height)): ?>
        body,
        body .price del,
        body .title-role,
        body .section-subtitle,
        body .woocommerce-info,
        body .support-content p,
        body .woocommerce-error,
        body .woocommerce-message,
        body .testi-details span.expert,
        body .style-3-search .cate-dropdown,
        body .style-3-search .search-field::placeholder,
        body.woocommerce ul.products li.product .price del,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header,
        .header-style-3 .header-left-part .account-user a,
        body .woocommerce-product-details__short-description p {
        letter-spacing: <?php echo $storecommerce_letter_spacing; ?>px;
        line-height: <?php echo $storecommerce_line_height; ?>;
        }

    <?php endif; ?>


        <?php if (!empty($storecommerce_primary_footer_background_color)): ?>
        body footer.site-footer .primary-footer {
        background: <?php echo $storecommerce_primary_footer_background_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($storecommerce_primary_footer_texts_color)): ?>
        body footer.site-footer .primary-footer,
        body footer.site-footer ins,
        body footer.site-footer .primary-footer .widget-title span,
        body footer.site-footer .primary-footer .site-title a,
        body footer.site-footer .primary-footer .site-description,
        body footer.site-footer .primary-footer a {
        color: <?php echo $storecommerce_primary_footer_texts_color; ?>;

        }

        footer.site-footer .primary-footer .social-widget-menu ul li a,
        footer.site-footer .primary-footer .em-author-details ul li a,
        footer.site-footer .primary-footer .tagcloud a
        {
        border-color: <?php echo $storecommerce_primary_footer_texts_color; ?>;
        }

        footer.site-footer .primary-footer a:visited {
        color: <?php echo $storecommerce_primary_footer_texts_color; ?>;
        }


    <?php endif; ?>


        <?php if (!empty($storecommerce_secondary_footer_background_color)): ?>
        body footer.site-footer .secondary-footer {
        background: <?php echo $storecommerce_secondary_footer_background_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($storecommerce_secondary_footer_texts_color)): ?>
        body footer.site-footer .secondary-footer .footer-navigation a{
        color: <?php echo $storecommerce_secondary_footer_texts_color; ?>;

        }

    <?php endif; ?>
        <?php if (!empty($storecommerce_footer_credits_background_color)): ?>
        body footer.site-footer .site-info {
        background: <?php echo $storecommerce_footer_credits_background_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_footer_credits_texts_color)): ?>
        body footer.site-footer .site-info,
        body footer.site-footer .site-info a {
        color: <?php echo $storecommerce_footer_credits_texts_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_mailchimp_background_color)): ?>
        body .mailchimp-block {
        background: <?php echo $storecommerce_mailchimp_background_color; ?>;

        }
    <?php endif; ?>


        <?php if (!empty($storecommerce_mailchimp_filed_border_color)): ?>
        body .mc4wp-form-fields input[type="text"], body .mc4wp-form-fields input[type="email"] {
        border-color: <?php echo $storecommerce_mailchimp_filed_border_color; ?>;

        }
    <?php endif; ?>

        @media only screen and (min-width: 1025px) and (max-width: 1599px) {

        <?php if (!empty($storecommerce_mainbanner_silder_caption_font_size)): ?>
        body .main-banner-slider .caption-heading .cap-title {
        font-size: <?php echo $storecommerce_mainbanner_silder_caption_font_size; ?>px;

        }
    }

    <?php endif; ?>


        <?php if (!empty($storecommerce_primary_title_font_size)): ?>

        body.woocommerce div.product .product_title,
        body span.header-after,
        body.archive .content-area .page-title,
        body.search-results .content-area .header-title-wrapper .page-title,
        body header.entry-header h1.entry-title,
        body .sale-info span.product-count,
        body .sale-title
        {
        font-size: <?php echo $storecommerce_primary_title_font_size; ?>px;
        }

    <?php endif; ?>




        <?php if (!empty($storecommerce_secondary_title_font_size)): ?>

        h2.entry-title,    
        .cart_totals h2,    
        h2.comments-title,    
        .support-content h5,    
        #sidr .widget-title,    
        div#respond h3#reply-title,    
        section.related.products h2,   
        body #sidr span.header-after,
        body #secondary .widget-title span,
        body footer .widget-title .header-after
        {
        font-size: <?php echo $storecommerce_secondary_title_font_size; ?>px;
        }

    <?php endif; ?>

        <?php if (!empty($storecommerce_tertiary_title_font_size)): ?>

        .nav-tabs>li>a, 
        body .product_store_faq_widget .ui-accordion .ui-accordion-header,
        body .blog-title h4 a,   
        .product-slider .product-title a,    
        body h4.product-title a
        {
        font-size: <?php echo $storecommerce_tertiary_title_font_size; ?>px;
        }

    <?php endif; ?>




        }
        <!--        end if media query-->

        <?php
        return ob_get_clean();
    }
}


