<?php

defined( 'ABSPATH' ) || exit;

if (!class_exists('Carbonick_Header_Sticky')) {
	class Carbonick_Header_Sticky extends Carbonick_Get_Header{

		public function __construct(){
			$this->header_vars();  
			$this->html_render = 'sticky';

	   		if (Carbonick_Theme_Helper::options_compare('header_sticky','mb_customize_header_layout','custom') == '1') {
	   			$header_sticky_style = Carbonick_Theme_Helper::get_option('header_sticky_style');
	   			
	   			echo "<div class='wgl-sticky-header wgl-sticky-element".($this->header_type === 'default' ? ' header_sticky_shadow' : '')."'".(!empty($header_sticky_style) ? ' data-style="'.esc_attr($header_sticky_style).'"' : '').">";

	   				echo "<div class='container-wrapper'>";
	   				
	   					$this->build_header_layout('sticky');
	   				echo "</div>";

	   			echo "</div>";
	   		}
		}
	}

    new Carbonick_Header_Sticky();
}
