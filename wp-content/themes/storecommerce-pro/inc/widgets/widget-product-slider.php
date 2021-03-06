<?php
if (!class_exists('StoreCommerce_Product_Slider')) :
    /**
     * Adds StoreCommerce_Product_Slider widget.
     */
    class StoreCommerce_Product_Slider extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-product-slider-title', 'storecommerce-product-slider-subtitle', 'storecommerce-product-slider-title-note',   'storecommerce-number-of-items');
            $this->select_fields = array('storecommerce-select-category');

            $widget_ops = array(
                'classname' => 'storecommerce_product_slider_widget grid-layout',
                'description' => __('Displays products slider from selected category.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_product_slider', __('AFTSC Product Slider', 'storecommerce'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['storecommerce-product-slider-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-product-slider-subtitle']) ? $instance['storecommerce-product-slider-subtitle'] : '';
            $title_note = isset($instance['storecommerce-product-slider-title-note']) ? $instance['storecommerce-product-slider-title-note'] : '';

            $category = isset($instance['storecommerce-select-category']) ? $instance['storecommerce-select-category'] : '0';
            $number_of_items = isset($instance['storecommerce-number-of-items']) ? $instance['storecommerce-number-of-items'] : '5';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="products">
                <div class="container-wrapper">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                        <span class="header-after">
                            <?php echo esc_html($title); ?>
                        </span>
                                    <?php if(!empty($title_note)): ?><span class="title-note"><?php echo esc_html($title_note); ?></span><?php endif; ?>
                                </h4>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)): ?>

                                <span class="section-subtitle">
                            <?php echo esc_html($subtitle); ?>
                        </span>

                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <?php
                    $all_posts = storecommerce_get_products($number_of_items, $category);
                    ?>
                    <div class="product-section-wrapper section-body">
                            <ul class="product-ul product-slider owl-carousel owl-theme">
                                <?php
                                if ($all_posts->have_posts()) :
                                    while ($all_posts->have_posts()): $all_posts->the_post();

                                        ?>
                                        <li class="item">
                                            <?php storecommerce_get_block('product-loop-extended'); ?>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
                    </div>
            </section>


            <?php
            //print_pre($all_posts);

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
            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::storecommerce_generate_text_input('storecommerce-product-slider-title', 'Title', 'Product Slider');
                echo parent::storecommerce_generate_text_input('storecommerce-product-slider-subtitle', 'Subtitle', 'Product Slider Subtitle');
                echo parent::storecommerce_generate_text_input('storecommerce-product-slider-title-note', 'Title Note', '');
                echo parent::storecommerce_generate_select_options('storecommerce-select-category', __('Select category', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '5', 'number');


            }
        }
    }
endif;