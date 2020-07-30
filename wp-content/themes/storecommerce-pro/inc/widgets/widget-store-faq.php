<?php
if (!class_exists('StoreCommerce_Store_Faq')) :
    /**
     * Adds StoreCommerce_Store_Faq widget.
     */
    class StoreCommerce_Store_Faq extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-store-faq-title', 'storecommerce-store-faq-subtitle', 'storecommerce-number-of-items');
            $this->select_fields = array('storecommerce-show-all-link', 'storecommerce-select-category');

            $widget_ops = array(
                'classname' => 'product_store_faq_widget',
                'description' => __('Displays frequently asked question lists from selected category.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('product_store_faq', __('AFTSC Store FAQ', 'storecommerce'), $widget_ops);
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
            $title = apply_filters('widget_title', $instance['storecommerce-store-faq-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-store-faq-subtitle']) ? $instance['storecommerce-store-faq-subtitle'] : '';
            $category = isset($instance['storecommerce-select-category']) ? $instance['storecommerce-select-category'] : '0';
            $view_all_link = isset($instance['storecommerce-show-all-link']) ? $instance['storecommerce-show-all-link'] : 'true';
            $number_of_items = isset($instance['storecommerce-number-of-items']) ? $instance['storecommerce-number-of-items'] : '5';

            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="blog">
                <div class="container-wrapper">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <span class="header-after">
                                        <?php echo esc_html($title); ?>
                                    </span>
                                </h4>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)): ?>
                                <span class="section-subtitle">
                                    <?php echo esc_html($subtitle); ?>
                                </span>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <div class="section-body">
                    <div id="accordion-section" class="aft-accordion-section blog-wrapper">
                        <?php
                        $all_posts = storecommerce_get_posts($number_of_items, $category, 'storecommerce_faq');

                        if ($all_posts->have_posts()) :
                            while ($all_posts->have_posts()) : $all_posts->the_post();

                                global $post;

                                ?>
                                <h4><?php the_title(); ?></h4>
                                <div class="col-1">
                                    <div class="blog-single">
                                        <div class="blog-details">
                                            <div class="blog-categories">
                                                <?php storecommerce_post_categories('&nbsp', 'storecommerce_topic'); ?>
                                            </div>
                                            <div class="blog-content">
                                        <span>
                                            <?php echo get_the_excerpt(); ?>
                                        </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($view_all_link == 'true'): ?>
                        <div class="faq-show-all-link btn-style1">
                            <a href="<?php echo get_post_type_archive_link('storecommerce_faq'); ?>"><?php echo _e('View All', 'storecommerce'); ?></a>
                        </div>
                    <?php endif; ?>
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

            $options = array(
                'true' => __('Yes', 'storecommerce'),
                'false' => __('No', 'storecommerce'),

            );
            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry

            $categories = storecommerce_get_terms('storecommerce_topic');
            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::storecommerce_generate_text_input('storecommerce-store-faq-title', __('Title', 'storecommerce'), __('Frequently Asked Questions', 'storecommerce'));
            echo parent::storecommerce_generate_text_input('storecommerce-store-faq-subtitle', __('Subtitle', 'storecommerce'), __('Frequently Asked Questions Subtitle', 'storecommerce'));
            echo parent::storecommerce_generate_select_options('storecommerce-select-category', __('Select category', 'storecommerce'), $categories);
            echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '5', 'number');
            echo parent::storecommerce_generate_select_options('storecommerce-show-all-link', __('Show "View All" link', 'storecommerce'), $options);


        }
    }
endif;