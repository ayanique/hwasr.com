<?php

namespace WglAddons\Includes;

use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

/**
* Wgl Elementor Helper Settings
*
*
* @class        Wgl_Elementor_Helper
* @version      1.0
* @category     Class
* @author       WebGeniusLab
*/

if (!class_exists('Wgl_Elementor_Helper')) {
    class Wgl_Elementor_Helper
    {

        private static $instance = null;
        public static function get_instance() {
            
            if ( null == self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function get_wgl_icons() {
            return [ 
                'ui',
                'commerce-and-shopping',
                'commerce-and-shopping-1',
                'setup',
                'phone',
                'map',
                'arrow',
                'expand-button',
                'back',
                'cross',
                'motor',
                'wheel',
                'car',
                'oil',
                'brake',
                'key',
                'tick',
                'sports-and-competition',
                'tire',
                'sports-and-competition-1',
                'turbo',
                'wrench',
                'oil-1',
                'dashboard',
                'car-1',
                'instagram',
                'quote',
                'spare',
                'motor-1',
                'add-plus-button',
                'plus-black-symbol',
                'add',
                'plus',
                'plus-1',
                'eye',
                'heart',
                'like',
                'eye-1',
                'comment-black-oval-bubble-shape',
                'play-arrow',
                'link',
                'link-1',
                'chain',
                'link-2',
                'link-3',
                'share',
                'chat',
                'user',
                'user-1',
                'chat-1',
                'automaton',
                'gear',
                'ui-1',
                'mission',
                'focus',
                'vision',
                'tire-1',
                'wheel-1',
                'transportation',
                'support',
                'mail',
                'ui-2',
                'correct',
                'minus',
                'cancel',
                'done',
                'tyre',
                'fuel',
                'wheel-2',
                'steering-wheel',
                'oil-gauge',
                'fuel-1',
            ];
        }

        public static function enqueue_css($style) {
            if (! (bool) Plugin::$instance->editor->is_edit_mode()) {
                if (! empty($style)) {
                    ob_start();             
                        echo $style;
                    $css = ob_get_clean();
                    $css = apply_filters( 'carbonick_enqueue_shortcode_css', $css, $style );

                    return $css;
                }
            } else {
                echo '<style>'.esc_attr($style).'</style>';
            }
        }

        public function get_elementor_templates() {
            
            $options = [];

            $_templates = get_posts( array(
                'post_type' => 'elementor_library',
                'posts_per_page' => -1,
            ));
            
            if ( ! empty( $_templates ) && ! is_wp_error( $_templates ) ) {
                
                foreach ( $_templates as $_template ) {
                    $options[ $_template->ID ] = $_template->post_title;
                }
                
                update_option( 'temp_count', $options );
                
                return $options;
            }
        }
              
    }
    new Wgl_Elementor_Helper;
}
?>