<?php

/**
 * Adds StoreCommerce_Youtube_Video_Slider widget.
 */
class StoreCommerce_Youtube_Video_Slider extends AFthemes_Widget_Base
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
            'storecommerce-youtube-video-slider-subtitle',
        );

        $this->url_fields = array(
            'storecommerce-youtube-video-url-1',
            'storecommerce-youtube-video-url-2',
            'storecommerce-youtube-video-url-3',

        );


        $widget_ops = array(
            'classname' => 'storecommerce_video_slider_widget',
            'description' => __('Displays youtube video slider.', 'storecommerce'),
            'customize_selective_refresh' => true,
        );

        parent::__construct('storecommerce_video_slider', __('AFTSC YouTube Video Slider', 'storecommerce'), $widget_ops);
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


        echo $args['before_widget'];

        ?>
        
        <?php if (!empty($mp_video_url = $instance['storecommerce-youtube-video-url-1'])): ?>
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
        <div class="slider-pro video-slider">
            <div class="sp-slides">
                <?php for ($i = 1; $i <= 3; $i++) { ?>
                    <div class="sp-slide">
                        <?php
                            $mp_video_url = $instance['storecommerce-youtube-video-url-' . $i];

                            ?>
                        <?php if (!empty($mp_video_url)) { ?>
                            <?php
                            $url = $mp_video_url;
                            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);

                            ?>
                            <div class="video-wrap">    
                            <a class="sp-video" href="<?php echo esc_url($mp_video_url); ?>">
                                <img src="https://img.youtube.com/vi/<?php echo $my_array_of_vars['v']; ?>/maxresdefault.jpg">
                                    <div class="video-desp-wrap">    
                                    <div class="video-desp-tbl">    
                                    <div class="video-desp-tcl">    
                                        <i class="fa fa-youtube-square"></i>
                                        <div class="sp-title-container">
                                            <h2><?php //echo esc_html($mp_video_titles); ?></h2>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                            </a>
                            </div>

                        <?php } else {
                            //_e('Video URL not found','storecommerce' );
                        } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="af-sp-arrows"></div>
            <div class="sp-thumbnails">
                <?php for ($j = 1; $j <= 3; $j++) { ?>
                    <?php
                        $mp_video_urls = $instance['storecommerce-youtube-video-url-' . $j] ;
                    ?>
                    <?php if (!empty($mp_video_urls)) { ?>
                        <?php
                        $url = $mp_video_urls;
                        parse_str(parse_url($url, PHP_URL_QUERY), $video_array);
                        ?>
                        <div class="sp-thumbnail">
                            <div class="sp-thumbnail-image-container">
                                <img src="https://img.youtube.com/vi/<?php echo $video_array['v']; ?>/mqdefault.jpg">
                                <span class="youtube-icon">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-youtube-square fa-stack-1x fa-inverse"></i>
                                    </span>    
                                </span>    
                            </div>
                        </div>
                    <?php } else {
                        //_e('Video URL not found','storecommerce' );
                    } ?>
                <?php } ?>
            </div>
        </div>
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
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-1', 'YouTube URL 1', '');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-3', 'YouTube URL 2', '');
        echo parent::storecommerce_generate_text_input('storecommerce-youtube-video-url-2', 'YouTube URL 3', '');





    }

}