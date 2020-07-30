<?php

// Class Theme Helper
require_once ( get_theme_file_path( '/core/class/theme-helper.php' ) );

// Class Walker comments
require_once ( get_theme_file_path( '/core/class/walker-comment.php' ) );

// Class Walker Mega Menu
require_once ( get_theme_file_path( '/core/class/walker-mega-menu.php' ) );

// Class Theme Cats Meta
require_once ( get_theme_file_path( '/core/class/theme-cat-meta.php' ) );

// Class Single Post
require_once ( get_theme_file_path( '/core/class/single-post.php' ) );

// Class Tinymce
require_once ( get_theme_file_path( '/core/class/tinymce-icon.php' ) );

// Class Theme Autoload
require_once ( get_theme_file_path( '/core/class/theme-autoload.php' ) );

// Class Theme Dashboard
require_once ( get_theme_file_path( '/core/class/theme-panel.php' ) );

// Class Theme Verify
require_once ( get_theme_file_path( '/core/class/theme-verify.php' ) );

function carbonick_content_width() {
	if (! isset( $content_width )) {
		$content_width = 940;
	}
}
add_action( 'after_setup_theme', 'carbonick_content_width', 0 );

function carbonick_theme_slug_setup() {
	add_theme_support('title-tag');
}
add_action('after_setup_theme', 'carbonick_theme_slug_setup');

add_action('init', 'carbonick_page_init');
if (! function_exists('carbonick_page_init')) {
	function carbonick_page_init() {
		add_post_type_support('page', 'excerpt');
	}
}

if (! function_exists('carbonick_main_menu')) {
	function carbonick_main_menu ($location = '') {
		wp_nav_menu( [
			'theme_location'  => 'main_menu',
			'menu'  => $location,
			'container' => '',
			'container_class' => '',
			'after' => '',
			'link_before' => '<span>',
			'link_after' => '</span>',
			'walker' => new Carbonick_Mega_Menu_Waker()
		] );
	}
}

// return all sidebars
if (! function_exists('carbonick_get_all_sidebar')) {
	function carbonick_get_all_sidebar() {
		global $wp_registered_sidebars;
		$out = [];
		if (empty( $wp_registered_sidebars ) )
			return;
		 foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) :
			$out[$sidebar_id] = $sidebar['name'];
		 endforeach;
		 return $out;
	}
}

if (! function_exists('carbonick_get_custom_menu')) {
	function carbonick_get_custom_menu() {
		$taxonomies = [];

		$menus = get_terms('nav_menu');
		foreach ($menus as $key => $value) {
			$taxonomies[$value->name] = $value->name;
		}
		return $taxonomies;
	}
}

function carbonick_get_attachment($attachment_id) {
	$attachment = get_post( $attachment_id );
	return [
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	];
}

if (! function_exists('carbonick_reorder_comment_fields')) {
	function carbonick_reorder_comment_fields($fields) {
		$new_fields = [];

		$myorder = [ 'author', 'email', 'url', 'comment' ];

		foreach ($myorder as $key) {
			$new_fields[ $key ] = isset($fields[ $key ]) ? $fields[ $key ] : '';
			unset( $fields[ $key ] );
		}

		if ($fields) {
			foreach ($fields as $key => $val) {
				$new_fields[ $key ] = $val;
			}
		}

		return $new_fields;
	}
}
add_filter('comment_form_fields', 'carbonick_reorder_comment_fields');

function carbonick_mce_buttons_2($buttons) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'carbonick_mce_buttons_2' );


