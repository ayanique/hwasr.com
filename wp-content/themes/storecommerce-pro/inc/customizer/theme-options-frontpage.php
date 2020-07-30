<?php

/**
 * Option Panel
 *
 * @package StoreCommerce
 */

$default = storecommerce_get_default_theme_options();

/**
 * Frontpage options section
 *
 * @package StoreCommerce
 */


// Add Frontpage Options Panel.
$wp_customize->add_panel('frontpage_option_panel',
    array(
        'title'      => esc_html__('Frontpage Options', 'storecommerce'),
        'priority'   => 199,
        'capability' => 'edit_theme_options',
    )
);


// Advertisement Section.
$wp_customize->add_section('frontpage_advertisement_settings',
    array(
        'title'      => esc_html__('Banner Advertisement', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'frontpage_option_panel',
    )
);



// Setting banner_advertisement_section.
$wp_customize->add_setting('banner_advertisement_section',
    array(
        'default'           => $default['banner_advertisement_section'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control($wp_customize, 'banner_advertisement_section',
        array(
            'label'       => esc_html__('Banner Section Advertisement', 'storecommerce'),
            'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'storecommerce'), 1500, 100),
            'section'     => 'frontpage_advertisement_settings',
            'width' => 1500,
            'height' => 100,
            'flex_width' => true,
            'flex_height' => true,
            'priority'    => 120,
        )
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('banner_advertisement_section_url',
    array(
        'default'           => $default['banner_advertisement_section_url'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('banner_advertisement_section_url',
    array(
        'label'    => esc_html__('URL Link', 'storecommerce'),
        'section'  => 'frontpage_advertisement_settings',
        'type'     => 'text',
        'priority' => 130,
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('banner_advertisement_open_on_new_tab',
    array(
        'default'           => $default['banner_advertisement_open_on_new_tab'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);
$wp_customize->add_control('banner_advertisement_open_on_new_tab',
    array(
        'label'    => esc_html__('Open in new tab', 'storecommerce'),
        'section'  => 'frontpage_advertisement_settings',
        'type'     => 'checkbox',
        'priority' => 130,
    )
);


// Setting - select_main_banner_section_mode.
$wp_customize->add_setting('banner_advertisement_scope',
    array(
        'default'           => $default['banner_advertisement_scope'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control( 'banner_advertisement_scope',
    array(
        'label'       => esc_html__('Show banner advertisement on', 'storecommerce'),
        'description' => esc_html__('Select scope to display on banner advertisement section', 'storecommerce'),
        'section'     => 'frontpage_advertisement_settings',
        'type'        => 'select',
        'choices'               => array(
            'front-page-only' => esc_html__( 'Show on Homepage only', 'storecommerce' ),
            'site-wide' => esc_html__( 'Show sitewide', 'storecommerce' ),
        ),
        'priority'    => 130,

    ));



/**
 * Main Banner Slider Section
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_main_banner_section_settings',
    array(
        'title'      => esc_html__('Main Banner Section', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'frontpage_option_panel',
    )
);


// Setting - show_main_news_section.
$wp_customize->add_setting('show_main_news_section',
    array(
        'default'           => $default['show_main_news_section'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_main_news_section',
    array(
        'label'    => esc_html__('Enable Main Banner Slider', 'storecommerce'),
        'section'  => 'frontpage_main_banner_section_settings',
        'type'     => 'checkbox',
        'priority' => 22,

    )
);

// Setting - select_main_banner_section_mode.
$wp_customize->add_setting('select_main_banner_section_mode',
    array(
        'default'           => $default['select_main_banner_section_mode'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control( 'select_main_banner_section_mode',
    array(
        'label'       => esc_html__('Select Banner Section Mode', 'storecommerce'),
        'description' => esc_html__('Select Banner Section Mode', 'storecommerce'),
        'section'     => 'frontpage_main_banner_section_settings',
        'type'        => 'select',
        'choices'               => array(
            'page-slider' => esc_html__( "Page Slider", 'storecommerce' ),
            'product-slider' => esc_html__( "Product Slider", 'storecommerce' ),
        ),
        'priority'    => 23,
        'active_callback' => 'storecommerce_main_banner_section_status'
    ));



$slider_number = 5;

for ( $i = 1; $i <= $slider_number; $i++ ) {

    //Slide Details
    $wp_customize->add_setting('page_slide_'.$i.'_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new StoreCommerce_Section_Title(
            $wp_customize,
            'page_slide_'.$i.'_section_title',
            array(
                'label' 			=> esc_html__( 'Set Slide ', 'storecommerce' ) . ' - ' . $i,
                'section' 			=> 'frontpage_main_banner_section_settings',
                'priority' 			=> 100,
                'active_callback' => function( $control ) {
                    return (
                        storecommerce_main_banner_section_status( $control )
                        &&
                        storecommerce_page_slider_banner_mode_status( $control )
                    );
                },
            )
        )
    );

    $wp_customize->add_setting( "slider_page_$i",
        array(
            'sanitize_callback' => 'storecommerce_sanitize_dropdown_pages',
        )
    );
    $wp_customize->add_control( "slider_page_$i",
        array(
            'label'           => esc_html__( 'Select Page', 'storecommerce' ),
            'section'         => 'frontpage_main_banner_section_settings',
            'type'            => 'dropdown-pages',            
            'priority' 		  => 100,
            'active_callback' => function( $control ) {
                return (
                    storecommerce_main_banner_section_status( $control )
                    &&
                    storecommerce_page_slider_banner_mode_status( $control )
                );
            },
        )
    );

    $wp_customize->add_setting( "page_caption_position_$i",
        array(
            'default'           => 'left',
            'sanitize_callback' => 'storecommerce_sanitize_select',
        )
    );

    $wp_customize->add_control( "page_caption_position_$i",
        array(
            'label'           => esc_html__( 'Caption Position', 'storecommerce' ),
            'section'         => 'frontpage_main_banner_section_settings',
            'type'            => 'select',
            'choices'         => array(
                'left'     => esc_html__( 'Left', 'storecommerce' ),
                'right'    => esc_html__( 'Right', 'storecommerce' ),
                'center'   => esc_html__( 'Center', 'storecommerce' ),
            ),           
            'priority' 		  => 100,
            'active_callback' => function( $control ) {
                return (
                    storecommerce_main_banner_section_status( $control )
                    &&
                    storecommerce_page_slider_banner_mode_status( $control )
                );
            },
        )
    );

    // Setting slider readmore text.
    $wp_customize->add_setting( "button_text_$i",
        array(
            'default'           => esc_html__( 'Shop Now', 'storecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control( "button_text_$i",
        array(
            'label'    => esc_html__( 'Button Text', 'storecommerce' ),
            'section'  => 'frontpage_main_banner_section_settings',
            'type'     => 'text',            
            'priority' => 100,
            'active_callback' => function( $control ) {
                return (
                    storecommerce_main_banner_section_status( $control )
                    &&
                    storecommerce_page_slider_banner_mode_status( $control )
                );
            },
        )
    );

    // Setting slider readmore link.
    $wp_customize->add_setting( "button_link_$i",
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control( "button_link_$i",
        array(
            'label'    => esc_html__( 'Button Link', 'storecommerce' ),
            'section'  => 'frontpage_main_banner_section_settings',
            'type'     => 'text',            
            'priority' => 100,
            'active_callback' => function( $control ) {
                return (
                    storecommerce_main_banner_section_status( $control )
                    &&
                    storecommerce_page_slider_banner_mode_status( $control )
                );
            },
        )
    );

}


$slider_number = 5;

for ( $i = 1; $i <= $slider_number; $i++ ) {

    //Slide Details
    $wp_customize->add_setting('product_slide_'.$i.'_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new StoreCommerce_Section_Title(
            $wp_customize,
            'product_slide_'.$i.'_section_title',
            array(
                'label' 			=> esc_html__( 'Set Slide ', 'storecommerce' ) . ' - ' . $i,
                'section' 			=> 'frontpage_main_banner_section_settings',
                'priority' 			=> 100,
                'active_callback' => function( $control ) {
                    return (
                        storecommerce_main_banner_section_status( $control )
                        &&
                        storecommerce_product_slider_banner_mode_status( $control )
                    );
                },
            )
        )
    );

    $wp_customize->add_setting( "slider_product_$i",
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control( "slider_product_$i",
        array(
            'label'           => esc_html__( 'Product Id', 'storecommerce' ),
            'section'         => 'frontpage_main_banner_section_settings',
            'type'            => 'text',
            'priority' 		  => 100,
            'active_callback' => function( $control ) {
                return (
                    storecommerce_main_banner_section_status( $control )
                    &&
                    storecommerce_product_slider_banner_mode_status( $control )
                );
            },
        )
    );

    $wp_customize->add_setting( "product_caption_position_$i",
        array(
            'default'           => 'left',
            'sanitize_callback' => 'storecommerce_sanitize_select',
        )
    );

    $wp_customize->add_control( "product_caption_position_$i",
        array(
            'label'           => esc_html__( 'Caption Position', 'storecommerce' ),
            'section'         => 'frontpage_main_banner_section_settings',
            'type'            => 'select',
            'choices'         => array(
                'left'     => esc_html__( 'Left', 'storecommerce' ),
                'right'    => esc_html__( 'Right', 'storecommerce' ),
                'center'   => esc_html__( 'Center', 'storecommerce' ),
            ),
            'priority' 		  => 100,
            'active_callback' => function( $control ) {
                return (
                    storecommerce_main_banner_section_status( $control )
                    &&
                    storecommerce_product_slider_banner_mode_status( $control )
                );
            },
        )
    );

}




//
//$wp_customize->add_setting( 'sample_image_radio_button',
//    array(
//        'default' => 'sidebarright',
//        'transport' => 'refresh',
//        'sanitize_callback' => 'storecommerce_text_sanitization'
//    )
//);
//
//
//$wp_customize->add_control( new StoreCommerce_Image_Radio_Button_Custom_Control( $wp_customize, 'sample_image_radio_button',
//    array(
//        'label' => __( 'Image Radio Button Control' ),
//        'description' => esc_html__( 'Sample custom control description' ),
//        'section' => 'frontpage_layout_settings',
//        'choices' => array(
//            'sidebarleft' => array(  // Required. Setting for this particular radio button choice
//                'image' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-left.png', // Required. URL for the image
//                'name' => __( 'Left Sidebar' ) // Required. Title text to display
//            ),
//            'sidebarnone' => array(
//                'image' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-none.png',
//                'name' => __( 'No Sidebar' )
//            ),
//            'sidebarright' => array(
//                'image' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-right.png',
//                'name' => __( 'Right Sidebar' )
//            )
//        )
//    )
//) );
//


