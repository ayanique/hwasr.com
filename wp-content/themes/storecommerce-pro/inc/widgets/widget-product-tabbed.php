<?php
if (!class_exists('StoreCommerce_Products_Tabbed')) :
    /**
     * Adds StoreCommerce_Products_Tabbed widget.
     */
    class StoreCommerce_Products_Tabbed extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-tabbed-product-title', 'storecommerce-tabbed-product-subtitle', 'storecommerce-tabbed-product-title-note', 'storecommerce-number-of-items');
            $this->select_fields = array('storecommerce-select-category-1', 'storecommerce-select-category-2', 'storecommerce-select-category-3');

            $widget_ops = array(
                'classname' => 'storecommerce_tabbed_products_carousel_widget grid-layout',
                'description' => __('Displays products tabbed carousel from selected categories.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_posts_carousel', __('AFTSC Tabbed Products Carousel', 'storecommerce'), $widget_ops);
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
            $tab_id = 'tabbed-' . $this->number;

            $title = apply_filters('widget_title', $instance['storecommerce-tabbed-product-title'], $instance, $this->id_base);

            $subtitle = isset($instance['storecommerce-tabbed-product-subtitle']) ? $instance['storecommerce-tabbed-product-subtitle'] : 'Tabbed Products Carousel Subtitle';
            $title_note = isset($instance['storecommerce-tabbed-product-title-note']) ? $instance['storecommerce-tabbed-product-title-note'] : '';
            $category_1 = isset($instance['storecommerce-select-category-1']) ? $instance['storecommerce-select-category-1'] : 0;
            $category_2 = isset($instance['storecommerce-select-category-2']) ? $instance['storecommerce-select-category-2'] : 0;
            $category_3 = isset($instance['storecommerce-select-category-3']) ? $instance['storecommerce-select-category-3'] : 0;
            $number_of_items = isset($instance['storecommerce-number-of-items']) ? $instance['storecommerce-number-of-items'] : '5';


            $categories = array();
            if (absint($category_1) > 0) {
                $categories[] = $category_1;
            }

            if (absint($category_2) > 0) {
                $categories[] = $category_2;
            }

            if (absint($category_3) > 0) {
                $categories[] = $category_3;
            }

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
            <?php if (isset($categories)): ?>
                <div class="section-body">
            <div class="tabbed-head">
            <ul class="nav nav-tabs af-tabs tab-warpper" role="tablist">
            <?php
            $count = 1;
            foreach ($categories as $category):
                $category_by_id = get_term_by('id', $category, 'product_cat');

            if($category_by_id):
            $category_title = $category_by_id->name;
                $class = ($count == 1) ? 'active' : '';
                ?>

                <li class="tab tab-first <?php echo esc_attr($class); ?>">
                    <a href="#<?php echo esc_attr($tab_id); ?>-carousel-<?php echo esc_attr($count); ?>"
                       aria-controls="<?php echo esc_attr($category_title); ?>" role="tab"
                       data-toggle="tab" class="font-family-1">
                        <?php echo esc_html($category_title); ?>
                    </a>
                </li>
<?php
            $count++;
            endif;
            endforeach; ?>

                </ul>
                </div>
                <div class="tab-content">
                        <?php
                        $count = 1;
                        foreach ($categories as $category):
                            $all_posts = storecommerce_get_products($number_of_items, $category);
                            $class = ($count == 1) ? 'active' : '';
                            ?>
                            <div id="<?php echo esc_attr($tab_id); ?>-carousel-<?php echo esc_attr($count); ?>"
                                 role="tabpanel"
                                 class="tab-pane product-section-wrapper <?php echo esc_attr($class); ?>">
                                    <ul class="product-ul tabbed-product-carousel owl-carousel owl-theme">
                                        <?php
                                        if ($all_posts->have_posts()) :
                                            while ($all_posts->have_posts()): $all_posts->the_post();
                                                ?>
                                                <li class="item">
                                                    <?php storecommerce_get_block('product-loop'); ?>
                                                </li>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                        <?php wp_reset_postdata(); ?>
                                    </ul>
                            </div>
                            <?php
                            $count++;
                        endforeach; ?>
                        <!--  First tab ends-->
                    </div>
                    </div>

                    <?php endif; ?>




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
            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::storecommerce_generate_text_input('storecommerce-tabbed-product-title', 'Title', 'Tabbed Products Carousel');
                echo parent::storecommerce_generate_text_input('storecommerce-tabbed-product-subtitle', 'Subtitle', 'Tabbed Products Carousel Subtitle');
                echo parent::storecommerce_generate_text_input('storecommerce-tabbed-product-title-note', 'Title Note', '');
                echo parent::storecommerce_generate_select_options('storecommerce-select-category-1', __('Select category 1', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_select_options('storecommerce-select-category-2', __('Select category 2', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_select_options('storecommerce-select-category-3', __('Select category 3', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '5', 'number');


            }
        }
    }
endif;