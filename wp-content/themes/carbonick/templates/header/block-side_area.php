<?php

defined( 'ABSPATH' ) || exit;

if (! class_exists('Carbonick_Header_Side_Area')) {
	class Carbonick_Header_Side_Area extends Carbonick_Get_Header
	{
		public function __construct()
		{
			$this->header_vars();

			$side_panel_enable = Carbonick_Theme_Helper::get_option('side_panel_enable');

   			if(empty($side_panel_enable)){
   				return;
   			}

			$pos = Carbonick_Theme_Helper::options_compare('side_panel_position', 'mb_customize_side_panel', 'custom');

			$content_type = Carbonick_Theme_Helper::options_compare('side_panel_content_type','mb_customize_side_panel','custom');
			$class = ! empty($pos) ? ' side-panel_position_'.$pos : ' side-panel_position_right';

			// Get options	
			$side_panel_spacing = Carbonick_Theme_Helper::options_compare('side_panel_spacing','mb_customize_side_panel','custom');

			$style = ! empty($side_panel_spacing['padding-top']) ? ' padding-top:'.(int)$side_panel_spacing['padding-top'].'px;' : '' ;
			$style .= ! empty($side_panel_spacing['padding-bottom']) ? ' padding-bottom:'.(int)$side_panel_spacing['padding-bottom'].'px;' : '' ;
			$style .= ! empty($side_panel_spacing['padding-left']) ? ' padding-left:'.(int)$side_panel_spacing['padding-left'].'px;' : '' ;
			$style .= ! empty($side_panel_spacing['padding-right']) ? ' padding-right:'.(int)$side_panel_spacing['padding-right'].'px;' : '' ;
			$style  = ! empty($style) ? ' style="'.$style.'"' : '';

			echo '<div class="side-panel_overlay"></div>';
			echo '<section id="side-panel" class="side-panel_widgets', esc_attr($class), '"', $this->side_panel_style(), '>';
				echo '<a href="#" class="side-panel_close"', $this->side_panel_style_icon(), '>',
					'<span class="side-panel_close_icon">',
						'<span></span><span></span><span></span>',
					'</span>',
				'</a>';
				echo '<div class="side-panel_sidebar"', $style, '>';

					switch ($content_type) {
						case 'pages': $this->side_panel_get_pages(); break;
						case 'widgets':
						default: dynamic_sidebar( 'side_panel' ); break;
					}

				echo '</div>';
			echo '</section>';
		}

		public function side_panel_style()
		{
			
			$bg = Carbonick_Theme_Helper::get_option('side_panel_bg');
			$bg = ! empty($bg['rgba']) ? $bg['rgba'] : '';

			$color = Carbonick_Theme_Helper::get_option('side_panel_text_color');
			$color = ! empty($color['rgba']) ? $color['rgba'] : '';

			$width = Carbonick_Theme_Helper::get_option('side_panel_width');
			$width = ! empty($width['width']) ? $width['width'] : '';

			$align = Carbonick_Theme_Helper::options_compare('side_panel_text_alignment', 'mb_customize_side_panel', 'custom');
			$style = '';

			if (class_exists( 'RWMB_Loader' ) && $this->id !== 0) {
				$side_panel_switch = rwmb_meta('mb_customize_side_panel');
				if ($side_panel_switch === 'custom') {
					$bg = rwmb_meta("mb_side_panel_bg");
					$color = rwmb_meta("mb_side_panel_text_color");
					$width = rwmb_meta("mb_side_panel_width");
				}
			}

			if (! empty($bg)) $style .= 'background-color: '.esc_attr($bg).';';
			if (! empty($color)) $style .= 'color: '.esc_attr($color).';';
			if (! empty($width)) $style .= 'width: '.esc_attr((int) $width).'px;';
			
			$style .= ! empty($align) ? 'text-align: '.esc_attr($align).';' : 'text-align: center;';

			return $style ? ' style="'.$style.'"' : '';
		}

		public function side_panel_get_pages()
		{
			$page_select = Carbonick_Theme_Helper::options_compare('side_panel_page_select','mb_customize_side_panel','custom');

			if (! empty($page_select)) {
				$page_select = intval($page_select);

				if (class_exists('SitePress') && function_exists('icl_object_id')) {
					$wpml_page = icl_object_id($page_select, 'side-panel', false,ICL_LANGUAGE_CODE);
					$page_select = !empty($wpml_page) ? $wpml_page : $page_select;
				}

				if ( did_action( 'elementor/loaded' ) ) {
					echo \Elementor\Plugin::$instance->frontend->get_builder_content( $page_select );
				}
			}
		}
	}

	new Carbonick_Header_Side_Area();
}
