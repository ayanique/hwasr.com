<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Includes\Wgl_Elementor_Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Frontend;
use Elementor\Repeater;


class Wgl_Carousel extends Widget_Base {

	public function get_name() {
		return 'wgl-carousel';
	}

	public function get_title() {
		return esc_html__('WGL Carousel', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-carousel';
	}

	public function get_script_depends() {
		return [ 'jquery-slick' ];
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}


	protected function _register_controls()
	{
		$theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$self = new REPEATER();
		
		$this->start_controls_section('wgl_carousel_section',
			[ 'label' => esc_html__('Carousel Settings' , 'carbonick-core') ]
		);

		$self->add_control(
			'content',
			[
				'label' => esc_html__('Content', 'carbonick-core'),
				'type' => Controls_Manager::SELECT2,
				'options' => Wgl_Elementor_Helper::get_instance()->get_elementor_templates(),
			]
		);
		
		$this->add_control(
			'content_repeater',
			[
				'label' => esc_html__('Templates', 'carbonick-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => array_values( $self->get_controls() ),
				'description' => esc_html__('Slider content is a template which you can choose from Elementor library. Each template will be a slider content', 'carbonick-core'),
				'title_field' => 'Template: {{{ content }}}'
			]
		);


		$this->add_control(
			'slide_to_show',
			[
				'label' => esc_html__('Columns Amount', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('1', 'carbonick-core'),
					'2' => esc_html__('2', 'carbonick-core'),
					'3' => esc_html__('3', 'carbonick-core'),
					'4' => esc_html__('4', 'carbonick-core'),
					'5' => esc_html__('5', 'carbonick-core'),
					'6' => esc_html__('6', 'carbonick-core'),
				],
				'default' => '1'
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__('Animation Speed', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => '3000',
				'min' => 1,
				'step' => 1,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__('Autoplay', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__('Autoplay Speed', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'autoplay' => 'yes' ],
				'min' => 1,
				'step' => 1,
				'default' => '3000',
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'label' => esc_html__('Slide One Item per time', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => esc_html__('Infinite loop sliding', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'adaptive_height',
			[
				'label' => esc_html__('Adaptive Height', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'fade_animation',
			[
				'label' => esc_html__('Fade Animation', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'slide_to_show' => '1' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'navigation_section',
			[ 'label' => esc_html__('Navigation', 'carbonick-core') ]
		);

		$this->add_control(
			'h_pag_controls',
			[
				'label' => esc_html__('Pagination Controls', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_control(
			'use_pagination',
			[
				'label' => esc_html__('Add Pagination control', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes'
			]
		);

		$this->add_control(
			'pag_type',
			[
				'label' => esc_html__('Pagination Type', 'carbonick-core'),
				'type' => 'wgl-radio-image',
				'condition' => [ 'use_pagination' => 'yes' ],
				'options' => [
					'circle' => [
						'title'=> esc_html__('Circle', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle.png',
					],
					'circle_border' => [
						'title'=> esc_html__('Empty Circle', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle_border.png',
					],
					'square' => [
						'title'=> esc_html__('Square', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_square.png',
					], 
					'square_border' => [
						'title'=> esc_html__('Empty Square', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_square_border.png',
					],
					'line' => [
						'title'=> esc_html__('Line', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line.png',
					],
					'line_circle' => [
						'title'=> esc_html__('Line - Circle', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle.png',
					],
				],
				'default' => 'circle',
			]
		);

		$this->add_control(
			'pag_align',
			[
				'label' => esc_html__('Pagination Aligning', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'use_pagination' => 'yes' ],
				'options' => [
					'left' => esc_html__('Left', 'carbonick-core'),
					'right' => esc_html__('Right', 'carbonick-core'),
					'center' => esc_html__('Center', 'carbonick-core'),
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'pag_offset',
			[
				'label' => esc_html__('Pagination Top Offset', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'use_pagination' => 'yes' ],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 1000, 'step' => 5 ],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]

		);

		$this->add_control(
			'custom_pag_color',
			[
				'label' => esc_html__('Custom Pagination Color', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'use_pagination' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'pag_color',
			[
				'label' => esc_html__('Pagination Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_pag_color' => 'yes' ],
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .pagination_circle .slick-dots li button' => 'background: {{VALUE}}',
					'{{WRAPPER}} .pagination_square .slick-dots li button' => 'background: {{VALUE}}',
					'{{WRAPPER}} .pagination_line .slick-dots li button:before' => 'background: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'hr_prev_next',
			[ 'type' => Controls_Manager::DIVIDER ]
		);

		$this->add_control(
			'divider_4',
			[
				'label' => esc_html__('Prev/Next Buttons', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'use_prev_next',
			[
				'label' => esc_html__('Add Prev/Next buttons', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);
		$this->add_control(
			'custom_prev_next_offset',
			[
				'label' => esc_html__('Custom offset', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'use_prev_next' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'prev_next_offset',
			[
				'label' => esc_html__('Buttons Top Offset', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'use_prev_next' => 'yes' ],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [ 'min' => 0, 'max' => 1000 ],
				],
				'default' => [ 'size' => 50, 'unit' => '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-carousel .slick-next' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wgl-carousel .slick-prev' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_prev_next_color',
			[
				'label' => esc_html__('Customize Colors', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'use_prev_next' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);
		$this->add_control(
			'prev_next_color',
			[
				'label' => esc_html__('Prev/Next Buttons Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_prev_next_color' => 'yes' ],
				'dynamic' => [ 'active' => true ],
				'default' => $theme_color,
			]
		);

		$this->add_control(
			'prev_next_bg_color',
			[
				'label' => esc_html__('Buttons Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				 'condition' => [
					'custom_prev_next_color' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'responsive_section',
			[ 'label' => esc_html__('Responsive', 'carbonick-core') ]
		);

		$this->add_control(
			'custom_resp',
			[
				'label' => esc_html__('Customize Responsive', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'heading_desktop',
			[
				'label' => esc_html__('Desktop Settings', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'custom_resp' => 'yes' ],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'resp_medium',
			[
				'label' => esc_html__('Desktop Screen Breakpoint', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
				'default' => '1025',
			]
		);

		$this->add_control(
			'resp_medium_slides',
			[
				'label' => esc_html__('Slides to show', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
			]
		);

		$this->add_control(
			'heading_tablet',
			[
				'label' => esc_html__('Tablet Settings', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'custom_resp' => 'yes' ],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'resp_tablets',
			[
				'label' => esc_html__('Tablet Screen Breakpoint', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
				'default' => '800',
			]
		);

		$this->add_control(
			'resp_tablets_slides',
			[
				'label' => esc_html__('Slides to show', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'condition' => [ 'custom_resp' => 'yes' ],
			]
		);

		$this->add_control(
			'heading_mobile',
			[
				'label' => esc_html__('Mobile Settings', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [ 'custom_resp' => 'yes' ],
			]
		);

		$this->add_control(
			'resp_mobile',
			[
				'label' => esc_html__('Mobile Screen Breakpoint', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
				'default' => '480',
			]
		);

		$this->add_control(
			'resp_mobile_slides',
			[
				'label' => esc_html__('Slides to show', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
			]
		);
	   
		$this->end_controls_section();
	
	}

	protected function render()
	{

		$atts = $this->get_settings_for_display();
		extract($atts);
		
		$content = [];
		
		foreach ($content_repeater as $template) {
			array_push($content, $template[ 'content' ]);
		}
		echo Wgl_Carousel_Settings::init($atts, $content, true);
	}
	
}