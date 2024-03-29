<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;


defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class Wgl_Image_Layers extends Widget_Base {
    
    public function get_name() {
        return 'wgl-image-layers';
    }

    public function get_title() {
        return esc_html__('WGL Image Layers', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-image-layers';
    }
 
    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    public function get_script_depends() {
        return [
            'jquery-appear',
        ];
    }

    
    
    protected function _register_controls() {
        $theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);
        $header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        
        /* Start General Settings Section */
        $this->start_controls_section('wgl_image_layers_section',
            array(
                'label'         => esc_html__('General Settings', 'carbonick-core'),
            )
        );

        $this->add_control(
            'interval',
            array(
                'label' => esc_html__('Enter Interval Images Appearing', 'carbonick-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 50,
				'step' => 50,
				'default' => 600,
                'description' => esc_html__('Enter interval in milliseconds', 'carbonick-core'),
            )
        );

        $this->add_control(
            'transition',
            array(
                'label' => esc_html__('Enter Transition Speed', 'carbonick-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 50,
				'step' => 50,
				'default' => 800,
                'description' => esc_html__('Enter transition speed in milliseconds', 'carbonick-core'),
            )
        );

        $this->add_control(
            'image_link',
            array(
                'label'             => esc_html__('Add Image Link', 'carbonick-core'),
                'type'              => Controls_Manager::URL,
                'label_block'       => true,
            )
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section('wgl_content_section',
            array(
                'label'         => esc_html__('Content', 'carbonick-core'),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            array(
                'label'       => esc_html__('Thumbnail', 'carbonick-core'),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [
                    'url' => '',
                ],
            )
        );

        $repeater->add_control(
            'top_offset',
            array(
                'label'             => esc_html__('Top Offset', 'carbonick-core'),
                'type'              => Controls_Manager::NUMBER,
                'min' => -100,
                'max' => 100,
				'step' => 1,
				'default' => '0',
                'description' => esc_html__('Enter offset in %, for example -100% or 100%', 'carbonick-core'),
            )
        );

        $repeater->add_control(
            'left_offset',
            array(
                'label'             => esc_html__('Left Offset', 'carbonick-core'),
                'type'              => Controls_Manager::NUMBER,
                'min' => -100,
                'max' => 100,
				'step' => 1,
				'default' => '0',
                'description' => esc_html__('Enter offset in %, for example -100% or 100%', 'carbonick-core'),
            )
        );

	    $repeater->add_control(
		    'image_animation',
		    array(
			    'label'   => esc_html__( 'Layer Animation', 'carbonick-core' ),
			    'type'    => Controls_Manager::SELECT,
			    'options' => [
				    'fade_in'         => esc_html__( 'Fade In', 'carbonick-core' ),
				    'slide_up'        => esc_html__( 'Slide Up', 'carbonick-core' ),
				    'slide_down'      => esc_html__( 'Slide Down', 'carbonick-core' ),
				    'slide_left'      => esc_html__( 'Slide Left', 'carbonick-core' ),
				    'slide_right'     => esc_html__( 'Slide Right', 'carbonick-core' ),
				    'slide_big_up'    => esc_html__( 'Slide Big Up', 'carbonick-core' ),
				    'slide_big_down'  => esc_html__( 'Slide Big Down', 'carbonick-core' ),
				    'slide_big_left'  => esc_html__( 'Slide Big Left', 'carbonick-core' ),
				    'slide_big_right' => esc_html__( 'Slide Big Right', 'carbonick-core' ),
				    'flip_x'          => esc_html__( 'Flip Horizontally', 'carbonick-core' ),
				    'flip_y'          => esc_html__( 'Flip Vertically', 'carbonick-core' ),
				    'zoom_in'         => esc_html__( 'Zoom In', 'carbonick-core' ),
				    'offset'          => esc_html__( 'Animate Offset', 'carbonick-core' ),
			    ],
			    'default' => 'fade_in',
		    )
	    );

        $repeater->add_control(
            'image_order',
            array(
                'label'             => esc_html__('Image z-index', 'carbonick-core'),
                'type'              => Controls_Manager::NUMBER,
				'step'              => 1,
                'default'           => '1',
            )
        );

        $this->add_control(
            'items',
            array(
                'label'   => esc_html__('Layers', 'carbonick-core'),
                'type'    => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
            )
        );

        $this->end_controls_section(); 

    }

    protected function render() {
        
        wp_enqueue_script('jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), false, false);

        $content = '';
        $animation_delay = 0;
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'image-layers', [
			'class' => [
                'wgl-image-layers', 
            ],
        ] );

        if (!empty($settings['image_link']['url'])) {
            $this->add_render_attribute('image_link', 'class', 'image_link');
            $this->add_link_attributes('image_link', $settings['image_link']);
        }

        foreach ( $settings[ 'items' ] as $index => $item ) {

            $animation_delay = $animation_delay + $settings[ 'interval' ];

            $image_layer = $this->get_repeater_setting_key( 'image_layer', 'items' , $index ); 
            $this->add_render_attribute( $image_layer, [
                'src' => esc_url($item[ 'thumbnail' ][ 'url' ]),
                'alt' => Control_Media::get_image_alt( $item[ 'thumbnail' ] ),
            ] );

            $image_wrapper = $this->get_repeater_setting_key( 'image_wrapper', 'items' , $index ); 
            $this->add_render_attribute( $image_wrapper, [
                'class' => [
                    'img-layer_image-wrapper',
                    esc_attr($item[ 'image_animation' ])
                ],
                'style' => 'z-index: '.esc_attr((int)$item[ 'image_order' ]),
            ] );

            $layer_item = $this->get_repeater_setting_key( 'layer_item', 'items' , $index ); 
            $this->add_render_attribute( $layer_item, [
                'class' => [ 'img-layer_item' ],
                'style' => 'transform: translate('.( !empty($item[ 'top_offset' ]) ? esc_attr($item[ 'top_offset' ]) : '0' ).'%, '.( !empty($item[ 'left_offset' ]) ? esc_attr($item[ 'left_offset' ]) : '0' ).'%); transition: all '.$settings[ 'transition' ].'ms; transition-delay: '.$animation_delay.'ms;'
            ] );

            $layer_image = $this->get_repeater_setting_key( 'layer_image', 'items' , $index ); 
            $this->add_render_attribute( $layer_image, [
                'class' => [ 'img-layer_image' ],
            ] );


            /*$layer_image = $this->get_repeater_setting_key( 'layer_image', 'items' , $index );
            $this->add_render_attribute( $layer_image, [
                'class' => [ 'img-layer_image' ],
                'style' => 'transition: all '.$settings[ 'transition' ].'ms; transition-delay: '.$animation_delay.'ms;'
            ] );*/

            ob_start();

            ?><div <?php echo $this->get_render_attribute_string( $image_wrapper ); ?>>
                <div <?php echo $this->get_render_attribute_string( $layer_item ); ?>>
                    <div <?php echo $this->get_render_attribute_string( $layer_image ); ?>>
                        <img <?php echo $this->get_render_attribute_string( $image_layer ); ?> />
                    </div>
                </div>
            </div> <?php

            $content .= ob_get_clean();
        }
        

        ?><div <?php echo $this->get_render_attribute_string( 'image-layers' ); ?>><?php
            if ( !empty($settings[ 'image_link' ][ 'url' ]) ) : ?><a <?php echo $this->get_render_attribute_string( 'image_link' ); ?>><?php endif;
                echo $content;
            if ( !empty($settings[ 'image_link' ][ 'url' ]) ) : ?></a><?php endif;
        ?></div><?php

    }
    
}