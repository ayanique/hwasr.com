<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglTeam;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;


class Wgl_Team extends Widget_Base
{
	
	public function get_name() {
		return 'wgl-team';
	}

	public function get_title() {
		return esc_html__('WGL Team', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-team';
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}


	protected function _register_controls()
	{
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
		$tertiary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-tertiary-color'));
		$h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_general',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);

		$this->add_control(
			'posts_per_line',
			[
				'label' => esc_html__('Columns in Row', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('1', 'carbonick-core'),
					'2' => esc_html__('2', 'carbonick-core'),
					'3' => esc_html__('3', 'carbonick-core'),
					'4' => esc_html__('4', 'carbonick-core'),
					'5' => esc_html__('5', 'carbonick-core'),
					'6' => esc_html__('6', 'carbonick-core'),
				],
				'default' => '3',
			]
		);

		$this->add_control(
			'info_align',
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
			]
		);

		$this->add_control(
			'single_link_wrapper',
			[
				'label' => esc_html__('Add Link on Image', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'single_link_heading',
			[
				'label' => esc_html__('Add Link on Heading', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> APPEARANCE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_appearance',
			[ 'label' => esc_html__('Appearance', 'carbonick-core') ]
		);

		$this->add_control(
			'info_position',
			[
				'label' => esc_html__('Position the Info ', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inside_image' => esc_html__('within image', 'carbonick-core'),
					'under_image' => esc_html__('beneath image', 'carbonick-core'),
				],
				'default' => 'inside_image',
			]
		);

		$this->add_control(
			'hide_title',
			[
				'label' => esc_html__('Hide Title', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hide_meta',
			[
				'label' => esc_html__('Hide Meta', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hide_soc_icons',
			[
				'label' => esc_html__('Hide Social Icons', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'hide_content',
			[
				'label' => esc_html__('Hide Excerpt/Content', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'letter_count',
			[
				'label' => esc_html__('Limit the Excerpt/Content letters', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'hide_content!'  => 'yes' ],
				'min' => 1,
				'default' => '100',
			]
		);
		
		
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CAROUSEL OPTIONS
		/*-----------------------------------------------------------------------------------*/

		Wgl_Carousel_Settings::options($this);


		/*-----------------------------------------------------------------------------------*/
		/*  SETTINGS -> QUERY
		/*-----------------------------------------------------------------------------------*/

		Wgl_Loop_Settings::init(
			$this,
			[
				'post_type' => 'team',
				'hide_cats' => true,
				'hide_tags' => true
			]
		);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_items',
			[
				'label' => esc_html__('General', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label' => esc_html__('Items Gap', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 15,
					'right' => 38,
					'bottom' => 63,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl_module_team .team-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wgl_module_team .team-items_wrap' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'background_style_section',
			[
				'label' => esc_html__('Image', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'unit' => 'px',
				],
				'mobile_default' => [
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-item_media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'unit'  => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .team-image, {{WRAPPER}} .team-image img, {{WRAPPER}} .team-image:before, {{WRAPPER}} .team-image:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bg_color_type',
			[
				'label' => esc_html__('Customize Overlays', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'background_color_tabs' );

		$this->start_controls_tab(
			'custom_background_color_idle',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
				'condition' => [ 'bg_color_type' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_color',
				'label' => esc_html__('Background Idle', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_color_type' => 'yes' ],
				'selector' => '{{WRAPPER}} .team-image:before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_background_color_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
				'condition' => [ 'bg_color_type' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_hover_color',
				'label' => esc_html__('Background Hover', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_color_type' => 'yes' ],
				'selector' => '{{WRAPPER}} .team-image:after',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> TITLE
		/*-----------------------------------------------------------------------------------*/
		
		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> INFO
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'background_style_info_section',
			[
				'label' => esc_html__('Info', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'info_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 19,
					'right' => 27,
					'bottom' => 0,
					'left' => 27,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl_module_team .team-item_info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'info_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'unit'  => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl_module_team .team-item_info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bg_color_type_info',
			[
				'label' => esc_html__('Customize Overlays', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'background_color_tabs_info' );

		$this->start_controls_tab(
			'custom_background_color_idle_info',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
				'condition' => [ 'bg_color_type_info' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_color_info',
				'label' => esc_html__('Background Idle', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_color_type_info' => 'yes' ],
				'selector' => '{{WRAPPER}}  .wgl_module_team .team-item_info:before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_background_color_hover_info',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
				'condition' => [ 'bg_color_type_info' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_hover_color_info',
				'label' => esc_html__('Background Hover', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_color_type_info' => 'yes' ],
				'selector' => '{{WRAPPER}}  .wgl_module_team .team-item_info:after',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
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
				'name' => 'title_team_headings',
				'selector' => '{{WRAPPER}} .team-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '',
					'left' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_title_color',
			[
				'label' => esc_html__('Customize Colors', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->start_controls_tabs( 'title_color_tabs' );

		$this->start_controls_tab(
			'custom_title_color_idle',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
				'condition' => [ 'custom_title_color' => 'yes' ],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label' => esc_html__('Title Idle', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_title_color' => 'yes' ],
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .team-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wgl_module_team .team-item_info .team-link_inside .team-link__icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_title_color_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
				'condition' => [ 'custom_title_color' => 'yes' ],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Title Hover', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_title_color' => 'yes' ],
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .team-item_wrap:hover .team-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .team-item_wrap:hover .team-item_info .team-link_inside .team-link__icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> META INFO
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_meta',
			[
				'label' => esc_html__('Meta Info', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 15,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-department' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_depart_color',
			[
				'label' => esc_html__('Customize Color', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->start_controls_tabs( 'depart_color_tabs' );

		$this->start_controls_tab(
			'custom_depart_color_idle',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
				'condition' => [ 'custom_depart_color' => 'yes' ],
			]
		);

		$this->add_control(
			'depart_color',
			[ 
				'label' => esc_html__('Meta Idle', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_depart_color' => 'yes' ],
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .team-department' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_depart_color_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
				'condition' => [ 'custom_depart_color' => 'yes' ],
			]
		);

		$this->add_control(
			'depart_color_hover',
			[
				'label' => esc_html__('Meta Hover', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_depart_color' => 'yes' ],
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .team-item_wrap:hover .team-department' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> SOCIALS
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'ssection_style_socials',
			[
				'label' => esc_html__('Socials', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'socials_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team__icons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_soc_color',
			[
				'label' => esc_html__('Customize Colors', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'soc_color_tabs' );

		$this->start_controls_tab(
			'custom_soc_color_idle',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
				'condition' => [ 'custom_soc_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_color',
			[ 
				'label' => esc_html__('Icon Idle', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_color' => 'yes' ],
				'default' => '#adadad',
				'selectors' => [
					'{{WRAPPER}} .team-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_soc_color_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
				'condition' => [ 'custom_soc_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_hover_color',
			[ 
				'label' => esc_html__('Icon Hover', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'custom_soc_bg_color',
			[
				'label' => esc_html__('Customize Backgrounds', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'soc_background_tabs' );

		$this->start_controls_tab(
			'custom_soc_bg_idle',
			[
				'label' => esc_html__('Idle' , 'carbonick-core'),
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_bg_color',
			[ 
				'label' => esc_html__('Background Idle', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-icon' => 'background: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_soc_bg_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_bg_hover_color',
			[ 
				'label' => esc_html__('Background Hover', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-icon:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();

		$team = new WglTeam();
		echo $team->render($atts);
	}
	
}