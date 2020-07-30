<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Includes\Wgl_Elementor_Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;


defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class Wgl_Flipbox extends Widget_Base {
    
    public function get_name() {
        return 'wgl-flipbox';
    }

    public function get_title() {
        return esc_html__('WGL Flipbox', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-flipbox';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    
    protected function _register_controls() {
        $primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_flipbox_settings',
            [ 'label' => esc_html__('General', 'carbonick-core') ]
        );

        $this->add_control(
            'flip_direction',
            [
                'label' => esc_html__('Border Type', 'Border Control', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flip_right' => esc_html__('Flip to Right', 'carbonick-core'),
                    'flip_left' => esc_html__('Flip to Left', 'carbonick-core'),
                    'flip_top' => esc_html__('Flip to Top', 'carbonick-core'),
                    'flip_bottom' => esc_html__('Flip to Bottom', 'carbonick-core'),
                ],
                'default' => 'flip_right',
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'carbonick-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'carbonick-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'carbonick-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'carbonick-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'flipbox_height',
            [
                'label' => esc_html__('Custom Flipbox Height)', 'carbonick-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 150,
                'step' => 10,
                'default' => 320,
                'description' => esc_html__('Enter value in pixels', 'carbonick-core'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> ICON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_flipbox_icon',
            [ 'label' => esc_html__('Icon', 'carbonick-core') ]
        );

        $this->start_controls_tabs( 'flipbox_icon' );

        $this->start_controls_tab(
            'flipbox_front_icon',
            [ 'label' => esc_html__('Front', 'carbonick-core') ]
        );

        Wgl_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'carbonick-core'),
                'output' => '',
                'section' => false,
                'prefix' => 'front_'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_icon',
            [
                'label' => esc_html__('Back', 'carbonick-core'),
            ]
        );

        Wgl_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'carbonick-core'),
                'output' => '',
                'section' => false,
                'prefix' => 'back_'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        //*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_ib_content',
            [ 'label' => esc_html__('Content', 'carbonick-core') ]
        );

        $this->start_controls_tabs( 'flipbox_content' );

        $this->start_controls_tab(
            'flipbox_front_content',
            [ 'label' => esc_html__('Front', 'carbonick-core') ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'front_content',
            [
                'label' => esc_html__('Flipbox Text', 'carbonick-core'),
                'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Description Text', 'carbonick-core'),
				'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'carbonick-core'),
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_content',
            [
                'label' => esc_html__('Back', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('This is the heading​', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'back_content',
            [
                'label' => esc_html__('Flipbox Text', 'carbonick-core'),
                'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('Description Text', 'carbonick-core'),
                'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'carbonick-core'),
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /*End General Settings Section*/
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [ 'label' => esc_html__('Flipbox Link', 'carbonick-core') ]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_read_more!' => 'yes' ],  
                'label_on' => esc_html__('On', 'carbonick-core'),
                'label_off' => esc_html__('Off', 'carbonick-core'),
                'return_value' => 'yes',

            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'carbonick-core'),
                'type' => Controls_Manager::URL,
                'condition' => [ 'add_item_link' => 'yes' ],
                'dynamic' => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'carbonick-core'),
                'label_off' => esc_html__('Off', 'carbonick-core'),
                'return_value' => 'yes',
                'condition' => [
                    'add_item_link!' => 'yes',
                ], 
            ]
        ); 

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'default' =>  esc_html__('Read More', 'carbonick-core'),
				'label_block' => true,
                'condition' => [ 
                    'add_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'carbonick-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'condition' => [ 
                    'add_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section(); 


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('General', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'flipbox_style' );

        $this->start_controls_tab(
            'flipbox_front_style',
            [
                'label' => esc_html__('Front', 'carbonick-core'),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'front_background',
				'label' => esc_html__('Front Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front',
			]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_style',
            [
                'label' => esc_html__('Back', 'carbonick-core'),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'back_background',
				'label' => esc_html__('Back Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl-flipbox_back',
			]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'flipbox_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'separator' => 'before',
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'flipbox_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'flipbox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'flipbox_border',
				'selector' => '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back',
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'flipbox_shadow',
				'selector' => '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back',
			]
		);

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> MEDIA
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'media_styles' );

        $this->start_controls_tab(
            'front_media_style',
            [ 'label' => esc_html__('Front', 'carbonick-core') ]
        );

        $this->add_responsive_control(
            'front_media_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'front_icon_color',
            [
                'label' => esc_html__('Icon Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'front_icon_type' => 'font',
                ]
            ]
        );

        $this->add_responsive_control(
            'front_icon_size',
            [
                'label' => esc_html__('Icon Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'front_icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 55, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_media_style',
            [ 'label' => esc_html__('Back', 'carbonick-core') ]
        );

        $this->add_responsive_control(
            'back_media_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'back_icon_color',
            [
                'label' => esc_html__('Icon Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => [ 'back_icon_type' => 'font' ],
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'back_icon_size',
            [
                'label' => esc_html__('Icon Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'back_icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 55, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title Tag', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'description' => esc_html__('Choose your tag for flipbox title', 'carbonick-core'),
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                ],
            ]
        );

        $this->start_controls_tabs( 'title_styles' );

        $this->start_controls_tab(
            'front_title_style',
            [ 'label' => esc_html__('Front', 'carbonick-core') ]
        );

        $this->add_responsive_control(
            'front_title_offset',
            [
                'label' => esc_html__('Title Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 8,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_front_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title',
            ]
        );

        $this->add_control(
            'front_title_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_title_style',
            [ 'label' => esc_html__('Back', 'carbonick-core') ]
        );

        $this->add_responsive_control(
            'back_title_offset',
            [
                'label' => esc_html__('Title Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 8,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_back_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title',
            ]
        );

        $this->add_control(
            'back_title_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs(); 
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'content_styles' );

        $this->start_controls_tab(
            'front_content_style',
            [ 'label' => esc_html__('Front', 'carbonick-core') ]
        );

        $this->add_responsive_control(
            'front_content_offset',
            [
                'label' => esc_html__('Content Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_front_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content',
            ]
        );

        $this->add_control(
            'front_content_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_content_style',
            [ 'label' => esc_html__('Back', 'carbonick-core') ]
        );

        $this->add_responsive_control(
            'back_content_offset',
            [
                'label' => esc_html__('Content Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_back_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content',
            ]
        );

        $this->add_control(
            'back_content_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs(); 
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BUTTON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'add_read_more!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wgl-flipbox_readmore',
            ]
        );

        $this->add_responsive_control(
            'custom_button_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 20,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_button_border',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs( 'button_color_tab' );

        $this->start_controls_tab(
            'custom_button_color_idle',
            [ 'label' => esc_html__('Idle' , 'carbonick-core') ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}} .wgl-flipbox_readmore',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .wgl-flipbox_readmore.wgl-button.elementor-button',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            [ 'label' => esc_html__('Hover' , 'carbonick-core') ]
        );

        $this->add_control(
            'button_background_hover',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore:hover' => 'background: {{VALUE}};'
                ],
            ]
        ); 

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_readmore:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}} .wgl-flipbox_readmore:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-flipbox_readmore:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render() {
        
        $settings = $this->get_settings_for_display();

        // HTML tags allowed for rendering
        $allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
            ],
            'br' => [],
            'em' => [],
            'strong' => [],
            'span' => [
                'class' => true,
                'style' => true,
            ],
            'p' => [
                'class' => true,
                'style' => true,
            ]
        ];

        $this->add_render_attribute(
            'flipbox',
            [
    			'class' => [
                    'wgl-flipbox',
                    'type_'.$settings[ 'flip_direction' ],
                ],
            ]
        );

        $this->add_render_attribute('flipbox_link', 'class', [ 'wgl-flipbox_readmore', 'wgl-button', 'elementor-button', 'elementor-size-xl']);
        if (isset($settings['link']['url'])) $this->add_link_attributes('flipbox_link', $settings['link']);

        $this->add_render_attribute('item_link', 'class', 'wgl-flipbox_item-link');
        if (isset($settings['item_link']['url'])) $this->add_link_attributes('item_link', $settings['item_link']);

        // Icon/Image output
        ob_start();
        if (! empty($settings[ 'front_icon_type' ])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $settings, 'front_' );
        }
        $front_media = ob_get_clean();
        // Icon/Image output
        ob_start();
        if (! empty($settings[ 'back_icon_type' ])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $settings, 'back_' );
        }
        $back_media = ob_get_clean();

        ?>
        <div <?php echo $this->get_render_attribute_string( 'flipbox' ); ?>>
            <div class="wgl-flipbox_wrap">
                <div class="wgl-flipbox_front"><?php
                    if ($settings[ 'front_icon_type' ] != '') {?>
                    <div class="wgl-flipbox_media-wrap"><?php 
                        if (! empty($front_media)) {
                            echo $front_media;
                        }?>
                    </div><?php
                    }
                    if (! empty($settings[ 'front_title' ])) {?>
                        <<?php echo $settings[ 'title_tag' ]; ?> class="wgl-flipbox_title"><?php echo wp_kses( $settings[ 'front_title' ], $allowed_html );?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    }
                    if (! empty($settings[ 'front_content' ])) {?>
                        <div class="wgl-flipbox_content"><?php echo wp_kses( $settings[ 'front_content' ], $allowed_html );?></div><?php
                    }?>
                </div>
                <div class="wgl-flipbox_back"><?php
                    if ($settings[ 'back_icon_type' ] != '') {?>
                    <div class="wgl-flipbox_media-wrap"><?php 
                        if (! empty($back_media)) {
                            echo $back_media;
                        }?>
                    </div><?php
                    }
                    if (! empty($settings[ 'back_title' ])) {?>
                        <<?php echo $settings[ 'title_tag' ]; ?> class="wgl-flipbox_title"><?php echo wp_kses( $settings[ 'back_title' ], $allowed_html );?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    }
                    if (! empty($settings[ 'back_content' ])) {?>
                        <div class="wgl-flipbox_content"><?php echo wp_kses( $settings[ 'back_content' ], $allowed_html );?></div><?php
                    }
                    if ((bool)$settings[ 'add_read_more' ]) {?>
                        <div class="wgl-flipbox_button-wrap"><a <?php echo $this->get_render_attribute_string( 'flipbox_link' ); ?>><?php echo esc_html($settings[ 'read_more_text' ]);?></a></div><?php
                    }?>
                </div>
            </div><?php
            if ((bool)$settings[ 'add_item_link' ]) {?>
                <a <?php echo $this->get_render_attribute_string( 'item_link' ); ?>></a><?php
            }?>
        </div>

        <?php     
    }
    
}