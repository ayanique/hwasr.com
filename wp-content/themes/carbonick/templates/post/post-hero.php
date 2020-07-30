<?php
global $wgl_blog_atts;

// Default settings for blog item
$trim = true;
if ( !(bool)$wgl_blog_atts ) {
    $opt_likes = Carbonick_Theme_Helper::get_option('blog_list_likes');
    $opt_share = Carbonick_Theme_Helper::get_option('blog_list_share');
    $opt_meta = Carbonick_Theme_Helper::get_option('blog_list_meta');
    $opt_meta_author = Carbonick_Theme_Helper::get_option('blog_list_meta_author');
    $opt_meta_comments = Carbonick_Theme_Helper::get_option('blog_list_meta_comments');
    $opt_meta_categories = Carbonick_Theme_Helper::get_option('blog_list_meta_categories');
    $opt_meta_date = Carbonick_Theme_Helper::get_option('blog_list_meta_date');
    $opt_read_more = Carbonick_Theme_Helper::get_option('blog_list_read_more');
    $opt_hide_media = Carbonick_Theme_Helper::get_option('blog_list_hide_media');
    $opt_hide_title = Carbonick_Theme_Helper::get_option('blog_list_hide_title');
    $opt_hide_content = Carbonick_Theme_Helper::get_option('blog_list_hide_content');
	$opt_letter_count = Carbonick_Theme_Helper::get_option('blog_list_letter_count');
    $opt_letter_count_hover = Carbonick_Theme_Helper::get_option('blog_list_letter_count_hover');
    $opt_blog_columns = Carbonick_Theme_Helper::get_option('blog_list_columns');
    $opt_blog_columns = empty($opt_blog_columns) ? '12' : $opt_blog_columns;

    global $wp_query;
    $wgl_blog_atts = array(
        'query' => $wp_query,
        // General
        'blog_layout' => 'grid',
        // Content
        'blog_columns' => $opt_blog_columns,
        'hide_media' => $opt_hide_media,
        'hide_content' => $opt_hide_content,
        'hide_blog_title' => $opt_hide_title,
        'hide_postmeta' => $opt_meta,
        'meta_author' => $opt_meta_author,
        'meta_comments' => $opt_meta_comments,
        'meta_categories' => $opt_meta_categories,
        'meta_date' => $opt_meta_date,
        'hide_likes' => !(bool)$opt_likes,
        'hide_share' => !(bool)$opt_share,
        'read_more_hide' => $opt_read_more,
        'content_letter_count' => empty($opt_letter_count_idle) ? '55' : $opt_letter_count,
        'content_letter_count_hover' => empty($opt_letter_count_hover) ? '155' : $opt_letter_count_hover,
        'crop_square_img' => 'true',
        'heading_tag' => 'h3',
        'read_more_text' => esc_html__('... and More', 'carbonick'),
        'items_load'  => 4,
        'heading_margin_bottom' => '11px',

    );
    $trim = false;
}

extract($wgl_blog_atts);

if ((bool)$crop_square_img) {
    $image_size = 'carbonick-740-830';
}else {
    $image_size = 'full';
}


global $wgl_query_vars;
if(!empty($wgl_query_vars)){
    $query = $wgl_query_vars;
}

// Allowed HTML render
$allowed_html = array(
    'a' => array(
        'href' => true,
        'title' => true,
    ),
    'br' => array(),
    'b' => array(),
    'em' => array(),
    'strong' => array()
); 

$blog_styles = '';

$blog_attr = !empty($blog_styles) ? ' style="'.esc_attr($blog_styles).'"' : '';

