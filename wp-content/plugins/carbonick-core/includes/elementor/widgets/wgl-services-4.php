<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Includes\Wgl_Elementor_Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
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


defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class Wgl_Services_4 extends Widget_Base {
    
    public function get_name() {
        return 'wgl-services-4';
    }

    public function get_title() {
        return esc_html__('WGL Services 4', 'carbonick-core');
    }

    public function get_icon() {
        return 'wgl-services-4';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    
    
    protected function _register_controls() {
        $theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $second_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $third_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-third-color'));
        $header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section('wgl_services_content',
            array(
                'label'         => esc_html__('Service Content', 'carbonick-core'),
            )
        );

        $this->add_control('service_image',
            array(
                'label'       => esc_html__('Thumbnail', 'carbonick-core'),
                'type'        => Controls_Manager::MEDIA,
            )
        );

        $this->add_control('services_title',
            array(
                'label'         => esc_html__('Title', 'carbonick-core'),
                'type'          => Controls_Manager::TEXTAREA,
                'label_block'   => true,
                'default'       => esc_html__('This is the heading​', 'carbonick-core'),
            )
        );

        $this->add_control('services_text',
            array(
                'label'         => esc_html__('Text', 'carbonick-core'),
                'type'          => Controls_Manager::TEXTAREA,
                'label_block'   => true,
            )
        ); 

        $this->add_control(
            'alignment',
            array(
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
                'toggle' => true,
            )
        );


        $this->add_control(
            'service_link',
            array(
                'label' => esc_html__('Service link', 'carbonick-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'carbonick-core'),
                    'whole' => esc_html__('Whole Item', 'carbonick-core'),
                    'button' => esc_html__('Only Button', 'carbonick-core'),
                ],
                'default' => 'button',
                'toggle' => true,
                'prefix_class' => 'link-',
            )
        );

        $this->add_control('item_link',
            array(
                'label'             => esc_html__('Link', 'carbonick-core'),
                'type'              => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'condition'     => [ 
                    'service_link!'   => 'none',
                ],
            )
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        // Title Styles

        $this->start_controls_section(
            'item_style_section',
            array(
                'label'     => esc_html__('Item', 'carbonick-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'services_overlay_color',
            array(
                'label' => esc_html__('Overlay Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_wrap:before' => 'background-color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        // Title Styles

        $this->start_controls_section(
            'title_style_section',
            array(
                'label'     => esc_html__('Title', 'carbonick-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-services_title',
            )
        );

        $this->add_control('title_tag',
            array(
                'label'         => esc_html__('Title Tag', 'carbonick-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'description'   => esc_html__('Choose your tag for services title', 'carbonick-core'),
                'options'       => [
                    'h1'      => 'H1',
                    'h2'      => 'H2',
                    'h3'      => 'H3',
                    'h4'      => 'H4',
                    'h5'      => 'H5',
                    'h6'      => 'H6',
                    'div'     => 'DIV',
                    'span'    => 'SPAN',
                ],
            )
        );

        $this->add_responsive_control(
            'title_margin',
            array(
                'label' => esc_html__('Title Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'title_padding',
            array(
                'label' => esc_html__('Title Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );
    
        $this->start_controls_tabs( 'services_color_tab_title' );

        $this->start_controls_tab(
            'custom_services_color_idle',
            array(
                'label' => esc_html__('Idle' , 'carbonick-core'),
            )
        );

        $this->add_control(
            'services_color',
            array(
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_title' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_services_color_hover',
            array(
                'label' => esc_html__('Hover' , 'carbonick-core'),
            )
        );

        $this->add_control(
            'services_color_hover',
            array(
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-services_title' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        // text Styles

        $this->start_controls_section(
            'text_style_section',
            array(
                'label'     => esc_html__('Text', 'carbonick-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_text',
                'selector' => '{{WRAPPER}} .wgl-services_text',
            )
        );

        $this->add_responsive_control(
            'text_margin',
            array(
                'label' => esc_html__('Text Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'services_color_tab_text' );

        $this->start_controls_tab(
            'custom_services_color_normal_text',
            array(
                'label' => esc_html__('Idle' , 'carbonick-core'),
            )
        );

        $this->add_control(
            'services_color_text',
            array(
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_text' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_services_color_hover_text',
            array(
                'label' => esc_html__('Hover' , 'carbonick-core'),
            )
        );

        $this->add_control(
            'services_color_hover_text',
            array(
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-services_text' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 
        
        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        // button Styles

        $this->start_controls_section(
            'button_style_section',
            array(
                'label'     => esc_html__('Button', 'carbonick-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .wgl-services_link-button .wgl-services_link',
            )
        );

        $this->add_responsive_control(
            'button_margin',
            array(
                'label' => esc_html__('Button Margin', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_link-button .wgl-services_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'button_padding',
            array(
                'label' => esc_html__('Button Padding', 'carbonick-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_link-button .wgl-services_link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'services_color_tab_button' );

        $this->start_controls_tab(
            'custom_services_color_normal_button',
            array(
                'label' => esc_html__('Idle' , 'carbonick-core'),
            )
        );

        $this->add_control(
            'services_color_button',
            array(
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_link-button .wgl-services_link' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->add_control(
            'services_bg_button',
            array(
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_link-button .wgl-services_link' => 'background-color: {{VALUE}};'
                ),
            )
        ); 

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_services_color_hover_button',
            array(
                'label' => esc_html__('Hover' , 'carbonick-core'),
            )
        );

        $this->add_control(
            'services_color_hover_button',
            array(
                'label' => esc_html__('Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-services_link-button .wgl-services_link:hover' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->add_control(
            'services_bg_hover_button',
            array(
                'label' => esc_html__('Background Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_link-button .wgl-services_link:hover' => 'background-color: {{VALUE}};'
                ),
            )
        ); 

        $this->add_control(
            'services_hover_border_button',
            array(
                'label' => esc_html__('Border Color', 'carbonick-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-services_link-button .wgl-services_link:hover' => 'border-color: {{VALUE}};'
                ),
            )
        ); 

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'button_border',
                'label'    => esc_html__('Border Type', 'carbonick-core'),
                'selector' => '{{WRAPPER}} .wgl-services_link-button .wgl-services_link',
            )
        );

        $this->end_controls_section(); 

    }

    public function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'services', [
			'class' => [
                'wgl-services-4',
                'a'.$settings[ 'alignment' ]
            ],
        ] );

        $this->add_render_attribute( 'image', [
			'class' => 'wgl-services_image',
            'src' => esc_url($settings[ 'service_image' ][ 'url' ]),
            'alt' => Control_Media::get_image_alt( $settings[ 'service_image' ] ),
        ] );

        $this->add_render_attribute('item_link', 'class', 'wgl-services_link');
        if (isset($settings['item_link']['url'])) $this->add_link_attributes('item_link', $settings['item_link']);

        ?>
        <div <?php echo $this->get_render_attribute_string( 'services' ); ?>>
            <div class="wgl-services_wrap"><?php
                if (!empty($settings[ 'service_image' ])) {?>
                    <div class="wgl-services_image-wrap"><img <?php echo $this->get_render_attribute_string( 'image' ); ?> /></div><?php
                }?>
                <div class="wgl-services_content"><?php
                    if (!empty($settings[ 'services_title' ])) {?>
                        <<?php echo $settings[ 'title_tag' ]; ?> class="wgl-services_title"><?php echo $settings[ 'services_title' ];?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    }
                    if (!empty($settings[ 'services_text' ])) {?>
                        <div class="wgl-services_text"><?php echo $settings[ 'services_text' ];?></div><?php
                    }
                    if ($settings[ 'service_link' ] != 'none') {?>
                        <div class="wgl-services_link-button"><a <?php echo $this->get_render_attribute_string( 'item_link' ); ?>></a></div><?php
                    }?>
                </div><?php
                if ($settings[ 'service_link' ] == 'whole') {?>
                    <a <?php echo $this->get_render_attribute_string( 'item_link' ); ?>></a><?php
                }?>
            </div>
        </div>

        <?php     
    }
    
}