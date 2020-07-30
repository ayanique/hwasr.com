<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, If called directly.

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
use Elementor\Plugin;


class Wgl_Header_Side_panel extends Widget_Base
{
	
	public function get_name() {
		return 'wgl-header-side_panel';
	}

	public function get_title() {
		return esc_html__('WGL Side Panel Button', 'carbonick-core' );
	}

	public function get_icon() {
		return 'wgl-header-side_panel';
	}

	public function get_categories() {
		return [ 'wgl-header-modules' ];
	}

	public function get_script_depends() {
		return [ 'wgl-elementor-extensions-widgets' ];
	}

	protected function _register_controls()
	{
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
		$h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


		$this->start_controls_section(
			'section_side_panel_settings',
			[
				'label' => esc_html__( 'Side Panel', 'carbonick-core' ),
			]
		);

		$this->add_responsive_control(
			'sp_width',
			[
				'label' => esc_html__( 'Item Width', 'carbonick-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [ 'min' => 30, 'max' => 200 ],
					'%' => [ 'min' => 5, 'max' => 100 ],
				], 
				'default' => [ 'size' => '100', 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sp_height',
			[
				'label' => esc_html__( 'Item Height', 'carbonick-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [ 'min' => 30, 'max' => 250 ],
					'%' => [ 'min' => 5, 'max' => 100 ],
				],
				'default' => [ 'size' => '100', 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'carbonick-core' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [ 'sp_width!' => 0 ],
				'options' => [
					'margin-right' => [
						'title' => esc_html__( 'Left', 'carbonick-core' ),
						'icon' => 'fa fa-align-left',
					],
					'margin' => [
						'title' => esc_html__( 'Center', 'carbonick-core' ),
						'icon' => 'fa fa-align-center',
					],
					'margin-left' => [
						'title' => esc_html__( 'Right', 'carbonick-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}}' => '{{VALUE}}: auto;',
				],

			]
		);

		$this->add_control(
			'dots_style',
			[
				'label' => esc_html__('Dots Style', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'def' => esc_html__('Default', 'carbonick-core'),
					'small' => esc_html__('Small', 'carbonick-core'),
				],
				'default' => 'def',
				'prefix_class' => 'style-',
			]
		); 

		$this->start_controls_tabs(
			'sp_color_tabs',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'tab_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'icon_color_idle',
			[
				'label' => esc_html__( 'Icon Color', 'carbonick-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6e6e6e',
				'selectors' => [
					'{{WRAPPER}} .side_panel .side_panel-toggle-inner span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_bg_idle',
			[ 
				'label' => esc_html__( 'Item Background', 'carbonick-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .side_panel' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Icon Color', 'carbonick-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}}:hover .side_panel .side_panel-toggle-inner span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_bg_hover',
			[ 
				'label' => esc_html__( 'Item Background', 'carbonick-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}}:hover .side_panel' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}


	public function render()
	{
		echo '<div class="side_panel">',
			'<div class="side_panel_inner">',
				'<a href="#" class="side_panel-toggle">',
					'<span class="side_panel-toggle-inner">',
						'<span></span>',
						'<span></span>',
						'<span></span>',
						'<span></span>',
						'<span></span>',
						'<span></span>',
						'<span></span>',
						'<span></span>',
						'<span></span>',
					'</span>',
				'</a>',
			'</div>',
		'</div>';
	}
}