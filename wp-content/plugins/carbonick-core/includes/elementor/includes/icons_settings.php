<?php

namespace WglAddons\Includes;

defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;


/**
* Wgl Elementor Icons Settings
*
*
* @class        Wgl_Icons
* @version      1.0
* @category     Class
* @author       WebGeniusLab
*/

if (! class_exists('Wgl_Icons')) {

    class Wgl_Icons
    {
        private static $instance = null;

        public static function get_instance()
        {
            if ( null == self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }


        public function build($self, $atts, $pref)
        {
            $icon_builder = new Wgl_Icon_Builder();
            return $icon_builder->build( $self, $atts, $pref );
        }


        public static function init($self, $array = [])
        {
            if (! $self) return;

            $label = isset($array['label']) ? $array['label'] : '';
            $prefix = ! empty($array['prefix']) ? $array['prefix'] : '';

	        $default_media_type = $array['default']['media_type'] ?? '';
	        $default_icon = $array['default']['icon'] ?? [];

            if ($array['section']) {
                $self->start_controls_section(
                    $prefix.'add_icon_image_section',
                    [
                        'label' => sprintf( esc_html__('%s Icon/Image', 'carbonick-core'), $label ),
                    ]
                );
            }

            $self->add_control(
                $prefix.'icon_type',
                [
                    'label' => esc_html__('Add Icon/Image', 'carbonick-core'),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => false,
                    'options' => [
                        '' => [
                            'title' => esc_html__('None', 'carbonick-core'),
                            'icon' => 'fa fa-ban',
                        ],
                        'number' => [
                            'title' => esc_html__('Number', 'carbonick-core'),
                            'icon' => 'fa fa-list-ol',
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
                    'default' => $default_media_type,
                    'prefix_class' => 'has-',
                ]
            );

            $self->add_control(
                $prefix.'number',
                [
                    'label' => esc_html__('Number', 'carbonick-core'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '01', 
                    'condition' => [
                        $prefix.'icon_type' => 'number',
                    ],
                ]
            );

            $self->add_control(
                $prefix.'icon_fontawesome',
                [
                    'label' => esc_html__( 'Icon', 'carbonick-core' ),
                    'type' => Controls_Manager::ICONS,
                    'label_block' => true,
                    'condition' => [
                        $prefix.'icon_type' => 'font',
                    ],
                    'default' => $default_icon,
                    'description' => esc_html__( 'Select icon from Fontawesome library.', 'carbonick-core' ),
                ]
            );

            $self->add_control(
                $prefix.'icon_render_class',
                [
                    'label' => esc_html__( 'Icon Class', 'carbonick-core' ),
                    'type' => Controls_Manager::HIDDEN,
                    'condition' => [
                        $prefix.'icon_type' => 'font',
                    ],
                    'prefix_class' => 'elementor-widget-icon-box ',
                    'default' => 'wgl-icon-box',
                ]
            );

            $self->add_control(
                $prefix.'thumbnail',
                [
                    'label' => esc_html__( 'Image', 'carbonick-core' ),
                    'type' => Controls_Manager::MEDIA,
                    'label_block' => true,
                    'condition' => [
                        $prefix.'icon_type' => 'image',
                    ],
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $self->add_control(
                $prefix.'image_render_class',
                [
                    'label' => esc_html__( 'Image Class', 'carbonick-core' ),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'wgl-image-box',
                    'prefix_class' => 'elementor-widget-image-box ',
                    'condition' => [
                        $prefix.'icon_type' => 'image',
                    ]
                ]
            );

            $self->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => $prefix.'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'default' => 'full',
                    'separator' => 'none',
                    'condition' => [
                        $prefix.'icon_type' => 'image',
                    ],
                ]
            );

	        $self->add_responsive_control(
		        $prefix.'image_width',
		        [
			        'label' => esc_html__('Image Width', 'carbonick-core'),
			        'type' => Controls_Manager::SLIDER,
			        'range' => [
				        'px' => [
					        'min' => 20,
					        'max' => 500,
				        ],
			        ],
			        'default' => [ 'size' => '162', 'unit' => 'px' ],
			        'condition' => [
				        $prefix.'icon_type' => 'image',
			        ],
			        'selectors' => [
				        '{{WRAPPER}} .wgl-image-box_img img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
			        ],
		        ]
	        );


	        if (isset($array['output']) && ! empty($array['output'])){
                foreach ($array['output'] as $key => $value) {
                    $self->add_control(
                        $key,
                        $value
                    );
                }
            }
            if ($array['section']) {
	            $self->end_controls_section();       
            }
        }
        
    }
    new Wgl_Icons();
}

/**
* Wgl Icon Build
*
*
* @class        Wgl_Icon_Builder
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/
if (!class_exists('Wgl_Icon_Builder')){
    class Wgl_Icon_Builder{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }


        public function build($self, $atts, $pref ){

            $prefix = '';
            if (isset($pref) && ! empty($pref)) {
                $prefix = $pref;
            }


            $icon_type = $atts[$prefix.'icon_type'];
            $icon_fontawesome = $atts[$prefix.'icon_fontawesome'];
            $thumbnail = $atts[$prefix.'thumbnail'];
            $number = $atts[$prefix.'number'];

            $self->add_render_attribute( $prefix.'icon', 'class', [ 'wgl-icon', 'elementor-icon' ] );
            $self->add_render_attribute( $prefix.'number', 'class', [ 'wgl-number', 'elementor-icon' ] );
            
            if (isset($atts['hover_animation_icon'])){
                $self->add_render_attribute( $prefix.'icon', 'class', 'elementor-animation-' . $atts['hover_animation_icon'] );
            }
            
            if (isset($atts['hover_animation_number'])){
                $self->add_render_attribute( $prefix.'number', 'class', 'elementor-animation-' . $atts['hover_animation_number'] );
            }

            $wrapper_class = isset($atts['wrapper_class']) ? $atts['wrapper_class'] : 'wgl-widget_wrapper';

            if ($icon_type !== ''){
                if ($icon_type === 'image'){
                    $wrapper_class .= ' elementor-image-box-img';
                }elseif($icon_type === 'number'){
                    $wrapper_class .= ' elementor-number-box-number';
                }else{
                    $wrapper_class .= ' elementor-icon-box-icon';
                }
            } 

            $container_class = isset($atts['container_class']) ? $atts['container_class'] : 'wgl-widget_container';

            $self->add_render_attribute( $prefix.'wrapper', 'class', [ $wrapper_class ] );

            $self->add_render_attribute( $prefix.'container', 'class', [ $container_class ] );

            $output = '';
            $icon_tag = 'span';
            
            if (isset($atts['link_t']['url']) && !empty($atts['link_t']['url'])) {
                $icon_tag = 'a';
                $self->add_link_attributes($prefix.'link_t', $atts['link_t']);
            }

            $icon_attributes = $self->get_render_attribute_string( $prefix.'icon' );        
            $number_attributes = $self->get_render_attribute_string( $prefix.'number' );        
            $link_attributes = $self->get_render_attribute_string( $prefix.'link_t' );

            $wrapper = $self->get_render_attribute_string( $prefix.'wrapper' );
            $container = $self->get_render_attribute_string( $prefix.'container' );
            
            if ($icon_type == 'font' && ! empty($icon_fontawesome) ||  $icon_type == 'number' && ! empty($number) || $icon_type == 'image' && ! empty($thumbnail)){

                $output .= '<div '.implode( ' ', [ $wrapper ] ).'>'; 
                    $output .= '<div '.implode( ' ', [ $container ] ).'>'; 
                    
                        if ($icon_type == 'font' && (! empty($icon_fontawesome) )) {

                            $icon_font = $icon_fontawesome;

                            $output .= '<'; 
                                $output .= implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] );
                            $output .= '>'; 
                               
                            // add icon migration 
                            $migrated = isset( $atts['__fa4_migrated'][$prefix.'icon_fontawesome'] );
                            $is_new = Icons_Manager::is_migration_allowed();
                            if ( $is_new || $migrated ) {
                                ob_start();
                                Icons_Manager::render_icon( $atts[$prefix.'icon_fontawesome'], [ 'class' => 'icon', 'aria-hidden' => 'true' ] );
                                $output .= ob_get_clean();
                            } else { 
                                $output .= '<i class="icon '.esc_attr($icon_font).'"></i>';
                            }                               

                            $output .= '</'.$icon_tag.'>';
                        }
                        if ($icon_type == 'number' && (! empty($number) )) {

                            $output .= '<'; 
                                $output .= implode( ' ', [ $icon_tag, $number_attributes, $link_attributes ] );
                            $output .= '>'; 
                               
                            $output .= '<span class="number">'.esc_html($number).'</span>';

                            $output .= '</'.$icon_tag.'>';

                        }
                        if ($icon_type == 'image' && ! empty($thumbnail)) {

                            // var_dump($thumbnail);
                            if ( ! empty( $thumbnail['url'] ) ) {
                                $self->add_render_attribute( 'thumbnail', 'src', $thumbnail['url'] );
                                $self->add_render_attribute( 'thumbnail', 'alt', Control_Media::get_image_alt( $thumbnail ) );
                                $self->add_render_attribute( 'thumbnail', 'title', Control_Media::get_image_title( $thumbnail ) );

                                if ( isset($atts['hover_animation_image']) ) {
                                    $atts['hover_animation'] = $atts['hover_animation_image'];
                                }

                                $output .= '<figure class="wgl-image-box_img">';

                                $output .= '<'; 
                                    $output .= implode( ' ', [ $icon_tag,  $link_attributes ] );
                                $output .= '>'; 
                                    $output .= Group_Control_Image_Size::get_attachment_image_html( $atts, 'thumbnail', $prefix.'thumbnail' );

                                $output .= '</'.$icon_tag.'>';

                                $output .= '</figure>';
                            }

                        }

                    $output .= '</div>';
                $output .= '</div>';
            }
            return $output;

        }

        public function template_build(){

        }       
    }
}
