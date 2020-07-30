<?php

$single = Carbonick_Single_Post::getInstance();
$single->set_data();

$single_author_info = Carbonick_Theme_Helper::get_option('single_author_info');
$single_meta = Carbonick_Theme_Helper::get_option('single_meta');
$show_tags = Carbonick_Theme_Helper::get_option('single_meta_tags');
$hide_featured = Carbonick_Theme_Helper::options_compare('post_hide_featured_image', 'mb_post_hide_featured_image', '1');

$show_share = Carbonick_Theme_Helper::get_option('single_share');
$show_likes = Carbonick_Theme_Helper::get_option('single_likes');
$show_views = Carbonick_Theme_Helper::get_option('single_views');

?>
<article class="blog-post blog-post-single-item format-<?php echo esc_attr($single->get_pf()); ?>">
	<div <?php post_class("single_meta"); ?>>
		<div class="item_wrapper">
			<div class="blog-post_content"><?php

				if ( ! $hide_featured ) {
					$pf_type = $single->get_pf();
					$video_style = function_exists("rwmb_meta") ? rwmb_meta('post_format_video_style') : '';
					if ( $pf_type !== 'standard-image' && $pf_type !== 'standard' ) {
						if ( $pf_type === 'video' && $video_style === 'bg_video' ) {
						} else {
							$single->render_featured(			
								$link_feature = false,
								$image_size = 'full',
								$aq_image = false,
								$hide_postmeta = true,
								$meta_cats = false
							);
						}
					}
				}

				the_content();

				wp_link_pages(
					[
						'before' => '<div class="page-link"><span class="pagger_info_text">' . esc_html__( 'Pages', 'carbonick' ) . ': </span>',
						'after' => '</div>'
					]
				);

				if ( ! $show_tags && has_tag() || $show_share || $show_views || $show_likes ) :

					echo '<div class="single_post_info">';

						// Tags
						if ( ! $show_tags && has_tag() ) {
							the_tags('<div class="tagcloud-wrapper"><div class="tagcloud">', ' ', '</div></div>');
						}

						// Views
						if ( $show_views ) {
							echo '<div class="blog-post_views-wrap">', $single->get_post_views(get_the_ID()), '</div>';
						}

						// Likes
						if ( $show_likes && function_exists('wgl_simple_likes') ) {
							echo '<div class="blog-post_likes-wrap">', wgl_simple_likes()->likes_button( get_the_ID(), 0 ), '</div>';
						}

					echo '</div>'; // post_info

					echo '<div class="post_info-divider"></div>';

					// Shares
					if ( $show_share && function_exists('wgl_theme_helper') ) :
						
						echo '<div class="single_info-share_social-wpapper">',
						wgl_theme_helper()->render_post_share('yes'),
						'</div>';
					
					endif; 

				else :

					echo '<div class="post_info-divider"></div>';

				endif;

				// Author Info
				if ( $single_author_info ) $single->render_author_info();

				?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</article>