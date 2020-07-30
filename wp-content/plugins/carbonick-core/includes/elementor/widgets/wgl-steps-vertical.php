<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

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
use Elementor\Icons_Manager;


class Wgl_Steps_Vertical extends Widget_Base
{
    public function get_name() {
        return 'wgl-steps-vertical';
    }

    public function get_title() {
        return esc_html__('WGL Steps Vertical', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-steps-vertical';
    }
 
    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    public function get_script_depends() {
        return [ 'jquery-appear' ];
    }


    protected function _register_controls()
    {
        $primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $tertiary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-tertiary-color'));
        $header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_steps_section',
            [
                'label' => esc_html__('General', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'add_appear',
            [
                'label' => esc_html__('Add Appear Animation', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => esc_html__('Line Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .steps-image_curve_inner:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .steps-image_curve_inner:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'carbonick-core'),
            ]
        ); 

        $repeater = new Repeater();

	    /*-----------------------------------------------------------------------------------*/
	    /*  CONTENT -> ICON/IMAGE
		/*-----------------------------------------------------------------------------------*/
	    $repeater->add_control(
        'steps_icon_type',
            [
                'label' => esc_html__('Add Icon/Image', 'carbonick-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__('None', 'carbonick-core'),
                        'icon' => 'fa fa-ban',
                    ],
                    'number' => [
                        'title' => esc_html__('Number', 'carbonick-core'),
                        'icon' => 'fa fa-list-ol',
                    ],
                    'font' => [
                        'title' => esc_html__('Icon', 'carbonick-core'),
                        'icon' => 'fa fa-smile-o',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'carbonick-core'),
                        'icon' => 'fa fa-picture-o',
                    ]
                ],
                'default' => 'number',
            ]
        );

        $repeater->add_control(
            'steps_number',
            [
                'label' => esc_html__('Number', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '01', 
                'condition' => [
                    'steps_icon_type'  => 'number',
                ],
            ]
        );


	    $repeater->add_control(
        'steps_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'carbonick-core'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'condition' => [
                    'steps_icon_type'  => 'font',
                ],
                'default' => [
	                'value' => 'flaticon flaticon-motor-1',
	                'library' => 'solid',
                ],
                'description' => esc_html__('Select icon from Fontawesome library.', 'carbonick-core'),
            ]
        );
        $repeater->add_control(
        'steps_icon_thumbnail',
            [
                'label' => esc_html__('Image', 'carbonick-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'condition' => [ 'steps_icon_type' => 'image' ],
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $repeater->add_control(
			'add_item_link',
			[
				'label' => esc_html__('Add Link On Whole Item', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			]
		); 

		$repeater->add_control(
			'item_link',
			[
				'label' => esc_html__('Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'condition' => [ 'add_item_link' => 'yes' ],
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
			]
        );
        
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__('This is the heading​', 'carbonick-core'),
				'placeholder' => esc_html__('This is the heading​', 'carbonick-core'),
                'dynamic' => [ 'active' => true],
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'carbonick-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'carbonick-core'),
                'dynamic' => [ 'active' => true],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'carbonick-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('First heading​', 'carbonick-core'),
                    ],
                    [
                        'title' => esc_html__('Second heading​', 'carbonick-core'),
                    ],
                ],
                'title_field' => '{{title}}',
            ]
        );

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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .steps-text',
            ]
        );

        $this->add_control(
			'title_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
				/* 'default' => [ 'size' => 15, 'unit' => 'px' ], */
				'selectors' => [
					'{{WRAPPER}} .steps-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_control(
			'title_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 4,
                    'left' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}} .steps-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( 'title_colors' );

        $this->start_controls_tab(
            'title_colors_idle',
            [
                'label' => esc_html__('Idle', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => [
                    '{{WRAPPER}} .steps-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_colors_hover',
            [
                'label' => esc_html__('Hover', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .steps-item:hover .steps-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .steps-item:hover .steps-pointer:before' => 'background-color: {{VALUE}};',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .steps-text',
            ]
        );
        
        $this->add_control(
			'content_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
				/* 'default' => [ 'size' => 15, 'unit' => 'px' ], */
				'selectors' => [
					'{{WRAPPER}} .steps-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_control(
			'content_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
				/* 'default' => [ 'size' => 15, 'unit' => 'px' ], */
				'selectors' => [
					'{{WRAPPER}} .steps-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( 'content_colors' );

        $this->start_controls_tab(
            'content_colors_idle',
            [
                'label' => esc_html__('Idle', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .steps-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .steps-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .steps-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_shadow',
                'selector' => '{{WRAPPER}} .steps-content',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'content_colors_hover',
            [
                'label' => esc_html__('Hover', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'content_hover_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .steps-item:hover .steps-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .steps-item:hover .steps-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_hover_border',
                'selector' => '{{WRAPPER}} .steps-item:hover .steps-content',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_hover_shadow',
                'selector' => '{{WRAPPER}} .steps-item:hover .steps-content',
            ]
        );

        
        $this->add_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .steps-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); 

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Content Wrapper
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Content Wrapper', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wrapper_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 64,
                    'left' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-cont' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'wrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .steps-cont' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_wrapper',
            [
                'separator' => 'before',
            ]
        );

        $this->start_controls_tab(
            'tab_wrapper_idle',
            [ 'label' => esc_html__('Idle', 'carbonick-core') ]
        );

        $this->add_control(
            'wrapper_bg_idle',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .steps-cont' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .steps-cont',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .steps-cont',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'wrapper_bg_hover',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .steps-item:hover .steps-cont' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .steps-item:hover .steps-cont',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .steps-item:hover .steps-cont',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Icon Image
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('Icon & Image & Number Icon', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'number_typo_desc',
			[
				'raw' => __( 'Number Settings.  Avaible only for the number', 'elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typo',
                'selector' => '{{WRAPPER}} .steps-image .number',
            ]
        );

        $this->add_control(
            'number_typo_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
			'icon_image_desc',
			[
				'raw' => __( 'Icon & Image settings. Avaible only for an icon and the image', 'elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon & Image Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'max' => 200 ],
                ],
                'size_units' => [ 'px' ],
                'default' => [ 'size' => 45, 'unit' => 'px' ],
                'description' => esc_html__('Enter button diameter in pixels.', 'carbonick-core'),
                'selectors' => [
                    '{{WRAPPER}} .steps-image i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .steps-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'number_icon_image_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
			'global_desc',
			[
				'raw' => __( 'Global settings', 'elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
        );

        $this->add_control(
            'icon_wrapper_size',
            [
                'label' => esc_html__('Wrapper Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'max' => 200 ],
                ],
                'size_units' => [ 'px' ],
                'default' => [ 'size' => 45, 'unit' => 'px' ],
                'description' => esc_html__('Enter button diameter in pixels.', 'carbonick-core'),
                'selectors' => [
                    '{{WRAPPER}} .steps-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .steps-item' => 'width: calc(100% + {{SIZE}}{{UNIT}}/2);',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_wrapper_border',
				'selector' => '{{WRAPPER}} .steps-image',
				'separator' => 'before',
			]
		);

        $this->start_controls_tabs( 'icon_colors' );

        $this->start_controls_tab(
            'icon_colors_idle',
            [
                'label' => esc_html__('Idle', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .steps-image i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .steps-image .number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .steps-image' => 'background-color: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow',
                'selector' => '{{WRAPPER}} .steps-image',
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
	        'icon_hover_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .steps-item:hover .steps-image i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .steps-item:hover .steps-image .number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .steps-item:hover .steps-image' => 'background-color: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'icon_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'icon_wrapper_border_border!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .steps-item:hover .steps-image' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'date_hover_shadow',
                'selector' => '{{WRAPPER}} .steps-item:hover .steps-image',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'add_border_animation',
			[
				'label' => esc_html__('Add Border Animation', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'yes',
			]
        );
        
        $this->add_control(
            'border_size',
            [
                'label' => esc_html__('Border Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'max' => 200 ],
                ],
                'size_units' => [ 'px' ],
                'default' => [ 'size' => 75, 'unit' => 'px' ],
                'description' => esc_html__('Enter button diameter in pixels.', 'carbonick-core'),
                'condition' => [
                    'add_border_animation'  => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-steps-vertical .steps-image:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; margin-left: calc(-{{SIZE}}{{UNIT}} / 2) ; margin-top: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );
        $this->add_control(
            'border_animation_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' =>'rgba('.\Carbonick_Theme_Helper::HexToRGB($primary_color).', 0.2)',
                'condition' => [
                    'add_border_animation'  => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-steps-vertical .steps-image:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        
        $this->end_controls_section();


    }

    protected function render()
    {
        
        wp_enqueue_script('jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js', [], false, false);

        $settings = $this->get_settings_for_display();

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

        $this->add_render_attribute( 'steps-vertical', [
            'class' => [
                 'wgl-steps-vertical',
                 ((bool)$settings[ 'add_appear' ] ? 'appear_animation' : '' ),
             ],
         ] );
       
        ?>
        <div <?php echo $this->get_render_attribute_string( 'steps-vertical' ); ?>>
        

        <div class="steps-items_wrap"><?php

        foreach ( $settings[ 'items' ] as $index => $item ) {

	        // Steps Icon/image
	        $icon_out = '';
	        if ( $item[ 'steps_icon_type' ] != '' ) {
		        if ( $item[ 'steps_icon_type' ] == 'font' && (!empty( $item[ 'steps_icon_fontawesome' ] )) ) {
                    
			        $icon_font = $item[ 'steps_icon_fontawesome' ];
			        $icon_out = '';
			        // add icon migration
			        $migrated = isset( $item['__fa4_migrated'][$item[ 'steps_icon_fontawesome' ]] );
			        $is_new = Icons_Manager::is_migration_allowed();
			        if ( $is_new || $migrated ) {
				        ob_start();
				        Icons_Manager::render_icon( $item[ 'steps_icon_fontawesome' ], [ 'aria-hidden' => 'true' ] );
				        $icon_out .= ob_get_clean();
			        } else {
				        $icon_out .= '<i class="icon '.esc_attr($icon_font).'"></i>';
			        }
		        }
		        if ( $item[ 'steps_icon_type' ] == 'image' && !empty( $item[ 'steps_icon_thumbnail' ] ) ) {
			        if ( ! empty( $item[ 'steps_icon_thumbnail' ][ 'url' ] ) ) {
				        $this->add_render_attribute( 'thumbnail', 'src', $item[ 'steps_icon_thumbnail' ][ 'url' ] );
				        $this->add_render_attribute( 'thumbnail', 'alt', Control_Media::get_image_alt( $item[ 'steps_icon_thumbnail' ] ) );
				        $this->add_render_attribute( 'thumbnail', 'title', Control_Media::get_image_title( $item[ 'steps_icon_thumbnail' ] ) );
				        $icon_out = Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'steps_icon_thumbnail' );
			        }
		        }
		        if ( $item[ 'steps_icon_type' ] == 'number' && !empty( $item[ 'steps_number' ] ) ) {
				    $icon_out = '<span class="number">'.$item[ 'steps_number' ] .'</span>';
		        }
	        }
	        // End Tab Icon/image

            $title = $this->get_repeater_setting_key( 'title', 'items' , $index ); 
            $this->add_render_attribute(
                $title,
                [
                    'class' => 'steps-title',
                ]
            );

            $item_wrap = $this->get_repeater_setting_key( 'item_wrap', 'items' , $index );
            $this->add_render_attribute(
                $item_wrap,
                [
                    'class' => [
                        'steps-item',
                        ((bool)$settings[ 'add_border_animation' ] ? 'bordered_animation' : '' ),
                    ]
                ]
            );

            ?>
            <div <?php echo $this->get_render_attribute_string( $item_wrap ); ?>>
                <div class="steps-image_wrap">
                    <div class="steps-image"><?php echo $icon_out; ?></div>
                    <div class="steps-image_curve"><div class="steps-image_curve_inner"></div>
                </div>
            </div>
                <div class="steps-cont">
                    <div class="steps-content" ><?php
                        if (!empty($item[ 'content' ]) || !empty($item[ 'title' ]) || !empty($item[ 'date' ])) {
                            if (!empty($item[ 'title' ])) {?>
                                <h3 <?php echo $this->get_render_attribute_string( $title ); ?>><?php echo $item[ 'title' ] ?></h3><?php
                            }
                            if (!empty($item[ 'content' ])) {?>
                                <div class="steps-text"><?php echo wp_kses( $item[ 'content' ], $allowed_html );?></div><?php
                            }
                        }?>
                    </div>
                </div>
                <?php
                
                if ((bool)$item['add_item_link']) {           

                    if (isset($item['item_link']['url']) && ! empty( $item['item_link']['url'] ) ) $this->add_link_attributes('item_link', $item['item_link']);

                    $link_attributes = $this->get_render_attribute_string( 'item_link' );
                    ?>
                    <a class="steps-link" <?php echo implode( ' ', [ $link_attributes ] );?>></a>
                    <?php
                }
                ?>
            </div><?php
        }?>
        </div>
        </div><?php 
        
    }
    
}