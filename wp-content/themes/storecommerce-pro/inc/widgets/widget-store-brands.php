<?php
if (!class_exists('StoreCommerce_Store_Brands')) :
    /**
     * Adds StoreCommerce_Store_Brands widget.
     */
    class StoreCommerce_Store_Brands extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array(
                'storecommerce-store-testimonial-title',
                'storecommerce-store-testimonial-subtitle',
                'storecommerce-number-of-items'
            );

            $widget_ops = array(
                'classname' => 'storecommerce_store_brands_widget grid-layout',
                'description' => __('Displays store brands.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_store_brands', __('AFTSC Store Brands', 'storecommerce'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['storecommerce-store-testimonial-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-store-testimonial-subtitle']) ? $instance['storecommerce-store-testimonial-subtitle'] : '';
            $number_of_items = isset($instance['storecommerce-number-of-items']) ? $instance['storecommerce-number-of-items'] : '5';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="brands-slider">
                <div class="container-wrapper-full">

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
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'storecommerce_brand',
                        'hide_empty' => false,
                        'number' => $number_of_items,
                    ));

                    ?>
                    <div class="section-body">
                    <div class="brand-carousel owl-carousel owl-theme">
                        <?php
                        if (isset($terms)) :
                            foreach ($terms as $term):

                                $term_name = $term->name;
                                $term_link = get_term_link($term);
                                $meta = get_term_meta($term->term_id);

                                if (isset($meta['thumbnail_id'])) {
                                    $thumb_id = $meta['thumbnail_id'][0];
                                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'full');
                                    $url = $thumb_url[0];
                                } else {
                                    $url = '';
                                }

                                ?>
                                <div class="item">
                                    <a href="<?php echo esc_attr($term_link); ?>">
                                        <img src="<?php echo esc_attr($url); ?>"
                                             title="<?php echo esc_attr($term_name); ?>">
                                    </a>
                                </div>
                            <?php
                            endforeach;
                        endif;

                        ?>
                    </div>
                    </div>


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
            $categories = storecommerce_get_terms();
            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::storecommerce_generate_text_input('storecommerce-store-testimonial-title', 'Title', 'Store Brands');
                echo parent::storecommerce_generate_text_input('storecommerce-store-testimonial-subtitle', 'Subtitle', 'Store Brands Subtitle');
                echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '5', 'number');


            }
        }
    }
endif;