<?php
if (!class_exists('StoreCommerce_Store_Testimonial')) :
    /**
     * Adds StoreCommerce_Store_Testimonial widget.
     */
    class StoreCommerce_Store_Testimonial extends AFthemes_Widget_Base
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
                'classname' => 'storecommerce_store_testimonial_widget grid-layout',
                'description' => __('Displays store testimonial.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_store_testimonial', __('AFTSC Store Testimonial', 'storecommerce'), $widget_ops);
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
            <section class="testimonial">
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
                    <?php
                    $all_posts = storecommerce_get_posts($number_of_items, '0', 'testimonial');
                    ?>
                    <div class="section-body">
                    <div class="testimonial-slider owl-carousel owl-theme">
                        <?php
                        if ($all_posts->have_posts()) :
                            while ($all_posts->have_posts()) : $all_posts->the_post();
                                global $post;
                                if (has_post_thumbnail()) {
                                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'storecommerce-thumbnail');
                                    $url = $thumb['0'];
                                } else {
                                    $url = '';
                                }

                                $testimonial_post = get_post_meta($post->ID, 'testimonial_post', true);
                                $testimonial_website = get_post_meta($post->ID, 'testimonial_website', true);
                                $testimonial_facebook = get_post_meta($post->ID, 'testimonial_facebook', true);
                                $testimonial_twitter = get_post_meta($post->ID, 'testimonial_twitter', true);
                                $testimonial_linkedin = get_post_meta($post->ID, 'testimonial_linkedin', true);

                                ?>
                                <div class="item">
                                    <div class="testimonial-single">
                                        <div class="testi-img">
                                            <img src="<?php echo $url; ?>">
                                        </div>
                                        <div class="testi-details">
                                                <span class="expert">
                                                    <?php the_content(); ?>
                                                </span>
                                            <div class="title-role">
                                                <span class="title-testi"><?php the_title(); ?></span>
                                                <?php if (!empty($testimonial_post)): ?>
                                                    <span class="role-testi"><?php echo esc_html($testimonial_post); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="testi-contacts">
                                                <ul>
                                                    <?php if (!empty($testimonial_website)): ?>
                                                        <li class="testi-website">
                                                            <a href="<?php echo esc_url($testimonial_website); ?>"
                                                               target="_blank">
                                                                <i class="fa fa-link"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($testimonial_facebook)): ?>
                                                        <li class="testi-facebook">
                                                            <a href="<?php echo esc_url($testimonial_facebook); ?>"
                                                               target="_blank">
                                                                <i class="fa fa-facebook-f"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($testimonial_twitter)): ?>
                                                        <li class="testi-twitter">
                                                            <a href="<?php echo esc_url($testimonial_twitter); ?>"
                                                               target="_blank">
                                                                <i class="fa fa-twitter"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($testimonial_linkedin)): ?>
                                                        <li class="testi-linkedin">
                                                            <a href="<?php echo esc_url($testimonial_linkedin); ?>"
                                                               target="_blank">
                                                                <i class="fa fa-linkedin"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
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
                echo parent::storecommerce_generate_text_input('storecommerce-store-testimonial-title', 'Title', 'Store Testimonial');
                echo parent::storecommerce_generate_text_input('storecommerce-store-testimonial-subtitle', 'Subtitle', 'Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, At vero eos et accusam et justo duo dolores et ea rebum. ');
                echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '5', 'number');


            }
        }
    }
endif;