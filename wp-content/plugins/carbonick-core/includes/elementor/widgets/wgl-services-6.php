<?php

namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Repeater;


class Wgl_Services_6 extends Widget_Base
{

    public function get_name()
    {
        return 'wgl-services-6';
    }

    public function get_title()
    {
        return esc_html__('WGL Services 6', 'carbonick-core');
    }

    public function get_icon()
    {
        return 'wgl-services-6';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }


    protected function _register_controls()
    {
        $primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> ICON/IMAGE
        /*-----------------------------------------------------------------------------------*/

        Wgl_Icons::init(
            $this,
            ['section' => true]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'module_content',
            ['label' => esc_html__('Content', 'carbonick-core')]
        );

        $this->add_control(
            'ib_title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'ib_text',
            [
                'label' => esc_html__('Text', 'carbonick-core'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'dynamic' => ['active' => true]
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
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> LINK
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Button', 'carbonick-core')]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['add_read_more!' => 'yes'],
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'carbonick-core'),
                'type' => Controls_Manager::URL,
                'condition' => ['add_item_link' => 'yes'],
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['add_item_link!' => 'yes'],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => ['add_read_more' => 'yes'],
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => '',
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
        /*  STYLE -> MEDIA
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
            ['condition' => ['icon_type'  => 'font']]
        );

        $this->start_controls_tab(
            'icon_colors_normal',
            ['label' => esc_html__('Normal', 'carbonick-core')]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            ['label' => esc_html__('Hover', 'carbonick-core')]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Primary Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
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
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-widget_container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['icon_type' => 'font'],
                'range' => [
                    'px' => ['min' => 16, 'max' => 200],
                ],
                'default' => ['size' => 40, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_alignment',
            [
                'label' => esc_html__('Media Alignment', 'carbonick-core'),
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
                'default' => 'left',
                'toggle' => true,
                'prefix_class' => 'media-',
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title Tag', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'description' => esc_html__('Choose your tag for service title', 'carbonick-core'),
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
            'title_offset',
            [
                'label' => esc_html__('Title Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
	                'top' => 14,
	                'right' => 25,
	                'bottom' => 8,
	                'left' => 0,
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


        $this->start_controls_tabs('title_color_tab');

        $this->start_controls_tab(
            'custom_title_color_normal',
            ['label' => esc_html__('Normal', 'carbonick-core')]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            ['label' => esc_html__('Hover', 'carbonick-core')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1e1e1e',
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_title, {{WRAPPER}}:hover .wgl-services_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TEXT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'text_style_section',
            [
                'label' => esc_html__('Text', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_offset',
            [
                'label' => esc_html__('Title Offset', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_text',
                'selector' => '{{WRAPPER}} .wgl-services_text',
            ]
        );


        $this->start_controls_tabs('text_color_tab');

        $this->start_controls_tab(
            'custom_text_color_normal',
            ['label' => esc_html__('Normal', 'carbonick-core')]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_text_color_hover',
            ['label' => esc_html__('Hover', 'carbonick-core')]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ITEM
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'item_style_section',
            [
                'label' => esc_html__('Item', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

	    $this->add_responsive_control(
		    'interval',
		    [
			    'label' => esc_html__('Services Min Height', 'carbonick-core'),
			    'type' => Controls_Manager::SLIDER,
			    'range' => [
				    'px' => [
					    'min' => 200,
					    'max' => 1000,
				    ],
			    ],
			    'devices' => [ 'desktop', 'tablet', 'mobile' ],
			    'desktop_default' => [
				    'size' => 370,
				    'unit' => 'px',
			    ],
			    'tablet_default' => [
				    'size' => 370,
				    'unit' => 'px',
			    ],
			    'mobile_default' => [
				    'size' => 370,
				    'unit' => 'px',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-services_wrap' => 'min-height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'item_pad',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 40,
                    'right' => 20,
                    'bottom' => 36,
                    'left' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-services_readmore' => 'left: {{LEFT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'services_item_shadow',
                'selector' => '{{WRAPPER}} .wgl-services_wrap',
            ]
        );

        $this->start_controls_tabs('item_color_tab');

        $this->start_controls_tab(
            'custom_item_color_normal',
            ['label' => esc_html__('Normal', 'carbonick-core')]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'custom_content_mask_color',
			    'label' => esc_html__('Background', 'carbonick-core'),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .wgl-services_image-wrap',
		    ]
	    );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_item_color_hover',
            ['label' => esc_html__('Hover', 'carbonick-core')]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'custom_content_mask_color_hover',
			    'label' => esc_html__('Background', 'carbonick-core'),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .wgl-services_image-wrap_hover',
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
                'condition' => ['add_read_more!' => ''],
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
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 13,
                    'right' => 13,
                    'bottom' => 13,
                    'left' => 13,
                ],
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
                'size_units' => ['px', 'em', '%'],
                'default' => [
	                'top' => 22,
	                'right' => 0,
	                'bottom' => 0,
	                'left' => 0,
                ],
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
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left'  => 50,
                    'unit'  => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs('button_color_tab');

        $this->start_controls_tab(
            'custom_button_color_idle',
            ['label' => esc_html__('Idle', 'carbonick-core')]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_color_item_hover',
            ['label' => esc_html__('Item Hover', 'carbonick-core')]
        );

        $this->add_control(
            'button_background_item_hover',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_readmore' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color_item_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_readmore' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_item_hover',
                'label' => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}}:hover .wgl-services_readmore',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_item_hover',
                'selector' => '{{WRAPPER}}:hover .wgl-services_readmore',
            ]
        );

        $this->end_controls_tab();

	    $this->start_controls_tab(
		    'custom_button_color_hover',
		    ['label' => esc_html__('Button Hover', 'carbonick-core')]
	    );


	    $this->add_control(
		    'button_background_hover',
		    [
			    'label' => esc_html__('Background Color', 'carbonick-core'),
			    'type' => Controls_Manager::COLOR,
			    'default' => '#efece5',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-services_readmore:hover' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'button_color_hover',
		    [
			    'label' => esc_html__('Color', 'carbonick-core'),
			    'type' => Controls_Manager::COLOR,
			    'default' => $primary_color,
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

        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    public function render()
    {
        $_s = $this->get_settings_for_display();
        extract($_s);

        $this->add_render_attribute(
            'services',
            [
                'class' => [
                    'wgl-services-6',
                    'services_' . $_s['alignment']
                ],
            ]
        );

        $this->add_render_attribute('serv_link', 'class', 'wgl-services_readmore');
        if (isset($_s['link']['url'])) $this->add_link_attributes('serv_link', $_s['link']);

        $this->add_render_attribute('item_link', 'class', 'wgl-services_link');
        if (isset($_s['item_link']['url'])) $this->add_link_attributes('item_link', $_s['item_link']);

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
        if (!empty($_s['icon_type'])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $_s, []);
        }
        $services_media = ob_get_clean();

        // Render
        echo '<div ', $this->get_render_attribute_string('services'), '>';
        echo '<div class="wgl-services_wrap">';

	    echo '<div class="wgl-services_image-wrap"></div>';
	    echo '<div class="wgl-services_image-wrap_hover"></div>';

        if ($_s['icon_type'] != '') {
            echo '<div class="wgl-services_media-wrap">';
            if (!empty($services_media)) {
                echo $services_media;
            }
            echo '</div>';
        }

	    if ($_s['add_read_more']) {
		    echo '<a ', $this->get_render_attribute_string('serv_link'), '>',
		    esc_html($read_more_text),
		    '</a>';
	    }

        echo '<div class="wgl-services_content-wrap">';

        echo '<', $_s['title_tag'], ' class="wgl-services_title">',
            wp_kses($_s['ib_title'], $allowed_html),
            '</', $_s['title_tag'], '>';
        echo '<div class="wgl-services_text">',
            wp_kses($_s['ib_text'], $allowed_html),
            '</div>';
        echo '</div>'; // content-wrap

        if ($_s['add_item_link']) {
            echo '<a ', $this->get_render_attribute_string('item_link'), '></a>';
        }

        echo '</div>'; // wgl-services_wrap
        echo '</div>';
    }
}
