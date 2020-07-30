<?php
namespace WglAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;


defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class Wgl_Video_Popup extends Widget_Base {
	
	public function get_name() {
		return 'wgl-video-popup';
	}

	public function get_title() {
		return esc_html__('WGL Video Popup', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-video-popup';
	}
 
	public function get_categories() {
		return [ 'wgl-extensions' ];
	}

	
	
	protected function _register_controls() {
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);
		$header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
		
		/*-----------------------------------------------------------------------------------*/
		/*  Content
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_video_popup_section',
			array(
				'label' => esc_html__('Video Popup Settings', 'carbonick-core'),
			)
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__('Subtitle', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__('Video Link', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('Enter your URL', 'carbonick-core'),
				'description' => esc_html__('Enter video link from youtube or vimeo.', 'carbonick-core'),
				'default' => 'https://www.youtube.com/watch?v=TKnufs85hXk',
				'label_block' => true,
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'title_pos',
			array(
				'label' => esc_html__('Title Position', 'carbonick-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'carbonick-core'),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__('Right', 'carbonick-core'),
						'icon' => 'eicon-h-align-right',
					],
					'bot' => [
						'title' => esc_html__('Bottom', 'carbonick-core'),
						'icon' => 'eicon-v-align-bottom',
					],
					'left' => [
						'title' => esc_html__('Left', 'carbonick-core'),
						'icon' => 'eicon-h-align-left',
					],
				],
				'label_block' => false,
				'default' => 'bot',
				'toggle' => true,
			)
		);

		$this->add_responsive_control(
			'button_pos',
			[
				'label' => esc_html__('Button Alignment', 'carbonick-core'),
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
					'inline' => [
						'title' => esc_html__('Inline', 'carbonick-core'),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'default' => 'center',
			]
		);
		
		$this->add_control(
			'bg_image',
			[
				'label' => esc_html__('Background Image', 'carbonick-core'),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'description' => esc_html__('Select video background image.', 'carbonick-core'),
				'separator' => 'after',
			]
		);

		$this->add_control(
			'animation_style',
			[
				'label' => esc_html__('Select Animation Style', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__('Default', 'carbonick-core'),
					'circles' => esc_html__('Pulsing Circles', 'carbonick-core'),
					'ring_pulse' => esc_html__('Pulsing Ring', 'carbonick-core'),
					'ring_rotate' => esc_html__('Rotating Ring', 'carbonick-core'),
				],
				'default' => 'triangle',
			]
		);

		$this->add_control(
			'always_run_animation',
			array(
				'label' => esc_html__('Always Run Animation', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'description'  => esc_html__('Run until hover state.', 'carbonick-core'),
				'return_value' => 'yes',
				'condition' => ['animation_style!' => 'default'],
			)
		);

		$this->end_controls_section(); 

		/*-----------------------------------------------------------------------------------*/
		/*  Styles options
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__('Title Styles', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'   => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'selector' => '{{WRAPPER}} .title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'subtitle_style',
			[
				'label' => esc_html__('Subitle Styles', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'   => [
					'top' => 23,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typo',
				'selector' => '{{WRAPPER}} .subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__('Subtitle Tag', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'div',
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'button_style',
			[
				'label' => esc_html__('Button Styles', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .videobox_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => esc_html__('Button Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'default' => [
					'size' => 62,
					'unit' => 'px',
				],
				'description' => esc_html__('Enter button diameter in pixels.', 'carbonick-core'),
				'selectors' => [
					'{{WRAPPER}} .videobox_link' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .videobox_link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color',
				'label' => esc_html__('Button Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .videobox_link',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => "#ffffff" ],
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name' => 'button_border',
				'label' => esc_html__('Border Type', 'carbonick-core'),
				'selector' => '{{WRAPPER}} .videobox_link',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow',
				'selector' =>  '{{WRAPPER}} .videobox_link',
			]
		);

		$this->add_control(
			'triangle_color',
			[
				'label' => esc_html__('Triangle Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .videobox_icon' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'anim_color',
			[
				'label' => esc_html__('Animation Circles Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .videobox_animation' => 'color: {{VALUE}};',
				],
				'condition' => ['animation_style!' => 'default'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_hover',
				'label' => esc_html__('Button Background', 'carbonick-core'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .videobox_link:hover',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => $header_font_color ],
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name' => 'button_border_hover',
				'label' => esc_html__('Border Type', 'carbonick-core'),
				'selector' => '{{WRAPPER}} .videobox_link:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow_hover',
				'selector' =>  '{{WRAPPER}} .videobox_link:hover',
			]
		);

		$this->add_control(
			'triangle_color_hover',
			[
				'label' => esc_html__('Triangle Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .videobox_link:hover .videobox_icon' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'anim_color_hover',
			[
				'label' => esc_html__('Animation Circles Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .videobox_link:hover .videobox_animation' => 'color: {{VALUE}};',
				],
				'condition' => ['animation_style!' => 'default'],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'triangle_size',
			[
				'label' => esc_html__('Triangle Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .videobox_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'triangle_corners',
			array(
				'label' => esc_html__('Rounded Corners', 'carbonick-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'carbonick-core'),
				'label_off' => esc_html__('Off', 'carbonick-core'),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		// Enqueue swipebox script
		wp_enqueue_script('jquery-swipebox', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', array(), false, false);
		wp_enqueue_style('jquery-swipebox', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');

		$settings = $this->get_settings_for_display();
		$triangle_svg = $animated_element = '';

		$this->add_render_attribute( 'video-wrap', [
			'class' => [
				'wgl-video_popup',
				'button_align-'.$settings[ 'button_pos' ],
				'button_align-tablet-'.$settings['button_pos_tablet'],
				'button_align-mobile-'.$settings['button_pos_mobile'],
				'animation_'.$settings[ 'animation_style' ],
				'title_pos-'.$settings[ 'title_pos' ],
				!empty($settings[ 'bg_image' ][ 'url' ]) ? 'with_image' : '',
				(bool)$settings[ 'always_run_animation' ] ? 'always-run-animation' : '',
			],
		] );

		// Animation element output
		switch ($settings[ 'animation_style' ]) {
			case 'circles':
				$animated_element .= '<div class="videobox_animation circle_1"></div>';
				$animated_element .= '<div class="videobox_animation circle_2"></div>';
				$animated_element .= '<div class="videobox_animation circle_3"></div>';	
				break;
			case 'ring_pulse':
				$animated_element .= '<div class="videobox_animation ring_1"></div>';
				break;
			case 'ring_rotate':
				$svg_ring_circle_color = !empty($settings[ 'anim_color' ]) ? 'rgba('.\Carbonick_Theme_Helper::HexToRGB($settings[ 'anim_color' ]).', 0.1)' : 'rgba(0,0,0,0.1)';
				$svg_ring = '<svg class="ring_1" viewBox="0 0 202 202">';
					$svg_ring .= '<g fill="none" stroke-width="1">';
						$svg_ring .= '<circle stroke="'.$svg_ring_circle_color.'" cx="101" cy="101" r="100"/>';
						$svg_ring .= '<path stroke="'.esc_attr($settings[ 'anim_color' ]).'" d="M74,197.3c-33.5-9.4-59.9-35.8-69.3-69.2"/>';
						$svg_ring .= '<path stroke="'.esc_attr($settings[ 'anim_color' ]).'" d="M128,4.7c33.5,9.4,59.9,35.8,69.3,69.3"/>';
					$svg_ring .= '</g>';
				$svg_ring .= '</svg>';
				$animated_element .= '<div class="videobox_animation">';
				$animated_element .= $svg_ring;
				$animated_element .= '</div>';
				break;
			case 'default':
				$animated_element .= '<div class="videobox_animation default_animation"></div>';
				break;
		}

		// Triangle svg output
		switch ($settings[ 'triangle_corners' ]) {
			case false:
				$triangle_svg .= '<svg class="videobox_icon" viewBox="0 0 10 10"><polygon points="1,0 1,10 8.5,5"/></svg>';
				break;
			case true:
				$triangle_svg .= '<svg class="videobox_icon" viewBox="0 0 232 232"><path d="M203,99L49,2.3c-4.5-2.7-10.2-2.2-14.5-2.2 c-17.1,0-17,13-17,16.6v199c0,2.8-0.07,16.6,17,16.6c4.3,0,10,0.4,14.5-2.2 l154-97c12.7-7.5,10.5-16.5,10.5-16.5S216,107,204,100z"/></svg>';
				break;
		}

		// Render html
		$uniqrel = uniqid();

		$output = '<div '.($this->get_render_attribute_string( 'video-wrap' )).'>';
			$output .= '<div class="videobox_content">';
				$output .= !empty($settings[ 'bg_image' ][ 'url' ]) ? '<div class="videobox_background">'.wp_get_attachment_image( $settings[ 'bg_image' ][ 'id' ] , 'full' ).'</div>' : '';
				$output .= !empty($settings[ 'bg_image' ][ 'url' ]) ? '<div class="videobox_link_wrapper">' : '';
				$output .= !empty($settings[ 'title' ]) ? '<'.$settings[ 'title_tag' ].' class="title">'.esc_html__($settings[ 'title' ]).'</'.$settings[ 'title_tag' ].'>' : '';
				$output .= '<a data-rel="youtube-'.esc_attr($uniqrel).'" class="videobox_link videobox" href="'.(!empty($settings[ 'link' ]) ? esc_url($settings[ 'link' ]) : '#').'">';
					$output .= !empty($settings[ 'subtitle' ]) ? '<'.$settings[ 'subtitle_tag' ].' class="subtitle">'.esc_html__($settings[ 'subtitle' ]).'</'.$settings[ 'subtitle_tag' ].'>' : '';
					$output .= $triangle_svg;
					$output .= $animated_element;
				$output .= '</a>';
				$output .= !empty($settings[ 'bg_image' ][ 'url' ]) ? '</div>' : '';
			$output .= '</div>';
		$output .= '</div>';

		echo \Carbonick_Theme_Helper::render_html($output);

	}
	
}