<?php

namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use WglAddons\Includes\Wgl_Icons;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;


class Wgl_Header_Search extends Widget_Base
{

    public function get_name() {
        return 'wgl-header-search';
    }

    public function get_title() {
        return esc_html__('WGL Search', 'carbonick-core' );
    }

    public function get_icon() {
        return 'wgl-header-search';
    }

    public function get_categories() {
        return [ 'wgl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'wgl-elementor-extensions-widgets',
        ];
    }

    protected function _register_controls()
    {
	    $primary_color   = esc_attr( \Carbonick_Theme_Helper::get_option( 'theme-primary-color' ) );
	    $secondary_color = esc_attr( \Carbonick_Theme_Helper::get_option( 'theme-secondary-color' ) );
	    $h_font_color    = esc_attr( \Carbonick_Theme_Helper::get_option( 'header-font' )['color'] );
	    $main_font_color = esc_attr( \Carbonick_Theme_Helper::get_option( 'main-font' )['color'] );


	    /*-----------------------------------------------------------------------------------*/
	    /*  CONTENT -> SEARCH SETTINGS
		/*-----------------------------------------------------------------------------------*/

	    $this->start_controls_section(
		    'section_search_settings',
		    [
			    'label' => esc_html__( 'Search Settings', 'carbonick-core' ),
		    ]
	    );

	    $this->add_control(
		    'search_height',
		    [
			    'label'     => esc_html__( 'Search Height', 'carbonick-core' ),
			    'type'      => Controls_Manager::NUMBER,
			    'min'       => 0,
			    'step'      => 1,
			    'separator' => 'before',
			    'default'   => 100,
			    'selectors' => [
				    '{{WRAPPER}} .header_search-button-wrapper,
				     {{WRAPPER}} .header_search-close' => 'height: {{VALUE}}px; line-height: {{VALUE}}px;',
			    ],
		    ]
	    );

	    $this->add_control(
		    'search_align',
		    [
			    'label'       => esc_html__( 'Alignment', 'carbonick-core' ),
			    'type'        => Controls_Manager::CHOOSE,
			    'options'     => [
				    'left' => [
					    'title' => esc_html__( 'Left', 'carbonick-core' ),
					    'icon'  => 'fa fa-align-left',
				    ],
				    'center'     => [
					    'title' => esc_html__( 'Center', 'carbonick-core' ),
					    'icon'  => 'fa fa-align-center',
				    ],
				    'right'   => [
					    'title' => esc_html__( 'Right', 'carbonick-core' ),
					    'icon'  => 'fa fa-align-right',
				    ],
			    ],
			    'label_block' => false,
			    'default'     => 'right',
			    'toggle'      => true,
			    'separator'   => 'before',
			    'prefix_class' => 'search_align-',
		    ]
	    );

	    $this->end_controls_section();

	    /*-----------------------------------------------------------------------------------*/
	    /*  Style Section
		/*-----------------------------------------------------------------------------------*/

	    $this->start_controls_section(
		    'search_section',
		    [
			    'label' => esc_html__( 'Search Style', 'carbonick-core' ),
			    'tab'   => Controls_Manager::TAB_STYLE,
		    ]
	    );

	    $this->add_control(
		    'icon_size',
		    [
			    'label' => esc_html__('Icon Size', 'carbonick-core'),
			    'type' => Controls_Manager::SLIDER,
			    'range' => [
				    'px' => [ 'max' => 100 ],
			    ],
			    'size_units' => [ 'px' ],
			    'default' => [ 'size' => 20, 'unit' => 'px' ],
			    'selectors' => [
				    '{{WRAPPER}} .header_search .icon' => 'font-size: {{SIZE}}{{UNIT}};',
			    ],

		    ]
	    );

	    $this->start_controls_tabs( 'search_style_tabs' );
	    $this->start_controls_tab(
		    'search_style_tab_idle',
		    [
			    'label' => esc_html__( 'Idle', 'carbonick-core' ),
		    ]
	    );

	    $this->add_control(
		    'search_icon_color',
		    [
			    'label'     => esc_html__( 'Icon Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_search .header_search-button i:before' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->end_controls_tab();

	    $this->start_controls_tab(
		    'search_style_tab_hover',
		    [
			    'label' => esc_html__( 'Hover', 'carbonick-core' ),
		    ]
	    );

	    $this->add_control(
		    'search_icon_color_hover',
		    [
			    'label'     => esc_html__( 'Icon Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_search:hover .header_search-button i:before,
				    {{WRAPPER}} .header_search:hover .header_search-close i:before,
				    {{WRAPPER}} .header_search:hover .header_search-close i:after' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->end_controls_tab();

	    $this->start_controls_tab(
		    'search_style_tab_active',
		    [
			    'label' => esc_html__( 'Active', 'carbonick-core' ),
		    ]
	    );

	    $this->add_control(
		    'search_icon_color_active',
		    [
			    'label'     => esc_html__( 'Icon Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_search .header_search-close i:before,
				    {{WRAPPER}} .header_search .header_search-close i:after' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
	    $this->end_controls_tabs();

	    $this->end_controls_section();
    }

    public function render()
    {
        $description = esc_html__('Type To Search', 'carbonick-core');
        $search_style = \Carbonick_Theme_Helper::get_option('search_style');
        $search_style =  !empty($search_style) ? $search_style : 'standard';
	    $settings = $this->get_settings_for_display();

        $search_class = ' search_'.\Carbonick_Theme_Helper::get_option('search_style');

        $this->add_render_attribute( 'search', 'class', ['wgl-search elementor-search header_search-button-wrapper'] );
        $this->add_render_attribute( 'search', 'role', 'button' );

        echo '<div class="header_search'.esc_attr($search_class).'">';

            echo '<div ', $this->get_render_attribute_string( 'search' ), '>',
                '<div class="header_search-button"><i class="icon flaticon-ui"></i></div>',
                '<div class="header_search-close"><i class="icon"></i></div>',
                '</div>';

            echo '<div class="header_search-field">';
                if ($search_style === 'alt') {
                    echo '<div class="header_search-wrap">',
                        '<div class="carbonick_module_double_headings aleft">',
                        '<h3 class="header_search-heading_description heading_title">',
                        apply_filters('carbonick_desc_search', $description),
                        '</h3>',
                        '</div>',
                        '<div class="header_search-close"></div>',
                        '</div>';
                }
                echo get_search_form(false);
            echo '</div>';

        echo '</div>';
    }

}