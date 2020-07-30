<?php
if (!class_exists('StoreCommerce_Social_Instagram')) :
    /**
     * Adds StoreCommerce_Social_Instagram widget.
     */
    class StoreCommerce_Social_Instagram extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-instagram-title', 'storecommerce-instagram-subtitle', 'storecommerce-instagram-background-image', 'storecommerce-instagram-access-token', 'storecommerce-instagram-username', 'storecommerce-number-of-items');


            $widget_ops = array(
                'classname' => 'storecommerce_social_instagram_widget grid-layout',
                'description' => __('Displays latest posts from instagram.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_social_instagram', __('AFTSC Instagram', 'storecommerce'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['storecommerce-instagram-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-instagram-subtitle']) ? $instance['storecommerce-instagram-subtitle'] : '';
            $access_token = isset($instance['storecommerce-instagram-access-token']) ? $instance['storecommerce-instagram-access-token'] : '7510889272.577c420.c6d613a1e7d24499ae6432d8e2e6fe9f';
            $username = isset($instance['storecommerce-instagram-username']) ? $instance['storecommerce-instagram-username'] : '';
            $number_of_items = isset($instance['storecommerce-number-of-items']) ? $instance['storecommerce-number-of-items'] : '10';

            // open the widget container
            echo $args['before_widget'];


            if (!empty($username) && !empty($number_of_items)) {
                $media_array = storecommerce_scrape_instagram($username, $access_token, $number_of_items);

                if (is_wp_error($media_array)) {
                    echo wp_kses_post($media_array->get_error_message());
                } else {
                    ?>
                    <section class="instagram">

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
                            <div class="insta-feed-head">
                                <a href="//instagram.com/<?php echo esc_attr(trim($username)); ?>" rel="me"
                                   class="secondary-font" target="_blank">
                                    <p class="instagram-username"><?php echo '/' . $username; ?></p>
                                </a>
                            </div>
                            <div class="insta-carousel owl-carousel owl-theme">
                                <?php
                                foreach ($media_array as $item) { ?>

                                    <div class="item zoom-gallery">
                                        <a href="<?php echo esc_url($item['original']) ?>"
                                           title="<?php if (isset($item['description']['text']) && !empty($item['description']['text'])) {
                                               echo esc_html($item['description']['text']);
                                           } ?>" target="_self"
                                           class="insta-hover">
                                            <figure>
                                                <img src="<?php echo esc_url($item['small']) ?>"/>
                                            </figure>
                                            <div class="insta-details">
                                                <div class="insta-tb">
                                                    <div class="insta-tc">
                                                        <?php if (isset($item['description']['text']) && !empty($item['description']['text'])): ?>
                                                            <p class="insta-desc"><?php echo esc_html(wp_trim_words($item['description']['text'], 15, '...')); ?></p>
                                                        <?php endif; ?>
                                                        <p class="insta-likes"><i
                                                                    class="fa fa-heart"></i><?php echo esc_html($item['likes']); ?>
                                                        </p>
                                                        <p class="insta-comments"><i
                                                                    class="fa fa-comment"></i><?php echo esc_html($item['comments']); ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                                    </div>

                    </section>
                    <?php
                }
            }
            ?>

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


            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::storecommerce_generate_text_input('storecommerce-instagram-title', 'Title', 'Instagram Posts');
            echo parent::storecommerce_generate_text_input('storecommerce-instagram-subtitle', 'Subtitle', 'Instagram Posts Subtitle');
            echo parent::storecommerce_generate_text_input('storecommerce-instagram-access-token', 'Descriptions', '7510889272.577c420.c6d613a1e7d24499ae6432d8e2e6fe9f');
            echo parent::storecommerce_generate_text_input('storecommerce-instagram-username', 'username', 'wpafthemes');
            echo parent::storecommerce_generate_text_input('storecommerce-number-of-items', __('No. of Items', 'storecommerce'), '10', 'number');


        }
    }
endif;