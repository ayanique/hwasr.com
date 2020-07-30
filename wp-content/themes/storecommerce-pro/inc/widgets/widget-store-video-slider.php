<?php

/**
 * Adds StoreCommerce_Video_Slider widget.
 */
class StoreCommerce_Video_Slider extends AFthemes_Widget_Base
{
    /**
     * Sets up a new widget instance.
     *
     * @since 1.0.0
     */
    function __construct()
    {
        $this->text_fields = array(
            'storecommerce-youtube-video-slider-title',
            'storecommerce-youtube-video-slider-subtitle'
        );

        $this->url_fields = array(
            'storecommerce-youtube-video-url-1',
            'storecommerce-youtube-video-url-2',
            'storecommerce-youtube-video-url-3',
            'storecommerce-youtube-video-url-4',
            'storecommerce-youtube-video-url-5'
        );


        $widget_ops = array(
            'classname' => 'storecommerce_video_slider_widget',
            'description' => __('Displays youtube video slider.', 'storecommerce'),
            'customize_selective_refresh' => true,
        );

        parent::__construct('storecommerce_video_slider', __('StoreCommerce Video Slider', 'storecommerce'), $widget_ops);
    }

    /**
     * Outputs the content for the current widget instance.
     *
     * @since 1.0.0
     *
     * @param array $args Display arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $instance = parent::storecommerce_sanitize_data($instance, $instance);
        $title = apply_filters('widget_title', $instance['storecommerce-youtube-video-slider-title'], $instance, $this->id_base);
        $subtitle = isset($instance['storecommerce-youtube-video-slider-subtitle']) ? $instance['storecommerce-youtube-video-slider-subtitle'] : '';

        $videos = array();
        for ($i = 1; $i <= 5; $i++) {
            if (isset($instance['storecommerce-youtube-video-url-'.$i]) && !empty($instance['storecommerce-youtube-video-url-'.$i])){
                $videos[] = $instance['storecommerce-youtube-video-url-'.$i];
            }
        }

        echo $args['before_widget'];

        ?>
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
        <?php if ($videos): ?>
        <div class="container-wrapper">    
            <div class="owl-video-slider owl-carousel owl-theme">

                    <?php foreach ($videos as $video): ?>
                                <?php parse_str(parse_url($video, PHP_URL_QUERY), $my_array_of_vars); ?>
                                <div class="item-video"><a class="owl-video" href="<?php echo esc_url($video); ?>"></a></div>
                    <?php endforeach;  ?>

            </div>
        </div>

    <?php endif; ?>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @since 1.0.0
     *
     * @param array $instance Previously saved values from database.
     *
     *
     */
    public function form($instance)
    {
        $this->form_instance = $instance;
        // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-slider-title', 'Title', 'YouTube Video Slider Title');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-slider-subtitle', 'Subtitle', 'YouTube Video Slider Subtitle');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-1', 'YouTube URL', '');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-2', 'YouTube URL', '');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-3', 'YouTube URL', '');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-4', 'YouTube URL', '');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-5', 'YouTube URL', '');


    }

}