<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglInfoBoxes;
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
use Elementor\Icons_Manager;


class Wgl_Info_Box extends Widget_Base
{

	public function get_name() {
		return 'wgl-info-box';
	}

	public function get_title() {
		return esc_html__('WGL Info Box', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-info-box';
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}


	protected function _register_controls()
	{
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);
		$h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_general',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__('Layout', 'carbonick-core'),
				'type' => 'wgl-radio-image',
				'condition' => [ 'icon_type!' => '' ],
				'options' => [
					'top' => [
						'title'=> esc_html__('Top', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_def.png',
					],
					'left' => [
						'title'=> esc_html__('Left', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_left.png',
					],
					'right' => [
						'title'=> esc_html__('Right', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_right.png',
					],
				],
				'prefix_class' => 'elementor-position-',
				'default' => 'left',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => esc_html__('Alignment', 'carbonick-core'),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => true,
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
				'prefix_class' => 'a',
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_wrapper' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .wgl-infobox_wrapper .wgl-infobox_subtitle' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> ICON/IMAGE
		/*-----------------------------------------------------------------------------------*/

		$output = [];
		$output[ 'view' ] = [
			'label' => esc_html__('View', 'carbonick-core'),
			'type' => Controls_Manager::SELECT,
			'condition' => [ 'icon_type'  => ['font', 'number']],
			'options' => [
				'default' => esc_html__('Default', 'carbonick-core'),
				'stacked' => esc_html__('Stacked', 'carbonick-core'),
				'framed' => esc_html__('Framed', 'carbonick-core'),
			],
			'default' => 'default',
			'prefix_class' => 'elementor-view-',
		];

		$output[ 'shape' ] = [
			'label' => esc_html__('Shape', 'carbonick-core'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'circle' => esc_html__('Circle', 'carbonick-core'),
				'square' => esc_html__('Square', 'carbonick-core'),
			],
			'default' => 'square',
			'condition' => [
				'icon_type'  => ['font', 'number'],
				'view!' => 'default',
			],
			'prefix_class' => 'elementor-shape-',
		];

		Wgl_Icons::init(
			$this,
			[
				'output' => $output,
				'section' => true,
				'default' => [
					'media_type' => 'font',
					'icon' => [
						'library' => 'wgl_icons',
						'value' => 'flaticon flaticon-sports-and-competition'
					],
				]
			]
		);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_ib_content',
			[ 'label' => esc_html__('Content', 'carbonick-core') ]
		);

		$this->add_control(
			'ib_title',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__('This is the heading​', 'carbonick-core'),
			]
		);

		$this->add_control(
			'ib_subtitle',
			[
				'label' => esc_html__('Watermark', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'default' => '',
			]
		);

		$this->add_control(
			'ib_content',
			[
				'label' => esc_html__('Content', 'carbonick-core'),
				'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Description Text', 'carbonick-core'),
				'label_block' => true,
				'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'carbonick-core'),
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> BUTTON
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_link',
			[ 'label' => esc_html__('Link', 'carbonick-core') ]
		);

		$this->add_control(
			'item_link',
			[
				'label' => esc_html__('Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'add_item_link',
			[
				'label' => esc_html__('Add Link On Whole Item', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
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
			]
		); 

		$this->add_control(
			'read_more_text',
			[
				'label' => esc_html__('Button Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'add_read_more' => 'yes' ],
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'hr_link',
			[ 'type' => Controls_Manager::DIVIDER ]
		); 

		$this->add_control(
			'read_more_icon_customize',
			[
				'label' => esc_html__('Customize the Icon', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'add_read_more' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
				'description' => esc_html__('Attach to the bottom right or left corner.', 'carbonick-core' ),
			]
		);

		$this->add_control(
			'read_more_icon_sticky',
			[
				'label' => esc_html__('Stick the button', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'add_read_more' => 'yes',
					'read_more_icon_customize' => 'yes',
				],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
				'description' => esc_html__('Attach to the bottom right or left corner.', 'carbonick-core' ),
			]
		);

		$this->add_control(
			'read_more_icon_sticky_pos',
			[
				'label' => esc_html__('Read More Position', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'add_read_more' => 'yes',
					'read_more_icon_sticky' => 'yes',
					'read_more_icon_customize' => 'yes',
				],
				'options' => [
					'right' => esc_html__('Right', 'carbonick-core'),
					'left' => esc_html__('Left', 'carbonick-core'),
				],
				'default' => 'right',
			]
		);

		$this->add_control(
			'read_more_icon_fontawesome',
			[
				'label' => esc_html__('Icon', 'carbonick-core'),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [ 
					'add_read_more' => 'yes',
					'read_more_icon_customize' => 'yes',
				],
				'description' => esc_html__('Select icon from Fontawesome library.', 'carbonick-core'),
			]
		);

		$this->add_control(
			'read_more_icon_align',
			[
				'label' => esc_html__('Icon Position', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'add_read_more' => 'yes',
					'read_more_icon_customize' => 'yes',
					'read_more_icon_fontawesome!' => [
						'value' => '',
						'library' => '',
					],
					'read_more_text!' => '',
				],
				'options' => [
					'left' => esc_html__('Before', 'carbonick-core'),
					'right' => esc_html__('After', 'carbonick-core'),
				],
				'default' => 'left',
			]
		);

		$this->add_control(
			'read_more_icon_spacing',
			[
				'label' => esc_html__('Icon Spacing', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					'add_read_more' => 'yes',
					'read_more_icon_customize' => 'yes',
					'read_more_icon_fontawesome!' => [
						'value' => '',
						'library' => '',
					],
					'read_more_text!' => '',
				],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [ 'size' => 10, 'unix' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_button.icon-position-right i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wgl-infobox_button.icon-position-left i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> HOVER ANIMATION
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_animation',
			[ 'label' => esc_html__('Hover Animation', 'carbonick-core') ]
		);

		$this->add_control(
			'hover_lifting',
			[
				'label' => esc_html__('Lift up the item', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'hover_toggling'  => '' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'lifting',
				'prefix_class' => 'animation_',
			]
		);

		$this->add_control(
			'hover_toggling',
			[
				'label' => esc_html__('Toggle Icon/Content Visibility', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'hover_lifting' => '',
					'layout!' => [ 'left', 'right' ],
					'icon_type!' => '',
				],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'toggling',
				'prefix_class' => 'animation_',
			]
		);

		$this->add_responsive_control(
			'hover_toggling_offset',
			[
				'label' => esc_html__('Animation Distance', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					'hover_toggling!' => '',
					'layout!' => [ 'left', 'right' ],
					'icon_type!' => '',
				],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [ 'size' => 60 ],
				'selectors' => [
					'{{WRAPPER}}.animation_toggling .wgl-infobox-icon_container,
					{{WRAPPER}}.animation_toggling .wgl-infobox-title_wrapper' => 'transform: translateY({{SIZE}}{{UNIT}});',
					'{{WRAPPER}}.animation_toggling:hover .wgl-infobox-icon_container,
					{{WRAPPER}}.animation_toggling:hover .wgl-infobox-title_wrapper' => 'transform: translateY(0);',
				],
			]
		);

		$this->add_responsive_control(
			'hover_toggling_transition',
			[
				'label' => esc_html__('Transition Duration', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					'hover_toggling!' => '',
					'layout!' => [ 'left', 'right' ],
					'icon_type!' => '',
				],
				'range' => [
					'px' => [ 'min' => 0.1, 'max' => 2, 'step' => 0.1 ],
				],
				'default' => [ 'size' => 0.6 ],
				'selectors' => [
					'{{WRAPPER}}.animation_toggling .wgl-infobox_content' => 'transition-duration: {{SIZE}}s; transition-delay: 0s;',
					'{{WRAPPER}}.animation_toggling:hover .wgl-infobox_content,
					{{WRAPPER}}.animation_toggling .wgl-infobox-icon_container' => 'transition-duration: {{SIZE}}s; transition-delay: calc({{SIZE}}s / 2);',
					'{{WRAPPER}}.animation_toggling .wgl-infobox-title_wrapper,
					{{WRAPPER}}.animation_toggling:hover .wgl-infobox-icon_container' => 'transition-duration: {{SIZE}}s; transition-delay: 0s;',
					'{{WRAPPER}}.animation_toggling:hover .wgl-infobox-title_wrapper' => 'transition-duration: {{SIZE}}s; transition-delay: calc({{SIZE}}s / 2);',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> ICON
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__('Icon', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'icon_type'  => 'font' ],
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .wgl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .wgl-icon, {{WRAPPER}}.elementor-view-default .wgl-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => esc_html__('Additional Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'view!' => 'default' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .wgl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .wgl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_shadow',
				'selector' =>  '{{WRAPPER}} .wgl-icon',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked:hover .wgl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed:hover .wgl-icon, {{WRAPPER}}.elementor-view-default:hover .wgl-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => esc_html__('Additional Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'view!' => 'default' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed:hover .wgl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked:hover .wgl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_hover_shadow',
				'selector' =>  '{{WRAPPER}}:hover .wgl-icon',
			]
		);

		$this->add_control(
			'hover_animation_icon',
			[
				'label' => esc_html__('Hover Animation', 'carbonick-core'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		); 

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'hr_icon_style',
			[ 'type' => Controls_Manager::DIVIDER ]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 6, 'max' => 300 ],
				],
				'default' => [ 'size' => 50, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .icon, {{WRAPPER}} svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view!' => 'default' ],
                'size_units' => [ 'px', 'em', '%' ],
				'default' => [ 'size' => 15, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => esc_html__('Rotate', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 'size' => 0, 'unit' => 'deg' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__('Border Width', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view' => 'framed' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view!' => 'default' ],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		
		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> Number
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_number',
			[
				'label' => esc_html__('Number', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'icon_type'  => 'number' ],
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typo',
                'selector' => '{{WRAPPER}} .wgl-number',
            ]
        );

		$this->start_controls_tabs( 'number_colors' );

		$this->start_controls_tab(
			'number_colors_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'primary_number_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .wgl-number' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .wgl-number, {{WRAPPER}}.elementor-view-default .wgl-number' => 'color: {{VALUE}}; border-color: {{VALUE}};; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_number_color',
			[
				'label' => esc_html__('Additional Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'view!' => 'default' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .wgl-number' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .wgl-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'number_shadow',
				'selector' =>  '{{WRAPPER}} .wgl-number',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'number_colors_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'number_primary_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked:hover .wgl-number' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed:hover .wgl-number, {{WRAPPER}}.elementor-view-default:hover .wgl-number' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_secondary_color_hover',
			[
				'label' => esc_html__('Additional Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'view!' => 'default' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed:hover .wgl-number' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked:hover .wgl-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'number_hover_shadow',
				'selector' =>  '{{WRAPPER}}:hover .wgl-number',
			]
		);

		$this->add_control(
			'hover_animation_number',
			[
				'label' => esc_html__('Hover Animation', 'carbonick-core'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		); 

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'hr_number_style',
			[ 'type' => Controls_Manager::DIVIDER ]
		);

		$this->add_responsive_control(
			'number_space',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-number-box-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'number_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view!' => 'default' ],
                'size_units' => [ 'px', 'em', '%' ],
				'default' => [ 'size' => 15, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'number_border_width',
			[
				'label' => esc_html__('Border Width', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view' => 'framed' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'number_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view!' => 'default' ],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__('Image', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'icon_type' => 'image' ],
			]
		);

		$this->add_responsive_control(
			'image_space',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__('Width', 'carbonick-core') . ' (%)',
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [ 'min' => 5, 'max' => 100 ],
				],
				'default' => [ 'size' => 100, 'unit' => '%' ],
				'tablet_default' => [ 'unit' => '%' ],
				'mobile_default' => [ 'unit' => '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_animation_image',
			[
				'label' => esc_html__('Hover Animation', 'carbonick-core'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'Idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .wgl-image-box_img img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => esc_html__('Opacity', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 0.10, 'max' => 1, 'step' => 0.01 ],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-image-box_img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__('Transition Duration', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 'size' => 0.3 ],
				'range' => [
					'px' => [ 'max' => 3, 'step' => 0.1 ],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-image-box_img img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover .wgl-image-box_img img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => esc_html__('Opacity', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 0.10, 'max' => 1, 'step' => 0.01 ],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .wgl-image-box_img img' => 'opacity: {{SIZE}};',
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
				'options' => [
					'h1' => '‹h1›',
					'h2' => '‹h2›',
					'h3' => '‹h3›',
					'h4' => '‹h4›',
					'h5' => '‹h5›',
					'h6' => '‹h6›',
					'div' => '‹div›',
					'span' => '‹span›',
				],
			]
		);

		$this->add_responsive_control(
			'title_offset',
			[
				'label' => esc_html__('Title Offset', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '8',
					'left' => '0',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_title',
				'selector' => '{{WRAPPER}} .wgl-infobox_title',
			]
		);

		$this->start_controls_tabs( 'title_color_tab' );

		$this->start_controls_tab(
			'custom_title_color_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($h_font_color),
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_title_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($h_font_color),
				'selectors' => [
					'{{WRAPPER}}:hover .wgl-infobox_title' => 'color: {{VALUE}};',
					'{{WRAPPER}}:hover .wgl-infobox_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> SUBTITLE
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'subtitle_style_section',
			[
				'label' => esc_html__('Watermark', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'ib_subtitle!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_bg_title',
				'selector' => '{{WRAPPER}} .wgl-infobox_subtitle',
			]
		);


		$this->add_responsive_control(
			'watermark_position',
			[
				'label' => esc_html__('Image Position', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'v-center h-center' => esc_html__( 'Center Center', 'carbonick-core' ),
					'v-center h-left' => esc_html__( 'Center Left', 'carbonick-core' ),
					'v-center h-right' => esc_html__( 'Center Right', 'carbonick-core' ),
					'v-top h-center' => esc_html__( 'Top Center', 'carbonick-core' ),
					'v-top h-left' => esc_html__( 'Top Left', 'carbonick-core' ),
					'v-top h-right' => esc_html__( 'Top Right', 'carbonick-core' ),
					'v-bottom h-center' => esc_html__( 'Bottom Center', 'carbonick-core' ),
					'v-bottom h-left' => esc_html__( 'Bottom Left', 'carbonick-core' ),
					'v-bottom h-right' => esc_html__( 'Bottom Right', 'carbonick-core' ),
				],
				'default' => 'v-top h-right',
				'prefix_class' => 'elementor-subtitle-position ',
			]
		);

		$this->add_control(
			'watermark_crop',
			[
				'label' => esc_html__('Crop the Watermark', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'hidden',
				'return_value' => 'hidden',
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_subtitle_wrap' => 'overflow: {{VALUE}}; z-index: -1;',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_offset',
			[
				'label' => esc_html__('Watermark Offset', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '-10',
					'right' => '8',
					'bottom' => '0',
					'left' => '0',
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'title_bg_color_tab' );

		$this->start_controls_tab(
			'custom_bg_title_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'bg_title_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#f2f2f2',
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_bg_title_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'title_bg_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff604c',
				'selectors' => [
					'{{WRAPPER}}:hover .wgl-infobox_subtitle' => 'color: {{VALUE}};'
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
				'condition' => [ 'ib_content!' => '' ],
			]
		);

		$this->add_control(
			'content_tag',
			[
				'label' => esc_html__('Content Tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => '‹h1›',
					'h2' => '‹h2›',
					'h3' => '‹h3›',
					'h4' => '‹h4›',
					'h5' => '‹h5›',
					'h6' => '‹h5›',
					'div' => '‹div›',
					'span' => '‹span›',
				],
				'default' => 'div',
			]
		);

		$this->add_responsive_control(
			'content_offset',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom'=> '20',
					'left'  => '0',
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_content_mask_color',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'custom_bg' => 'custom' ],
				'selector' => '{{WRAPPER}} .wgl-infobox_content',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wgl-infobox_content',
			]
		); 

		$this->start_controls_tabs( 'content_color_tab' );

		$this->start_controls_tab(
			'custom_content_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $main_font_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_content_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'content_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .wgl-infobox_content' => 'color: {{VALUE}};'
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

		$this->start_controls_tabs( 'item_bg' );
		$this->start_controls_tab(
			'item_bg_idle',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'bg_image_idle',
				'label'     => esc_html__( 'Background', 'carbonick-core' ),
				'types'     => [ 'classic', 'gradient', 'video' ],
				'default'   => '',
				'selector'  => '{{WRAPPER}} .wgl-infobox:before',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .wgl-infobox',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'item_bg_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'bg_image_hover',
				'label'     => esc_html__( 'Background', 'carbonick-core' ),
				'types'     => [ 'classic', 'gradient', 'video' ],
				'default'   => '',
				'selector'  => '{{WRAPPER}} .wgl-infobox:after',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border_hover',
				'selector' => '{{WRAPPER}}:hover .wgl-infobox',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view!' => 'default' ],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox:before, {{WRAPPER}} .wgl-infobox:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow',
				'selector' => '{{WRAPPER}} .wgl-infobox:before,{{WRAPPER}} .wgl-infobox:after',
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> BUTTON
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__('Button', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'add_read_more' => 'yes', ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_button',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wgl-infobox_button',
				'condition' => [ 'read_more_text!' => '', ],
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label' => esc_html__('Icon Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 6, 'max' => 300 ],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_button i, {{WRAPPER}} .wgl-infobox_button svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'custom_button_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .button-read-more:before, {{WRAPPER}} .button-read-more:after' => 'margin-left: {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wgl-infobox_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox-button_wrapper .wgl-infobox_button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:after, {{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => esc_html__('Border Type', 'carbonick-core'),
				'selector' => '{{WRAPPER}} .wgl-infobox_button',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow',
				'selector' =>  '{{WRAPPER}} .wgl-infobox_button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_button_color_hover_item',
			[ 'label' => esc_html__('Item Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'button_background_hover_item',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .wgl-infobox_button' => 'background: {{VALUE}};'
				],
			]
		); 

		$this->add_control(
			'button_color_hover_item',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}}:hover .wgl-infobox-button_wrapper .wgl-infobox_button' => 'color: {{VALUE}};',
					'{{WRAPPER}}:hover .wgl-infobox_button.read-more-icon:empty:after, {{WRAPPER}}:hover .wgl-infobox_button.read-more-icon:empty:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border_hover_item',
				'label' => esc_html__('Border Type', 'carbonick-core'),
				'default' => '',
				'selector' => '{{WRAPPER}}:hover .wgl-infobox_button',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow_hover_item',
				'selector' => '{{WRAPPER}}:hover .wgl-infobox_button',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox_button:hover' => 'background: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'button_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-infobox-button_wrapper .wgl-infobox_button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wgl-infobox-button_wrapper .wgl-infobox_button.read-more-icon:empty:hover:after, {{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border_hover',
				'label' => esc_html__('Border Type', 'carbonick-core'),
				'default' => '',
				'selector' => '{{WRAPPER}} .wgl-infobox_button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow_hover',
				'selector' => '{{WRAPPER}} .wgl-infobox_button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section(); 

	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();

		$info_box = new WglInfoBoxes();
		echo $info_box->render($this, $atts);
	}
	
}
