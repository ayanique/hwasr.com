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

class Wgl_Header_Cart extends Widget_Base {
    
    public function get_name() {
        return 'wgl-header-cart';
    }

    public function get_title() {
        return esc_html__('WooCart', 'carbonick-core' );
    }

    public function get_icon() {
        return 'wgl-header-cart';
    }

    public function get_categories() {
        return [ 'wgl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'wgl-elementor-extensions-widgets',
        ];
    }

    protected function _register_controls() {
        $primary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);

        $this->start_controls_section(
            'section_search_settings',
            [
                'label' => esc_html__( 'Cart Settings', 'carbonick-core' ),
            ]
        );

	    $this->add_control(
		    'cart_title',
		    [
			    'label'   => esc_html__( 'Title', 'carbonick-core' ),
			    'type'    => Controls_Manager::TEXT,
			    'default' => esc_html__( 'Cart', 'carbonick-core' ),
		    ]
	    );

        $this->add_control(
            'cart_height',
            array(
                'label' => esc_html__( 'Cart Icon Height', 'carbonick-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 100,
                'description' => esc_html__( 'Enter value in pixels', 'carbonick-core' ),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .mini-cart' => 'height: {{VALUE}}px;',
                ],
            )
        );

        $this->add_control(
            'cart_align',
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
                    '{{WRAPPER}} .wgl-mini-cart_wrapper' => 'text-align: {{VALUE}};',
                ],
            )
        );       

        $this->end_controls_section();              
 

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'cart_style_section',
            [
                'label' => esc_html__( 'Cart Style', 'carbonick-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

	    $this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
			    'name' => 'title_typo',
			    'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			    'selector' => '{{WRAPPER}} .title',
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
			    'default' => [ 'size' => 19, 'unit' => 'px' ],
			    'selectors' => [
				    '{{WRAPPER}} .header_cart-button .icon,
				    {{WRAPPER}} .header_cart-button svg' => 'font-size: {{SIZE}}{{UNIT}};',
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
		    'cart_icon_color',
		    [
			    'label'     => esc_html__( 'Icon Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $h_font_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_cart-button i.icon:before,
				    {{WRAPPER}} .header_cart-button svg' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->add_control(
		    'cart_counter_color',
		    [
			    'label'     => esc_html__( 'Counter Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_cart-button .woo_mini-count' => 'color: {{VALUE}}',
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
				    '{{WRAPPER}} .header_cart-button .title' => 'color: {{VALUE}}',
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
				    '{{WRAPPER}} .header_cart-button:hover i.icon:before,
				    {{WRAPPER}} .header_cart-button:hover svg' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->add_control(
		    'cart_counter_color_hover',
		    [
			    'label'     => esc_html__( 'Counter Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $primary_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_cart-button:hover .woo_mini-count' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->add_control(
		    'search_title_color_hover',
		    [
			    'label'     => esc_html__( 'Title Color', 'carbonick-core' ),
			    'type'      => Controls_Manager::COLOR,
			    'default'   => $h_font_color,
			    'selectors' => [
				    '{{WRAPPER}} .header_cart-button:hover .title' => 'color: {{VALUE}}',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
	    $this->end_controls_tabs();

	    $this->end_controls_section();
    }

    public function render(){
        if(!class_exists( '\WooCommerce' )){
            return;
        }
        echo '<div class="wgl-mini-cart_wrapper">'; 
        echo '<div class="mini-cart woocommerce">'.$this->icon_cart().self::woo_cart().'</div>';
        echo '</div>';
    }

    public function icon_cart() {
	    $settings = $this->get_settings_for_display();
        ob_start();

        $this->add_render_attribute( 'cart', 'class', ['wgl-cart woo_icon elementor-cart'] );
        $this->add_render_attribute( 'cart', 'role', 'button' );
        $this->add_render_attribute( 'cart', 'title', esc_attr__( 'Click to open Shopping Cart', 'carbonick-core' ) );

        ?>
        <div class="header_cart-button">
            <a <?php echo \Carbonick_Theme_Helper::render_html( $this->get_render_attribute_string( 'cart' ) ) ;?> >
                <?php if($settings[ 'cart_title' ]){ ?><span class="title"><?php esc_html_e($settings[ 'cart_title' ]) ?></span><?php } ?>
                <span><i class="icon flaticon flaticon-commerce-and-shopping-1"></i></span>
                <span class="woo_mini-count"><?php
                if((!(bool) Plugin::$instance->editor->is_edit_mode())){
                    echo ((\WooCommerce::instance()->cart->cart_contents_count > 0) ? '<span>' . esc_html( \WooCommerce::instance()->cart->cart_contents_count ) .'</span>' : '');
                }
                ?></span>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    public static function woo_cart(){      
        ob_start();
        echo '<div class="wgl-woo_mini_cart">';
        if(!(bool) Plugin::$instance->editor->is_edit_mode() ){
            woocommerce_mini_cart();
        }
        echo '</div>';
        return ob_get_clean();          
    }  
}