<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use WglAddons\Includes\Wgl_Elementor_Helper;


defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class Wgl_Clients extends Widget_Base {

    public function get_name() {
        return 'wgl-clients';
    }

    public function get_title() {
        return esc_html__('WGL Clients', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-clients';
    }

    public function get_script_depends() {
        return [
            'jquery-slick',
        ];
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }


	protected function _register_controls() {
		$theme_color       = esc_attr( \Carbonick_Theme_Helper::get_option( 'theme-primary-color' ) );
		$main_font_color   = esc_attr( \Carbonick_Theme_Helper::get_option( 'main-font' )['color'] );
		$header_font_color = esc_attr( \Carbonick_Theme_Helper::get_option( 'header-font' )['color'] );

		/*-----------------------------------------------------------------------------------*/
		/*  Content
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section( 'wgl_clients_section',
			array(
				'label' => esc_html__( 'Clients Settings', 'carbonick-core' ),
			)
		);

		$this->add_responsive_control( 'item_grid',
			array(
				'label'   => esc_html__( 'Columns Amount', 'carbonick-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'One Column', 'carbonick-core' ),
					'2' => esc_html__( 'Two Columns', 'carbonick-core' ),
					'3' => esc_html__( 'Three Columns', 'carbonick-core' ),
					'4' => esc_html__( 'Four Columns', 'carbonick-core' ),
					'5' => esc_html__( 'Five Columns', 'carbonick-core' ),
					'6' => esc_html__( 'Six Columns', 'carbonick-core' ),
					'7' => esc_html__( 'Seven Columns', 'carbonick-core' ),
					'8' => esc_html__( 'Eight Columns', 'carbonick-core' ),
				],
				'default' => '4',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'thumbnail',
			array(
				'label'       => esc_html__( 'Thumbnail', 'carbonick-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			)
		);

		$repeater->add_control(
			'hover_thumbnail',
			array(
				'label'       => esc_html__( 'Hover Thumbnail', 'carbonick-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => '',
				],
				'description' => esc_html__( 'Need for \'Exchange Images\' and \'Shadow\' animations only.', 'carbonick-core' ),
			)
		);

		$repeater->add_control( 'client_link',
			array(
				'label'       => esc_html__( 'Add Link', 'carbonick-core' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
			)
		);

		$this->add_control(
			'list',
			array(
				'label'  => esc_html__( 'Items', 'carbonick-core' ),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			)
		);

		$this->add_control( 'item_anim',
			array(
				'label'   => esc_html__( 'Thumbnail Animation', 'carbonick-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'          => esc_html__( 'None', 'carbonick-core' ),
					'grayscale'     => esc_html__( 'Grayscale', 'carbonick-core' ),
					'opacity'       => esc_html__( 'Opacity', 'carbonick-core' ),
					'zoom'          => esc_html__( 'Zoom', 'carbonick-core' ),
					'contrast'      => esc_html__( 'Contrast', 'carbonick-core' ),
					'blur'          => esc_html__( 'Blur', 'carbonick-core' ),
					'invert'        => esc_html__( 'Invert', 'carbonick-core' ),
					'ex_images'     => esc_html__( 'Exchange Images', 'carbonick-core' ),
					'ex_images_ver' => esc_html__( 'Exchange Images Vertical', 'carbonick-core' ),
					'ex_images_bg'  => esc_html__( 'Exchange Images with Background', 'carbonick-core' ),
				],
				'default' => 'ex_images_ver',
			)
		);

		$this->add_responsive_control(
			'height',
			array(
				'label'           => esc_html__( 'Custom Items Height', 'carbonick-core' ),
				'type'            => Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 50,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 238,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 200,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 180,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .clients_image' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'       => [
					'item_anim' => 'ex_images_bg',
				],
			)
		);

		$this->add_control(
			'item_align',
			array(
				'label'       => esc_html__( 'Alignment', 'carbonick-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'carbonick-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'carbonick-core' ),
						'icon'  => 'fa fa-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'carbonick-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'label_block' => false,
				'default'     => 'center',
				'toggle'      => true,
				'selectors'   => [
					'{{WRAPPER}} .clients_image' => 'justify-content: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'item_align_v',
			array(
				'label'       => esc_html__( 'Vertical Alignment', 'carbonick-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'carbonick-core' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'carbonick-core' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'carbonick-core' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'label_block' => false,
				'default'     => 'center',
				'toggle'      => true,
				'selectors'   => [
					'{{WRAPPER}} .wgl-clients' => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .slick-track' => 'align-items: {{VALUE}}; display: flex;',
				],
			)
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Carousel options
		/*-----------------------------------------------------------------------------------*/

		Wgl_Carousel_Settings::options( $this );

		/*-----------------------------------------------------------------------------------*/
		/*  Carousel styles
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Carousel', 'carbonick-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'carbonick-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .image_wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .image_wrapper img',
			]
		);

		$this->add_responsive_control(
			'slick_margin',
			[
				'label'      => esc_html__( 'Margin', 'carbonick-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Carousel Items styles
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'items_style',
			[
				'label'     => esc_html__( 'Items', 'carbonick-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'item_anim' => 'ex_images_bg',
				],
			]
		);

		$this->start_controls_tabs( 'item_colors_style' );

		$this->start_controls_tab(
			'item_colors',
			[
				'label' => esc_html__( 'Idle', 'carbonick-core' ),
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .clients_image' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_hover',
			[
				'label' => esc_html__( 'Hover', 'carbonick-core' ),
			]
		);

		$this->add_control(
			'hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'carbonick-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .clients_image:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'label'    => esc_html__( 'Border Type', 'carbonick-core' ),
				'selector' => '{{WRAPPER}} .clients_image',
			)
		);

		$this->end_controls_section();

	}

    protected function render() {

        $content = '';
        $carousel_options = array();
        $settings = $this->get_settings_for_display();
        extract($settings);

	    if ( (bool) $use_carousel ) {
		    // carousel options array
		    $carousel_options = array(
			    'slide_to_show'          => $item_grid,
			    'autoplay'               => $autoplay,
			    'autoplay_speed'         => $autoplay_speed,
			    'fade_animation'         => $fade_animation,
			    'slides_to_scroll'       => $slides_to_scroll,
			    'infinite'               => true,
			    'rtl'                    => true,
			    'use_pagination'         => $use_pagination,
			    'pag_type'               => $pag_type,
			    'pag_offset'             => $pag_offset,
			    'pag_align'              => $pag_align,
			    'custom_pag_color'       => $custom_pag_color,
			    'pag_color'              => $pag_color,
			    'use_prev_next'          => $use_prev_next,
			    'prev_next_position'     => $prev_next_position,
			    'custom_prev_next_color' => $custom_prev_next_color,
			    'prev_next_color'        => $prev_next_color,
			    'prev_next_color_hover'  => $prev_next_color_hover,
			    'prev_next_bg_idle'      => $prev_next_bg_idle,
			    'prev_next_bg_hover'     => $prev_next_bg_hover,
			    'custom_resp'            => $custom_resp,
			    'resp_medium'            => $resp_medium,
			    'resp_medium_slides'     => $resp_medium_slides,
			    'resp_tablets'           => $resp_tablets,
			    'resp_tablets_slides'    => $resp_tablets_slides,
			    'resp_mobile'            => $resp_mobile,
			    'resp_mobile_slides'     => $resp_mobile_slides,
		    );

		    wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/js/slick.min.js', array(), false, false );
		}

		$carousel_id = uniqid( "carbonick_carousel_" );

		$tablet_width = get_option('elementor_viewport_lg');
		$tablet_width = ! empty($tablet_width) ? $tablet_width : '1025';
		
		$mobile_width = get_option('elementor_viewport_md');
		$mobile_width = ! empty($mobile_width) ? $mobile_width : '768';

		// Custom styles

		$styles = '';

		if($slick_margin['top'] !== ''){
			$styles .= "#$carousel_id .slick-list{
				margin-top:".$slick_margin['top'].$slick_margin['unit'].";
				margin-right:".$slick_margin['right'].$slick_margin['unit'].";
				margin-bottom:".$slick_margin['bottom'].$slick_margin['unit'].";
				margin-left:".$slick_margin['left'].$slick_margin['unit'].";
			}";			
		}

		if($slick_margin_tablet['top'] !== ''){
			$styles .= "@media (max-width: ".(int) $tablet_width."px) { 
				#$carousel_id .slick-list{
					margin-top:".$slick_margin_tablet['top'].$slick_margin_tablet['unit'].";
					margin-right:".$slick_margin_tablet['right'].$slick_margin_tablet['unit'].";
					margin-bottom:".$slick_margin_tablet['bottom'].$slick_margin_tablet['unit'].";
					margin-left:".$slick_margin_tablet['left'].$slick_margin_tablet['unit'].";
				}
			}";
		}
		
		if($slick_margin_mobile['top'] !== ''){
			$styles .= "@media (max-width: ".(int) $mobile_width."px) {
				#$carousel_id .slick-list{ 
					margin-top:".$slick_margin_mobile['top'].$slick_margin_mobile['unit'].";
					margin-right:".$slick_margin_mobile['right'].$slick_margin_mobile['unit'].";
					margin-bottom:".$slick_margin_mobile['bottom'].$slick_margin_mobile['unit'].";
					margin-left:".$slick_margin_mobile['left'].$slick_margin_mobile['unit'].";
				}
			}";
		}

		Wgl_Elementor_Helper::enqueue_css($styles);


        $this->add_render_attribute( 'clients', [
			'class' => [
                'wgl-clients',
                'clearfix',
                'anim-'.$item_anim,
                'items-'.$item_grid,
				'items-tablet-'.$settings['item_grid_tablet'],
				'items-mobile-'.$settings['item_grid_mobile'],
			],
            'id' => $carousel_id,
            'data-carousel' => $use_carousel,
        ] );

        foreach ( $settings[ 'list' ] as $index => $item ) {

            if ( !empty( $item[ 'client_link' ][ 'url' ] ) ) {
                $client_link = $this->get_repeater_setting_key( 'client_link', 'list' , $index );
				$this->add_render_attribute($client_link, 'class', [
                    'image_link',
                    'image_wrapper'
                ]);
				$this->add_link_attributes($client_link, $item['client_link']);
            } 

            $client_image = $this->get_repeater_setting_key( 'thumbnail', 'list' , $index );
            $this->add_render_attribute( $client_image, [
                'class' => 'main_image',
                'src' => esc_url($item[ 'thumbnail' ][ 'url' ]),
                'alt' => Control_Media::get_image_alt( $item[ 'thumbnail' ] ),
            ] );

            $client_hover_image = $this->get_repeater_setting_key( 'hover_thumbnail', 'list' , $index );
            $this->add_render_attribute( $client_hover_image, [
                'class' => 'hover_image',
                'src' => esc_url($item[ 'hover_thumbnail' ][ 'url' ]),
                'alt' => Control_Media::get_image_alt( $item[ 'hover_thumbnail' ] ),
            ] );

            ob_start();

            ?><div class="clients_image"><?php
                if ( !empty($item[ 'client_link' ][ 'url' ]) ) : ?><a <?php echo $this->get_render_attribute_string( $client_link ); ?>><?php
                else : ?><div class="image_wrapper"><?php
                endif;
                    if (!empty($item[ 'hover_thumbnail' ][ 'url' ]) && ($item_anim == 'ex_images' || $item_anim == 'ex_images_bg' || $item_anim == 'ex_images_ver')) : ?><img <?php echo $this->get_render_attribute_string( $client_hover_image ); ?> /><?php endif;
                    ?><img <?php echo $this->get_render_attribute_string( $client_image ); ?> /><?php
                if ( !empty($item[ 'client_link' ][ 'url' ]) ) : ?></a><?php
                else : ?></div><?php
                endif;
            ?></div> <?php

            $content .= ob_get_clean();
        }

        ?><div <?php echo $this->get_render_attribute_string( 'clients' ); ?>><?php
            if((bool)$use_carousel) : echo Wgl_Carousel_Settings::init($carousel_options, $content, false);
            else : echo $content;
            endif;
        ?></div><?php

    }

}