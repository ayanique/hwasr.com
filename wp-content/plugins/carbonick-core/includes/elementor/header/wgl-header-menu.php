<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

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


class Wgl_Header_Menu extends Widget_Base {

    public function get_name() {
        return 'wgl-menu';
    }

    public function get_title() {
        return esc_html__('WGL Menu', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-header-menu';
    }

    public function get_categories() {
        return [ 'wgl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'wgl-elementor-extensions-widgets',
        ];
    }


    protected function _register_controls()
    {
        $primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__('General', 'carbonick-core') ]
        );

        $this->add_control(
            'menu_choose',
            [
                'label' => esc_html__('Template', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'carbonick-core'),
                    'custom' => esc_html__('Custom Menu', 'carbonick-core'),
                ],
                'default' => 'default',
            ]
        );

        $this->add_control(
            'custom_menu',
            [
                'label' => esc_html__('Custom Menu', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [ 'menu_choose' => 'custom' ],
                'options' => carbonick_get_custom_menu(),
                'default' => 'Main',
            ]
        );

        $this->add_control(
            'lavalamp_active',
            [
                'label' => esc_html__('Lavalamp Marker', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'carbonick-core'),
                'label_off' => esc_html__('Off', 'carbonick-core'),
            ]
        );

        $this->add_control(
            'heading_width',
            [
                'label' => esc_html__('Width', 'carbonick-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'display',
            [
                'label' => esc_html__('Display', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'inline-flex; width: auto' => esc_html__('Inline-Flex', 'carbonick-core'),
                    'block' => esc_html__('Block', 'carbonick-core'),
                ],
                'default' => 'inline-flex; width: auto',
                'selectors' => [
                    '{{WRAPPER}}' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'flex_grow',
            [
                'label' => esc_html__('Flex Grow', 'carbonick-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [ 'display' => 'inline-flex; width: auto' ],
                'separator' => 'after',
                'min' => -1,
                'max' => 20,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}}' => 'flex-grow: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_height',
            [
                'label' => esc_html__('Height', 'carbonick-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'menu_height',
            [
                'label' => esc_html__('Module Height (px)', 'carbonick-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'menu_align',
            [
                'label' => esc_html__('Alignment', 'carbonick-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [ 'display' => 'block' ],
                'separator' => 'before',
                'toggle' => false,
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
                'selectors' => [
                    '{{WRAPPER}} .primary-nav' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_align_flex',
            [
                'label' => esc_html__('Alignment', 'carbonick-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'display' => [ 'inline-flex; width: auto', 'flex' ],
                ],
                'separator' => 'before',
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'carbonick-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'carbonick-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'carbonick-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> MENU
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_menu',
            [
                'label' => esc_html__('Menu', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'items',
                'selector' => '{{WRAPPER}} .primary-nav > div > ul, {{WRAPPER}} .primary-nav > ul',
            ]
        );

        $this->add_responsive_control(
            'menu_items_padding',
            [
                'label' => esc_html__('Items Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .primary-nav > ul' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}}; margin-bottom: -{{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_menu',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_menu_idle',
            [ 'label' => esc_html__('Idle' , 'carbonick-core') ]
        );

        $this->add_control(
            'menu_color_idle',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li > a > span:before, {{WRAPPER}} .primary-nav > ul > li > a > span:after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'menu_icon_idle',
            [
                'label' => esc_html__('Icon Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li > a > .menu-item__plus' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_hover',
            [ 'label' => esc_html__('Hover' , 'carbonick-core') ]
        );

        $this->add_control(
            'menu_color_hover',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li:hover > a > span:before' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li:hover > a > span:after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'menu_icon_hover',
            [
                'label' => esc_html__('Icon Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li:hover > a > .menu-item__plus' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'menu_delimiter_hover',
            [
                'label' => esc_html__('Delimiter Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li > a:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_active',
            [ 'label' => esc_html__('Active', 'carbonick-core') ]
        );

        $this->add_control(
            'menu_color_active',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-item > a > span:after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-item > a > span:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_item > a > span:after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_item > a > span:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-parent > a > span:after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-parent > a > span:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_parent > a > span:after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_parent > a > span:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-ancestor > a > span:after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-ancestor > a > span:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_ancestor > a > span:after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_ancestor > a > span:before' => 'color: {{VALUE}}',

                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-parent > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_parent > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-ancestor > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_ancestor > a' => 'color: {{VALUE}}',
                ],
            ]
        );
                
        $this->add_control(
            'menu_delimiter_color_active',
            [
                'label' => esc_html__('Delimiter Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-item > a:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_item > a:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-parent > a:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_parent > a:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current-menu-ancestor > a:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .primary-nav > ul > li.current_page_ancestor > a:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> SUBMENU
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_submenu',
            [
                'label' => esc_html__('Submenu', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_typo',
                'selector' => '{{WRAPPER}} .primary-nav > div > ul ul, {{WRAPPER}} .primary-nav > ul ul',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submenu_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .primary-nav ul li ul',
            ]
        );

        $this->start_controls_tabs(
            'tabs_submenu',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_submenu_idle',
            [ 'label' => esc_html__('Idle' , 'carbonick-core') ]
        );

        $this->add_control(
            'submenu_color_idle',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_icon_idle',
            [
                'label' => esc_html__('Icon Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul li:not(:hover) > a > .menu-item__plus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_submenu_hover',
            [ 'label' => esc_html__('Hover' , 'carbonick-core') ]
        );

        $this->add_control(
            'submenu_color_hover',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul li:hover > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li:hover > a > span:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li:not([class*="current"]) > a > span:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_icon_hover',
            [
                'label' => esc_html__('Icon Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul li:hover > a > .menu-item__plus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_delimiter_hover',
            [
                'label' => esc_html__('Delimiter Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul li > a > span:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_submenu_active',
            [ 'label' => esc_html__('Active' , 'carbonick-core') ]
        );

        $this->add_control(
            'submenu_color_active',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul li.current-menu-ancestor > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current_page_ancestor > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current-menu-item > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current_page_item > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current-menu-ancestor > a > span:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current-menu-ancestor > a > span:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current_page_ancestor > a > span:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current_page_ancestor > a > span:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current-menu-item > a > span:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current-menu-item > a > span:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current_page_item > a > span:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-nav ul li ul li.current_page_item > a > span:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        
        $this->add_control(
            'submenu_delimiter_active',
            [
                'label' => esc_html__('Delimiter Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul li[class*="current"] > a > span:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submenu_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .primary-nav ul li ul',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submenu_shadow',
                'selector' => '{{WRAPPER}} .primary-nav ul li ul',
            ]
        );

        $this->add_responsive_control(
            'submenu_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .primary-nav ul li ul' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                    '{{WRAPPER}} .primary-nav ul li ul a' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> LAVALAMP
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_lavalamp',
            [
                'label' => esc_html__('Lavalamp', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'lavalamp_active!' => '' ],
            ]
        );

        $this->add_control(
            'lavalamp_color',
            [
                'label' => esc_html__('Lavalamp Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lavalamp .lavalamp-object' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $menu = '';

        if ($menu_choose === 'custom') {
            $menu = !empty($custom_menu) ? $custom_menu : '';
        }

        if (has_nav_menu('main_menu')) {
            echo "<nav class='primary-nav" . (!empty($lavalamp_active) ? ' menu_line_enable' : '') . "'>";
            carbonick_main_menu($menu);
            echo '</nav>';

            echo '<div class="mobile-hamburger-toggle">',
                '<div class="hamburger-box">',
                '<div class="hamburger-inner">',
                '</div>',
                '</div>',
                '</div>';
        }
    }

}