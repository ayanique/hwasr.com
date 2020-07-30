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
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;


defined('ABSPATH') || exit; // Abort, if called directly.

class Wgl_Striped_Services extends Widget_Base
{

    public function get_name()
    {
        return 'wgl-striped-services';
    }

    public function get_title()
    {
        return esc_html__('WGL Striped Services', 'carbonick-core');
    }

    public function get_icon()
    {
        return 'wgl-striped-services';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear'];
    }


    protected function _register_controls()
    {
        $theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);
        $header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_striped_services_section',
            ['label' => esc_html__('General', 'carbonick-core')]
        );

        $this->add_responsive_control(
            'interval',
            [
                'label' => esc_html__('Module Height', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 200, 'max' => 1000],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => ['size' => 850, 'unit' => 'px'],
                'tablet_default' => ['size' => 850, 'unit' => 'px'],
                'mobile_default' => ['size' => 750, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-striped-services' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_content_section',
            ['label' => esc_html__('Content', 'carbonick-core')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'serv_title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Service Title', 'carbonick-core'),
            ]
        );

        $repeater->add_control(
            'serv_subtitle',
            [
                'label' => esc_html__('Subtitle', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Service Subtitle', 'carbonick-core'),
            ]
        );
        $repeater->add_control(
            'serv_bg_text',
            [
                'label' => esc_html__('Background Text', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('01', 'carbonick-core'),
            ]
        );

        $repeater->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['thumbnail[url]' => ''],
                'default' => '#323232',
            ]
        );

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'carbonick-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => ['url' => ''],
            ]
        );

        $repeater->add_responsive_control(
            'bg_position',
            [
                'label' => esc_html__('Position', 'Background Control', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'responsive' => true,
                'options' => [
                    'top left' => esc_html__('Top Left', 'Background Control', 'carbonick-core'),
                    'top center' => esc_html__('Top Center', 'Background Control', 'carbonick-core'),
                    'top right' => esc_html__('Top Right', 'Background Control', 'carbonick-core'),
                    'center left' => esc_html__('Center Left', 'Background Control', 'carbonick-core'),
                    'center center' => esc_html__('Center Center', 'Background Control', 'carbonick-core'),
                    'center right' => esc_html__('Center Right', 'Background Control', 'carbonick-core'),
                    'bottom left' => esc_html__('Bottom Left', 'Background Control', 'carbonick-core'),
                    'bottom center' => esc_html__('Bottom Center', 'Background Control', 'carbonick-core'),
                    'bottom right' => esc_html__('Bottom Right', 'Background Control', 'carbonick-core'),
                ],
                'default' => 'top left',
            ]
        );

        $repeater->add_control(
            'bg_size',
            [
                'label' => esc_html__('Size', 'Background Control', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'responsive' => true,
                'options' => [
                    'auto' => esc_html__('Auto', 'Background Control', 'carbonick-core'),
                    'cover' => esc_html__('Cover', 'Background Control', 'carbonick-core'),
                    'contain' => esc_html__('Contain', 'Background Control', 'carbonick-core'),
                ],
                'default' => 'cover',
            ]
        );

        $repeater->add_control(
            'serv_link',
            [
                'label' => esc_html__('Add Link', 'carbonick-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'carbonick-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{serv_title}}',
                'description' => esc_html__('Enter services height in pixels', 'carbonick-core'),
                'default' => [
                    ['serv_title' => esc_html__('Service Title', 'carbonick-core')],
                ],
            ]
        );

        $this->add_control(
            'deprecated_notice',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__('Two or three items are expected for correct rendering', 'carbonick-core'),
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title',
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
                'selector' => '{{WRAPPER}} .service-item_title',
            ]
        );

        $this->start_controls_tabs( 'title_colors' );

        $this->start_controls_tab(
            'title_colors_normal',
            [ 'label' => esc_html__('Normal', 'carbonick-core') ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service-item_title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .onhover .service-item:not(.active) .service-item_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_colors_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .onhover .service-item .service-item_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 50,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-item_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> SUBTITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .service-item_subtitle',
            ]
        );

        $this->start_controls_tabs( 'subtitle_colors' );

        $this->start_controls_tab(
            'subtitle_colors_normal',
            [ 'label' => esc_html__('Normal', 'carbonick-core') ]
        );

       $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service-item_subtitle' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .onhover .service-item:not(.active) .service-item_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'subtitle_colors_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .onhover .service-item .service-item_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'subtitle_tag',
            [
                'label' => esc_html__('Subtitle HTML Tag', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'div',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .service-item_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BACKGROUND TEXT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'bg_text_style_section',
            [
                'label' => esc_html__('Background Text', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bg_text_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .service-item_bg_text',
            ]
        );

        

        $this->start_controls_tabs( 'bg_text_colors' );

        $this->start_controls_tab(
            'bg_text_colors_normal',
            [ 'label' => esc_html__('Normal', 'carbonick-core') ]
        );

       $this->add_control(
            'bg_text_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service-item_bg_text' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
                    '{{WRAPPER}} .onhover .service-item:not(.active) .service-item_bg_text' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'bg_text_colors_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'bg_text_color_hover',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .onhover .service-item .service-item_bg_text' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_responsive_control(
            'bg_text_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .service-item_bg_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> LINK
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'link_style_section',
            [
                'label' => esc_html__('Link', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'link_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-item_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('link_colors');

        $this->start_controls_tab(
            'link_colors_normal',
            ['label' => esc_html__('Normal', 'carbonick-core')]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service-item_link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => [
                    '{{WRAPPER}} .service-item_link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_circle_color',
            [
                'label' => esc_html__('Сircle Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-item_link:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'link_colors_hover',
            ['label' => esc_html__('Hover', 'carbonick-core')]
        );

        $this->add_control(
            'hover_link_color',
            [
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => [
                    '{{WRAPPER}} .service-item_link:hover, {{WRAPPER}} .service-item_title:hover .service-item_link:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_link_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service-item_link:hover, {{WRAPPER}} .service-item_title:hover .service-item_link:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_link_circle_color',
            [
                'label' => esc_html__('Сircle Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#d8d8d8',
                'selectors' => [
                    '{{WRAPPER}} .service-item_link:hover:before, {{WRAPPER}} .service-item_title:hover .service-item_link:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute(
            'striped-services',
            [
                'class' => 'wgl-striped-services',
            ]
        );

        echo '<div ', $this->get_render_attribute_string('striped-services'), '>';

        foreach ($_s['items'] as $index => $item) {

            $item_wrap = $this->get_repeater_setting_key('item_wrap', 'items', $index);
            $this->add_render_attribute(
                $item_wrap,
                [
                    'class' => [
                        'service-image',
                        !empty($item['thumbnail']['url'] ? '' : 'no-image'),
                    ],
                    'style' => [
                        !empty($item['thumbnail']['url']) ? 'background-image: url(' . esc_url($item['thumbnail']['url']) . ');' : '',
                        $item['bg_position'] != '' ? 'background-position: ' . esc_attr($item['bg_position']) . ';' : '',
                        $item['bg_size'] != '' ? 'background-size: ' . esc_attr($item['bg_size']) . ';' : '',
                        $item['bg_color'] != '' ? 'background-color: ' . esc_attr($item['bg_color']) . ';' : '',
                    ]
                ]
            );

            $image = $this->get_repeater_setting_key('image', 'items', $index);
            $this->add_render_attribute(
                $image,
                [
                    'src' => esc_url($item['thumbnail']['url']),
                    'alt' => Control_Media::get_image_alt($item['thumbnail']),
                ]
            );

            $url = isset($item['serv_link']['url']) && !empty($item['serv_link']['url']);
            if ( $url ) {
                $serv_link = $this->get_repeater_setting_key('serv_link', 'items', $index);
                $this->add_link_attributes($serv_link, $item['serv_link']);
            }

            echo '<div class="service-item">';
            echo '<div ', $this->get_render_attribute_string($item_wrap), '></div>';
            echo '<div class="service-item_content">';
            if (!empty($item['serv_bg_text'])) {
                echo '<div class="service-item_bg_text">', esc_html($item['serv_bg_text']), '</div>';
            }

            if (!empty($item['serv_title'])) {
                echo '<', $_s['title_tag'], ' class="service-item_title">',
                    $url ? '<a ' . $this->get_render_attribute_string($serv_link) . '>' : '',
                    esc_html($item['serv_title']),
                    $url ? '</a>' : '';
            }
            if ($url) {
                echo '<a class="service-item_link"', $this->get_render_attribute_string($serv_link), '></a>';
            }
            if (!empty($item['serv_title'])) {
                echo '</',
                    $_s['title_tag'],
                    '>';
            }
            if (!empty($item['serv_subtitle'])) {
                echo '<', $_s['subtitle_tag'], ' class="service-item_subtitle">',
                    esc_html($item['serv_subtitle']),
                    '</',
                    $_s['subtitle_tag'],
                    '>';
            }

            echo '</div>'; // service-item_content
            echo '</div>'; // service-item

        }

        echo '</div>';
    }
}
