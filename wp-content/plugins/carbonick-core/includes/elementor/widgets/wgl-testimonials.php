<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglTestimonials;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;


class Wgl_Testimonials extends Widget_Base {
	
	public function get_name() {
		return 'wgl-testimonials';
	}

	public function get_title() {
		return esc_html__('WGL Testimonials', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-testimonials';
	}

	public function get_script_depends() {
		return [ 'jquery-slick' ];
	}
 
	public function get_categories() {
		return [ 'wgl-extensions' ];
	}


	protected function _register_controls() {
		$theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);
		$header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_testimonials_section',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);
		$this->add_control(
			'posts_per_line',
			[
				'label' => esc_html__('Columns Amount', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('One Column', 'carbonick-core'),
					'2' => esc_html__('Two Columns', 'carbonick-core'),
					'3' => esc_html__('Three Columns', 'carbonick-core'),
					'4' => esc_html__('Four Columns', 'carbonick-core'),
					'5' => esc_html__('Five Columns', 'carbonick-core'),
				],
				'default' => '2',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'thumbnail',
			[
				'label' => esc_html__('Image', 'carbonick-core'),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [ 'url' => Utils::get_placeholder_image_src() ],
			]
		);

		$repeater->add_control(
			'author_name',
			[
				'label' => esc_html__('Author Name', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$repeater->add_control('link_author',
			[
				'label' => esc_html__('Link Author', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'author_position',
			[
				'label' => esc_html__('Author Position', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$repeater->add_control(
			'quote',
			[
				'label' => esc_html__('Quote', 'carbonick-core'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__('Items', 'carbonick-core'),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'author_name' => esc_html__('Derry Long', 'carbonick-core'),
						'author_position' => '',
						'quote' => esc_html__('Choosing online studies was the best way to do it – the internet is fast, cheap & popular and it’s easy to communicate in native speakers.', 'carbonick-core'),
						'thumbnail' => Utils::get_placeholder_image_src()
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ author_name }}}'
			]
		);
		
		$this->add_control(
			'item_type',
			[
				'label' => esc_html__('Overall Layout', 'carbonick-core'),
				'type' => 'wgl-radio-image',
				'options' => [
					'author_top' => [
						'title'=> esc_html__('Top', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_1.png',
					],
					'inline_top' => [
						'title'=> esc_html__('Top Inline', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_2.png',
					],
					'author_bottom' => [
						'title'=> esc_html__('Bottom', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_4.png',
					],
					'inline_bottom' => [
						'title'=> esc_html__('Bottom Inline', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_3.png',
					],
					'author_center' => [
						'title'=> esc_html__('Center', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_3.png',
					],

				],
				'default' => 'inline_top',
			]
		);

		$this->add_control(
			'item_align',
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
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__('Enable Hover Animation', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
				'description'  => esc_html__('Lift up the item on hover.', 'carbonick-core'),
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  Carousel options
		/*-----------------------------------------------------------------------------------*/ 

		Wgl_Carousel_Settings::options($this);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'section_style_testimonials_image',
			[
				'label' => esc_html__('Image', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__('Image Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 20, 'max' => 1000 ],
				],
				'default' => [ 'size' => 90, 'unit' => 'px' ],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'testimonials_image_shadow',
				'selector' =>  '{{WRAPPER}} .wgl-testimonials_image img',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_image img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 120,
					'left' => 120,
					'right' => 120,
					'bottom' => 120,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> QUOTE
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'quote_style_section',
			[
				'label' => esc_html__('Quote', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_tag',
			[
				'label' => esc_html__('Quote tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'div' => 'div',
					'span'  => 'span',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'quote_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '',
					'left' => '',
					'right' => '',
					'bottom' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'quote_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'quote_color' );

		$this->start_controls_tab(
			'custom_quote_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_quote_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#616161',
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'custom_quote_color_bg',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_quote_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_hover_quote_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#616161',
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'custom_hover_quote_color_bg',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_quote',
				'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> NAME
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'author_name_style_section',
			[
				'label' => esc_html__('Name', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_tag',
			[
				'label' => esc_html__('HTML tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'div' => 'div',
					'span'  => 'span',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'name_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 22,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'name_color' );

		$this->start_controls_tab(
			'custom_name_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_name_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_name_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_hover_name_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials_item .wgl-testimonials_name:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_name',
				'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_name',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> POSITION
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'author_position_style_section',
			[
				'label' => esc_html__('Position', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'position_tag',
			[
				'label' => esc_html__('HTML tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'span',
				'options' => [
					'div' => 'div',
					'span'  => 'span',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'position_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 10,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'position_color' );

		$this->start_controls_tab(
			'custom_position_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_position_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#b2b2b2',
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_position_color_hover',
			[
				'label' => esc_html__('Hover' , 'carbonick-core'),
			]
		);

		$this->add_control(
			'custom_hover_position_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#8d8d8d',
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_position',
				'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position',
			]
		);

		$this->end_controls_section();
		
		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> QUOTE ICON
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'quote_icon_style_section',
			array(
				'label'     => esc_html__( 'Quote Icon', 'carbonick-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'item_type' => array( 'inline_top', 'inline_bottom', 'author_center' ),
				]
			)
		);

		$this->add_control( 'quote_icon_switcher',
			array(
				'label'        => esc_html__( 'Enable Quote Icon', 'carbonick-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'carbonick-core' ),
				'label_off'    => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'item_type' => array( 'inline_top', 'inline_bottom', 'author_center' ),
				]
			)
		);

		$this->start_controls_tabs( 'quote_icon_color' );


		$this->start_controls_tab(
			'custom_quote_icon_color_normal',
			array(
				'label'     => esc_html__( 'IDLE', 'carbonick-core' ),
				'condition' => [
					'quote_icon_switcher' => 'yes',
				]
			)
		);

		$this->add_control(
			'custom_quote_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => esc_attr( $theme_color ),
				'selectors' => array(
					'{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:before' => 'color: {{VALUE}};',
				),
				'condition' => [
					'quote_icon_switcher' => 'yes',
				]
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_quote_icon_color_hover',
			array(
				'label'     => esc_html__( 'Hover', 'carbonick-core' ),
				'condition' => [
					'quote_icon_switcher' => 'yes',
				]
			)
		);

		$this->add_control(
			'custom_hover_quote_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => esc_attr( $theme_color ),
				'selectors' => array(
					'{{WRAPPER}}:hover .wgl-testimonials .wgl-testimonials_item:before' => 'color: {{VALUE}};',
				),
				'condition' => [
					'quote_icon_switcher' => 'yes',
				]
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CONTENT BOX
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'secondary_style_section',
			[
				'label' => esc_html__('Content Box', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_item',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wgl-testimonials_item',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'testimonials_shadow',
				'selector'       => '{{WRAPPER}} .wgl-testimonials_item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'testimonials_border',
				'label' => esc_html__('Border', 'carbonick-core'),
				'selector' => '{{WRAPPER}} .wgl-testimonials_item',
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

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__('Content Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 22,
					'left' => 39,
					'right' => 25,
					'bottom' => 46,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-testimonials_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();   

	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		
		$testimonials = new WglTestimonials();
		echo $testimonials->render($this, $atts);
	}
	
}