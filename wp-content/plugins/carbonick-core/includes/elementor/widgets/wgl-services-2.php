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

class Wgl_Services_2 extends Widget_Base {
    
    public function get_name() {
        return 'wgl-services-2';
    }

    public function get_title() {
        return esc_html__('WGL Services 2', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-services-2';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }
    
    
    protected function _register_controls() {
        $theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $second_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/

        $output[ 'media_width' ] = [
            'label' => esc_html__('Media Width(Height)', 'carbonick-core'),
            'type' => Controls_Manager::NUMBER,
            'condition' => [ 'icon_type!' => '' ],
            'min' => 50,
            'step' => 1,
            'default' => 110,
            'description' => esc_html__('Enter value in pixels', 'carbonick-core'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wgl-services_media-wrap' => 'width: {{VALUE}}px; height: {{VALUE}}px; line-height: {{VALUE}}px;',
            ],
        ];

        Wgl_Icons::init(
            $this,
            [
                'label' => esc_html__('Services 2 ', 'carbonick-core'),
                'output' => $output,'section' => true,
                'prefix' => ''
            ]
        );
        
        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section('wgl_ib_content',
            [
                'label' => esc_html__('Service Content', 'carbonick-core'),
            ]
        );

        $this->add_control('ib_title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'carbonick-core'),
                'dynamic' => [ 'active' => true ]
            ]
        );

        $this->add_control('ib_content',
            [
                'label' => esc_html__('Service Text', 'carbonick-core'),
                'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('Description Text', 'carbonick-core'),
				'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'carbonick-core'),
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
                    '{{WRAPPER}} .wgl-services_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [
                'label' => esc_html__('Service Link', 'carbonick-core'),
            ]
        );

        $this->add_control('add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'carbonick-core'),
                'label_off' => esc_html__('Off', 'carbonick-core'),
                'return_value' => 'yes',
                'condition' => [
                    'add_read_more!' => 'yes',
                ],  

            ]
        );

        $this->add_control('item_link',
            [
                'label' => esc_html__('Link', 'carbonick-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'condition' => [ 
                    'add_item_link' => 'yes',
                ],
            ]
        );

        $this->add_control('add_read_more',
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

        $this->add_control('read_more_text',
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

        $this->add_control('link',
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

        /*End Link Settings Section*/
        $this->end_controls_section(); 

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 
            'icon_colors',
            [
                'condition' => [
                    'icon_type'  => 'font',
                ],
            ]
        );

        $this->start_controls_tab(
            'icon_colors_idle',
            [
                'label' => esc_html__('Idle', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $second_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [
                'label' => esc_html__('Hover', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Primary Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'font',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'carbonick-core') . ' (%)',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'image',
                ]
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom'=> 1,
                    'left'  => 1,
                    'unit'  => 'px',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'border_type',
            [
                'label' => esc_html__('Border Type', 'Border Control', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'Border Control', 'carbonick-core'),
                    'double' => esc_html__('Double', 'Border Control', 'carbonick-core'),
                    'dotted' => esc_html__('Dotted', 'Border Control', 'carbonick-core'),
                    'dashed' => esc_html__('Dashed', 'Border Control', 'carbonick-core'),
                    'groove' => esc_html__('Groove', 'Border Control', 'carbonick-core'),
                ],
                'default' => 'dashed',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('border_colors');

        $this->start_controls_tab(
            'border_colors_idle',
            [
                'label' => esc_html__('Idle', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'border_primary_color',
            [
                'label' => esc_html__('Border Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $second_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'border_colors_hover',
            [
                'label' => esc_html__('Hover', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'border_hover_primary_color',
            [
                'label' => esc_html__('Border Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_media-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'circle_width',
            [
                'label' => esc_html__('Circles Width(Height)', 'carbonick-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 2,
                'step' => 1,
                'default' => 8,
                'description' => esc_html__('Enter value in pixels', 'carbonick-core'),
                'condition' => [
                'icon_type!' => '',
                ],
                'separator' => 'before',
                'selectors' => [
                '{{WRAPPER}} .wgl-services_circle' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
                ],
            ]
        );
        
        $this->add_control(
            'circle_color_1',
            [
                'label' => esc_html__('First Circle Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $second_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_circle-wrapper:nth-child(1) .wgl-services_circle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'circle_color_2',
            [
                'label' => esc_html__('Second Circle Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $second_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_circle-wrapper:nth-child(2) .wgl-services_circle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('title_tag',
            [
                'label' => esc_html__('Title Tag', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'description' => esc_html__('Choose your tag for service title', 'carbonick-core'),
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹DIV›',
                    'span' => '‹SPAN›',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_offset',
            [
                'label' => esc_html__('Title Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 15,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                    'unit'  => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-services_title',
            ]
        );


        $this->start_controls_tabs( 'title_color_tab' );

        $this->start_controls_tab(
            'custom_title_color_idle',
            [
                'label' => esc_html__('Idle' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            [
                'label' => esc_html__('Hover' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($header_font_color),
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_title' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .wgl-services_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('content_tag',
            [
                'label' => esc_html__('Content Tag', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'div',
                'description' => esc_html__('Choose your tag for service content', 'carbonick-core'),
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

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Content Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom'=> 20,
                    'left'  => 0,
                    'unit'  => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_content_mask_color',
                'label' => esc_html__('Background', 'carbonick-core'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl-services_text',
                'condition' => [ 
                    'custom_bg' => 'custom',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .wgl-services_text',
            ]
        ); 

        $this->start_controls_tabs( 'content_color_tab' );

        $this->start_controls_tab(
            'custom_content_color_idle',
            [
                'label' => esc_html__('Idle' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($main_font_color),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_content_color_hover',
            [
                'label' => esc_html__('Hover' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($main_font_color),
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_text' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'add_read_more!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->add_responsive_control(
            'custom_button_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_button_border',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs( 'button_color_tab' );

        $this->start_controls_tab(
            'custom_button_color_idle',
            [
                'label' => esc_html__('Idle' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selectors' =>  '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            [
                'label' => esc_html__('Hover' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'button_background_hover',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore:hover' => 'background: {{VALUE}};'
                ],
            ]
        ); 

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($second_color),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}} .wgl-services_readmore:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-services_readmore:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 
        
        $this->start_controls_section(
            'service_2_style_section',
            [
                'label' => esc_html__('Item', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'service_2_offset',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_2_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'service_2_border_radius',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'service_2_color_tab' );

        $this->start_controls_tab(
            'custom_service_2_color_idle',
            [
                'label' => esc_html__('Idle' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'bg_service_2_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}} .wgl-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow',
                'selector' =>  '{{WRAPPER}} .wgl-services_wrap',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_2_color_hover',
            [
                'label' => esc_html__('Hover' , 'carbonick-core'),
            ]
        );

        $this->add_control(
            'bg_service_2_color_hover',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border_hover',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}}:hover .wgl-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow_hover',
                'selector' =>  '{{WRAPPER}}:hover .wgl-services_wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $circle_w = $settings[ 'media_width' ];

        $this->add_render_attribute( 'services', [
			'class' => [
                'wgl-services-2',
            ],
        ] );

        $this->add_render_attribute( 'circle_wrap', [
			'class' => [
                'wgl-services_circle-wrapper',
            ],
            'style' => [
                'width: '.(round($circle_w/sqrt(2))).'px;',
                'height: '.(round($circle_w/sqrt(2))).'px;',
                'left: '.(($circle_w - round($circle_w/sqrt(2)))/2).'px;',
                'top: '.(($circle_w - round($circle_w/sqrt(2)))/2).'px;',
            ]
        ] );

        $this->add_render_attribute(
            'serv_link',
            [
                'class' => [
                    'wgl-services_readmore'
                ],
            ]
        );
        if (isset($settings['link']['url'])) $this->add_link_attributes('serv_link', $settings['link']);

        $this->add_render_attribute('item_link', 'class', 'wgl-services_item-link');
        if (isset($settings['item_link']['url'])) $this->add_link_attributes('item_link', $settings['item_link']);


        // HTML tags allowed for rendering
        $allowed_html = [
            'a' => [
                'href' => true,
                'title' => true,
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

        // Icon/Image output
        ob_start();
        if (!empty($settings[ 'icon_type' ])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $settings, []);
        }
        $services_media = ob_get_clean();

        ?>
        <div <?php echo $this->get_render_attribute_string( 'services' ); ?>>
            <div class="wgl-services_wrap"><?php
                if ($settings[ 'icon_type' ] != '') {?>
                <div class="wgl-services_media-wrap">
                    <div <?php echo $this->get_render_attribute_string( 'circle_wrap' ); ?>><div class="wgl-services_circle"></div></div>
                    <div <?php echo $this->get_render_attribute_string( 'circle_wrap' ); ?>><div class="wgl-services_circle"></div></div><?php 
                    if (!empty($services_media)) {
                        echo $services_media;
                    }?>
                </div><?php
                }?>
                <div class="wgl-services_content-wrap">
                    <<?php echo $settings[ 'title_tag' ]; ?> class="wgl-services_title"><?php echo wp_kses( $settings[ 'ib_title' ], $allowed_html );?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    if (!empty($settings[ 'ib_content' ])) {?>
                        <<?php echo $settings[ 'content_tag' ]; ?> class="wgl-services_text"><?php echo wp_kses( $settings[ 'ib_content' ], $allowed_html );?></<?php echo $settings[ 'content_tag' ]; ?>><?php
                    }
                    if ((bool)$settings[ 'add_read_more' ]) {?>
                        <a <?php echo $this->get_render_attribute_string( 'serv_link' ); ?>><?php echo esc_html($settings[ 'read_more_text' ]);?></a><?php
                    }?>
                </div><?php
                if ((bool)$settings[ 'add_item_link' ]) {?>
                    <a <?php echo $this->get_render_attribute_string( 'item_link' ); ?>></a><?php
                }?>
            </div>
        </div>

        <?php     
    }
    
}