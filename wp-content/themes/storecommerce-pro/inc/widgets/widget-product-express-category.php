<?php
if (!class_exists('StoreCommerce_Product_Express_Category')) :
    /**
     * Adds StoreCommerce_Product_Express_Category widget.
     */
    class StoreCommerce_Product_Express_Category extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-product-express-category-title', 'storecommerce-product-express-category-subtitle', 'storecommerce-product-express-category-title-note', 'storecommerce-number-of-items');
            $this->select_fields = array('storecommerce-select-category', 'storecommerce-product-onsale-count', 'storecommerce-product-count');

            $widget_ops = array(
                'classname' => 'storecommerce_product_express_category_widget',
                'description' => __('Displays category details along with product from selected categories.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_product_express_category', __('AFTSC Express Category', 'storecommerce'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         */

        public function widget($args, $instance)
        {

            $instance = parent::storecommerce_sanitize_data($instance, $instance);


            /** This filter is documented in wp-includes/default-widgets.php */

            $title = apply_filters('widget_title', $instance['storecommerce-product-express-category-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-product-express-category-subtitle']) ? $instance['storecommerce-product-express-category-subtitle'] : '';
            $title_note = isset($instance['storecommerce-product-express-category-title-note']) ? $instance['storecommerce-product-express-category-title-note'] : '';
            $category = isset($instance['storecommerce-select-category']) ? $instance['storecommerce-select-category'] : '0';
            $product_count = isset($instance['storecommerce-product-count']) ? $instance['storecommerce-product-count'] : 'true';
            $onsale_product_count = isset($instance['storecommerce-product-onsale-count']) ? $instance['storecommerce-product-onsale-count'] : 'true';
            $number_of_items = isset($instance['storecommerce-number-of-items']) ? $instance['storecommerce-number-of-items'] : '6';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="categories">
                <div class="container-wrapper clearfix">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <span class="header-after">
                                        <?php echo esc_html($title); ?>
                                    </span>
                                    <?php if (!empty($title_note)): ?>
                                        <span class="title-note"><?php echo esc_html($title_note); ?></span><?php endif; ?>
                                </h4>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)): ?>
                                <span class="section-subtitle">
                                    <?php echo esc_html($subtitle); ?>
                                </span>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <div class="section-body clearfix">
                        <?php if (absint($category) > 0): ?>
                            <div class="col-2 float-l pad btm-margi product-ful-wid">
                                <div class="sale-single-wrap">
                                    <?php storecommerce_product_category_loop($category, $product_count, $onsale_product_count); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php $all_posts = storecommerce_get_products($number_of_items, $category); ?>
                        <div class="product-section-wrapper">
                            <!-- <div class="row"> -->
                            <ul class="product-ul">
                                <?php
                                if ($all_posts->have_posts()) :
                                    while ($all_posts->have_posts()): $all_posts->the_post();

                                        ?>
                                        <li class="col-4 float-l pad" data-mh="express-product-loop">
                                            <?php storecommerce_get_block('product-loop'); ?>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </section>

            <?php
            // close the widget container
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance)
        {
            $this->form_instance = $instance;

            $categories = storecommerce_get_terms('product_cat');
            $options = array(
                'true' => __('Yes', 'storecommerce'),
                'false' => __('No', 'storecommerce'),
            );

            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::storecommerce_generate_text_input('storecommerce-product-express-category-title', __('Title', 'storecommerce'), 'Product Express Category');
                echo parent::storecommerce_generate_text_input('storecommerce-product-express-category-subtitle', __('Subtitle', 'storecommerce'), 'Product Express Category Subtitle');
                echo parent::storecommerce_generate_text_input('storecommerce-product-express-category-title-note', __('Title Note', 'storecommerce'), '');
                echo parent::storecommerce_generate_select_options('storecommerce-select-category', __('Select category', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_select_options('storecommerce-product-count', __('Show Product Count', 'storecommerce'), $options);
                echo parent::storecommerce_generate_select_options('storecommerce-product-onsale-count', __('Show On Sale Product Count', 'storecommerce'), $options);
                echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '6', 'number');


            }

            //print_pre($terms);


        }

    }
endif;