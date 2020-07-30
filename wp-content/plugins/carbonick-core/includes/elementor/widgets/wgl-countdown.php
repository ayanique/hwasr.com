<?php

namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglCountDown;
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

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class Wgl_CountDown extends Widget_Base {

	public function get_name() {
		return 'wgl-countdown';
	}

	public function get_title() {
		return esc_html__( 'WGL Countdown Timer', 'carbonick-core' );
	}

	public function get_icon() {
		return 'wgl-countdown';
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}

	public function get_script_depends() {
		return [
			'jquery-countdown',
			'wgl-elementor-extensions-widgets',
		];
	}


	protected function _register_controls() {
		$primary_color     = esc_attr( \Carbonick_Theme_Helper::get_option( 'theme-primary-color' ) );
		$secondary_color   = esc_attr( \Carbonick_Theme_Helper::get_option( 'theme-secondary-color' ) );
		$tertiary_color    = esc_attr( \Carbonick_Theme_Helper::get_option( 'theme-tertiary-color' ) );
		$header_font_color = esc_attr( \Carbonick_Theme_Helper::get_option( 'header-font' )['color'] );
		$main_font_color   = esc_attr( \Carbonick_Theme_Helper::get_option( 'main-font' )['color'] );

		/* Start General Settings Section */
		$this->start_controls_section( 'wgl_countdown_section',
			array(
				'label' => esc_html__( 'Countdown Timer Settings', 'carbonick-core' ),
			)
		);

		$this->add_control( 'countdown_year',
			array(
				'label'       => esc_html__( 'Year', 'carbonick-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'carbonick-core' ),
				'default'     => esc_html__( '2020', 'carbonick-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 2020', 'carbonick-core' ),
			)
		);

		$this->add_control( 'countdown_month',
			array(
				'label'       => esc_html__( 'Month', 'carbonick-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '12', 'carbonick-core' ),
				'default'     => esc_html__( '12', 'carbonick-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 12', 'carbonick-core' ),
			)
		);

		$this->add_control( 'countdown_day',
			array(
				'label'       => esc_html__( 'Day', 'carbonick-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '31', 'carbonick-core' ),
				'default'     => esc_html__( '31', 'carbonick-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 31', 'carbonick-core' ),
			)
		);

		$this->add_control( 'countdown_hours',
			array(
				'label'       => esc_html__( 'Hours', 'carbonick-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '24', 'carbonick-core' ),
				'default'     => esc_html__( '24', 'carbonick-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 24', 'carbonick-core' ),
			)
		);

		$this->add_control( 'countdown_min',
			array(
				'label'       => esc_html__( 'Minutes', 'carbonick-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '59', 'carbonick-core' ),
				'default'     => esc_html__( '59', 'carbonick-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 59', 'carbonick-core' ),
			)
		);

		/*End General Settings Section*/
		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Button Section
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section( 'wgl_countdown_content_section',
			array(
				'label' => esc_html__( 'Countdown Timer Content', 'carbonick-core' ),
			)
		);

		$this->add_control( 'hide_day',
			array(
				'label'        => esc_html__( 'Hide Days?', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'hide_hours',
			array(
				'label'        => esc_html__( 'Hide Hours?', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'hide_minutes',
			array(
				'label'        => esc_html__( 'Hide Minutes?', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'hide_seconds',
			array(
				'label'        => esc_html__( 'Hide Seconds?', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'show_value_names',
			array(
				'label'        => esc_html__( 'Show Value Names?', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'show_value_names-',
			)
		);

		$this->add_control( 'show_separating',
			array(
				'label'        => esc_html__( 'Show Separating?', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
				'prefix_class' => 'show_separating-',
			)
		);
		$this->add_responsive_control(
			'align',
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
				'prefix_class' => 'elementor%s-align-',
				'default' => 'center',
			]
		);

		/*End General Settings Section*/
		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_style_section',
			array(
				'label' => esc_html__( 'Style', 'carbonick-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control( 'size',
			array(
				'label'   => esc_html__( 'Countdown Size', 'carbonick-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'large'  => esc_html__( 'Large', 'carbonick-core' ),
					'medium' => esc_html__( 'Medium', 'carbonick-core' ),
					'small'  => esc_html__( 'Small', 'carbonick-core' ),
					'custom' => esc_html__( 'Custom', 'carbonick-core' ),
				],
				'default' => 'large'
			)
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => esc_html__( 'Number Typography', 'carbonick-core' ),
				'name'      => 'custom_fonts_number',
				'selector'  => '{{WRAPPER}} .wgl-countdown .countdown-section .countdown-amount',
				'condition' => [
					'size' => 'custom'
				]
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => esc_html__( 'Text Typography', 'carbonick-core' ),
				'name'      => 'custom_fonts_text',
				'selector'  => '{{WRAPPER}} .wgl-countdown .countdown-section .countdown-period',
				'condition' => [
					'size' => 'custom'
				]
			)
		);

		$this->add_control(
			'number_text_color',
			array(
				'label'     => esc_html__( 'Number Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-countdown .countdown-section .countdown-amount' => 'color: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'period_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1f242c',
				'selectors' => [
					'{{WRAPPER}} .wgl-countdown .countdown-section .countdown-period' => 'color: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'separating_color',
			array(
				'label'     => esc_html__( 'Separate Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(97,97,97,.3)',
				'selectors' => [
					'{{WRAPPER}} .wgl-countdown .countdown-section:after'  => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_separating' => 'yes'
				]
			)
		);

		/*End Style Section*/
		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		$countdown = new WglCountDown();
		echo $countdown->render( $this, $atts );

	}

}