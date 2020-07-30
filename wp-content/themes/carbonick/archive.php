<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Carbonick
 * @since 1.0
 * @version 1.0
 */

get_header();

$sb = Carbonick_Theme_Helper::render_sidebars('blog_list');
$row_class = $sb['row_class'];
$container_class = $sb['container_class'];
$column = $sb['column'];

?>
    <div class="wgl-container<?php echo apply_filters('carbonick_container_class', $container_class); ?>">
        <div class="row<?php echo apply_filters('carbonick_row_class', $row_class); ?>">
            <div id='main-content' class="wgl_col-<?php echo apply_filters('carbonick_column_class', $column); ?>"><?php
                // List of Post
                get_template_part('templates/post/posts-list');
                // Pagination
                echo Carbonick_Theme_Helper::pagination();
                ?>
            </div>
            <?php
                echo (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
            ?>
        </div>
    </div>
    
<?php

get_footer();

?>