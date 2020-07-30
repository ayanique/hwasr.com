<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglPricingTable;
use WglAddons\Widgets\Wgl_Button;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;


class Wgl_Pricing_Table extends Widget_Base {
	
	public function get_name() {
		return 'wgl-pricing-table';
	}

	public function get_title() {
		return esc_html__('WGL Pricing Table', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-pricing-table';
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
			'section_content_general',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);

		$this->add_responsive_control(
			'p_alignment',
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
				'prefix_class' => 'a',
			]
		);

		$this->add_control(
			'p_title',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Title...', 'carbonick-core'),
				'default' => esc_html__('Basic', 'carbonick-core'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'p_currency',
			[
				'label' => esc_html__('Currency', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Currency...', 'carbonick-core'),
				'default' => esc_html__('$', 'carbonick-core'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'p_price',
			[
				'label' => esc_html__('Price', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Price...', 'carbonick-core'),
				'default' => esc_html__('99', 'carbonick-core'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'p_period',
			[
				'label' => esc_html__('Period', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Period...', 'carbonick-core'),
				'default' => esc_html__('/ month', 'carbonick-core'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'p_content',
			[
				'label' => esc_html__('Content', 'carbonick-core'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => esc_html__('Your content...', 'carbonick-core'),
			]
		);

		$this->add_control(
			'p_description',
			[
				'label' => esc_html__('Description', 'carbonick-core'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
				'placeholder' => esc_html__('Description...', 'carbonick-core'),
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__('Enable hover animation', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html__('Lift up the item on hover.', 'carbonick-core'),
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> ICON/IMAGE
		/*-----------------------------------------------------------------------------------*/

		Wgl_Icons::init(
			$this,
			['section' => true]
		);

		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> HIGHLIGHTER
		/*-----------------------------------------------------------------------------------*/  

		$this->start_controls_section(
			'section_content_highlighter',
			[ 'label' => esc_html__('Highlighter', 'carbonick-core') ]
		);

		$this->add_control(
			'highlighter_switch',
			[
				'label' => esc_html__('Use highlighting element?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'highlighter_text',
			[
				'label' => esc_html__('Highlighting Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'highlighter_switch' => 'yes' ],
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__('Best', 'carbonick-core'),
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> BUTTON
		/*-----------------------------------------------------------------------------------*/  

		$this->start_controls_section(
			'section_content_button',
			[ 'label' => esc_html__('Button', 'carbonick-core') ]
		);

		$this->add_control(
			'b_switch',
			[
				'label' => esc_html__('Use button?','carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'b_title',
			[
				'label' => esc_html__('Button Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'b_switch' => 'yes' ],
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__('Buy now', 'carbonick-core'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'b_link',
			[
				'label' => esc_html__('Button Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'condition' => [ 'b_switch' => 'yes' ],
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> HIGHLIGHTER
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_highlighter',
			[
				'label' => esc_html__('Highlighter', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'highlighter_switch!' => '' ],
			]
		);

		$this->add_control(
			'highlighter_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pricing_highlighter' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'highlighter_bg_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .pricing_highlighter' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'highlighter_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 3,
					'right' => 35,
					'bottom' => 3,
					'left' => 35,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_highlighter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'highlighter_b_rotated',
			[
				'label' => esc_html__('Enable rotate', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'prefix_class' => 'highlighter_rotated-',
			]
		);

		$this->add_responsive_control(
			'highlighter_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 30,
					'bottom' => 0,
					'left' => 0,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_highlighter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'highlighter_b_rotated!' => 'yes' ],
			]
		);

		$this->add_control(
			'highlighter_b_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom'=> 50,
					'left'  => 50,
					'unit'  => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_highlighter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'highlighter_b_rotated!' => 'yes' ],
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
				'label' => esc_html__('Title Typography', 'carbonick-core'),
				'name' => 'title_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pricing_title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pricing_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_bg',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_scheme' => 'module' ],
				'selector' => '{{WRAPPER}} .pricing_title',
				'separator' => 'before',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => $secondary_color ],
				],
			]
		);

		$this->add_control(
			't_bg_text_switch',
			[
				'label' => esc_html__('Enable shadow text', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'default' => '',
			]
		); 

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_shadow_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pricing_title__shadow',
				'condition' => [ 't_bg_text_switch!' => '' ],
			]
		);

		$this->add_control(
			't_bg_text_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#d6d6d6',
				'selectors' => [
					'{{WRAPPER}} .pricing_title__shadow' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
				],
				'condition' => [ 't_bg_text_switch!' => '' ],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom'=> '0',
					'left'  => '-60',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '20',
					'right' => '60',
					'bottom'=> '16',
					'left'  => '59',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .pricing_title',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> PRICE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__('Price', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_price_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pricing_price_wrap',
			]
		);

		$this->add_control(
			'custom_price_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .pricing_price_wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '22',
					'right' => '0',
					'bottom'=> '20',
					'left'  => '0',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_price_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '36',
					'bottom'=> '0',
					'left'  => '36',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_price_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'price_border',
				'selector' => '{{WRAPPER}} .pricing_price_wrap',
				'separator' => 'before',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '0',
							'right' => '0',
							'bottom' => '1',
							'left' => '0',
							'isLinked' => false,
						],
					],
					'color' => [
						'default' => '#e8e8e8',
					],
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> PERIOD
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_period',
			[
				'label' => esc_html__('Period', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_period_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pricing_period',
				'fields_options' => [
					'font_size' => [
						'default' => [ 'size' => 0.3, 'unit' => 'em' ]
					]
				],
			]
		);

		$this->add_control(
			'period_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#a2a2a2',
				'selectors' => [
					'{{WRAPPER}} .pricing_period' => 'color: {{VALUE}};',
				],
			]
		);  

		$this->add_responsive_control(
			'period_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing_period' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_content_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pricing_content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $main_font_color,
				'selectors' => [
					'{{WRAPPER}} .pricing_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content-padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing_content' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}} !important; padding-right: {{RIGHT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> DESCRIPTION
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__('Description', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'p_description!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_desc_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pricing_desc',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $main_font_color,
				'selectors' => [
					'{{WRAPPER}} .pricing_desc' => 'color: {{VALUE}};',
				],
			]
		);    

		$this->add_responsive_control(
			'description_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing_desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> BUTTON
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__('Button', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'b_switch!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .wgl-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__('Text Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'b_hover_color',
			[
				'label' => esc_html__('Text Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-button:hover, {{WRAPPER}} .wgl-button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'b_bg_hover_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button:hover',
			]
		);

		$this->add_control(
			'b_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'border_border!' => '' ],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '2',
							'right' => '2',
							'bottom' => '2',
							'left' => '2',
							'isLinked' => false,
						],
					],
					'color' => [
						'default' => $primary_color,
					],
				],
			]
		);

		$this->add_control(
			'b_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'b_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'b_switch' => 'yes' ],
				'separator' => 'before',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'b_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'b_switch' => 'yes' ],
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '19',
					'right' => '29',
					'bottom' => '17',
					'left' => '29',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> BACKGROUND
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_bg',
			[
				'label' => esc_html__('Container', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_scheme',
			[
				'label' => esc_html__('Customize background for:', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'module' => esc_html__('whole module', 'carbonick-core'),
					'sections'  => esc_html__('separate sections', 'carbonick-core'),
				],
				'default' => 'module',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'module',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_scheme' => 'module' ],
				'selector' => '{{WRAPPER}} .pricing_plan_wrap',
			]
		);

		$this->add_control(
			'header_s_bg',
			[
				'label' => esc_html__('Header Section Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'bg_scheme' => 'sections' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pricing_plan_wrap .pricing_header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_s_bg',
			[
				'label' => esc_html__('Content Section Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'bg_scheme' => 'sections' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pricing_plan_wrap .pricing_content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'footer_s_bg',
			[
				'label' => esc_html__('Footer Section Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'bg_scheme' => 'sections' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pricing_plan_wrap .pricing_footer' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'bg_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '20',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bg_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '29',
					'right' => '40',
					'bottom' => '44',
					'left' => '40',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pricing_header' => 'padding-top: {{TOP}}{{UNIT}};',
					'{{WRAPPER}} .pricing_header, {{WRAPPER}} .pricing_content, {{WRAPPER}} .pricing_footer' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .pricing_footer' => 'padding-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bg_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing_plan_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bg_border',
				'selector' => '{{WRAPPER}} .pricing_plan_wrap',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => false,
						],
					],
					'color' => [
						'default' => '#e1e1e1',
					],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$_s = $this->get_settings_for_display();

		$media = $title = $description = $highlighter = $button = '';

		// Wrapper classes
		$wrap_classes = $_s['hover_animation'] ? ' hover-animation' : '';


		// Icon/Image output
		ob_start();
		if (!empty($_s['icon_type'])) {
			$icons = new Wgl_Icons;
			echo $icons->build($this, $_s, []);
		}
		$services_media = ob_get_clean();

		if ($_s['icon_type'] != '') {
			$media = '<div class="wgl-services_media-wrap">';
			if (!empty($services_media)) {
				$media .= $services_media;
			}
			$media .= '</div>';
		}

		// Title
		if ( ! empty($_s['p_title']) ) {
			$title .= '<h4 class="pricing_title">';
				$title .= esc_html($_s['p_title']);
				$title .= $_s['t_bg_text_switch'] ? '<span class="pricing_title__shadow">'.esc_html($_s['p_title']).'</span>' : '';
			$title .= '</h4>';
		}

		// Currency
		$currency = ! empty($_s['p_currency']) ? '<span class="pricing_currency">'.esc_html($_s['p_currency']).'</span>' : '';

		// Price
		if ( isset($_s['p_price']) ) {
			preg_match( "/(\d+)(\.| |,)(\d+)$/", $_s['p_price'], $matches, PREG_OFFSET_CAPTURE );
			switch ( isset($matches[0]) ) {
				case false:
					$price = '<div class="pricing_price">'.esc_html($_s['p_price']).'</div>';
					break;
				case true:
					$price = '<div class="pricing_price">';
						$price .= esc_html($matches[1][0]);
						$price .= '<span class="price_decimal">'.esc_html($matches[3][0]).'</span>';
					$price .= '</div>';
					break;
			}
		}

		// Period
		$period = ! empty($_s['p_period']) ? '<span class="pricing_period">'.wp_kses_post($_s['p_period']).'</span>' : '';

		// Description
		if ( $_s['p_description'] ) {
			$allowed_html = [
				'a' => [
					'href' => true, 'title' => true,
					'class' => true, 'style' => true,
				],
				'br' => [ 'class' => true ],
				'em' => [],
				'strong' => [],
				'span' => [ 'class' => true, 'style' => true ],
				'p' => [ 'class' => true, 'style' => true ],
				'ul' => [ 'class' => true, 'style' => true ],
				'ol' => [ 'class' => true, 'style' => true ],
			];
			$description = '<div class="pricing_desc">'.wp_kses( $_s['p_description'], $allowed_html ).'</div>';
		}

		// Highlighter
		if ( $_s['highlighter_switch'] && ! empty($_s['highlighter_text']) ) {
			$highlighter = '<div class="pricing_highlighter">'.esc_html($_s['highlighter_text']).'</div>';
		}

		// Button
		if ( $_s['b_switch'] ) {
			// options array
			$button_options = [
				'icon_type' => '',
				'text' => $_s['b_title'],
				'link' => $_s['b_link'],
				'size' => 'xl',
			];
			ob_start();
				echo Wgl_Button::init_button($this, $button_options);
			$button = ob_get_clean();
		}

		// Render
		echo
			'<div class="wgl-pricing_plan', $wrap_classes, '">',
				'<div class="pricing_plan_wrap">',
					'<div class="pricing_header">',
						$highlighter,
						$media,
						$title,
					'</div>',
					'<div class="pricing_price_wrap">',
					$currency,
					$price,
					$period,
					'</div>',					
					'<div class="pricing_content">',
						$_s['p_content'],
					'</div>',
					'<div class="pricing_footer">',
						$description,
						$button,
					'</div>',
				'</div>',
			'</div>'
		;
	}
}
