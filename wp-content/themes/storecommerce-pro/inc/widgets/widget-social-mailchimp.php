<?php
if (!class_exists('StoreCommerce_Social_MailChimp')) :
    /**
     * Adds StoreCommerce_Social_MailChimp widget.
     */
    class StoreCommerce_Social_MailChimp extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-social-mailchimp', 'storecommerce-social-mailchimp-subtitle', 'storecommerce-social-mailchimp-background-image', 'storecommerce-social-mailchimp-shortcode');
            $widget_ops = array(
                'classname' => 'storecommerce_social_mailchimp_widget grid-layout',
                'description' => __('Displays newsletter subscriptions from MailChimp Shortcode.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_social_mailchimp', __('AFTSC MailChimp Subscriptions', 'storecommerce'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['storecommerce-social-mailchimp'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-social-mailchimp-subtitle']) ? $instance['storecommerce-social-mailchimp-subtitle'] : '';
            $background_image = isset($instance['storecommerce-social-mailchimp-background-image']) ? $instance['storecommerce-social-mailchimp-background-image'] : '';

            if($background_image){
                $image_attributes = wp_get_attachment_image_src( $background_image, 'full' );
                $image_src = $image_attributes[0];
                $image_class = 'data-bg data-bg-hover';

            }else{
                $image_src = '';
                $image_class = 'no-bg';
            }
            $desc = isset($instance['storecommerce-social-mailchimp-shortcode']) ? $instance['storecommerce-social-mailchimp-shortcode'] : '';
            $button_text = isset($instance['storecommerce-social-mailchimp-button-text']) ? $instance['storecommerce-social-mailchimp-button-text'] : '';
            $button_url = isset($instance['storecommerce-social-mailchimp-button-url']) ? $instance['storecommerce-social-mailchimp-button-url'] : '';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="social-mailchimp <?php echo esc_attr($image_class); ?>" data-background="<?php echo esc_url($image_src); ?>">
                <div class="container-wrapper">
                    <div class="inner-call-to-action">
                        <div class="mail-wrappper col-md-12">
                            <?php if (!empty($title)): ?>
                                <div class="section-head">
                                    <?php if (!empty($title)): ?>
                                        <h4 class="widget-title section-title whit-col">
                                            <span class="header-after">
                                                <?php echo esc_html($title); ?>
                                            </span>
                                        </h4>
                                    <?php endif; ?>
                                    <?php if (!empty($subtitle)): ?>
                                        <span class="section-subtitle whit-col">
                                            <?php echo esc_html($subtitle); ?>
                                        </span>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                            <div class="suscribe">
                                <div class="inner-suscribe">
                                            <span class="desc"><p><?php echo do_shortcode($desc); ?></p></span>
                                            <span class="btn"><a href="<?php echo esc_url($button_url); ?>"><?php echo esc_html($button_text); ?></a></span>
                                </div>
                            </div>
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


            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::storecommerce_generate_text_input('storecommerce-social-mailchimp', 'Title', 'MailChimp Subscription');
            echo parent::storecommerce_generate_text_input('storecommerce-social-mailchimp-subtitle', 'Subtitle', 'MailChimp Subscription Subtitle');
            echo parent::storecommerce_generate_image_upload('storecommerce-social-mailchimp-background-image', __('Background Image', 'storecommerce'), __('Background Image', 'storecommerce'));
            echo parent::storecommerce_generate_text_input('storecommerce-social-mailchimp-shortcode', 'Shortcode', '');




        }
    }
endif;