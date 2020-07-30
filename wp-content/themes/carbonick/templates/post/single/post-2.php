<?php

$single = Carbonick_Single_Post::getInstance();
$single->set_data();

$show_tags = Carbonick_Theme_Helper::get_option('single_meta_tags');
$single_author_info = Carbonick_Theme_Helper::get_option('single_author_info');
$single_meta = Carbonick_Theme_Helper::get_option('single_meta');
$hide_featured = Carbonick_Theme_Helper::options_compare('post_hide_featured_image', 'mb_post_hide_featured_image', '1');
$single->set_post_views(get_the_ID());

$show_share = Carbonick_Theme_Helper::get_option('single_share');
$show_likes = Carbonick_Theme_Helper::get_option('single_likes');
$show_views = Carbonick_Theme_Helper::get_option('single_views');

$single->set_data_image(false, 'full', false);

$has_media = $single->meta_info_render;

$meta_cats = $meta_args = [];

if ( ! $single_meta ) :
	$meta_cats['category'] = ! (bool)Carbonick_Theme_Helper::get_option('single_meta_categories');	
	$meta_args['date'] = ! (bool)Carbonick_Theme_Helper::get_option('single_meta_date');
	$meta_args['author'] = ! (bool)Carbonick_Theme_Helper::get_option('single_meta_author');
	$meta_args['comments'] = ! (bool)Carbonick_Theme_Helper::get_option('single_meta_comments');
	$meta_args['comments_single'] = true;
endif;

?>
<article class="blog-post blog-post-single-item format-<?php echo esc_attr($single->get_pf()); ?>">
	<div <?php post_class("single_meta"); ?>>
		<div class="item_wrapper">
			<div class="blog-post_content"><?php
				
				if(!$has_media){
					// Cats
					if (!$single_meta) {
						$single->render_post_meta($meta_cats);
					}
				}
				
				// Featured Image
				if ( ! $hide_featured ) {
					$single->render_featured(false, 'full', false, $single_meta, $meta_cats);
				}
				
				echo '<div class="post_meta-wrap">';

					// Date, Author, Comments
					if ( ! $single_meta ) {
						$single->render_post_meta($meta_args);
					}

				echo '</div>'; // meta-wrap

				// Title
				echo '<h2 class="blog-post_title">', get_the_title(), '</h2>';

				the_content();

				wp_link_pages(
					[
						'before' => '<div class="page-link"><span class="pagger_info_text">' .esc_html__( 'Pages', 'carbonick' ). ': </span>',
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
