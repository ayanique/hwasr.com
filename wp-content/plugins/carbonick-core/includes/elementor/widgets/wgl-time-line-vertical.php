<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Repeater;
use WglAddons\Includes\Wgl_Elementor_Helper;
use Elementor\Icons_Manager;


class Wgl_Time_Line_Vertical extends Widget_Base
{
    public function get_name() {
        return 'wgl-time-line-vertical';
    }

    public function get_title() {
        return esc_html__('WGL Time Line Vertical', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-time-line-vertical';
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
        $h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            [ 'label' => esc_html__('Content', 'carbonick-core') ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'carbonick-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [ 'url' => '' ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'carbonick-core'),
                'type' => Controls_Manager::TEXTAREA,
                'separator' => 'before',
                'placeholder' => esc_html__('Your title', 'carbonick-core'),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'carbonick-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit.', 'carbonick-core'),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'time_line_icon_type',
            [
                'label' => esc_html__('Add Icon/Image', 'carbonick-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__('None', 'carbonick-core'),
                        'icon' => 'fa fa-ban',
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
                'default' => 'font',
            ]
        );

        $repeater->add_control(
            'time_line_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'carbonick-core'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'condition' => [
                    'time_line_icon_type'  => 'font',
                ],
                'default' => [
                    'value' => 'flaticon flaticon-motor-1',
                    'library' => 'solid',
                ],
                'description' => esc_html__('Select icon from Fontawesome library.', 'carbonick-core'),
            ]
        );