function carbonick_tiny_mce_before_init( $settings) {

	$settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';
	$header_font_color = Carbonick_Theme_Helper::get_option('header-font')['color'];
	$theme_color = Carbonick_Theme_Helper::get_option('theme-primary-color');
	$secondary_color = Carbonick_Theme_Helper::get_option('theme-secondary-color');

	$style_formats = [
		[
			'title' => esc_html__('Dropcap', 'carbonick'),
			'items' => [
				[
					'title' => esc_html__('Primary color', 'carbonick'),
					'inline' => 'span',
					'classes' => 'dropcap-bg',
				], [
					'title' => esc_html__('Secondary color', 'carbonick'),
					'inline' => 'span',
					'classes' => 'dropcap-bg secondary',
				],
			],
		],
		[
			'title' => esc_html__('Highlighter', 'carbonick'),
			'items' => [
				[
					'title' => esc_html__('Primary color', 'carbonick'),
					'inline' => 'span',
					'classes' => 'highlighter',
				], [
					'title' => esc_html__('Secondary color', 'carbonick'),
					'inline' => 'span',
					'classes' => 'highlighter secondary',
				],
			],
		],
		[
			'title' => esc_html__('Font Weight', 'carbonick'),
			'items' => [
				[
					'title' => esc_html__('Default', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => 'inherit' ],
				], [
					'title' => esc_html__('Lightest (100)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '100' ],
				], [
					'title' => esc_html__('Lighter (200)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '200' ],
				], [
					'title' => esc_html__('Light (300)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '300' ],
				], [
					'title' => esc_html__('Normal (400)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '400' ],
				], [
					'title' => esc_html__('Medium (500)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '500' ],
				], [
					'title' => esc_html__('Semi-Bold (600)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '600' ],
				], [
					'title' => esc_html__('Bold (700)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '700' ],
				], [
					'title' => esc_html__('Bolder (800)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '800' ],
				], [
					'title' => esc_html__('Extra Bold (900)', 'carbonick'),
					'inline' => 'span',
					'styles' => [ 'font-weight' => '900' ],
				],
			]
		],
		[
			'title' => esc_html__('List Style', 'carbonick'),
			'items' => [
				[
					'title' => esc_html__('Dot, primary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_dot',
				], [
					'title' => esc_html__('Dot, secondary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_dot secondary',
				], [
					'title' => esc_html__('Square, primary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_square',
				], [
					'title' => esc_html__('Square, secondary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_square secondary',
				], [
					'title' => esc_html__('Check, primary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_check',
				], [
					'title' => esc_html__('Check, secondary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_check secondary',
				], [
					'title' => esc_html__('Arrow, primary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_arrow',
				], [
					'title' => esc_html__('Arrow, secondary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_arrow secondary',
				], [
					'title' => esc_html__('Plus, primary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_plus',
				], [
					'title' => esc_html__('Plus, secondary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_plus secondary',
				], [
					'title' => esc_html__('Hyphen, primary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_hyphen',
				], [
					'title' => esc_html__('Hyphen, secondary color', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'carbonick_hyphen secondary',
				], [
					'title' => esc_html__('No List Style', 'carbonick'),
					'selector' => 'ul',
					'classes' => 'no-list-style',
				],
			]
		],
		[
			'title' => esc_html__('Font Family', 'carbonick'),
			'items' => [
				[
					'title' => esc_html__('Content Font', 'carbonick'),
					'inline' => 'span',
					'classes' => 'content-font',
				], [
					'title' => esc_html__('Headings Font', 'carbonick'),
					'inline' => 'span',
					'classes' => 'theme-header-font',
				]
			]
		],
	];

	$settings['style_formats'] = str_replace( '"', "'", json_encode( $style_formats ) );
	$settings['extended_valid_elements'] = 'span[*],a[*],i[*]';
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'carbonick_tiny_mce_before_init' );

function carbonick_theme_add_editor_styles() {
	add_editor_style( 'css/all.min.css' );
}
add_action( 'current_screen', 'carbonick_theme_add_editor_styles' );

function carbonick_categories_postcount_filter($variable)
{
	if (strpos($variable,'</a> (')) {
		$variable = str_replace('</a> (', '<span class="post_count">', $variable);
		$variable = str_replace('</a>&nbsp;(', '<span class="post_count">', $variable);
		$variable = str_replace(')', '</span></a>', $variable);
	} else {
		$variable = str_replace('</a> <span class="count">(', '<span class="post_count">', $variable);
		$variable = str_replace(')', '</span></a>', $variable);
	}

	$pattern1 = '/cat-item-\d+/';
	preg_match_all( $pattern1, $variable,$matches );
	if (isset($matches[0])) {
		foreach ($matches[0] as $value) {
			$int = (int) str_replace('cat-item-', '', $value);
			$icon_image_id = get_term_meta ( $int, 'category-icon-image-id', true );
			if (! empty($icon_image_id)) {
				$icon_image = wp_get_attachment_image_src ( $icon_image_id, 'full' );
				$icon_image_alt = get_post_meta($icon_image_id, '_wp_attachment_image_alt', true);
				$replacement = '$1<img class="cats_item-image" src="'. esc_url($icon_image[0]) .'" alt="'.(! empty($icon_image_alt) ? esc_attr($icon_image_alt) : '').'"/>';
				$pattern = '/(cat-item-'.$int.'+.*?><a.*?>)/';
				$variable = preg_replace( $pattern, $replacement, $variable );
			}
		}
	}

	return $variable;
}
add_filter('wp_list_categories', 'carbonick_categories_postcount_filter');
add_filter('woocommerce_layered_nav_term_html', 'carbonick_categories_postcount_filter');

function carbonick_render_archive_widgets($link_html, $url, $text, $format, $before, $after)
{
	$text = wptexturize($text);
	$url  = esc_url($url);

	if ('link' == $format) {
		$link_html = "\t<link rel='archives' title='" . esc_attr($text) . "' href='$url' />\n";
	} elseif ('option' == $format) {
		$link_html = "\t<option value='$url'>$before $text $after</option>\n";
	} elseif ('html' == $format) {

		$after = str_replace('(', '', $after);
		$after = str_replace(' ', '', $after);
		$after = str_replace('&nbsp;', '', $after);
		$after = str_replace(')', '', $after);

		$after = ! empty($after) ? " <span class='post_count'>".esc_html($after)."</span> " : "";

		$link_html = "<li>" . esc_html($before) . "<a href='" . esc_url($url) . "'>" . esc_html($text) . $after . "</a></li>";
	} else { // custom
		$link_html = "\t$before<a href='$url'>$text</a>$after\n";
	}

	return $link_html;
}
add_filter( 'get_archives_link', 'carbonick_render_archive_widgets', 10, 6 );

// Add image size
if (function_exists( 'add_image_size' )) {
	add_image_size( 'carbonick-700-700',  700, 700, true  );
}

// Include Woocommerce init if plugin is active
if (class_exists( 'WooCommerce' )) {
	require_once( get_theme_file_path ( '/woocommerce/woocommerce-init.php' ) );
}

add_filter('carbonick_enqueue_shortcode_css', 'carbonick_render_css');
function carbonick_render_css($styles) {
	global $carbonick_dynamic_css;
	if (! isset($carbonick_dynamic_css['style'])) {
		$carbonick_dynamic_css = [];
		$carbonick_dynamic_css['style'] = $styles;
	} else {
		$carbonick_dynamic_css['style'] .= $styles;
	}
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function carbonick_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'carbonick_pingback_header' );
