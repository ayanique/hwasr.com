<?php
/**
 * Block Product Carousel support.
 *
 * @package StoreCommerce
 */
?>
<div class="product-wrapper">
    <?php
    global $post;
    $url = storecommerce_get_featured_image($post->ID);
    $cat_display = storecommerce_get_option('aft_product_loop_category');
    ?>
    <div class="product-image-wrapper">
    <?php
    if ($url): ?>
        <a href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_attr($url); ?>">
        </a>
    <?php endif; ?>
    <div class="badge-wrapper">
        <?php do_action('storecommerce_woocommerce_show_product_loop_sale_flash'); ?>
    </div>
    </div>
    <div class="product-description">

        <?php if($cat_display == 'yes'): ?>
            <span class="prodcut-catagory">
            <?php storecommerce_post_categories(); ?>
        </span>
        <?php endif; ?>
        <h4 class="product-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h4>
        <div class="product-rating-wrapper">
            <?php do_action('storecommerce_woocommerce_template_loop_rating'); ?>
        </div>
        <span class="price">
            <?php do_action('storecommerce_woocommerce_after_shop_loop_item_title'); ?>
        </span>
        <?php

        $excerpt = storecommerce_get_excerpt(25, get_the_content());
        echo wp_kses_post(wpautop($excerpt));

        ?>
        <div class="aft-btn-warpper btn-style1">
            <?php do_action('storecommerce_woocommerce_template_loop_add_to_cart');?>
        </div>
    </div>
</div>