        $repeater->add_control(
            'time_line_icon_thumbnail',
            [
                'label' => esc_html__('Image', 'carbonick-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'condition' => ['time_line_icon_type' => 'image'],
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'date',
            [
                'label' => esc_html__('Date', 'carbonick-core'),
                'type' => Controls_Manager::TEXT,
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
                        'date' => esc_html__('2020', 'carbonick-core'),
                    ],
                    [
                        'title' => esc_html__('Second heading​', 'carbonick-core'),
                        'date' => esc_html__('2019', 'carbonick-core'),
                    ],
                ],
                'title_field' => '{{title}}',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> ANIMATION
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_animation',
            [ 'label' => esc_html__('Animation', 'carbonick-core') ]
        );

        $this->add_control(
            'add_appear',
            [
                'label' => esc_html__('Use Appear Animation?', 'carbonick-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CURVE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_curve',
            [
                'label' => esc_html__('Main Curve', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
                  
        $this->add_control(
            'curve_bg',
            [
                'label' => esc_html__('Curve Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#cbcbcb',
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-timeline-vertical .tlv__item:first-child .tlv__curve-inner:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-timeline-vertical .tlv__item:last-child .tlv__curve-inner:after' => 'background-color: {{VALUE}};',

                    // ↓ Responsive styles depending on Elementor Breakpoint setting ↓
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item:nth-child(even), body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item:nth-child(even)' => 'text-align: left; flex-direction: row;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item:nth-child(even), body.elementor-device-mobile {{WRAPPER}} .tlv__item:nth-child(even)' => 'text-align: left; flex-direction: row;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__item-outer, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__item-outer' => 'text-align: left;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item:nth-child(even) .tlv__item-outer, body.elementor-device-mobile {{WRAPPER}} .tlv__item:nth-child(even) .tlv__item-outer' => 'text-align: left;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item-outer, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item-outer' => 'flex-direction: column;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item-outer, body.elementor-device-mobile {{WRAPPER}} .tlv__item-outer' => 'flex-direction: column;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item-outer, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item-outer' => 'flex-direction: column;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item-outer, body.elementor-device-mobile {{WRAPPER}} .tlv__item-outer' => 'flex-direction: column;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__media .tlv__date, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__media .tlv__date' => 'right: auto;left: -22px;',
                    'body.elementor-device-tablet {{WRAPPER}}  .tlv__media .tlv__date, body.elementor-device-mobile {{WRAPPER}}  .tlv__media .tlv__date' => 'right: auto;left: -22px;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__media, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__media' => 'max-width: 480px;',
                    'body.elementor-device-tablet {{WRAPPER}}  .tlv__media, body.elementor-device-mobile {{WRAPPER}}  .tlv__media' => 'max-width: 480px;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__curve-wrapper, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__curve-wrapper' => 'display: none;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__curve-wrapper, body.elementor-device-mobile {{WRAPPER}} .tlv__curve-wrapper' => 'display: none;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__curve-wrapper.curve-mobile, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__curve-wrapper.curve-mobile' => 'display: block; margin-right: 43px; margin-left: 0px;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__curve-wrapper.curve-mobile, body.elementor-device-mobile {{WRAPPER}} .tlv__curve-wrapper.curve-mobile' => 'display: block; margin-right: 43px; margin-left: 0px;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item:first-child .tlv__curve-wrapper.curve-mobile, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item:first-child .tlv__curve-wrapper.curve-mobile' => 'margin-top: -62px;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item:first-child .tlv__curve-wrapper.curve-mobile, body.elementor-device-mobile {{WRAPPER}} .tlv__item:first-child .tlv__curve-wrapper.curve-mobile' => 'margin-top: -62px;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item:nth-child(odd) .tlv__date-wrapper, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item:nth-child(odd) .tlv__date-wrapper' => 'justify-content: flex-start;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item:nth-child(odd) .tlv__date-wrapper, body.elementor-device-mobile {{WRAPPER}} .tlv__item:nth-child(odd) .tlv__date-wrapper' => 'justify-content: flex-start;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item .tlv__date-wrapper, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__date-wrapper' => 'display: block;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item .tlv__date-wrapper, body.elementor-device-mobile {{WRAPPER}} .tlv__item .tlv__date-wrapper' => 'display: block;',
                    
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__content .tlv__content-image, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__content .tlv__content-image' => 'left: auto; right: 0;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__content .tlv__content-image, body.elementor-device-mobile {{WRAPPER}} .tlv__content .tlv__content-image' => 'left: auto; right: 0;',

                     // ↑ responsive styles ↑ 
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_line' );

        $this->start_controls_tab(
            'tab_line_idle',
            [ 'label' => esc_html__('Idle', 'carbonick-core') ]
        );

        $this->add_control(
            'in_line_bg_idle',
            [
                'label' => esc_html__('Inner Line Background', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#cbcbcb',
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'out_line_bg_idle',
            [
                'label' => esc_html__('Outter Line Background', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_line_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'in_line_bg_hover',
            [
                'label' => esc_html__('Inner Line Background', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__curve-wrapper:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'out_line_bg_hover',
            [
                'label' => esc_html__('Outter Line Background', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__curve-wrapper:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT & MEDIA WRAPPER
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Content Wrapper', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items.', 'carbonick-core'),
                'default' => [
                    'top' => 45,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'tablet_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__volume-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-timeline-vertical .tlv__curve-wrapper:before' => 'margin-top: {{TOP}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .wgl-timeline-vertical .tlv__curve-wrapper:after' => 'margin-top: {{TOP}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__volume-wrapper' => 'margin-left: {{RIGHT}}{{UNIT}}; margin-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__('Box Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'nimbus-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items. It is only available on preview or live page, and not while editing in Elementor.', 'nimbus-core'),
                'default' => [
                    'top' => 0,
                    'right' => 130,
                    'bottom' => 30,
                    'left' => 0,
                ],
                'tablet_default' => [
                    'top' => 0,
                    'right' => 130,
                    'bottom' => 30,
                    'left' => 0,
                ],
                'mobile_default' => [
                    'top' => 0,
                    'right' => 15,
                    'bottom' => 30,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content' => 'padding-left: {{RIGHT}}{{UNIT}}; padding-right: {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .tlv__content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content-wrapper' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
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
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .tlv__content-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .tlv__content-wrapper',
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
                    '{{WRAPPER}} .tlv__item:hover .tlv__content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .tlv__item:hover .tlv__content-wrapper',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .tlv__item:hover .tlv__content-wrapper',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Icon Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('Icon & Image', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items.', 'carbonick-core'),
                'default' => [
                    'top' => -107,
                    'right' => 123,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'tablet_default' => [
                    'top' => -107,
                    'right' => 123,
                    'bottom' => 30,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content-image' => 'margin-left: {{RIGHT}}{{UNIT}}; margin-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon & Image Size', 'carbonick-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'max' => 200 ],
                ],
                'size_units' => [ 'px' ],
                'default' => [ 'size' => 150, 'unit' => 'px' ],
                'description' => esc_html__('Enter button diameter in pixels.', 'carbonick-core'),
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-image i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__content-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
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
                'default' => '#e6e6e6',
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-image i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-image' => 'background-color: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow',
                'selector' => '{{WRAPPER}} .tlv__content-image',
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
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__content-image i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__content-image' => 'background-color: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'date_hover_shadow',
                'selector' => '{{WRAPPER}} .tlv__item:hover .tlv__content-image',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
            'hide_on_mobile',
            [
                'label'        => esc_html__('Hide On Mobile?','carbonick-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'carbonick-core' ),
                'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'hide_mobile_resolution',
            [
                'label' => esc_html__( 'Screen Resolution', 'carbonick-core' ),
                'type' => Controls_Manager::NUMBER,
                'step' => 1,
                'default' => 992,
                'condition' => [
                    'hide_on_mobile' => 'yes',
                ],
            ]
        );
        
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> MEDIA
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'media_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items.', 'carbonick-core'),
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 99,
                    'left' => 0,
                ],
                'tablet_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 22,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__media' => 'margin-left: {{RIGHT}}{{UNIT}}; margin-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items.', 'carbonick-core'),
                'selectors' => [
                    '{{WRAPPER}} .tlv__media img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__media img' => 'padding-left: {{RIGHT}}{{UNIT}}; padding-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_border_radius',
            [
                'label' => esc_html__('Border Radius', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items.', 'carbonick-core'),
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__media img' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'media',
                'selector' => '{{WRAPPER}} .tlv__media img',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Title & Text', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title Styles', 'carbonick-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_title',
                'selector' => '{{WRAPPER}} .tlv__title',
            ]
        );

        $this->start_controls_tabs( 'tabs_title' );

        $this->start_controls_tab(
            'tab_title_idle',
            [ 'label' => esc_html__('Idle', 'carbonick-core') ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tlv__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__('Text Styles', 'carbonick-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_text',
                'selector' => '{{WRAPPER}} .tlv__text',
            ]
        );

        $this->start_controls_tabs( 'tabs_content' );

        $this->start_controls_tab(
            'tab_content_idle',
            [ 'label' => esc_html__('Idle', 'carbonick-core') ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .tlv__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> DATE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_date',
            [
                'label' => esc_html__('Date', 'carbonick-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tlv__date',
            ]
        );

        $this->add_responsive_control(
            'date_padding',
            [
                'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 7,
                    'right' => 18,
                    'bottom' => 7,
                    'left' => 18,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'date_margin',
            [
                'label' => esc_html__('Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__date' => 'margin-left: {{RIGHT}}{{UNIT}}; margin-right: {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_date' );

        $this->start_controls_tab(
            'date_colors_idle',
            [ 'label' => esc_html__('Idle', 'carbonick-core') ]
        );

        $this->add_control(
            'date_color_idle',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bg_idle',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_date_hover',
            [ 'label' => esc_html__('Hover', 'carbonick-core') ]
        );

        $this->add_control(
            'date_color_hover',
            [
                'label' => esc_html__('Text Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bg_hover',
            [
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__date' => 'background-color: {{VALUE}};',
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

        // Invert left/right values for desktop module layout
        $module_id = uniqid('tlv_');

		// Custom styles

		$styles = '';

		if(isset($_s['hide_on_mobile']) && !empty($_s['hide_on_mobile'])){
			$styles .= "@media (max-width: ".(int) $_s['hide_mobile_resolution']."px) { 
				#$module_id .tlv__content-image{
                    display: none;
				}
			}";
		}

		Wgl_Elementor_Helper::enqueue_css($styles);
        
        // HTML tags allowed for rendering
        $allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
                'rel' => true, 'target' => true
            ],
            'br' => [ 'class' => true, 'style' => true ],
            'em' => [ 'class' => true, 'style' => true ],
            'strong' => [ 'class' => true, 'style' => true ],
            'span' => [ 'class' => true, 'style' => true ],
            'p' => [ 'class' => true, 'style' => true ],
            'ul' => [ 'class' => true, 'style' => true ],
            'ol' => [ 'class' => true, 'style' => true ],
        ];


        $this->add_render_attribute(
            'timeline-vertical',
            [
                'class' => [
                    'wgl-timeline-vertical',
                    $_s[ 'add_appear' ] ? 'appear_animation' : '',
                ],
                'id' => $module_id,
            ]
        );

        echo '<div ', $this->get_render_attribute_string( 'timeline-vertical' ), '>';
        echo '<div class="tlv__items-wrapper">';

        foreach ( $_s[ 'items' ] as $index => $item )
        {


            // Time Line Icon/image
	        $icon_out = '';
	        if ( $item[ 'time_line_icon_type' ] != '' ) {
		        if ( $item[ 'time_line_icon_type' ] == 'font' && (!empty( $item[ 'time_line_icon_fontawesome' ] )) ) {
                    
			        $icon_font = $item[ 'time_line_icon_fontawesome' ];
			        $icon_out = '';
			        // add icon migration
			        $migrated = isset( $item['__fa4_migrated'][$item[ 'time_line_icon_fontawesome' ]] );
			        $is_new = Icons_Manager::is_migration_allowed();
			        if ( $is_new || $migrated ) {
				        ob_start();
				        Icons_Manager::render_icon( $item[ 'time_line_icon_fontawesome' ], [ 'aria-hidden' => 'true' ] );
				        $icon_out .= ob_get_clean();
			        } else {
				        $icon_out .= '<i class="icon '.esc_attr($icon_font).'"></i>';
			        }
		        }
		        if ( $item[ 'time_line_icon_type' ] == 'image' && !empty( $item[ 'time_line_icon_thumbnail' ] ) ) {
			        if ( ! empty( $item[ 'time_line_icon_thumbnail' ][ 'url' ] ) ) {
				        $this->add_render_attribute( 'thumbnail_content', 'src', $item[ 'time_line_icon_thumbnail' ][ 'url' ] );
				        $this->add_render_attribute( 'thumbnail_content', 'alt', Control_Media::get_image_alt( $item[ 'time_line_icon_thumbnail' ] ) );
				        $this->add_render_attribute( 'thumbnail_content', 'title', Control_Media::get_image_title( $item[ 'time_line_icon_thumbnail' ] ) );
				        $icon_out = Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail_content', 'time_line_icon_thumbnail' );
			        }
		        }
	        }
	        // End Tab Icon/image

            $thumbnail = $this->get_repeater_setting_key( 'thumbnail', 'list' , $index );
            $this->add_render_attribute(
                $thumbnail,
                [
                    'class' => 'tlv_thumbnail',
                    'src' => esc_url($item[ 'thumbnail' ][ 'url' ]),
                    'alt' => Control_Media::get_image_alt( $item[ 'thumbnail' ] ),
                ]
            );

            $date = '<span class="tlv__date">' . $item['date'] . '</span>';    

            echo '<div class="tlv__item'.(!empty($item['thumbnail']['url']) ? ' with_image' : '').'">';

                echo '<div class="tlv__curve-wrapper curve-mobile"><span class="tlv__curve-inner"></span></div>';

                echo '<div class="tlv__item-outer">';
                echo '<div class="tlv__date-wrapper">';
                    
                    if (!empty($item['thumbnail']['url'])) {
                        echo '<div class="tlv__media">'; 
                            echo '<img ', $this->get_render_attribute_string( $thumbnail ), '/>';

                            echo $date;
                        echo '</div>'; // media
                    }else{
                        echo $date;                     
                    }
                
                echo '</div>';
                //Date Wrapper

                echo '<div class="tlv__curve-wrapper"><span class="tlv__curve-inner"></span></div>';

                echo '<div class="tlv__volume-wrapper">';
                    echo '<div class="tlv__content-wrapper">';

                    echo '<div class="tlv__content">';
                    if (!empty($item[ 'title' ])) {
                        echo '<h3 class="tlv__title">',
                            $item[ 'title' ],
                        '</h3>';
                    }
                    if (!empty($item[ 'content' ])) {
                        echo '<div class="tlv__text">',
                            wp_kses( $item[ 'content' ], $allowed_html ),
                        '</div>';
                    }
                    echo '<div class="tlv__content-image">' ,$icon_out, '</div>';
                    echo '</div>'; // content 

                    echo '</div>'; // content-wrapper
                echo '</div>'; // volume-wrapper
                
                echo '</div>'; // tlv__item-outer

            echo '</div>';
        }

        echo '</div>';
        echo '</div>';

    }

}