<?php
namespace WglAddons\Templates;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use Elementor\Plugin;
use Elementor\Frontend;
use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Elementor_Helper;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Includes\Wgl_Icons;
use Elementor\Icons_Manager;


/**
* WGL Elementor Info Boxes Template
*
*
* @class        WglInfoBoxes
* @version      1.0
* @category     Class
* @author       WebGeniusLab
*/

class WglInfoBoxes
{
    private static $instance = null;
    public static function get_instance()
    {
        if ( null == self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function render( $self, $atts ){

        extract($atts);

        $theme_color = esc_attr(\Carbonick_Theme_Helper::get_option('theme-primary-color'));
        $theme_color_secondary = esc_attr(\Carbonick_Theme_Helper::get_option('theme-secondary-color'));
        $header_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Carbonick_Theme_Helper::get_option('main-font')['color']);

        $infobox_id = $infobox_inner = $infobox_icon = $infobox_title = $infobox_content = $infobox_button = $item_link_html = '';

        // Info box wrapper classes
        $infobox_helper_classes  = $icon_type === 'font' ?  ' elementor-icon-box-wrapper' : '';
        $infobox_helper_classes .= $icon_type === 'number' ?  ' elementor-number-box-wrapper' : '';
        $infobox_helper_classes .= $icon_type === 'image' ? ' elementor-image-box-wrapper' : '';
        $infobox_helper_classes .= !empty($add_border_animation) ? ' add_border_animation' : '';

        // HTML tags allowed for rendering
        $allowed_html = array(
            'a' => array(
                'href' => true,
                'title' => true,
                'style' => true,
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'span' => array(
                'class' => true,
                'style' => true,
            ),
            'p' => array(
                'class' => true,
                'style' => true,
            ),
            'ol' => array(
                'class' => true,
                'style' => true,
            ),
            'ul' => array(
                'class' => true,
                'style' => true,
            ),
            'li' => array(
                'class' => true,
                'style' => true,
            )
        );

	    // SubTitle
	    $infobox_subtitle = !empty($ib_subtitle) ? '<div class="wgl-infobox_subtitle_wrap"><div class="wgl-infobox_subtitle">'.wp_kses( $ib_subtitle, $allowed_html ).'</div></div>' : '';

        // Title output
        $infobox_title .='<div class="wgl-infobox-title_wrapper">';
        $infobox_title .= !empty($ib_title) ? '<'.esc_attr($title_tag).' class="wgl-infobox_title">'.wp_kses( $ib_title, $allowed_html ).'</'.esc_attr($title_tag).'>' : '';
        $infobox_title .= '</div>';

        // Content output
        $infobox_content .= !empty($ib_content) ? '<'.esc_attr($content_tag).' class="wgl-infobox_content">'.wp_kses($ib_content, $allowed_html).'</'.esc_attr($content_tag).'>' : '';

        // Icon/Image output
        if (!empty($icon_type)) {
            $atts['wrapper_class'] = 'wgl-infobox-icon_wrapper';
            $atts['container_class'] = 'wgl-infobox-icon_container';

            $icons = new Wgl_Icons;
            $infobox_icon .= $icons->build($self, $atts, array());
        }

	    // Read more button
        if ( !empty($add_read_more) ) {

            if((bool)$read_more_icon_sticky){
                $self->add_render_attribute( 'button_link', 'class', [
                	'corner-attached',
	                !empty($read_more_icon_sticky_pos) ? 'corner-position_'.esc_attr($read_more_icon_sticky_pos) : ''
                ] );
            }

            $self->add_render_attribute( 'button_link', 'class', [
            	'wgl-infobox_button',
	            'button-read-more',
	            'read-more-icon',
	            !empty($read_more_icon_align) ? 'icon-position-'.esc_attr($read_more_icon_align) : '',
	            !empty($read_more_icon_customize) ? 'icon-customize-'.esc_attr($read_more_icon_customize) : ''
            ] );

            if ($add_item_link){
	            $button_tag = 'div';
            }else{
	            if ( ! empty( $item_link['url'] ) ) {
		            $self->add_link_attributes( 'button_link', $item_link );
	            }
	            $button_tag = 'a';
            }
	        $attr_btn = $self->get_render_attribute_string( 'button_link' );


            $icon_font = $read_more_icon_fontawesome;

            $migrated = isset( $atts['__fa4_migrated']['read_more_icon_fontawesome'] );
            $is_new = Icons_Manager::is_migration_allowed();
            if ( $is_new || $migrated ) {
                ob_start();
                    Icons_Manager::render_icon( $atts['read_more_icon_fontawesome'], [ 'aria-hidden' => 'true' ] );
                $icon_output = ob_get_clean();
            } else {
                $icon_output = '<i class="icon '.esc_attr($icon_font).'"></i>';
            }

            $infobox_button .= '<div class="wgl-infobox-button_wrapper">';
            $infobox_button .= '<'.$button_tag.' '.implode( ' ', [ $attr_btn ] ).'>';

            if($read_more_icon_align !== 'right'){
                $infobox_button .= !empty($icon_font) ? $icon_output : '';
            }

            $infobox_button .= !empty($read_more_text) ? '<span>'.esc_html($read_more_text).'</span>' : '';

            if($read_more_icon_align === 'right'){
                $infobox_button .= !empty($icon_font) ? $icon_output : '';
            }

            $infobox_button .= '</'.$button_tag.'>';
            $infobox_button .= '</div>';
        }

        if ((bool)$add_item_link) {
            if ( ! empty( $item_link['url'] ) ) {
	            $self->add_link_attributes( 'item_link', $item_link );
            }

            $link_attributes = $self->get_render_attribute_string( 'item_link' );

            $wrapper_tag_start = 'a '.implode( ' ', [ $link_attributes ] );
            $wrapper_tag_end = 'a';
        }else{
	        $wrapper_tag_start = $wrapper_tag_end = 'div';
        }

        $content_class = '';
        $content_class .= $icon_type === 'font' ?  ' elementor-icon-box-content' : '';
        $content_class .= $icon_type === 'number' ?  ' elementor-number-box-content' : '';
        $content_class .= $icon_type === 'image' ? ' elementor-image-box-content' : '';

        $infobox_inner .= $infobox_icon;
        $infobox_inner .= $infobox_subtitle;
        $infobox_inner .= '<div class="wgl-infobox-content_wrapper'.esc_attr($content_class).'">';
        $infobox_inner .= $infobox_title;
        $infobox_inner .= $infobox_content;
        $infobox_inner .= $infobox_button;
        $infobox_inner .= '</div>';


        // Render html
        $output = '<div class="wgl-infobox">';
            $output .= '<'.$wrapper_tag_start.' class="wgl-infobox_wrapper'.esc_attr($infobox_helper_classes).'">';
                $output .= $infobox_inner;
            $output .= '</'.$wrapper_tag_end.'>';
        $output .= '</div>';

        echo \Carbonick_Theme_Helper::render_html($output);
    }

}