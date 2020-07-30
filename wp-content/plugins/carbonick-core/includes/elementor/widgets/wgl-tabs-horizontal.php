<?php

namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Elementor_Helper;
use WglAddons\Templates\WglToggleAccordion;
use Elementor\Frontend;
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
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;


class Wgl_Tabs_Horizontal extends Widget_Base {
	
	public function get_name() {
		return 'wgl-tabs-horizontal';
	}

	public function get_title() {
		return esc_html__('WGL Tabs Horizontal', 'carbonick-core');
	}

	public function get_icon() {
		return 'wgl-tabs-horizontal';
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
			'section_content_general',
			[ 'label' => esc_html__('General', 'carbonick-core') ]
		);

		$this->add_responsive_control('tabs_tab_align',
			[
				'label' => esc_html__('Alignment', 'carbonick-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__('Left', 'carbonick-core'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'carbonick-core'),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => esc_html__('Right', 'carbonick-core'),
						'icon' => 'fa fa-align-right',
					],
					'space-between' => [
						'title' => esc_html__('Justify', 'carbonick-core'),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'space-between',
				'selectors' => [ '{{WRAPPER}} .wgl-tabs-horizontal_header' => 'justify-content: {{VALUE}}' ],
			]
		);

		$this->add_responsive_control(
			'tabs_heading_width',
			[
				'label' => esc_html__('Heading Width', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 33,
					'unit' => 'vw',
				],
				'size_units' => [ '%', 'vw', 'px' ],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 10,
						'max' => 960,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_headings' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_content',
			[ 'label' => esc_html__('Content', 'carbonick-core') ]
		);

		$this->add_control(
			'tabs_tab',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'tabs_tab_title' => esc_html__('01 &nbsp; Tab Title 1', 'carbonick-core'), ],
					[ 'tabs_tab_title' => esc_html__('02 &nbsp; Tab Title 2', 'carbonick-core'), ],
					[ 'tabs_tab_title' => esc_html__('03 &nbsp; Tab Title 3', 'carbonick-core'), ],
				],
				'fields' => [
					[
						'name' => 'tabs_tab_title',
						'label' => esc_html__('Tab Title', 'carbonick-core'),
						'type' => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__('Tab Title', 'carbonick-core'),
					],
					[
						'name' => 'tabs_tab_prefix',
						'label' => esc_html__('Tab Prefix', 'carbonick-core'),
						'type' => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__('/', 'carbonick-core'),
					],
					[
						'name' => 'tabs_tab_icon_type',
						'label' => esc_html__('Add Icon/Image', 'carbonick-core'),
						'type' => Controls_Manager::CHOOSE,
						'label_block' => false,
						'options' => [
							'' => [
								'title' => esc_html__('None', 'carbonick-core'),
								'icon' => 'fa fa-ban',
							],
							'font' => [
								'title' => esc_html__('Icon', 'carbonick-core'),
								'icon' => 'fa fa-smile-o',
							],
							'image' => [
								'title' => esc_html__('Image', 'carbonick-core'),
								'icon' => 'fa fa-picture-o',
							]
						],
						'default' => 'font',
					],
					[
						'name' => 'tabs_tab_icon_fontawesome',
						'label' => esc_html__('Icon', 'carbonick-core'),
						'type' => Controls_Manager::ICONS,
						'label_block' => true,
						'default' => [
							'value' => 'flaticon flaticon-arrow',
							'library' => 'solid',
						],
						'condition' => [
							'tabs_tab_icon_type'  => 'font',
						],
						'description' => esc_html__('Select icon from Fontawesome library.', 'carbonick-core'),
					],
					[
						'name' => 'tabs_tab_icon_thumbnail',
						'label' => esc_html__('Image', 'carbonick-core'),
						'type' => Controls_Manager::MEDIA,
						'label_block' => true,
						'condition' => [ 'tabs_tab_icon_type' => 'image' ],
						'default' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'name' => 'tabs_content_type',
						'label' => esc_html__('Content Type', 'carbonick-core'),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'content' => esc_html__('Content', 'carbonick-core'),
							'template' => esc_html__('Saved Templates', 'carbonick-core'),
						],
						'default' => 'content',
					],
					[
						'name' => 'tabs_content_templates',
						'label' => esc_html__('Choose Template', 'carbonick-core'),
						'type' => Controls_Manager::SELECT,
						'condition' => [ 'tabs_content_type' => 'template' ],
						'options' => Wgl_Elementor_Helper::get_instance()->get_elementor_templates(),
					],
					[
						'name' => 'tabs_content',
						'label' => esc_html__('Tab Content', 'carbonick-core'),
						'type' => Controls_Manager::WYSIWYG,
						'condition' => [ 'tabs_content_type' => 'content' ],
						'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'carbonick-core'),
						'dynamic' => [ 'active' => true ],
					],
				],
				'title_field' => '{{tabs_tab_title}}',
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

