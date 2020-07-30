<?php
/**
* Wgl Elementor Extenstion
*
*
* @class        Wgl_Addons_Elementor
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/
define('WGL_ELEMENTOR_ADDONS_URL', plugins_url('/', __FILE__));
define('WGL_ELEMENTOR_ADDONS_PATH', plugin_dir_path(__FILE__));
define('WGL_ELEMENTOR_ADDONS_FILE', __FILE__);

if( ! class_exists('Wgl_Addons_Elementor') ) {

    class Wgl_Addons_Elementor {

        /**
         * Wgl Addons elementor dir path
         *
         * @since 1.0.0
         *
         * @var string The defualt path to elementor dir on this plugin.
         */
        private $dir_path;
        
        private static $instance = null;
        
        public function __construct() {

            $this->dir_path = plugin_dir_path(__FILE__);

            add_action( 'plugins_loaded', array( $this, 'elementor_setup' ) );


            add_action( 'elementor/init', array( $this, 'elementor_init' ) );
            
            add_action( 'elementor/init', array( $this, 'elementor_header_builder' ) );

            add_action( 'elementor/init', array( $this, 'save_custom_schemes' ));

	        add_filter( 'elementor/controls/hover_animations/additional_animations', array( $this, 'additional_animations'), 10, 1);

            add_filter( 'elementor/widgets/wordpress/widget_args',  array( $this, 'wgl_widget_args' ), 10, 1 ); // WPCS: spelling ok.

            add_action( 'elementor/frontend/after_register_styles',function() {
                foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
                    wp_deregister_style( 'elementor-icons-fa-' . $style );
                }
            }, 20 );


        }

        function remove_wp_block_library_css(){
            //wp_dequeue_style( 'wp-block-library' );
        }


        /**
         * Installs default variables and checks if Elementor is installed
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function elementor_setup() {

            // Check if Elementor installed and activated
            // https://developers.elementor.com/creating-an-extension-for-elementor/
           
            if ( ! did_action( 'elementor/loaded' ) ) {
                return;
            }

            // Include Modules files
            $this->includes();

            $this->init_addons();
        }

        /**
         * Include Files
         *
         * Load required core files.
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function includes() {
            $this->init_helper_files();
        }

        /**
         * Require initial necessary files
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function init_helper_files() {
            
            require_once ( $this->dir_path . 'includes/loop_settings.php' );
            require_once ( $this->dir_path . 'includes/icons_settings.php' );
            require_once ( $this->dir_path . 'includes/carousel_settings.php' );
            require_once ( $this->dir_path . 'includes/plugin_helper.php' );

            foreach ( glob( $this->dir_path . 'templates/' . '*.php' ) as $file ) {
                require_once ( $file );
            }  
        }        

        /**
         * Require initial necessary files
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function init_modules_files() {
             foreach ( glob( $this->dir_path . 'modules/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_modules_addon( $file );
            }
            
        }

        /**
         * 
         * Register addon by file name.
         * 
         * @since 1.0.0
         * @access public
         *
         * @param  string $file            File name.
         * @param  object $controls_manager Controls manager instance.
         * 
         * @return void
         */
        public function register_modules_addon( $file ) {
            
            $base  = basename( str_replace( '.php', '', $file ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Modules\%s', $class );
            
            //Class File
            require_once ( $file );

            if ( class_exists( $class ) ) {
                new $class();
            }
        }



        /**
         * Load required file for addons integration
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function init_addons() {

            add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_area' ) );
            add_action( 'elementor/controls/controls_registered', array( $this, 'controls_area'   ) );

            // Register Frontend Widget Scripts
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

            // Register Backend Widget Scripts
            add_action( 'elementor/editor/before_enqueue_scripts'  , array( $this, 'extensions_scripts' ) );

            $this->init_modules_files();
        }

        /** 
         * Load controls require function
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function controls_area() {
            $this->controls_register();
        }        
        
        /**
         * Requires controls files
         * 
         * @since 1.0.0
         * @access private
         */
        private function controls_register() {
           
            foreach ( glob( $this->dir_path . 'controls/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_controls_addon( $file );
            }
        }

        /**
         * 
         * Register addon by file name.
         * 
         * @since 1.0.0
         * @access public
         *
         * @param  string $file            File name.
         * @param  object $controls_manager Controls manager instance.
         * 
         * @return void
         */
        public function register_controls_addon( $file ) {
            
            $controls_manager = \Elementor\Plugin::$instance->controls_manager;
            
            $base  = basename( str_replace( '.php', '', $file ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Controls\%s', $class );
            
            //Class File
            require_once ( $file );

            if ( class_exists( $class ) ) {
                $name_class = new $class();
                $controls_manager->register_control($name_class->get_type(), new $class );
            }
        }


        /** 
         * Load widgets require function
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function widgets_area() {
            $this->widgets_register();
            $this->widgets_header();
        }

        /**
         * Requires widgets files
         * 
         * @since 1.0.0
         * @access private
         */
        private function widgets_register() {
           
            foreach ( glob( $this->dir_path . 'widgets/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_widgets_addon( $file );
            }

        }        
        /**
         * Requires widgets files
         * 
         * @since 1.0.0
         * @access private
         */
        private function widgets_header() {
           
            foreach ( glob( $this->dir_path . 'header/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_widgets_addon( $file );
            }

        }

        private function header_module_check( $class ) {

            if($class === 'WglAddons\Widgets\Wgl_Header_Cart' && !class_exists('\WooCommerce')){
                return false;
            }elseif ($class === 'WglAddons\Widgets\Wgl_Header_Wpml' && !class_exists('\SitePress')){
                return false;
            }else{
                return true;
            }
        
        }

        /**
         * 
         * Register addon by file name.
         * 
         * @since 1.0.0
         * @access public
         *
         * @param  string $file            File name.
         * @param  object $widgets_manager Widgets manager instance.
         * 
         * @return void
         */
        public function register_widgets_addon( $file ) {
            
            $widget_manager = \Elementor\Plugin::instance()->widgets_manager;
            
            $base  = basename( str_replace( '.php', '', $file ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Widgets\%s', $class );

            $module_header = $this->header_module_check( $class );
            
            if(!(bool) $module_header){
                return;
            }
            
            //Class File
            require_once ( $file );

            if ( class_exists( $class ) ) {
                $widget_manager->register_widget_type( new $class );
            }
        }
        
        /**
         * Enqueue scripts.
         *
         * Enqueue all the widgets scripts.
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function widget_scripts() {

            wp_register_script(
                'wgl-elementor-extensions-widgets',
                WGL_ELEMENTOR_ADDONS_URL . '/assets/js/wgl_elementor_widgets.js',
                array('jquery'),
                '1.0.0',
                true
            );                       

            wp_register_script(
                'isotope',
                WGL_ELEMENTOR_ADDONS_URL . 'assets/js/isotope.pkgd.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-appear',
                get_template_directory_uri() . '/js/jquery.appear.js',
                array('jquery'),
                '1.0.0',
                true
            );             

            wp_register_script(
                'jquery-easypiechart',
                get_template_directory_uri() . '/js/jquery.easypiechart.min.js',
                array('jquery'),
                '1.0.0',
                true
            ); 

            wp_register_script(
                'jquery-slick',
                get_template_directory_uri() . '/js/slick.min.js',
                array('jquery'),
                '1.0.0',
                true
            );            
            
            wp_register_script(
                'jarallax',
                get_template_directory_uri() . '/js/jarallax.min.js',
                array('jquery'),
                '1.0.0',
                true
            );            

            wp_register_script(
                'jarallax-video',
                get_template_directory_uri() . '/js/jarallax-video.min.js',
                array('jquery'),
                '1.0.0',
                true
            );             

            wp_register_script(
                'jquery-countdown',
                get_template_directory_uri() . '/js/jquery.countdown.min.js',
                array('jquery'),
                '1.0.0',
                true
            ); 

            wp_register_script(
                'cocoen',
                get_template_directory_uri() . '/js/cocoen.min.js',
                array('jquery'),
                '1.0.0',
                true
            );             

            wp_register_script(
                'perfect-scrollbar',
                get_template_directory_uri() . '/js/perfect-scrollbar.min.js',
                array('jquery'),
                '1.0.0',
                true
            ); 

        }

        /**
         * Elementor Init
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function elementor_init() {

            \Elementor\Plugin::instance()->elements_manager->add_category(
                'wgl-extensions',
                array(
                    'title' => esc_html__('Wgl Extensions', 'carbonick-core')
                ),
            1);

        }        

        /**
         * Header Builder
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function elementor_header_builder() {

            \Elementor\Plugin::instance()->elements_manager->add_category(
                'wgl-header-modules',
                array(
                    'title' => esc_html__('Wgl Header Modules', 'carbonick-core')
                ),
            1);

        }

        public function extensions_scripts(){
         
            wp_enqueue_style( 'flaticon', get_template_directory_uri().'/fonts/flaticon/flaticon.css' );
        }

        public function save_custom_schemes(){

            if(!class_exists('\Carbonick_Theme_Helper')){
                return;
            }

            $schemes_manager = new Elementor\Schemes_Manager();

            $header_font = \Carbonick_Theme_Helper::get_option('header-font');
            $main_font   = \Carbonick_Theme_Helper::get_option('main-font');
            $add_font    = \Carbonick_Theme_Helper::get_option('additional-font');
	        $add_font    = !empty( $add_font ) ? $add_font : $header_font;

            $page_colors_switch = \Carbonick_Theme_Helper::options_compare('page_colors_switch','mb_page_colors_switch','custom');
            $use_gradient_switch = \Carbonick_Theme_Helper::options_compare('use-gradient','mb_page_colors_switch','custom');
            if ($page_colors_switch == 'custom') {
                $theme_color = \Carbonick_Theme_Helper::options_compare('page_theme_color','mb_page_colors_switch','custom');
            } else {
                $theme_color = \Carbonick_Theme_Helper::get_option('theme-primary-color');
            }

            $theme_fonts = array(
                '1' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => esc_attr($header_font['font-weight']),
                ],
                '2' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => esc_attr($header_font['font-weight']),
                ],
                '3' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => esc_attr($main_font['font-weight']),
                ],
                '4' => [
                    'font_family' => esc_attr($add_font['font-family']),
                    'font_weight' => esc_attr($add_font['font-weight']),
                ],
            );
            $scheme_obj_typo = $schemes_manager->get_scheme('typography');
            
            $theme_color = array(
                '1' => esc_attr($theme_color),
                '2' => esc_attr($header_font['color']),
                '3' => esc_attr($main_font['color']),
                '4' => esc_attr($theme_color),
            );

            $scheme_obj_color = $schemes_manager->get_scheme('color');

            //Save Options 
            $scheme_obj_typo->save_scheme($theme_fonts);                
            $scheme_obj_color->save_scheme($theme_color);

        }

        public function wgl_widget_args($params){

            // Default wrapper for widget and title
            $id   = str_replace( 'wp-', '', $params['widget_id']);
            $id   = str_replace( '-', '_', $id);

            $wrapper_before = '<div class="wgl-elementor-widget widget carbonick_widget '.esc_attr($id).'">';
            $wrapper_after = '</div>';
            $title_before = '<div class="widget-title"><span class="widget-title_wrapper">';
            $title_after = '</span></div>';

            $default_widget_args = [
                'id' => "sidebar_".esc_attr(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $params['widget_id'])))),
                'before_widget' => $wrapper_before,  
                'after_widget' => $wrapper_after,
                'before_title' => $title_before,
                'after_title' => $title_after,
            ];

            return $default_widget_args;
        }

	    public function additional_animations($animations) {
		    return array(
			    'default' => esc_html__('WGL Default','carbonick-core')
		    );
	    }

        /**
         * Creates and returns an instance of the class
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return object
         */
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    
    }
}

if ( ! function_exists( 'wgl_addons_elementor' ) ) {
    
    function wgl_addons_elementor() {
        return Wgl_Addons_Elementor::get_instance();
    }
}

wgl_addons_elementor();
