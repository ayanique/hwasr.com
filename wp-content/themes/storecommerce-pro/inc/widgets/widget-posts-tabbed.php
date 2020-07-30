<?php
if (!class_exists('StoreCommerce_Tabbed_Posts')) :
    /**
     * Adds StoreCommerce_Tabbed_Posts widget.
     */
    class StoreCommerce_Tabbed_Posts extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-tabbed-popular-posts-title', 'storecommerce-tabbed-latest-posts-title', 'storecommerce-tabbed-categorised-posts-title');

            $this->select_fields = array('storecommerce-show-excerpt', 'storecommerce-enable-categorised-tab', 'storecommerce-select-category');

            $widget_ops = array(
                'classname' => 'storecommerce_tabbed_posts_widget',
                'description' => __('Displays tabbed posts lists from selected settings.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_tabbed_posts', __('AFTSC Tabbed Posts', 'storecommerce'), $widget_ops);
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
            $tab_id = 'tabbed-' . $this->number;


            /** This filter is documented in wp-includes/default-widgets.php */

            $show_excerpt = isset($instance['storecommerce-show-excerpt']) ? $instance['storecommerce-show-excerpt'] : 'false';
            $excerpt_length = '25';
            $number_of_posts = '5';

            $popular_title = isset($instance['storecommerce-tabbed-popular-posts-title']) ? $instance['storecommerce-tabbed-popular-posts-title'] : __('StoreCommerce Popular', 'storecommerce');
            $latest_title = isset($instance['storecommerce-tabbed-latest-posts-title']) ? $instance['storecommerce-tabbed-latest-posts-title'] : __('StoreCommerce Latest', 'storecommerce');

            $enable_categorised_tab = isset($instance['storecommerce-enable-categorised-tab']) ? $instance['storecommerce-enable-categorised-tab'] : 'true';
            $categorised_title = isset($instance['storecommerce-tabbed-categorised-posts-title']) ? $instance['storecommerce-tabbed-categorised-posts-title'] : __('Trending', 'storecommerce');
            $category = isset($instance['storecommerce-select-category']) ? $instance['storecommerce-select-category'] : '0';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <div class="container-wrapper">
            <div class="tabbed-container">
                <div class="tabbed-head">
                    <ul class="nav nav-tabs af-tabs tab-warpper" role="tablist">
                        <li class="tab tab-recent active">
                            <a href="#<?php echo esc_attr($tab_id); ?>-recent"
                               aria-controls="<?php esc_attr_e('Recent', 'storecommerce'); ?>" role="tab"
                               data-toggle="tab" class="font-family-1">
                                <?php echo esc_html($latest_title); ?>
                            </a>
                        </li>
                        <li role="presentation" class="tab tab-popular">
                            <a href="#<?php echo esc_attr($tab_id); ?>-popular"
                               aria-controls="<?php esc_attr_e('Popular', 'storecommerce'); ?>" role="tab"
                               data-toggle="tab" class="font-family-1">
                                <?php echo esc_html($popular_title); ?>
                            </a>
                        </li>

                        <?php if ($enable_categorised_tab == 'true'): ?>
                            <li class="tab tab-categorised">
                                <a href="#<?php echo esc_attr($tab_id); ?>-categorised"
                                   aria-controls="<?php esc_attr_e('Categorised', 'storecommerce'); ?>" role="tab"
                                   data-toggle="tab" class="font-family-1">
                                    <?php echo esc_html($categorised_title); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="<?php echo esc_attr($tab_id); ?>-recent" role="tabpanel" class="tab-pane active">
                        <?php
                        storecommerce_render_posts('recent', $show_excerpt, $excerpt_length, $number_of_posts);
                        ?>
                    </div>
                    <div id="<?php echo esc_attr($tab_id); ?>-popular" role="tabpanel" class="tab-pane">
                        <?php
                        storecommerce_render_posts('popular', $show_excerpt, $excerpt_length, $number_of_posts);
                        ?>
                    </div>
                    <?php if ($enable_categorised_tab == 'true'): ?>
                        <div id="<?php echo esc_attr($tab_id); ?>-categorised" role="tabpanel" class="tab-pane">
                            <?php
                            storecommerce_render_posts('categorised', $show_excerpt, $excerpt_length, $number_of_posts, $category);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            </div>
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

            $enable_categorised_tab = array(
                'true' => __('Yes', 'storecommerce'),
                'false' => __('No', 'storecommerce')

            );

            $options = array(
                'false' => __('No', 'storecommerce'),
                'true' => __('Yes', 'storecommerce')

            );


            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry

            ?><h4><?php _e('Latest Posts', 'storecommerce'); ?></h4><?php
            echo parent::storecommerce_generate_text_input('storecommerce-tabbed-latest-posts-title', __('Title', 'storecommerce'), __('Latest', 'storecommerce')); ?>

            <h4><?php _e('Popular Posts', 'storecommerce'); ?></h4><?php
            echo parent::storecommerce_generate_text_input('storecommerce-tabbed-popular-posts-title', __('Title', 'storecommerce'), __('Popular', 'storecommerce'));



            $categories = storecommerce_get_terms();
            if (isset($categories) && !empty($categories)) {
                ?><h4><?php _e('Categorised Posts', 'storecommerce'); ?></h4>
                <?php
                echo parent::storecommerce_generate_select_options('storecommerce-enable-categorised-tab', __('Enable Categorised Tab', 'storecommerce'), $enable_categorised_tab);
                echo parent::storecommerce_generate_text_input('storecommerce-tabbed-categorised-posts-title', __('Title', 'storecommerce'), __('Trending', 'storecommerce'));
                echo parent::storecommerce_generate_select_options('storecommerce-select-category', __('Select category', 'storecommerce'), $categories);

            }
            ?><h4><?php _e('Settings for all tabs', 'storecommerce'); ?></h4><?php
            echo parent::storecommerce_generate_select_options('storecommerce-show-excerpt', __('Show excerpt', 'storecommerce'), $options);


        }
    }
endif;