$heading_attr = isset($heading_margin_bottom) && $heading_margin_bottom != '' ? ' style="margin-bottom: '.(int) $heading_margin_bottom.'px"' : '';
while ($query->have_posts()) : $query->the_post();          

    echo '<div class="wgl_col-'.esc_attr($blog_columns).' item">';

    $single = Carbonick_Single_Post::getInstance();
    $single->set_data();

    $title = get_the_title();

    $blog_item_classes = ' format-'.$single->get_pf();
    $blog_item_classes .= (bool)$hide_media ? ' hide_media' : '';
    $blog_item_classes .= is_sticky() ? ' sticky-post' : '';

    $single->set_data_image_hero(true, $image_size,$aq_image = true);
    $has_media = $single->render_bg_image;

    if((bool)$hide_media){ 
        $has_media = false;
    }
    
    $blog_item_classes .= !(bool) $has_media ? ' format-no_featured' : '';

    $meta_to_show = array(
        'comments' => !(bool)$meta_comments,
        'author' => !(bool)$meta_author,
        'date' => !(bool)$meta_date,
        'likes' => !(bool)$hide_likes,
    );
    $meta_to_show_cats = array(
    	'category' => !(bool)$meta_categories,
    );

    ?>

    <div class="blog-post <?php echo esc_attr($blog_item_classes); ?>"<?php echo Carbonick_Theme_Helper::render_html($blog_attr);?>>
        <div class="blog-post-hero_wrapper">
            <?php

            // Media blog post
            $link_feature = true;
            $single->featured_bg($link_feature, $image_size, $aq_image = true, false, !(bool)$hide_media);

            //Post Meta render cats
            if ( !(bool)$hide_postmeta && !empty($meta_to_show_cats) && (bool) $has_media && $single->get_pf() !== 'video' ) {
	            $single->render_post_meta($meta_to_show_cats);
            }

            //Render link,quote post,etc.
            $single->render_featured_media( !(bool)$hide_media);
            ?>

            <div class="blog-post-hero-content_front">
                <div class="blog-post-hero_content">
                <?php         

                    //Render link,quote post,etc.
                    $single->render_featured_media( !(bool)$hide_media);        

                    //Post Meta render cats
                    if ( !(bool)$hide_postmeta && !empty($meta_to_show_cats) && !(bool) $has_media ) {
                        $single->render_post_meta($meta_to_show_cats);
                    }

                    // Blog Title
                    if ( !(bool)$hide_blog_title && !empty($title) ) :
                        echo sprintf('<%1$s class="blog-post_title"%2$s><a href="%3$s">%4$s</a></%1$s>', esc_html($heading_tag), $heading_attr, esc_url(get_permalink()), wp_kses( $title, $allowed_html ) );
                    endif;

                    // Content Blog
                    if ( !(bool)$hide_content ) $single->render_excerpt($content_letter_count, $trim, !(bool)$read_more_hide, $read_more_text);

                    //Post Meta render comments, author, date, likes, shares
	                if ( !(bool)$hide_postmeta || (! (bool) $hide_share && function_exists( 'wgl_theme_helper' )) ) {
		                echo '<div class="post_meta-wrap">';

		                //Post Meta render comments, author
		                if ( ! (bool) $hide_postmeta ) {
			                $single->render_post_meta( $meta_to_show );
		                }

		                // Render shares
		                if ( ! (bool) $hide_share && function_exists( 'wgl_theme_helper' ) ) {
			                wgl_theme_helper()->render_post_list_share();
		                }
		                echo '</div>';
	                }

                    wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'carbonick') . ': ', 'after' => '</div>'));
                    ?>
                </div>
            </div>

            <div class="blog-post-hero-content_back">
                <div class="blog-post-hero_content">
                <?php         

                    //Post Meta render cats
                    if ( !(bool)$hide_postmeta && !empty($meta_to_show_cats) && ( !(bool) $has_media || $single->get_pf() === 'video' ) ) {
                        $single->render_post_meta($meta_to_show_cats);
                    }

                    $heading_tag_back = 'p'; 
                    // Blog Title
                    if ( !(bool)$hide_blog_title && !empty($title) ) :
                        echo sprintf('<%1$s class="blog-post_title"%2$s><a href="%3$s">%4$s</a></%1$s>', esc_html($heading_tag_back), $heading_attr, esc_url(get_permalink()), wp_kses( $title, $allowed_html ) );
                    endif;
                    // Content Blog
                    if ( !(bool)$hide_content ) $single->render_excerpt ( ( !(bool) $has_media || $single->get_pf() === 'video' ? $content_letter_count : $content_letter_count_hover ), $trim, !(bool)$read_more_hide, $read_more_text);

                    // Read more link
                    if ( !(bool)$read_more_hide ) : ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="button-read-more standard_post"><?php echo esc_html($read_more_text); ?></a>
                    <?php endif;

                    wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'carbonick') . ': ', 'after' => '</div>'));

                    //Post Meta render comments, author, date, likes, shares
                    if ( !(bool)$hide_postmeta || (! (bool) $hide_share && function_exists( 'wgl_theme_helper' )) ) {
                    echo '<div class="post_meta-wrap">';

                        //Post Meta render comments, author
                        if ( ! (bool) $hide_postmeta ) {
                        $single->render_post_meta( $meta_to_show );
                        }

                        // Render shares
                        if ( ! (bool) $hide_share && function_exists( 'wgl_theme_helper' ) ) {
                        wgl_theme_helper()->render_post_list_share();
                        }
                        echo '</div>';
                    }

                    ?>
                </div>                
            </div>
        </div>
    </div>
    <?php

    echo '</div>';

endwhile;
wp_reset_postdata();