		$this->add_responsive_control(
			'tabs_tab_width',
			[
				'label' => esc_html__('Max Width', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 300,
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 960,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_title_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wgl-tabs-horizontal_title',
			]
		);

		$this->add_control(
			'tabs_title_tag',
			[
				'label' => esc_html__('Title HTML Tag', 'carbonick-core'),
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
				'default' => 'h4',
			]
		);

		$this->add_responsive_control(
			'tabs_title_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '40',
					'right' => '25',
					'bottom' => '40',
					'left' => '25',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_header_tabs' );
	
		$this->start_controls_tab(
			'tabs_header_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			't_title_color_idle',
			[
				'label' => esc_html__('Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
                'default' => '#707070',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_bg_color_idle',
			[
				'label' => esc_html__('Title Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tabs_title_border',
				'selector' => '{{WRAPPER}} .wgl-tabs-horizontal_header_wrap',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_header_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			't_title_color_hover',
			[
				'label' => esc_html__('Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap:hover .wgl-tabs-horizontal_header' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_bg_color_hover',
			[
				'label' => esc_html__('Title Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 't_title_border_hover',
				'selector' => '{{WRAPPER}} .wgl-tabs-horizontal_header_wrap:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			't_header_active',
			[ 'label' => esc_html__('Active', 'carbonick-core') ]
		);

		$this->add_control(
			't_title_color_active',
			[
				'label' => esc_html__('Title Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap.active .wgl-tabs-horizontal_header' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_bg_color_active',
			[
				'label' => esc_html__('Title Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap.active' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 't_title_border_active',
				'selector' => '{{WRAPPER}} .wgl-tabs-horizontal_header_wrap.active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> PREFIX
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_prefix',
			[
				'label' => esc_html__('Prefix', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_prefix_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_prefix_tabs' );
		$this->start_controls_tab(
			'tabs_prefix_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);
		$this->add_control(
			'tabs_prefix_color',
			[
				'label' => esc_html__('Prefix Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#707070',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_prefix' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_prefix_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);
		$this->add_control(
			'tabs_prefix_color_hover',
			[
				'label' => esc_html__('Prefix Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap:hover .wgl-tabs-horizontal_prefix' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_prefix_active',
			[ 'label' => esc_html__('Active', 'carbonick-core') ]
		);
		$this->add_control(
			'tabs_prefix_color_active',
			[
				'label' => esc_html__('Prefix Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap.active .wgl-tabs-horizontal_prefix' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> ICON
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__('Icon', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_icon_size',
			[
				'label' => esc_html__('Icon Size', 'carbonick-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 17,
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_icon:not(.wgl-tabs-horizontal_icon-image)' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_icon_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '15',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->start_controls_tabs( 'tabs_icon_tabs' );
	 
		$this->start_controls_tab(
			'tabs_icon_idle',
			[ 'label' => esc_html__('Idle', 'carbonick-core') ]
		);

		$this->add_control(
			'tabs_icon_color',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#707070',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_hover',
			[ 'label' => esc_html__('Hover', 'carbonick-core') ]
		);

		$this->add_control(
			'tabs_icon_color_hover',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap:hover .wgl-tabs-horizontal_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_active',
			[ 'label' => esc_html__('Active', 'carbonick-core') ]
		);

		$this->add_control(
			'tabs_icon_color_active',
			[
				'label' => esc_html__('Icon Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_header_wrap.active .wgl-tabs-horizontal_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content', 'carbonick-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_content_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wgl-tabs-horizontal_content',
			]
		);

		$this->add_responsive_control(
			'tabs_content_padding',
			[
				'label' => esc_html__('Padding', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_content_margin',
			[
				'label' => esc_html__('Margin', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tabs_content_color',
			[
				'label' => esc_html__('Content Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_content-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tabs_content_bg_color',
			[
				'label' => esc_html__('Content Background Color', 'carbonick-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_content-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tabs_content_border_radius',
			[
				'label' => esc_html__('Border Radius', 'carbonick-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-tabs-horizontal_content-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tabs_content_border',
				'selector' => '{{WRAPPER}} .wgl-tabs-horizontal_content',
			]
		);

		$this->end_controls_section(); 

	}

	protected function render() {
		
		$_s = $this->get_settings_for_display();
		$id_int = substr( $this->get_id_int(), 0, 3 );

		$this->add_render_attribute(
			'tabs',
			[
				'class' => [
					'wgl-tabs-horizontal',
					'tabs_align-'.$_s[ 'tabs_tab_align' ],
				],
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'tabs' ); ?>>

			<div class="wgl-tabs-horizontal_headings"><?php
				foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

					$tab_count = $index + 1;
					$tab_title_key = $this->get_repeater_setting_key( 'tabs_tab_title', 'tabs_tab', $index );
					$this->add_render_attribute(
						$tab_title_key,
						[
							'data-tab-id' => 'wgl-tab_' . $id_int . $tab_count,
							'class' => [ 'wgl-tabs-horizontal_header_wrap' ],
						]
					);
					$item_prefix = !empty($item[ 'tabs_tab_prefix' ]) ? '<span class="wgl-tabs-horizontal_prefix">'.$item[ 'tabs_tab_prefix' ].'</span>' : '';
					?>

                    <div <?php echo $this->get_render_attribute_string( $tab_title_key ); ?>> <<?php echo $_s[ 'tabs_title_tag' ]; ?> class="wgl-tabs-horizontal_header">
						<span class="wgl-tabs-horizontal_title"><?php echo $item_prefix , $item[ 'tabs_tab_title' ] ?></span>

						<?php 
						// Tab Icon/image
						if ( $item[ 'tabs_tab_icon_type' ] != '' ) {
							if ( $item[ 'tabs_tab_icon_type' ] == 'font' && (!empty( $item[ 'tabs_tab_icon_fontawesome' ] )) ) {

								$icon_font = $item[ 'tabs_tab_icon_fontawesome' ];
								$icon_out = '';
	                            // add icon migration 
	                            $migrated = isset( $item['__fa4_migrated'][$item[ 'tabs_tab_icon_fontawesome' ]] );
	                            $is_new = Icons_Manager::is_migration_allowed();
	                            if ( $is_new || $migrated ) {
	                                ob_start();
	                                Icons_Manager::render_icon( $item[ 'tabs_tab_icon_fontawesome' ], [ 'aria-hidden' => 'true' ] );
	                                $icon_out .= ob_get_clean();
	                            } else { 
	                                $icon_out .= '<i class="icon '.esc_attr($icon_font).'"></i>';
	                            }  	

								?>
								<span class="wgl-tabs-horizontal_icon">
									<?php
                                    	echo $icon_out;
                                	?>
								</span>
								<?php
							 }
							if ( $item[ 'tabs_tab_icon_type' ] == 'image' && !empty( $item[ 'tabs_tab_icon_thumbnail' ] ) ) {
								if ( ! empty( $item[ 'tabs_tab_icon_thumbnail' ][ 'url' ] ) ) {
									$this->add_render_attribute( 'thumbnail', 'src', $item[ 'tabs_tab_icon_thumbnail' ][ 'url' ] );
									$this->add_render_attribute( 'thumbnail', 'alt', Control_Media::get_image_alt( $item[ 'tabs_tab_icon_thumbnail' ] ) );
									$this->add_render_attribute( 'thumbnail', 'title', Control_Media::get_image_title( $item[ 'tabs_tab_icon_thumbnail' ] ) );
									?>
									<span class="wgl-tabs-horizontal_icon wgl-tabs-horizontal_icon-image">
									<?php
										echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'tabs_tab_icon_thumbnail' );
									?>
									</span>
									<?php
								}
							}
						}
						// End Tab Icon/image
						?>

					</<?php echo $_s[ 'tabs_title_tag' ]; ?>></div>

				<?php endforeach;?>
			</div>

			<div class="wgl-tabs-horizontal_content-wrap"><?php
				foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

					$tab_count = $index + 1;
					$tab_content_key = $this->get_repeater_setting_key( 'tab_content', 'tabs_tab', $index );
					$this->add_render_attribute(
						$tab_content_key,
						[
							'data-tab-id' => 'wgl-tab_' . $id_int . $tab_count,
							'class' => [ 'wgl-tabs-horizontal_content' ],
						]
					);

					?>
					<div <?php echo $this->get_render_attribute_string( $tab_content_key ); ?>>
					<?php
						if ( $item[ 'tabs_content_type' ] == 'content' ) {
							echo do_shortcode( $item[ 'tabs_content' ] );
						} else if ( $item[ 'tabs_content_type' ] == 'template' ) {
							$id = $item[ 'tabs_content_templates' ];
							$wgl_frontend = new Frontend;
							echo $wgl_frontend->get_builder_content_for_display( $id, false );
						}
					?>
					</div>

				<?php endforeach; ?>
			</div>
			
		</div>
		<?php

	}
	
}