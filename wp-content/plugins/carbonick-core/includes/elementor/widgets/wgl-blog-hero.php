<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglBlogHero;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;


class Wgl_Blog_Hero extends Widget_Base {
	
	public function get_name() {
		return 'wgl-blog-hero';
	}

	public function get_title() {
		return esc_html__('WGL Blog Hero', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-blog-hero';
	}

	public function get_script_depends() {
		return [
			'jquery-slick',
			'jarallax',
			'jarallax-video',
			'imagesloaded',
			'wgl-elementor-extensions-widgets',
		];
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}

	
	protected function _register_controls() {
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
		$tertiary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-tertiary-color'));
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);
		$h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);


		$this->start_controls_section(
			'wgl_blog_section',
			[ 'label' => esc_html__('Settings', 'carbonick-core') ]
		);

		$this->add_control(
			'blog_title',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ]
			]
		);

		$this->add_control(
			'blog_subtitle',
			[
				'label' => esc_html__('Sub Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ]
			]
		);

		$this->add_control(
			'blog_columns',
			[
				'label' => esc_html__('Grid Columns Amount', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'12' => esc_html__('One', 'carbonick-core'),
					'6' => esc_html__('Two', 'carbonick-core'),
					'4' => esc_html__('Three', 'carbonick-core'),
					'3' =>esc_html__('Four', 'carbonick-core')
				],
				'default' => '4',
				'tablet_default' => 'inherit',
				'mobile_default' => '12',
				'frontend_available' => true,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'blog_layout',
			[
				'label' => esc_html__('Layout', 'carbonick-core'),
				'type' => 'wgl-radio-image',
				'options' => [
					'grid' => [
						'title'=> esc_html__('Grid', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
					],
					'masonry' => [
						'title'=> esc_html__('Masonry', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
					],
					'carousel' => [
						'title'=> esc_html__('Carousel', 'carbonick-core'),
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_carousel.png',
					],
				],
				'default' => 'grid',
			]
		); 

		$this->add_control(
			'blog_navigation',
			[
				'label' => esc_html__('Navigation Type', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'blog_layout' => [ 'grid', 'masonry' ] ],
				'options' => [
					'none' => esc_html__('None', 'carbonick-core'),
					'pagination' => esc_html__('Pagination', 'carbonick-core'),
					'load_more' => esc_html__('Load More', 'carbonick-core'),
				],
				'default' => 'none',
			]
		); 

		$this->add_control(
			'blog_navigation_align',
			[
				'label' => esc_html__('Navigation\'s Alignment', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'blog_navigation' => 'pagination' ],
				'options' => [
					'left' => esc_html__('Left', 'carbonick-core'),
					'center' => esc_html__('Center', 'carbonick-core'),
					'right' => esc_html__('Right', 'carbonick-core'),
				],
				'default' => 'left',
			]
		); 
		
		$this->add_control(
			'items_load', 
			[
				'label' => esc_html__('Items to be loaded', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('4', 'carbonick-core'),
				'condition' => [
					'blog_navigation' => 'load_more',
					'blog_layout' => ['grid', 'masonry']
				]
			]
		);

		$this->add_control(
			'name_load_more', 
			[
				'label' => esc_html__('Button Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Load More', 'carbonick-core'),
				'condition' => [
					'blog_navigation' => 'load_more',
					'blog_layout' => ['grid', 'masonry']
				]
			]
		);
		
		$this->add_control(
			'spacer_load_more',
			[
				'label' => esc_html__('Button Spacer Top', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => -20, 'max' => 200 ],
				],
				'size_units' => [ 'px', 'em', 'rem', 'vw' ],
				'condition' => [
					'blog_navigation' => 'load_more',
					'blog_layout' => ['grid', 'masonry']
				],
				'default' => [ 'size' => '30', 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->end_controls_section();

		$this->start_controls_section(
			'display_section',
			[ 'label' => esc_html__('Display', 'carbonick-core') ]
		);

		$this->add_control(
			'hide_media',
			[
				'label' => esc_html__('Hide Media?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_blog_title',
			[
				'label' => esc_html__('Hide Title?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'hide_content',
			[
				'label' => esc_html__('Hide Content?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);
		
		$this->add_control(
			'hide_postmeta',
			[
				'label' => esc_html__('Hide all post-meta?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'meta_author',
			[
				'label' => esc_html__('Hide post-meta author?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'hide_postmeta!' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'meta_comments',
			[
				'label' => esc_html__('Hide post-meta comments?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'hide_postmeta!' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'meta_categories',
			[
				'label' => esc_html__('Hide post-meta categories?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'hide_postmeta!' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'meta_date',
			[
				'label' => esc_html__('Hide post-meta date?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'hide_postmeta!' => 'yes' ],
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);

		$this->add_control(
			'hide_likes',
			[
				'label' => esc_html__('Hide Likes?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'hide_share',
			[
				'label' => esc_html__('Hide Post Share?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'read_more_hide',
			[
				'label' => esc_html__('Hide \'Read More\' button?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => esc_html__('Read More Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'read_more_hide' => '' ],
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__('...and More', 'carbonick-core'),
			]
		);

		$this->start_controls_tabs( 'post_count_tab' );

		$this->start_controls_tab(
			'post_count_tab_idle',
			[ 'label' => esc_html__('Idle' , 'carbonick-core') ]
		);

		$this->add_control(
			'content_letter_count',
			[
				'label' => esc_html__('Characters Amount in Content', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'hide_content' => '' ],
				'min' => 1,
				'step' => 1,
				'default' => '55',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'post_count_tab_hover',
			[ 'label' => esc_html__('Hover' , 'carbonick-core') ]
		);

		$this->add_control(
			'content_letter_count_hover',
			[
				'label' => esc_html__('Characters Amount in Content', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'hide_content' => '' ],
				'min' => 1,
				'step' => 1,
				'default' => '155',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'crop_square_img',
			[
				'label' => esc_html__('Crop Images for Posts List?', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__('For correctly work uploaded image size should be larger than 700px height and width.', 'text-domain' ),
			]
		);
	   
		$this->end_controls_section();

		$this->start_controls_section(
			'wgl_carousel_section',
			[
				'label' => esc_html__('Carousel Options', 'carbonick-core'),
				'condition' => [ 'blog_layout' => 'carousel' ]
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
				'step' => 1,
				'default' => '3000',
			]
		);
		
		$this->add_control(
			'use_pagination',
			[
				'label' => esc_html__('Add Pagination control', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
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
						'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line_circle.png',
					],                    
				],
				'default' => 'line',
			]
		); 

		$this->add_control(
			'pag_offset',
			[
				'label' => esc_html__('Pagination Top Offset', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'use_pagination' => 'yes' ],
				'min' => 1,
				'step' => 1,
				'default' => 5,
				'selectors' => [
					'{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'custom_pag_color',
			[
				'label' => esc_html__('Custom Pagination Color', 'carbonick-core'),
				
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			]
		); 

		$this->add_control(
			'pag_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($primary_color),
				'condition' => [
					'custom_pag_color' => 'yes',
				]
			]
		);

		$this->add_control(
			'use_navigation',
			[
				'label' => esc_html__('Add Navigation control', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		); 


		$this->add_control(
			'custom_resp',
			[
				'label' => esc_html__('Customize Responsive', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'heading_desktop',
			[
				'label' => esc_html__('Desktop Settings', 'carbonick-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [ 'custom_resp' => 'yes' ],
			]
		);

		$this->add_control(
			'resp_medium',
			[
				'label' => esc_html__('Desktop Screen Breakpoint', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => '1025',
				'min' => 1,
				'step' => 1,
				'condition' => [ 'custom_resp' => 'yes' ],
			]
		); 

		$this->add_control(
			'resp_medium_slides',
			[
				'label' => esc_html__('Slides to show', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'condition' => [ 'custom_resp' => 'yes' ],
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
				'default' => '800',
				'min' => 1,
				'step' => 1,
				'condition' => [ 'custom_resp' => 'yes' ],
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
				'default' => '480',
				'min' => 1,
			]
		); 

		$this->add_control(
			'resp_mobile_slides',
			[
				'label' => esc_html__('Slides to show', 'carbonick-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
			]
		); 

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  Build Query Section 
		/*-----------------------------------------------------------------------------------*/

		Wgl_Loop_Settings::init(
			$this,
			[ 'post_type' => 'post' ]
		);

		/*-----------------------------------------------------------------------------------*/
		/*  Style Section(Headings Section)
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'headings_style_section',
			[
				'label' => esc_html__('Headings', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label' => esc_html__('Heading tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
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
			'heading_margin',
			[
				'label' => esc_html__('Heading margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .blog-post_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .blog-post-hero-content_front .blog-post_title a' => 'color: {{VALUE}};',
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
				'default' => esc_attr($h_font_color),
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_back .blog-post_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_blog_headings',
				'selector' => '{{WRAPPER}} .blog-post_title, {{WRAPPER}} .blog-post_title > a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => esc_html__('Content', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 16,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .blog-post_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_content_color' );

		$this->start_controls_tab(
			'tab_content_color_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'custom_content_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_front .blog-post_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_content_color_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'custom_content_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($main_font_color),
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_back .blog-post_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_blog_content',
				'selector' => '{{WRAPPER}} .blog-post_text',
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'meta_info_style_section',
			[
				'label' => esc_html__('Meta Info', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'meta_info_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '',
					'left' => '',
					'right' => '',
					'bottom' => '',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .blog-post .blog-post-hero_content .meta-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_meta_info' );

		$this->start_controls_tab(
			'tab_meta_info_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'custom_main_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_front .blog-post-hero_content .post_meta-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'custom_main_bgcolor',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($primary_color),
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_front .blog-post-hero_content .post_meta-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_meta_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'custom_main_color_hover',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d5a3c',
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_back .blog-post-hero_content .post_meta-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'custom_main_bgcolor_hover',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#f9f7f3',
				'selectors' => [
					'{{WRAPPER}} .blog-post-hero-content_back .blog-post-hero_content .post_meta-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'media_style_section',
			[
				'label' => esc_html__('Media', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'custom_blog_mask',
			[
				'label' => esc_html__('Custom Image Idle Overlay', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_image_mask_color',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient', 'video' ],
				'condition' => [ 'custom_blog_mask' => 'yes' ],
				'default' => 'rgba( '.\Carbonick_Theme_Helper::hexToRGB($h_font_color).',0.1)',
				'selector' => '{{WRAPPER}} .blog-post_bg_media:after',
			]
		);

		$this->add_control(
			'custom_blog_hover_mask',
			[
				'label' => esc_html__('Custom Image Hover Overlay', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_image_hover_mask_color',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient', 'video' ],
				'condition' => [ 'custom_blog_hover_mask' => 'yes' ],
				'default' => 'rgba(50,50,50,1)',
				'selector' => '{{WRAPPER}} .blog-post .blog-post_bg_media:after',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'without_media_style_section',
			[
				'label' => esc_html__('Without Media', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'custom_standard_headings_color',
			[
				'label' => esc_html__('Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($h_font_color),
				'selectors' => [
					'{{WRAPPER}} .blog-post.format-no_featured .blog-post_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_meta_color',
			[ 'type' => Controls_Manager::DIVIDER ]
		);

		$this->add_control(
			'custom_meta_standard_color',
			[
				'label' => esc_html__('Meta Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d5a3c',
				'selectors' => [
					'{{WRAPPER}} .format-no_featured .blog-post-hero_content .post_meta-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_content_color',
			[ 'type' => Controls_Manager::DIVIDER ]
		);

		$this->add_control(
			'custom_standard_content_color',
			[
				'label' => esc_html__('Content Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($main_font_color),
				'selectors' => [
					'{{WRAPPER}} .format-standard.format-no_featured .blog-post_text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .format-link.format-no_featured .blog-post_text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .format-video.format-no_featured .blog-post_text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .format-gallery.format-no_featured .blog-post_text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .format-quote.format-no_featured .blog-post_text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .format-audio.format-no_featured .blog-post_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_bg_color',
			[ 'type' => Controls_Manager::DIVIDER ]
		);


		$this->add_control(
			'custom_blog_bg_item',
			[
				'label' => esc_html__('Custom Items Background', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_bg_color',
				'label' => esc_html__('Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient', 'video' ],
				'condition' => [ 'custom_blog_bg_item' => 'yes' ],
				'default' => 'rgba(247,247,247,1)',
				'selector' => '{{WRAPPER}} .blog-style-hero .blog-post-hero_wrapper',
			]
		);

		$this->add_control(
			'custom_blog_bg_item_hover',
			[
				'label' => esc_html__('Custom Items Hover Background', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_bg_color_hover',
				'label' => esc_html__('Hover Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient', 'video' ],
				'condition' => [ 'custom_blog_bg_item_hover' => 'yes' ],
				'default' => 'rgba(247,247,247,1)',
				'selector' => '{{WRAPPER}} .blog-style-hero .blog-post-hero_wrapper:hover',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		$blog = new WglBlogHero();
		$blog->render($atts);
	}
}