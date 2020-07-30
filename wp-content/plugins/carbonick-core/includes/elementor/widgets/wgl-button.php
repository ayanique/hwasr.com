<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglButton;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;


class Wgl_Button extends Widget_Base
{
	
	public function get_name() {
		return 'wgl-button';
	}

	public function get_title() {
		return esc_html__('WGL Button', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-button';
	}

	public function get_categories() {
		return [ 'wgl-extensions' ];
	}

	public static function get_button_sizes()
	{
		return [
			'sm' => esc_html__('Small', 'carbonick-core'),
			'md' => esc_html__('Medium', 'carbonick-core'),
			'lg' => esc_html__('Large', 'carbonick-core'),
			'xl' => esc_html__('Extra Large', 'carbonick-core'),
		];
	}

	
	
	protected function _register_controls()
	{
		$primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
		$h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'wgl_button_section',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);

		$this->add_control(
			'text',
			[
				'label' => esc_html__('Text', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__('Learn More', 'carbonick-core'),
				'placeholder' => esc_html__('Learn More', 'carbonick-core'),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__('Link', 'carbonick-core'),
				'type' => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'placeholder' => esc_html__('https://your-link.com', 'carbonick-core'),
				'default' => [ 'url' => '#' ],
			]
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
					'justify' => [
						'title' => esc_html__('Justified', 'carbonick-core'),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => esc_html__('Size', 'carbonick-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'lg',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => esc_html__('Button ID', 'carbonick-core'),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__('Add your custom id WITHOUT the Pound key. e.g: my-id', 'carbonick-core'),
				'separator' => 'before',
				'dynamic' => [ 'active' => true ],
				'label_block' => false,
				'default' => '',
				'description' => esc_html__('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows [A-z _ 0-9] chars without spaces.', 'carbonick-core'),
			]
		);

		$this->end_controls_section();
		
		$output[ 'icon_align' ] = [
			'label' => esc_html__('Icon Position', 'carbonick-core'),
			'type' => Controls_Manager::SELECT,
			'condition' => [ 'icon_type!' => '' ],
			'options' => [
				'left' => esc_html__('Before', 'carbonick-core'),
				'right' => esc_html__('After', 'carbonick-core'),
			],
			'default' => 'left',
		];

		$output[ 'icon_indent' ] = [
			'label' => esc_html__('Icon Spacing', 'carbonick-core'),
			'type' => Controls_Manager::SLIDER,
			'condition' => [ 'icon_type!' => '' ],
			'range' => [
				'px' => [ 'max' => 50 ],
			],
			'default' => [ 'size' => '0', 'unit' => 'px' ],
			'selectors' => [
				'{{WRAPPER}} .elementor-button .elementor-align-icon-right .elementor-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .elementor-button .elementor-align-icon-left .elementor-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
			],
		];

		Wgl_Icons::init(
			$this,
			[
				'output' => $output,
				'section' => true,
			]
		);


		/*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BUTTON
        /*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__('Button', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__('Hover Animation', 'carbonick-core'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
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
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
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
			'button_hover_color',
			[
				'label' => esc_html__('Text Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => esc_html__('Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'border_border!' => '' ],
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
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
			'button_border_radius',
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
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ICON
        /*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'icon_section_style',
			[
				'label' => esc_html__('Icon', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style_icon' );

		$this->start_controls_tab(
			'tab_button_normal_icon',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'color_icon',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover_icon',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'hover_color_icon',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__('Icon Font Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'icon_type' => 'font' ],
				'separator' => 'before',
				'size_units' => [ 'px', 'em', 'rem', 'vw' ],
				'range' => [
					'px' => [ 'max' => 90 ],
				],
				'default' => [ 'size' => '13', 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}
	
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		
		echo Wgl_Button::init_button($this, $settings);
	}

	public static function init_button($self, $settings)
	{

		$self->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings[ 'link' ][ 'url' ] ) ) {
			$self->add_link_attributes( 'button', $settings['link'] );
			$self->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

		$self->add_render_attribute( 'button', 'class', 'wgl-button elementor-button' );
		$self->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings[ 'button_css_id' ] ) ) {
			$self->add_render_attribute( 'button', 'id', $settings[ 'button_css_id' ] );
		}

		if ( ! empty( $settings[ 'size' ] ) ) {
			$self->add_render_attribute( 'button', 'class', 'button-size-' . $settings[ 'size' ] );
		}

		if ( isset($settings[ 'hover_animation' ]) ) {
			$self->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings[ 'hover_animation' ] );
		}

		$settings_icon_align = isset($settings[ 'icon_align' ]) ? $settings[ 'icon_align' ] : '';

		$self->add_render_attribute( [
			'content-wrapper' => [
				'class' => [
					'elementor-button-content-wrapper',
					'elementor-align-icon-' . $settings_icon_align,
				]
			],
			'wrapper' => [
				'class' => 'elementor-button-icon',
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		?>
		<div <?php echo $self->get_render_attribute_string( 'wrapper' );?>>
			<a <?php echo $self->get_render_attribute_string( 'button' );?>><?php
			if ( !empty($settings[ 'text' ]) || !empty($settings[ 'icon_type' ]) ) {?>
				<div <?php echo $self->get_render_attribute_string( 'content-wrapper' );?>>
					<?php
					if ( ! empty( $settings[ 'icon_type' ] ) ) : 
						$icons = new Wgl_Icons;
						$button_icon_out = $icons->build($self, $settings, []);
						echo \Carbonick_Theme_Helper::render_html($button_icon_out);
					endif;
					?>
					<span <?php echo $self->get_render_attribute_string( 'text' );?>><?php echo $settings[ 'text' ]; ?></span>
				</div><?php
			}
			?></a>
		</div>
		<?php

	}
}