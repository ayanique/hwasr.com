<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Includes\Wgl_Elementor_Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Plugin;


defined('ABSPATH') || exit; // Abort, If called directly.

class Wgl_Header_Wpml extends Widget_Base {
    
    public function get_name() {
        return 'wgl-header-wpml';
    }

    public function get_title() {
        return esc_html__('WPML Selector', 'carbonick-core' );
    }

    public function get_icon() {
        return 'wgl-header-wpml';
    }

    public function get_categories() {
        return [ 'wgl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'perfect-scrollbar',
            'wgl-elementor-extensions-widgets',
        ];
    }

    protected function _register_controls() {
        $primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);

        $this->start_controls_section(
            'section_navigation_settings',
            [
                'label' => esc_html__( 'WPML Settings', 'carbonick-core' ),
            ]
        );

        $this->add_control(
            'wpml_height',
            array(
                'label' => esc_html__( 'WPML Height', 'carbonick-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 100,
                'description' => esc_html__( 'Enter value in pixels', 'carbonick-core' ),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'height: {{VALUE}}px;',
                ],
            )
        );

        $this->add_control(
            'wpml_align',
            array(
                'label' => esc_html__( 'Alignment', 'carbonick-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'carbonick-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'carbonick-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'carbonick-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'label_block' => false,
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->end_controls_section();

	    /*-----------------------------------------------------------------------------------*/
	    /*  Style Section
		/*-----------------------------------------------------------------------------------*/

	    $this->start_controls_section(
		    'wpml_style_section',
		    [
			    'label' => esc_html__( 'WPML Style', 'carbonick-core' ),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
			    'name' => 'title_typo',
			    'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			    'selector' => '{{WRAPPER}} .wpml-ls-native',
		    ]
	    );

	    $this->start_controls_tabs( 'wpml_style_tabs' );
	    $this->start_controls_tab(
		    'wpml_style_tab_idle',
		    [
			    'label' => esc_html__( 'Idle', 'carbonick-core' ),
		    ]
	    );

	    $this->add_control(
		    'cart_icon_color',
		    [
			    'label'     => esc_html__( 'Icon Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .js-wpml-ls-item-toggle .wpml-ls-native:after' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->add_control(
		    'cart_title_color',
		    [
			    'label'     => esc_html__( 'Title Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $h_font_color,
			    'selectors' => [
				    '{{WRAPPER}} .js-wpml-ls-item-toggle .wpml-ls-native' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->end_controls_tab();

	    $this->start_controls_tab(
		    'wpml_style_tab_hover',
		    [
			    'label' => esc_html__( 'Hover', 'carbonick-core' ),
		    ]
	    );

	    $this->add_control(
		    'wpml_icon_color_hover',
		    [
			    'label'     => esc_html__( 'Icon Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .wpml-ls-item:hover .js-wpml-ls-item-toggle .wpml-ls-native:after' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->add_control(
		    'wpml_title_color_hover',
		    [
			    'label'     => esc_html__( 'Title Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $h_font_color,
			    'selectors' => [
				    '{{WRAPPER}} .wpml-ls-item:hover .js-wpml-ls-item-toggle .wpml-ls-native' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
	    $this->end_controls_tabs();

	    $this->end_controls_section();
    }

    public function render(){
        if (class_exists('\SitePress')) {
            ob_start();
                do_action('wpml_add_language_selector');
            $wpml_render = ob_get_clean();
            
            if(!empty($wpml_render)){
                echo "<div class='sitepress_container'>";
                    do_action('wpml_add_language_selector');
                echo "</div>";                
            }

        }
    }   
}