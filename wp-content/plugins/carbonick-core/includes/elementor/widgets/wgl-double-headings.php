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

class Wgl_Double_Headings extends Widget_Base {
	
	public function get_name() {
		return 'wgl-double-headings';
	}

	public function get_title() {
		return esc_html__('WGL Double Headings', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-double-headings';
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
			'wgl_double_headings_section',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
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
				'default' => esc_html__('/ Subtitle', 'carbonick-core'),
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
				'default' => esc_html__('This is the heading​', 'carbonick-core'),
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

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> SUB TITLE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_subtitle',
			[
				'label' => esc_html__('Subtitle', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'subtitle!'  => '' ],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typo',
				'selector' => '{{WRAPPER}} .dbl-subtitle',
				'condition' => [ 'subtitle!'  => '' ],
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__('Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'subtitle!'  => '' ],
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
					'top' => '0',
					'right' => '0',
					'bottom' => '5',
					'left' => '0',
					'unit'  => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .dbl-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		self::init_double_headings($this);
	}

	public static function init_double_headings($self)
	{
		
		$_s = $self->get_settings_for_display();
		if (! empty($_s[ 'link_double_headings' ][ 'url' ])) {
			$self->add_link_attributes( 'link', $_s['link_double_headings'] );
		}

		$self->add_render_attribute(
			'heading_wrapper',
			[
				'class' => [
					'wgl-double_heading',
					'a'.$_s[ 'align_double_headings' ],
				],
			]
		);

		?><div <?php echo $self->get_render_attribute_string( 'heading_wrapper' );?>><?php
			if (! empty($_s[ 'subtitle' ]) ) : ?><div class="dbl-subtitle"><span><?php echo $_s[ 'subtitle' ]; ?></span></div><?php endif;
			if (! empty($_s[ 'link_double_headings' ][ 'url' ]) ) : ?><a <?php echo $self->get_render_attribute_string( 'link' );?>><?php endif;?>
				<<?php echo $_s[ 'title_tag' ]; ?> class="dbl-title_wrapper"><?php
				if (! empty($_s[ 'title_1' ]) ) : ?><span class="dbl-title dbl-title_1"><?php echo $_s[ 'title_1' ]; ?></span> <?php endif;?>
				</<?php echo $_s[ 'title_tag' ]; ?>><?php
			if (! empty($_s[ 'link_double_headings' ][ 'url' ]) ) : ?></a><?php endif;?>
		</div><?php
	}
}