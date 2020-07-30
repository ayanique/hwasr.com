<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglPortfolio;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

class Wgl_Portfolio extends Widget_Base
{
	public function get_name() {
		return 'wgl-portfolio';
	}

	public function get_title() {
		return esc_html__('WGL Portfolio', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-portfolio';
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}

	public function get_script_depends()
	{
		return [
			'jquery-slick',
			'imagesloaded',
			'isotope',
			'wgl-elementor-extensions-widgets',
		];
	}


	protected function _register_controls()
	{
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
		$tertiary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-tertiary-color'));
		$h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_portfolio_section',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);
		
		$this->add_control(
			'portfolio_layout',
			[
				'label' => esc_html__('Layout', 'carbonick-core'),
				'type' => 'wgl-radio-image',
				'options' => [
					'grid' => [
						'title' => esc_html__('Grid', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
					],
					'carousel' => [
						'title' => esc_html__('Carousel', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_carousel.png',
					],
					'masonry' => [
						'title' => esc_html__('Masonry', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
					],
					'masonry2' => [
						'title' => esc_html__('Masonry 2', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
					],
					'masonry3' => [
						'title' => esc_html__('Masonry 3', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
					],
					'masonry4' => [
						'title' => esc_html__('Masonry 4', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
					],
				],
				'default' => 'grid',
			]
		);

		$this->add_control(
			'posts_per_row',
			[
				'label' => esc_html__('Columns Amount', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('1', 'carbonick-core'),
					'2' => esc_html__('2', 'carbonick-core'),
					'3' => esc_html__('3', 'carbonick-core'),
					'4' => esc_html__('4', 'carbonick-core'),
					'5' => esc_html__('5', 'carbonick-core'),
				],
				'default' => '3',
				'condition' => [
					'portfolio_layout' => [ 'grid', 'masonry', 'carousel' ]
				]
			]
		);

		$this->add_control(
			'grid_gap',
			[
				'label' => esc_html__('Grid Gap', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'0px' => esc_html__('0', 'carbonick-core'),
					'1px' => esc_html__('1', 'carbonick-core'),
					'2px' => esc_html__('2', 'carbonick-core'),
					'3px' => esc_html__('3', 'carbonick-core'),
					'4px' => esc_html__('4', 'carbonick-core'),
					'5px' => esc_html__('5', 'carbonick-core'),
					'10px' => esc_html__('10', 'carbonick-core'),
					'15px' => esc_html__('15', 'carbonick-core'),
					'20px' => esc_html__('20', 'carbonick-core'),
					'25px' => esc_html__('25', 'carbonick-core'),
					'30px' => esc_html__('30', 'carbonick-core'),
					'35px' => esc_html__('35', 'carbonick-core'),
				],
				'default' => '30px',
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label' => esc_html__('Show Filter', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'filter_align',
			[
				'label' => esc_html__('Filter Align', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'show_filter' => 'yes',
				],
				'options' => [
					'left' => esc_html__('Left', 'carbonick-core'),
					'right' => esc_html__('Right', 'carbonick-core'),
					'center' => esc_html__('Сenter', 'carbonick-core'),
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'crop_images',
			[
				'label' => esc_html__('Crop Images', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'portfolio_layout!' => 'masonry' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => esc_html__('Navigation Type', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'portfolio_layout!' => 'carousel' ],
				'options' => [
					'none' => esc_html__('None', 'carbonick-core'),
					'pagination' => esc_html__('Pagination', 'carbonick-core'),
					'infinite' => esc_html__('Infinite Scroll', 'carbonick-core'),
					'load_more' => esc_html__('Load More', 'carbonick-core'),
					'custom_link' => esc_html__('Custom Link', 'carbonick-core'),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'item_link',
			[
				'label' => esc_html__('Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'condition' => [ 'navigation' => 'custom_link' ],
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('https://your-link.com', 'carbonick-core'),
				'default' => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'link_position',
			[
				'label' => esc_html__('Link Position', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'navigation' => 'custom_link' ],
				'options' => [
					'below_items' => esc_html__('Below Items', 'carbonick-core'),
					'after_items' => esc_html__('After Items', 'carbonick-core'),
				],
				'default' => 'below_items',
			]
		);

		$this->add_control(
			'link_align',
			[
				'label' => esc_html__('Link Alignment', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'navigation' => 'custom_link' ],
				'options' => [
					'center' => esc_html__('Сenter', 'carbonick-core'),
					'left' => esc_html__('Left', 'carbonick-core'),
					'right' => esc_html__('Right', 'carbonick-core'),
				],
				'default' => 'left',
			]
		);

		$this->add_responsive_control(
			'link_margin',
			[
				'label' => esc_html__('Spacing', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'navigation' => 'custom_link' ],
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 60,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio_item_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_align',
			[
				'label' => esc_html__('Alignment', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'navigation' => 'pagination' ],
				'options' => [
					'center' => esc_html__('Сenter', 'carbonick-core'),
					'left' => esc_html__('Left', 'carbonick-core'),
					'right' => esc_html__('Right', 'carbonick-core'),
				],
				'default' => 'center',
			]
		);
		
		$this->add_control(
			'items_load', 
			[
				'label' => esc_html__('Items to be loaded', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'navigation' => [ 'load_more', 'infinite' ],
				],
				'default' => esc_html__('4', 'carbonick-core'),
			]
		);

		$this->add_control(
			'name_load_more', 
			[
				'label' => esc_html__('Button Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'navigation' => [ 'load_more', 'custom_link' ],
				],
				'default' => esc_html__('Load More', 'carbonick-core'),
			]
		);

		$this->add_control(
			'add_animation',
			[
				'label' => esc_html__('Add Appear Animation', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'appear_animation',
			[
				'label' => esc_html__('Animation Style', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'add_animation' => 'yes' ],
				'options' => [
					'fade-in' => esc_html__('Fade In', 'carbonick-core'),
					'slide-top' => esc_html__('Slide Top', 'carbonick-core'),
					'slide-bottom' => esc_html__('Slide Bottom', 'carbonick-core'),
					'slide-left' => esc_html__('Slide Left', 'carbonick-core'),
					'slide-right' => esc_html__('Slide Right', 'carbonick-core'),
					'zoom' => esc_html__('Zoom', 'carbonick-core'),
				],
				'default' => 'fade-in',
			]
		);

		$this->end_controls_section();

				/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_double_headings_section',
			[ 'label' => esc_html__('Double Headings', 'carbonick-core') ]
		);

		$this->add_control(
			'sub_pos',
			[
				'label' => esc_html__('Subtitle Position', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'column' => esc_html__('Top', 'carbonick-core'),
					'column-reverse' => esc_html__('Bottom', 'carbonick-core'),
				],
				'default' => 'column',
				'selectors' => [
					'{{WRAPPER}} .wgl-double_heading' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__('Subtitle', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('Subtitle', 'carbonick-core'),
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'title_1',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('This is the heading​', 'carbonick-core'),
			]
		);

		$this->add_control(
			'align_double_headings',
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
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => '‹h1›',
					'h2' => '‹h2›',
					'h3' => '‹h3›',
					'h4' => '‹h4›',
					'h5' => '‹h5›',
					'h6' => '‹h6›',
					'div' => '‹div›',
				],
				'default' => 'h3',
			]
		);
		
		$this->add_control(
			'link_double_headings',
			[
				'label' => esc_html__('Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('https://your-link.com', 'carbonick-core'),
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> APPEARANCE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'display_section',
			[ 'label' => esc_html__('Appearance', 'carbonick-core') ]
		);

		$this->add_control(
			'img_click_action',
			[
				'label' => esc_html__('Image Click Action', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'single' => esc_html__('Open Single Page', 'carbonick-core'),
					'custom' => esc_html__('Open Custom Link', 'carbonick-core'),
					'popup' => esc_html__('Popup the Image', 'carbonick-core'),
					'none' => esc_html__('Do Nothing', 'carbonick-core'),
				],
				'default' => 'single',
			]
		);

		$this->add_control(
			'img_click_action_notice',
			[
				'label' => esc_html__('Notice! You can specify custom link for each post in corresponding metabox options section.', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'img_click_action' => 'custom' ],
			]
		);

		$this->add_control(
			'single_link_title',
			[
				'label' => esc_html__('Heading linked with the Single Page', 'carbonick-core'),
				'condition' => [ 'gallery_mode' => '' ],
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
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
			'image_anim',
			[
				'label' => esc_html__('Description Animation', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'info_position' => 'inside_image' ],
				'options' => [
					'simple' => esc_html__('Simple', 'carbonick-core'),
					'sub_layer' => esc_html__('On Sub-Layer', 'carbonick-core'),
					'offset' => esc_html__('Side Offset', 'carbonick-core'),
					'zoom_in' => esc_html__('Zoom In', 'carbonick-core'),
					'outline' => esc_html__('Outline', 'carbonick-core'),
					'always_info' => esc_html__('Active Visible', 'carbonick-core'),
				],
				'default' => 'simple',
			]
		);

		$this->add_control(
			'horizontal_align',
			[
				'label' => esc_html__('Description Alignment', 'carbonick-core'),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'gallery_mode' => '',
					'info_position' => 'under_image'
				],
				'label_block' => true,
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
					'justify' => [
						'title' => esc_html__('Justified', 'carbonick-core'),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'center',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'content_section',
			[ 'label' => esc_html__('Content', 'carbonick-core') ]
		);

		$this->add_control(
			'gallery_mode',
			[
				'label' => esc_html__('Gallery Mode', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'show_portfolio_title',
			[
				'label' => esc_html__('Show Title?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'gallery_mode' => '' ],
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_categories',
			[
				'label' => esc_html__('Show categories?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'gallery_mode' => '' ],
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_content',
			[
				'label' => esc_html__('Show Excerpt/Content?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'gallery_mode' => '' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'content_letter_count',
			[
				'label' => esc_html__('Content Letter Count', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter content letter count.', 'carbonick-core' ),
				'condition' => [
					'show_content' => 'yes',
					'gallery_mode' => '',
				],
				'min' => 1,
				'default' => '85',
			]
		);

		$this->add_control(
			'portfolio_icon_type',
			[
				'label' => esc_html__('Add Icon', 'carbonick-core' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [ 'gallery_mode!' => '' ],
				'label_block' => false,
				'options' => [                  
					'' => [
						'title' => esc_html__('None', 'carbonick-core' ),
						'icon' => 'fa fa-ban',
					],
					'font' => [
						'title' => esc_html__('Icon', 'carbonick-core' ),
						'icon' => 'fa fa-smile-o',
					],
				],
				'default' => '',
			]
		);

		$this->add_control(
			'portfolio_icon_fontawesome',
			[
				'label' => esc_html__('Icon', 'carbonick-core' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'gallery_mode!' => '',
					'portfolio_icon_type' => 'font',
				],
				'description' => esc_html__('Select icon from Fontawesome library.', 'carbonick-core' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> First Title
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'first_title_section',
			[
				'label' => esc_html__('First Title', 'carbonick-core'),
				'condition' => [ 'portfolio_layout' => 'masonry4' ]
			]
		);

		$this->add_control(
			'show_first_title',
			[
				'label' => esc_html__('Show First Title?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'condition' => [ 'portfolio_layout' => 'masonry4' ],
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'first_title_title',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'portfolio_layout' => 'masonry4',
					'show_first_title'  => 'yes'
				],
			]
		);

		$this->add_control(
			'first_title_sub_title',
			[
				'label' => esc_html__('Sub Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'portfolio_layout' => 'masonry4',
					'show_first_title'  => 'yes'
				],
			]
		);

		$this->add_control(
			'show_first_title_button',
			[
				'label'     => esc_html__( 'Show Button?', 'carbonick-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'portfolio_layout' => 'masonry4',
					'show_first_title'  => 'yes'
				],
				'label_on'  => esc_html__( 'On', 'carbonick-core' ),
				'label_off' => esc_html__( 'Off', 'carbonick-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_first_title_btn_text',
			[
				'label' => esc_html__('Button Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('View Projects', 'carbonick-core'),
				'condition' => [
					'portfolio_layout' => 'masonry4',
					'show_first_title'  => 'yes',
					'show_first_title_button'  => 'yes'
				],
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_first_title_btn_link',
			[
				'label' => esc_html__('Button Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'condition' => [
					'portfolio_layout' => 'masonry4',
					'show_first_title'  => 'yes',
					'show_first_title_button'  => 'yes'
				],
				'dynamic' => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CAROUSEL OPTIONS
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_carousel_section',
			[
				'label' => esc_html__('Carousel Options', 'carbonick-core'),
				'condition' => [ 'portfolio_layout' => 'carousel' ],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__('Autoplay', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__('Autoplay Speed', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'autoplay' => 'yes' ],
				'min' => 1,
				'default' => '3000',
			]
		);

		$this->add_control(
			'c_infinite_loop',
			[
				'label' => esc_html__('Infinite Loop', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'c_slide_per_single',
			[
				'label' => esc_html__('Slide per single item', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label' => esc_html__('Center Mode', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'center_info',
			[
				'label' => esc_html__('Show Center Info', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'center_mode' => 'yes' ],
			]
		);

		$this->add_control(
			'variable_width',
			[
				'label' => esc_html__('Variable Width', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);
		
		$this->add_control(
			'freeScroll',
			[
				'label' => esc_html__('FreeScroll', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'use_pagination',
			[
				'label' => esc_html__('Add Pagination control', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
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
						'title' => esc_html__('Circle', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle.png',
					],
					'circle_border' => [
						'title' => esc_html__('Empty Circle', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle_border.png',
					],
					'square' => [
						'title' => esc_html__('Square', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_square.png',
					], 
					'square_border' => [
						'title' => esc_html__('Empty Square', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_square_border.png',
					],    
					'line' => [
						'title' => esc_html__('Line', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line.png',
					],
					'line_circle' => [
						'title' => esc_html__('Line - Circle', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line_circle.png',
					],
				],
				'default' => 'square_border',
			]
		);

		$this->add_control(
			'pag_offset',
			[
				'label' => esc_html__('Pagination Top Offset', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'use_pagination' => 'yes' ],
				'min' => -55,
				'max' => 55,
				'default' => 14,
				'selectors' => [
					'{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'custom_pag_color',
			[
				'label' => esc_html__('Customize Pagination Color', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'use_pagination!' => '' ],
			]
		);

		$this->add_control(
			'pag_color',
			[
				'label' => esc_html__('Pagination Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'condition' => [ 'custom_pag_color' => 'yes' ],
			]
		);

		$this->add_control(
			'use_prev_next',
			[
				'label' => esc_html__('Add Prev/Next buttons', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'prev_next_position',
			[
				'label' => esc_html__('Arrows Positioning', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'use_prev_next' => 'yes' ],
				'options' => [
					'' => esc_html__('Opposite each other', 'carbonick-core'),
					'top_right' => esc_html__('Top right corner', 'carbonick-core'),
				],
			]
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
				'default' => '1025',
			]
		);

		$this->add_control(
			'resp_medium_slides',
			[
				'label' => esc_html__('Columns amount', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
			]
		);

		$this->add_control(
			'heading_tablet',
			[
				'label' => esc_html__('Tablet Settings', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [ 'custom_resp' => 'yes' ],
			]
		);

		$this->add_control(
			'resp_tablets',
			[
				'label' => esc_html__('Tablet Screen Breakpoint', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'default' => '800',
			]
		);

		$this->add_control(
			'resp_tablets_slides',
			[
				'label' => esc_html__('Columns amount', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
			]
		);

		$this->add_control(
			'heading_mobile',
			[
				'label' => esc_html__('Mobile Settings', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'custom_resp' => 'yes' ],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'resp_mobile',
			[
				'label' => esc_html__('Mobile Screen Breakpoint', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'default' => '480',
			]
		);

		$this->add_control(
			'resp_mobile_slides',
			[
				'label' => esc_html__('Columns amount', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  SETTINGS -> QUERY 
		/*-----------------------------------------------------------------------------------*/

		Wgl_Loop_Settings::init(
			$this,
			[
				'post_type' => 'portfolio',
				'hide_cats' => true,
				'hide_tags' => true
			]
		);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'media_style_section',
			[
				'label' => esc_html__('General', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_padding',
			[
				'label' => esc_html__('Description Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 40,
					'right' => 40,
					'bottom' => 19,
					'left' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'description',
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'info_position' => 'under_image' ],
				'selector' => '{{WRAPPER}} .wgl-portfolio-item_description',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => 'rgba('.\Carbonick_Theme_Helper::HexToRGB($h_font_color).', 0.7)' ],
				],
			]
		);

		$this->add_control(
			'custom_image_mask_heading',
			[
				'label' => esc_html__('Item Overlay', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'info_position' => 'inside_image' ],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_image_mask_color',
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 
					'info_position' => 'inside_image',
					'image_anim!' => 'sub_layer',
				],
				'selector' => '{{WRAPPER}} .overlay',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => 'rgba(34, 35, 40, 0.6)' ],
				],
			]
		);
			
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_desc_mask_color',
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 
					'info_position' => 'inside_image',
					'image_anim' => 'sub_layer',
				],
				'selector' => '{{WRAPPER}} .wgl-portfolio-item_description',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => 'rgba(34, 35, 40, 0.6)' ],
				],
			]
		);

		$this->add_control(
			'sec_overlay_color',
			[
				'label' => esc_html__('Additional Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 
					'info_position' => 'inside_image',
					'image_anim' => [ 'offset', 'outline', 'always_info' ],
				],
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .inside_image .overlay:before' => 'box-shadow: inset 0px 0px 0px 0px {{VALUE}}',
					'{{WRAPPER}} .inside_image:hover .overlay:before' => 'box-shadow: inset 0px 0px 0px 10px {{VALUE}}',
					'{{WRAPPER}} .inside_image.offset_animation:before' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> FILTER 
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_filter',
			[
				'label' => esc_html__('Filter', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_filter' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'filter_cats_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 9,
					'right' => 0,
					'bottom' => 9,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'filter_cats_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 17,
					'bottom' => 0,
					'left' => 17,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_filter_cats',
				'selector' => '{{WRAPPER}} .wgl-filter a',
			]
		);

		$this->start_controls_tabs( 'filter_cats_color_tabs' );

		$this->start_controls_tab(
			'filter_cats_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'filter_color_idle',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_bg_idle',
			[
				'label' => esc_html__('Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_cats_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'filter_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wgl-filter a:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_bg_hover',
			[
				'label' => esc_html__('Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_cats_color_active',
			[ 'label' => esc_html__('Active' , 'carbonick-core') ]
		);

		$this->add_control(
			'filter_color_active',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wgl-filter a.active:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_bg_active',
			[
				'label' => esc_html__('Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'filter_cats_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-filter a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'filter_cats_shadow',
				'selector' => '{{WRAPPER}} .wgl-filter a',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> HEADINGS 
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_headings',
			[
				'label' => esc_html__('Headings', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'headings_padding',
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
					'{{WRAPPER}} .portfolio__item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_portfolio_headings',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .title',
			]
		);

		$this->start_controls_tabs( 'headings_color' );

		$this->start_controls_tab(
			'custom_headings_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_headings_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_headings_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'custom_hover_headings_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, .7)',
				'selectors' => [
					'{{WRAPPER}} .title:hover, {{WRAPPER}} .title:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CATEGORIES 
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'cats_style_section',
			[
				'label' => esc_html__('Categories', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_meta_categories!' => '' ],
				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_portfolio_cats',
				'selector' => '{{WRAPPER}} .post_cats',
			]
		);

		$this->start_controls_tabs( 'cats_color_tabs' );

		$this->start_controls_tab(
			'custom_cats_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'cats_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .portfolio-category, {{WRAPPER}} .portfolio-category:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_cats_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'cat_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .portfolio-category:hover, {{WRAPPER}} .portfolio-category:hover:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> First Title
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'first_title_section_style',
			[
				'label' => esc_html__('First Title', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'portfolio_layout' => 'masonry4' ]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'first_title_background',
				'label' => esc_html__( 'Background', 'carbonick-core' ),
				'types' => [ 'classic', 'gradient', 'video', 'slideshow' ],
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => $primary_color ],
				],
				'selector' => '{{WRAPPER}} .first_title .wgl-portfolio-item_wrapper',
				'condition' => [ 'portfolio_layout' => 'masonry4' ]
			]
		);

		$this->add_responsive_control(
			'first_title_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .first_title .wgl-portfolio-item_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => 10,
					'right' => 50,
					'bottom' => 10,
					'left' => 50,
					'unit' => 'px',
				],
				'tablet_default' => [
					'top' => 80,
					'right' => 50,
					'bottom' => 80,
					'left' => 50,
					'unit' => 'px',
				],
				'mobile_default' => [
					'top' => 40,
					'right' => 30,
					'bottom' => 40,
					'left' => 30,
					'unit' => 'px',
				],
				'condition' => [ 'portfolio_layout' => 'masonry4' ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'first_title_title_custom_fonts',
				'selector' => '{{WRAPPER}} .first_title .title',
			]
		);

		$this->add_control(
			'first_title_title_color',
			[
				'label' => esc_html__('Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .first_title .title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'first_title_title_margin',
			[
				'label' => esc_html__('Title Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 36,
					'unit' => 'px',
				],
				'mobile_default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .first_title .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'first_title_sub_title_custom_fonts',
				'selector' => '{{WRAPPER}} .first_title .subtitle',
			]
		);

		$this->add_control(
			'first_title_sub_title_color',
			[
				'label' => esc_html__('Sub Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .first_title .subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'first_title_sub_title_margin',
			[
				'label' => esc_html__('Sub Title Margin', 'carbonick-core'),
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
					'{{WRAPPER}} .first_title .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> First Title Button
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_first_title_button',
			[
				'label' => esc_html__('First Title Button', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'portfolio_layout' => 'masonry4',
					'show_first_title_button' => 'yes'
				]
			]
		);

		$this->start_controls_tabs( 'first_title_tabs_button_style' );
		$this->start_controls_tab(
			'first_title_tab_button_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'first_title_button_text_color',
			[
				'label' => esc_html__('Text Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .first_title a.elementor-button, {{WRAPPER}} .first_title .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'first_title_button_background_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => 'rgba(255,255,255,0)',
				'selectors' => [
					'{{WRAPPER}} .first_title a.elementor-button, {{WRAPPER}} .first_title .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'first_title_button_box_shadow',
				'selector' => '{{WRAPPER}} .first_title .elementor-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'first_title_tab_button_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'first_title_button_hover_color',
			[
				'label' => esc_html__('Text Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .first_title a.elementor-button:hover, {{WRAPPER}} .first_title .elementor-button:hover, {{WRAPPER}} .first_title a.elementor-button:focus, {{WRAPPER}} .first_title .elementor-button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'first_title_button_background_hover_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .first_title a.elementor-button:hover, {{WRAPPER}} .first_title .elementor-button:hover, {{WRAPPER}} .first_title a.elementor-button:focus, {{WRAPPER}} .first_title .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'first_title_button_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .first_title a.elementor-button:hover, {{WRAPPER}} .first_title .elementor-button:hover, {{WRAPPER}} .first_title a.elementor-button:focus, {{WRAPPER}} .first_title .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'first_title_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .first_title .elementor-button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'first_title_border',
				'selector' => '{{WRAPPER}} .first_title .elementor-button',
				'separator' => 'before',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width' => [
						'default' => [
							'top' => 1,
							'right' => 1,
							'bottom' => 1,
							'left' => 1,
						],
					],
					'color' => [ 'default' => 'rgba(255,255,255,.5)' ],
				]
			]
		);

		$this->add_control(
			'first_title_button_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom'=> 0,
					'left'  => 0,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .first_title a.elementor-button, {{WRAPPER}} .first_title_button .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'first_title_text_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 20,
					'right' => 25,
					'bottom'=> 20,
					'left'  => 25,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .first_title_button a.elementor-button, {{WRAPPER}} .first_title_button .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);





		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> EXCERPT/CONTENT 
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Excerpt/Content', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_content!' => '' ],
			]
		);

		$this->add_control(
			'custom_content_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> LOAD MORE 
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'load_more_style_section',
			[
				'label' => esc_html__('Load More', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'navigation' => 'load_more' ],
			]
		);

		$this->add_responsive_control(
			'load_more_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		); 

		$this->add_responsive_control(
			'load_more_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 38,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_load_more',
				'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
			]
		);

		$this->start_controls_tabs( 'load_more_color_tab' );

		$this->start_controls_tab(
			'custom_load_more_color_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'load_more_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_background',
			[
				'label' => esc_html__('Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_load_more_color_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'load_more_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_background_hover',
			[
				'label' => esc_html__('Background', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'load_more_border',
				'label' => esc_html__('Border Type', 'carbonick-core'),
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
				'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
			]
		);

		$this->add_control(
			'load_more_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'load_more_shadow',
				'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> Double Headings
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__('Double Headings', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'double_headings_title_style',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_1_typo',
				'selector' => '{{WRAPPER}} .dbl-title_1',
			]
		);

		$this->add_control(
			'title_1_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .dbl-title_1' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Title Offset', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit'  => 'px',
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .dbl-title_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'double_headings_sub_title_style',
			[
				'label' => esc_html__('Sub Title', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typo',
				'selector' => '{{WRAPPER}} .dbl-subtitle',
				'separator' => 'before',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'separator' => 'after',
				'default' => esc_attr($primary_color),
				'selectors' => [
					'{{WRAPPER}} .dbl-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__('Subtitle Offset', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 4,
					'left' => 0,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .dbl-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GALLERY ICON
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_gallery',
			[
				'label' => esc_html__('Gallery Icon', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'portfolio_icon_type' => 'font' ],
			]
		);

		$this->add_responsive_control(
			'gallery_icon_size',
			[
				'label' => esc_html__('Icon Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 10, 'max' => 100 ],
				],
				'default' => [ 'size' => 20, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gallery_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wgl-portfolio-item_icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gallery_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'gallery_icon_color',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wgl-portfolio-item_icon a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gallery_icon_bg_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'gallery_icon_hover_color',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wgl-portfolio-item_icon:hover a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gallery_icon_bg_hover_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gallery_icon_border_hover_color',
			[
				'label' => esc_html__('Border Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon:hover' => 'border-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'gallery_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 30,
					'right' => 30,
					'bottom' => 30,
					'left' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-portfolio-item_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'gallery_icon_border',
				'selector' => '{{WRAPPER}} .wgl-portfolio-item_icon',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width' => [
						'default' => [
							'top' => 1,
							'right' => 1,
							'bottom' => 1,
							'left' => 1,
						],
					],
					'color' => [ 'default' => '#ffffff' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();
		$portfolio = new WglPortfolio();
		echo $portfolio->render($atts, $this);
	}
	
}