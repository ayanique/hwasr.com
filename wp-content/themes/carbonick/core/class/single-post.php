<?php

defined( 'ABSPATH' ) || exit;


if (! class_exists('Carbonick_Single_Post')) {
	/**
	* @class        Carbonick_Single_Post
	* @version      1.0
	* @category     Class
	* @author       WebGeniusLab
	*/

	class Carbonick_Single_Post
	{
		/**
		 * @var SinglePost
		 */
		private static $instance;

		/**
		 * @var \WP_Post
		 */
		private $post_id;
		private $post_format;
		private $show_meta_date;
		private $show_meta_author;
		private $show_meta_comments;
		private $show_meta_cats;
		private $show_meta_likes;
		private $show_meta_shares;

		/**
		 * @return SinglePost
		 */
		public static function getInstance()
		{
			if (null === static::$instance) {
				static::$instance = new static();
			}
			return static::$instance;
		}

		private function __construct () {
			$this->post_id = get_the_ID();   	
		}

		public function set_post_meta($args = false)
		{
			if (! $args || empty($args)) {
				$this->show_meta_date = true;
				$this->show_meta_author = true;
				$this->show_meta_comments = true;
				$this->show_meta_cats = true;
				$this->show_meta_likes = true;
				$this->show_meta_share = true;
			} else {
				$this->show_meta_date = isset($args['date']) ? $args['date'] : '';
				$this->show_meta_author = isset($args['author']) ? $args['author'] : '';
				$this->show_meta_comments = isset($args['comments']) ? $args['comments'] : '';
				$this->show_meta_cats = isset($args['category']) ? $args['category'] : '';
				$this->show_meta_likes = isset($args['likes']) ? $args['likes'] : '';
				$this->show_meta_share = isset($args['share']) ? $args['share'] : '';
			}
		}

		public function set_data_image( $link_feature = false, $image_size = 'full', $aq_image = false)
		{
			$this->meta_info_render = false;
			
			$media = false;
			if (class_exists('RWMB_Loader')) {
				switch($this->post_format) {
					case 'gallery':
						$this->meta_info_render = true;
						$media = $this->featured_gallery($link_feature, $image_size);
						break;
					case 'video':
						if(is_single()){
							$this->meta_info_render = false;	
						}else{
							$this->meta_info_render = true;
						}
						
						$media = $this->featured_video($image_size, $aq_image);
						break;           
					case 'quote':
					case 'link':
					case 'audio':
						$this->meta_info_render = false;
						break;
					default:
						$this->meta_info_render = true;
						$media = $this->featured_image($link_feature, $image_size, $aq_image);
						break;

				}
				
			} else {
				$this->meta_info_render = true;
				$media = $this->featured_image($link_feature, $image_size, $aq_image);
			}
			
			if (empty($media)) {
				$this->meta_info_render = false;
			} 		
			$this->post_format = get_post_format(); 
		}

		public function set_data_image_hero ($link_feature = false, $image_size = 'full', $aq_image = false)
		{
			$this->render_bg_image = false;
			
			$media = false;
			if (class_exists('RWMB_Loader')) {
				switch($this->post_format) {
					case 'gallery':
						$this->render_bg_image = true;
						$media = $this->featured_image($link_feature, $image_size);
						break;
					case 'video':
						$this->render_bg_image = true;
						$media = $this->featured_image($link_feature, $image_size, $aq_image);
						break;           
					case 'quote':
					case 'link':
					case 'audio':
						$this->render_bg_image = false;
						break;
					default :
						$this->render_bg_image = true;
						$media = $this->featured_image($link_feature, $image_size, $aq_image);
						break;
				}
			} else {
				$this->render_bg_image = true;
				$media = $this->featured_image($link_feature, $image_size, $aq_image);
			}
			
			if (empty($media)) {
				$this->render_bg_image = false;
			}
			$this->post_format = get_post_format(); 
		}


		public function set_data( $link_feature = false) {
			$this->post_id = get_the_ID();
			$this->post_format = get_post_format(); 
		}


		public function get_pf()
		{
			if (! $this->post_format) {
				$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( $this->post_id ) );
				if (has_post_thumbnail() && ! empty($featured_image_url)) {
					return 'standard-image';
				} else {
					return 'standard';
				}
			}

			return $this->post_format;
		}


		public function render_featured(
			$link_feature = false,
			$image_size = 'full',
			$aq_image = false,
			$hide_postmeta = false,
			$meta_cats = false
		) {
			$class_media_part = $oembed_error = '';

			if (class_exists( 'RWMB_Loader' )) {
				switch($this->post_format) {
					case 'link':
						$media = $this->featured_link();
						break;
					case 'quote':
						$media = $this->featured_quote();
						break;
					case 'audio':
						$media = $this->featured_audio();
						break;
					case 'video':
						$media = $this->featured_video($image_size, $aq_image);
						break;
					case 'gallery':
						$media = $this->featured_gallery($link_feature, $image_size);
						break;
					default:
						$media = $this->featured_image($link_feature, $image_size, $aq_image);
						break;
				}
			} else {
				$media = $this->featured_image($link_feature, $image_size, $aq_image);
			}

			if (class_exists('RWMB_Loader') && $this->post_format == 'video') {
				$video_style = rwmb_meta('post_format_video_style');
				if ($video_style == 'bg_video') {
					$class_media_part .= ' video_parallax';
				}
				global $wgl_related_posts;
				if (has_post_thumbnail() && (! is_single() || !empty($wgl_related_posts) ) ) {
					$class_media_part .= ' video_image';
				}
				if(!empty($media)){
					$oembed_error = (bool) strpos($media, 'rwmb-oembed-not-available', 11);
				}
				
			}

			if (!empty($media) && !$oembed_error) {
				echo '<div class="blog-post_media">',
					'<div class="blog-post_media_part', esc_attr($class_media_part), '">',
						$media,
					'</div>';
					
					// Cats
					if (!$hide_postmeta && $this->meta_info_render) {
						$this->render_post_meta($meta_cats);
					}
				echo '</div>';
			}
		}


		public function videobox()
		{
			if ($this->post_format === 'video') {
				$video_style = rwmb_meta('post_format_video_style');
				$video_link = get_post_meta($this->post_id, 'post_format_video_url');
				
				if ($video_style != 'bg_video') {
					wp_enqueue_script('swipebox', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', [], false, false);
					wp_enqueue_style('swipebox', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');
					$uniqrel = uniqid();
					echo '<div class="wgl-video_popup button_align-center">';
						if (isset($video_link[0])) { 
							echo '<a data-rel="youtube-'.esc_attr($uniqrel).'" href="'.esc_url($video_link[0]) .'" class="videobox_wrapper_link videobox">';
						}
						echo '<div class="videobox_content"><span class="videobox_link" style="color: #ffffff;"><span class="videobox_icon" style="border-color: transparent transparent transparent #ffffff"></span></span></div>';
						if (isset($video_link[0])) {
							echo '</a>';
						}
					echo '</div>';
				}
			}
		}


		public function videobox_hero()
		{
			$output = '';

			$video_style = rwmb_meta('post_format_video_style');
			$video_link = get_post_meta($this->post_id, 'post_format_video_url');

			wp_enqueue_script('swipebox', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', [], false, false);
			wp_enqueue_style('swipebox', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');

			$output .= '<div class="wgl-video_popup">';
			  $output .= '<div class="videobox_content">';

				if (isset($video_link[0])) {
					$output .= '<div class="videobox_link_wrapper">';
					$output .= '<a data-rel="youtube-'.esc_attr(uniqid()).'" href="'.esc_url($video_link[0]) .'" class="videobox_link videobox">';

					$output .= '<svg class="videobox_icon" width="35%" height="35%" viewBox="0 0 10 10"><polygon points="1,0 1,10 8.5,5"/></svg>';
					$output .= '</a>';
					$output .= '</div>';
				}

			  $output .= '</div>';
			$output .= '</div>';

			return $output;
		} 

		public function render_bg(
			$link_feature = false,
			$image_size = 'full',
			$aq_image = false,
			$data_animation = null,
			$show_media = true
		) {
			$media = '';
			$video_style = function_exists("rwmb_meta") ? rwmb_meta('post_format_video_style') : '';
			
			$featured_image = Carbonick_Theme_Helper::options_compare('featured_image_type', 'mb_featured_image_conditional', 'custom');
			if ($featured_image == 'replace') {
				$featured_image_replace = Carbonick_Theme_Helper::options_compare('featured_image_replace', 'mb_featured_image_conditional', 'custom');
			}

			switch ($this->post_format) {
				default :
				if (has_post_thumbnail()) {

					if (! empty($featured_image_replace) && is_single()) {
						if (rwmb_meta('mb_featured_image_conditional') == 'custom') {
							$image_id = array_values($featured_image_replace);
							$image_id = $image_id[0]['ID'];
						} else {
							$image_id = $featured_image_replace['id'];
						}
					} else {
						$image_id = get_post_thumbnail_id();
					}

					$image_data = wp_get_attachment_metadata($image_id);
					$image_meta = isset($image_data['image_meta']) ? $image_data['image_meta'] : [];
					$upload_dir = wp_upload_dir();
					$width = '1170';
					$height = '725';
					$image_url = wp_get_attachment_image_src( $image_id, $image_size, false ); 
					$temp_url = $image_url[0];
					if ($aq_image) {
						$arr = $this->image_size_render_bg($image_size);  
						extract($arr);

						if (function_exists('aq_resize')) {
							$image_url[0] = aq_resize($image_url[0], $width, $height, true, true, true);
						}
					}
					$image_url[0] = ! empty($image_url[0]) ? $image_url[0] : $temp_url;
					$media .= $image_url[0];
				}
				break;
			}
			
			if ($this->post_format === 'gallery' && ! is_single()) {
				$media = $this->featured_gallery($link_feature, $image_size);
			} 				
			
			if ($video_style == 'bg_video' && $this->post_format === 'video') {
				$media = $this->featured_video($link_feature, $image_size);
			}
			
			if ($link_feature) echo '<a href="'.esc_url(get_permalink()).'" class="blog-post_feature-link">';

			if ($media && $show_media) {
				if ($this->post_format === 'video' && $video_style == 'bg_video') {
					echo Carbonick_Theme_Helper::render_html($media);
				} elseif ($featured_image != 'off') {
					echo '<div class="blog-post_bg_media" style="background-image:url('.esc_url($media).')"'.(! empty($data_animation) ? $data_animation : "").'></div>';
				}
			}

			if ($link_feature) echo '</a>';
					
		}

		public function featured_bg (
			$link_feature = false,
			$image_size = 'full',
			$aq_image = false,
			$data_animation = null,
			$show_media = true
		) {

			$media = '';
			$video_style = function_exists("rwmb_meta") ? rwmb_meta('post_format_video_style') : '';
			
			$featured_image = Carbonick_Theme_Helper::options_compare('featured_image_type', 'mb_featured_image_conditional', 'custom');
			if ($featured_image == 'replace') {
				$featured_image_replace = Carbonick_Theme_Helper::options_compare('featured_image_replace', 'mb_featured_image_conditional', 'custom');
			}

			$default_media = '';

			if (has_post_thumbnail()) {

				$image_id = get_post_thumbnail_id();

				$image_data = wp_get_attachment_metadata($image_id);
				$image_meta = isset($image_data['image_meta']) ? $image_data['image_meta'] : [];
				$upload_dir = wp_upload_dir();
				$width = '1170';
				$height = '725';
				$image_url = wp_get_attachment_image_src( $image_id, $image_size, false ); 
				$temp_url = $image_url[0];
				if ($aq_image) {
					$arr = $this->image_size_render_bg($image_size);  
					extract($arr);

					if (function_exists('aq_resize')) {
						$image_url[0] = aq_resize($image_url[0], $width, $height, true, true, true);
					}
				}
				$image_url[0] = ! empty($image_url[0]) ? $image_url[0] : $temp_url;
				$default_media .= $image_url[0];
			}

			if (class_exists( 'RWMB_Loader' )) {
				switch($this->post_format) {
					default :
						$media = $default_media;
						break;
				}
			} else {
				$media = $default_media;
			}
			
			echo '<div class="blog-post-hero_thumb">';
				
				if ($link_feature) echo '<a href="', esc_url(get_permalink()), '" class="blog-post_feature-link">';
					
				if ($media && $show_media) {
					echo '<div class="blog-post_bg_media" style="background-image: url(',esc_url($media),')"', (! empty($data_animation) ? $data_animation : ""),'></div>';
				}
					
				if ($link_feature) echo '</a>';
				
			echo '</div>';

		}

		public function render_featured_media($show_media = true)
		{
			$media = '';
			$featured_image = Carbonick_Theme_Helper::options_compare('featured_image_type', 'mb_featured_image_conditional', 'custom');

			if (class_exists( 'RWMB_Loader' )) {
				switch($this->post_format) {
					case 'quote' : $media = $this->featured_quote(); break;
					case 'link'  : $media = $this->featured_link();  break;
					case 'audio' : $media = $this->featured_audio(); break;
					case 'video' : $media = $this->videobox_hero();  break;
				}
			}

			if ($media && $show_media && $featured_image != 'off') {
				if (class_exists( 'RWMB_Loader' )) {
					switch($this->post_format) {
						case 'audio':
						case 'quote':
						case 'link':
						case 'video':
							echo '<div class="blog-post-featured_media">',
								Carbonick_Theme_Helper::render_html($media),
							'</div>';
							break;
					}
				}
			}
		}


		public function featured_image( $link_feature, $image_size, $aq_image = false)
		{
			$output = $featured_image_replace = '';
		
			$featured_image = Carbonick_Theme_Helper::options_compare('featured_image_type', 'mb_featured_image_conditional', 'custom');
			if ($featured_image == 'replace') {
				$featured_image_replace = Carbonick_Theme_Helper::options_compare('featured_image_replace', 'mb_featured_image_conditional', 'custom');
			}

			if ($featured_image != 'off' || ! is_single()) {
				if (has_post_thumbnail() || ! empty($featured_image_replace)) {

					if (! empty($featured_image_replace) && is_single()) {
						if (rwmb_meta('mb_featured_image_conditional') == 'custom') {
							$image_id = array_values($featured_image_replace);
							$image_id = $image_id[0]['ID'];
						} else {
							$image_id = $featured_image_replace['id'];
						}
					} else {
						$image_id = get_post_thumbnail_id();
					}

					$image_data = wp_get_attachment_metadata($image_id);
					$image_meta = isset($image_data['image_meta']) ? $image_data['image_meta'] : [];
					$upload_dir = wp_upload_dir();
					$width = '1170';
					$height = '725';
					$image_url = wp_get_attachment_image_src( $image_id, $image_size, false );
					$temp_url = $image_url[0] ?? '';

					if ($aq_image) {
						$arr = $this->image_size_render($image_size);  
						extract($arr);
						
						if (function_exists('aq_resize')) {
							if(isset($image_url[0])){
								$image_url[0] = aq_resize($image_url[0], $width, $height, true, true, true);
							}
						}
					}
					$image_url[0] = ! empty($image_url[0]) ? $image_url[0] : $temp_url;

					$image_meta['title'] = isset($image_meta['title']) ? $image_meta['title'] : "";

					if ($image_url[0]) {
						if ($link_feature) $output .= '<a href="'.esc_url(get_permalink()).'" class="blog-post_feature-link">';
							$output .= "<img src='" . esc_url($image_url[0]) . "' alt='" . esc_attr($image_meta['title']) . "' />";
						if ($link_feature ) $output .= '</a>';

						$this->post_format = 'standard-image';
					}
				}
			}

			return $output;
		}


		public function featured_video($image_size, $aq_image)
		{
			$output = ''; 
			global $wgl_related_posts;  
			
			$video_style = rwmb_meta('post_format_video_style');
			
			if (is_single() && $video_style != 'bg_video' && empty($wgl_related_posts)) {
				$output .= rwmb_meta('post_format_video_url', 'type=oembed');
			} else {

				$video_link = get_post_meta($this->post_id, 'post_format_video_url');
				$video_start = get_post_meta($this->post_id, 'start_video');
				$video_end = get_post_meta($this->post_id, 'end_video');

				if ($video_style == 'bg_video') {
					wp_enqueue_script('jarallax', get_template_directory_uri() . '/js/jarallax.min.js', [], false, false);
					wp_enqueue_script('jarallax-video', get_template_directory_uri() . '/js/jarallax-video.min.js', [], false, false);
					$class = 'parallax-video';
					$attr = '';
					if (isset($video_link[0]) ) $attr = ' data-video="'. esc_url($video_link[0]) .'"';
					if (isset($video_start[0]) ) $attr  .= ' data-start="'. esc_attr((int)$video_start[0]) .'"';
					if (isset($video_end[0]) ) $attr .= ' data-end="'. esc_attr((int)$video_end[0]) .'"';

					$output .= '<div class="'.esc_attr($class).'"'.$attr.'>';
					if (! is_single()) {
						$output .= '<a href="'.esc_url(get_permalink()).'" class="blog-post_feature-link">';
						$output .= '</a>';
					}
					$output .= '</div>';
				} else {
					if (has_post_thumbnail()) {

						wp_enqueue_script('swipebox', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', [], false, false);
						wp_enqueue_style('swipebox', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');
						$image_id = get_post_thumbnail_id();
						$image_data = wp_get_attachment_metadata($image_id);
						$image_meta = isset($image_data['image_meta']) ? $image_data['image_meta'] : [];
						$upload_dir = wp_upload_dir();
						$width = '1170';
						$height = '725';
						$image_url = wp_get_attachment_image_src( $image_id, $image_size, false );

						if ($aq_image) {
							$arr = $this->image_size_render($image_size);  
							extract($arr);
							if (function_exists('aq_resize')) {
								$image_url[0] = aq_resize($image_url[0], $width, $height, true, true, true);
							}
						}

						if (! $image_url[0] ) return;

						$output .= '<div class="wgl-video_popup stick-bot-center with_image">';
						  $output .= '<div class="videobox_content">';
							$title = isset($image_meta['title']) ? $image_meta['title'] : '';
							$output .= '<div class="videobox_background">';
								$output .= "<img src='" . esc_url( $image_url[0] ) . "' alt='" . esc_attr($title) . "' />";
							$output .= '</div>';

							if (isset($video_link[0])) {
								$output .= '<div class="videobox_link_wrapper">';
								  $output .= '<a data-rel="youtube-'.esc_attr(uniqid()).'" href="'.esc_url($video_link[0]) .'" class="videobox_link videobox">';
									$output .= '<svg class="videobox_icon" width="35%" height="35%" viewBox="0 0 10 10"><polygon points="1,0 1,10 8.5,5"/></svg>';
								  $output .= '</a>';
								$output .= '</div>';
							}

						  $output .= '</div>';
						$output .= '</div>';
					} else {
						$output .= rwmb_meta('post_format_video_url', 'type=oembed');
					}
				}
			}

			return $output;
		}


		public function featured_gallery($link_feature, $image_size)
		{
			$output = '';
			$gallery_data = rwmb_meta('post_format_gallery');

			// Abort, if no any data
			if (empty($gallery_data) ) return;
			
			$arr = $this->image_size_render($image_size);  
			extract($arr);
			$class = 'blog-post_media-slider_slick wgl-carousel_slick fade_slick';
			$class_module = ' wgl-carousel';
			ob_start();
			?>
			<div class="slider-wrapper theme-default<?php echo esc_attr($class_module);?>">
				<div class="<?php echo esc_attr($class);?>">
				<?php
					foreach ($gallery_data as $image) {
						echo '<div class="item_slick">';
						echo '<span>';
							$image_src = aq_resize( $image["full_url"], $width, $height, true, true, true);
							$img = ! empty($image_src) ? $image_src : $image["full_url"];
							$alt = isset($image["alt"]) ? $image["alt"] : '';
							echo "<img src='" , esc_url($img) , "' alt='" . esc_attr($alt) , "' />";
						echo '</span>';
						echo '</div>';
						wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', [], false, false);    	
					}
				?>
				</div>
			</div><?php
			$output = ob_get_clean();

			return $output;
		}


		public function featured_quote()
		{
			$quote_author = rwmb_meta('post_format_qoute_name');
			$quote_author_pos = rwmb_meta('post_format_qoute_position');
			$quote_author_image = rwmb_meta('post_format_qoute_avatar');
			$quote_text = rwmb_meta('post_format_qoute_text');

			if (! empty($quote_author_image)) {
				$quote_author_image = array_values($quote_author_image);
				$quote_author_image = $quote_author_image[0];
				$quote_author_image = $quote_author_image['url'];
			} else {
				$quote_author_image = '';
			}

			// render Quote text
			ob_start();
			if (! empty($quote_text) ) : ?>
				<h4 class="blog-post_quote-text"><?php echo esc_html($quote_text); ?></h4>
				<?php
			endif;
			$output = ob_get_clean();

			// render Author Image
			ob_start();
			if (! empty($quote_author_image)) { ?>
				<img src="<?php echo esc_url($quote_author_image);?>"  class="blog-post_quote-image" alt="<?php echo esc_attr($quote_author);?>">
				<?php
			}
			$autor_avatar = ob_get_clean(); // Get Author image

			ob_start();
			// Render basic quote container
			if (strlen($quote_author)) : ?>
				<div class="blog-post_quote-author"><?php
					echo Carbonick_Theme_Helper::render_html($autor_avatar);
					echo esc_html($quote_author);
					if (! empty($quote_author_pos)) {
						echo ', <span class="blog-post_quote-author-pos">',
							esc_html($quote_author_pos),
						'</span>';
					}
					?>
				</div><?php
			endif;

			$output .= ob_get_clean(); // Get Quote HTML

			return $output;
		}


		public function featured_link ()
		{
			$link = rwmb_meta('post_format_link_url');
			$link_text = rwmb_meta('post_format_link_text');

			ob_start(); ?>
			<h4 class="blog-post_link">
				<?php
				if (! empty($link)) {
					echo '<a class="link_post" href="' , esc_url($link) , '">';
				} else {
					echo '<span class="link_post">';
				}

				if (! empty($link_text)) {
					echo esc_attr($link_text);
				} else {
					echo esc_attr($link);
				}

				if (! empty($link)) {
					echo '</a>';
				} else {
					echo '</span>';
				}

				?>
			</h4><?php
			$output = ob_get_clean();

			return $output;
		}


		public function image_size_render($image_size)
		{
			$arr = [];
			switch ($image_size) {
				default: $arr = ['width' => '1170', 'height' => '725' ]; break;
				case 'carbonick-700-700': $arr = [ 'width' => '700', 'height' => '700' ]; break;
				case 'carbonick-800-700': $arr = [ 'width' => '800', 'height' => '700' ]; break;
				case 'carbonick-700-550': $arr = [ 'width' => '700', 'height' => '550' ]; break;
				case 'carbonick-440-440': $arr = [ 'width' => '440', 'height' => '440' ]; break;
				case 'carbonick-420-300': $arr = [ 'width' => '420', 'height' => '300' ]; break;
			} 
			return $arr; 
		}


		public function image_size_render_bg($image_size)
		{
			$arr = [];
			switch ($image_size) {
				default: $arr = [ 'width' => '1170', 'height' => '725' ]; break;
				case 'carbonick-700-700': $arr = [ 'width' => '700', 'height' => '700' ]; break;
				case 'carbonick-800-700': $arr = [ 'width' => '800', 'height' => '700' ]; break;
				case 'carbonick-740-560': $arr = [ 'width' => '740', 'height' => '560' ]; break;
				case 'carbonick-700-550': $arr = [ 'width' => '700', 'height' => '550' ]; break;
				case 'carbonick-740-830': $arr = [ 'width' => '740', 'height' => '830' ]; break;
			}
			return $arr; 
		}


		public function featured_audio()
		{
			$output = '';
			$audio_meta = get_post_meta($this->post_id, 'post_format_audio_url');

			if (! empty($audio_meta)) {
				$audio_embed = rwmb_meta('post_format_audio_url', 'type=oembed');
				$output = $audio_embed;
			}

			return $output;
		}


		public function render_post_meta($args = false)
		{
			$this->set_post_meta($args);

			if ($this->show_meta_cats) {
				$this->render_post_cats();
			}

			if ($this->show_meta_date || $this->show_meta_author || ($this->show_meta_comments && isset($args['comments_single']) ) ) :
			  echo '<div class="meta-wrapper post-meta-data">';

				if ($this->show_meta_date) {
					echo '<span class="post_date"><i class="post_date-icon far fa-calendar-alt"></i>',
						esc_html(get_the_time(get_option( 'date_format' ))),
					'</span>';
				}

				if ($this->show_meta_comments && isset($args['comments_single'])) {
					$comments_num = get_comments_number($this->post_id);
					echo '<span class="post_comments">',
						'<a href="',
						esc_url(get_comments_link()),
						'" title="',
						esc_attr__('Leave a reply', 'carbonick'),
						'">',
						'<i class="post_comments-icon flaticon-chat-1"></i>',
						esc_html($comments_num),
						' ',
						esc_html(_n('Comment', 'Comments', $comments_num, 'carbonick')),
						'</a>',
						'</span>';
				}

				if ($this->show_meta_author) {
					echo '<span class="post_author">',
						'<i class="post_author-icon flaticon-user"></i>',
						esc_html__('by ', 'carbonick'),
						'<a href="', esc_url(get_author_posts_url(get_the_author_meta('ID'))), '">',	
							esc_html( get_the_author_meta('display_name') ),
						'</a>',
					'</span>';
				}

			  echo '</div>';
			endif;

			if ($this->show_meta_comments && !isset($args['comments_single'])) {
				$comments_num = get_comments_number($this->post_id);
				echo '<div class="post_comments-container">';
					echo '<span class="post_comments">',
						'<a href="', esc_url(get_comments_link()), '" title="', esc_attr__( 'Leave a reply', 'carbonick'), '">',
							'<i class="flaticon-comment-black-oval-bubble-shape"></i>',
							esc_html($comments_num),
						'</a>',
					'</span>';
				echo '</div>';
			}

			if ($this->show_meta_likes && function_exists('wgl_simple_likes')) {
				echo wgl_simple_likes()->likes_button( get_the_ID(), 0 );
			}				
			
			if ($this->show_meta_share && function_exists('wgl_theme_helper')) {
				echo wgl_theme_helper()->render_post_list_share();
			}	
		}


		public function render_post_cats()
		{
			echo '<span class="post_meta-categories">';
			if ($categories = get_the_category()) {
				foreach ($categories as $category) :
					$color = get_term_meta( $category->term_id, '_category_color', true );
					echo '<span', (! empty($color) ? ' style="color: #'.esc_attr($color).';"' : "" ),'>',
						'<a', (! empty($color) ? ' style="background-color: #'.esc_attr($color).';"' : "" ),' href="', esc_url(get_category_link($category->term_id)), '">',
							$category->cat_name,
						'</a>',
					'</span>';
				endforeach;
			}
			echo '</span>';
		}


		public function get_excerpt()
		{
			ob_start();
			if (has_excerpt()) {
				the_excerpt();
			} 
			return ob_get_clean();
		}


		public function render_excerpt(
			$symbol_count = false,
			$shortcode = false
		) {
			ob_start();
			if (has_excerpt() ) : the_excerpt();
			else : the_content();
			endif;
			$post_content = ob_get_clean();

			if (in_array( $this->post_format, ['audio', 'quote', 'link'] ) && ! $symbol_count) {
				$symbol_count = '185';
			} elseif (! (bool)$symbol_count) {
				$symbol_count = '400';
			}

			if ((bool)Carbonick_Theme_Helper::get_option('blog_post_listing_content') || $shortcode) {
				$post_content = preg_replace( '~\[[^\]]+\]~', '', $post_content);
				$post_content_stripe_tags = strip_tags($post_content);
				$output = Carbonick_Theme_Helper::modifier_character($post_content_stripe_tags, $symbol_count, "...");
			} else {
				$output = $post_content;
			}

			echo '<div class="blog-post_text"><p>', $output, '</p></div>';
		}

		public function get_post_views($postID)
		{
			$count_key = 'post_views_count';
			$count = get_post_meta($postID, $count_key, true);
			if ($count == '') {
				$count = '0';
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, $count);
			}
			$title = esc_html__( 'Total Views', 'carbonick');
			$text = ' <span class="counts_text">' .esc_html( _n( 'View', 'Views', (int)$count, 'carbonick') ). '</span>';

			echo '<div class="wgl-views" title="', esc_attr($title), '">',
				'<span class="counts">',
					esc_html($count),
				'</span>',
			'</div>';
		}

		public function set_post_views($postID)
		{
			if (! current_user_can('administrator')) {
				$user_ip = function_exists('wgl_get_ip') ? wgl_get_ip() : '0.0.0.0';
				$key = $user_ip . 'x' . $postID; 
				$value = [$user_ip, $postID]; 
				$visited = get_transient($key); 

				// check to see if the Post ID/IP ($key) address is currently stored as a transient
				if (false === ( $visited )) {

					// store the unique key, Post ID & IP address for 12 hours if it does not exist
				   set_transient( $key, $value, 60*60*12 );

					$count_key = 'post_views_count';
					$count = get_post_meta($postID, $count_key, true);
					if ($count=='') {
						$count = 0;
						delete_post_meta($postID, $count_key);
						add_post_meta($postID, $count_key, '0');
					} else {
						$count++;
						update_post_meta($postID, $count_key, $count);
					}
				}
			} 
		}


		public function render_author_info()
		{
			$user_email = get_the_author_meta('user_email');
			$user_avatar = get_avatar($user_email, 190);
			$user_first = get_the_author_meta('first_name');
			$user_last = get_the_author_meta('last_name');
			$user_description = get_the_author_meta('description'); 
 
			$avatar_html = ! empty($user_avatar) ? '<div class="author-info_avatar">'.$user_avatar.'</div>' : '';
			$name_html = ! empty($user_first) || ! empty($user_last) ? '<h5 class="author-info_name">'.'<span class="author-excerpt_name">' . esc_html__('About', 'carbonick') . '</span>'.$user_first.' '.$user_last.'</h5>' : '';

			$description = ! empty($user_description) ? '<div class="author-info_description">'.$user_description.'</div>' : '';

			$social_medias = '';
			if (function_exists('wgl_user_social_medias_arr')) {
				foreach (wgl_user_social_medias_arr() as $social => $value) {
					$social_medias .= ! empty( get_the_author_meta($social) )
						? '<a href="'.esc_url( get_the_author_meta($social) ).'" class="author-info_social-link fab fa-'.esc_attr($social).'"></a>'
						: '';
				}
			}
			$social_medias = ! empty($social_medias) ? '<div class="author-info_social-wrapper">'.'<span class="title_soc_share">'. $social_medias.'</span></div>' : '';

			if ($name_html && $description ) :
				echo '<div class="author-info_wrapper clearfix">',
					$avatar_html,
					'<div class="author-info_content">',
						$name_html,
						$description,
						$social_medias,
					'</div>',
				'</div>';
			endif;
		}
	}
}