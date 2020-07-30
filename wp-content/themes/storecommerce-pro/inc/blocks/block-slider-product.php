<?php
/**
 * Block Product Carousel support.
 *
 * @package StoreCommerce
 */
?>
<?php

$product_ids = array();
$caption_class = array();
$slider_product_1 = storecommerce_get_option('slider_product_1');
if (!empty($slider_product_1)) {
    $product_ids[] = $slider_product_1;
    $caption_class[] = storecommerce_get_option('product_caption_position_1');
}

$slider_product_2 = storecommerce_get_option('slider_product_2');
if (!empty($slider_product_2)) {
    $product_ids[] = $slider_product_2;
    $caption_class[] = storecommerce_get_option('product_caption_position_2');
}
$slider_product_3 = storecommerce_get_option('slider_product_3');
if (!empty($slider_product_3)) {
    $product_ids[] = $slider_product_3;
    $caption_class[] = storecommerce_get_option('product_caption_position_3');
}
$slider_product_4 = storecommerce_get_option('slider_product_4');
if (!empty($slider_product_4)) {
    $product_ids[] = $slider_product_4;
    $caption_class[] = storecommerce_get_option('product_caption_position_4');
}
$slider_product_5 = storecommerce_get_option('slider_product_5');
if (!empty($slider_product_5)) {
    $product_ids[] = $slider_product_5;
    $caption_class[] = storecommerce_get_option('product_caption_position_5');
}

if ($product_ids):

    $query_args = array(
        'post__in' => $product_ids,
        'post_status' => 'publish',
        'post_type' => 'product',
        'no_found_rows' => 1,
        'order' => 'DESC',
        'orderby' => 'post__in',

    );

    $all_posts = new WP_Query($query_args);
    ?>
    <?php if ($all_posts->have_posts()): ?>
    <div class="main-banner-slider owl-carousel owl-theme">
        <?php
        $count = 0;
        while ($all_posts->have_posts()): $all_posts->the_post();

            $url = storecommerce_get_featured_image(get_the_ID(), 'storecommerce-slider-full');

            ?>
            <div class="item">
                <div class="item-single data-bg data-bg-hover data-bg-slide "
                     data-background="<?php echo esc_url($url); ?>">
                    <div class="container-wrapper pos-rel">
                        <div class="content-caption on-<?php echo esc_attr($caption_class[$count]); ?>">
                            <div class="fig-categories">
                                <?php storecommerce_post_categories(); ?>
                            </div>


                            <div class="caption-heading">
                                <h3 class="cap-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                    
                                </h3>
                            </div>
                            <?php do_action('storecommerce_woocommerce_template_loop_rating'); ?>
                            <span class="price">
                                <?php do_action('storecommerce_woocommerce_after_shop_loop_item_title'); ?>
                                <div class="badge-wrapper">
                                    <?php do_action('storecommerce_woocommerce_show_product_loop_sale_flash'); ?>
                                </div>
                            </span>
                            <div class="aft-btn-warpper btn-style1">
                                <?php do_action('storecommerce_woocommerce_template_loop_add_to_cart'); ?>
                            </div>
                            <div class="aft-btn-warpper aft-add-to-wishlist btn-style1">
                                <a href="#">Add to Wishlist</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $count++;
        endwhile; ?>
    </div>
<?php endif; ?>
<?php endif; ?>