<?php /*
Plugin Name: CarDealer 
Plugin URI: http://cardealerplugin.com
Description: Car Dealer Plugin for Car Dealer agency.
Version: 2.77
Text Domain: cardealer
Domain Path: /language
Author: Bill Minozzi
Author URI: http://billminozzi.com
License:     GPL2
Copyright (c) 2017 Bill Minozzi
Car Dealer Right Away is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
cardealer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with cardealer. If not, see {License URI}.
Permission is hereby granted, free of charge subject to the following conditions:
The above copyright notice and this FULL permission notice shall be included in
all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
*/
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
define('CARDEALERVERSION', '2.77');
define('CARDEALERPATH', plugin_dir_path(__file__));
define('CARDEALERURL', plugin_dir_url(__file__));
define('CARDEALERIMAGES', plugin_dir_url(__file__) . 'assets/images/');
include_once (ABSPATH . 'wp-includes/pluggable.php');
$cardealer_plugin = plugin_basename(__file__);
$CarDealer_hp_or_kw = sanitize_text_field(get_option('CarDealer_hp_or_kw', 'HP'));
__('HP', 'cardealer');
__('KW', 'cardealer');


function cardealer_plugin_settings_link($links)
{
    $settings_link = '<a href="options.php?page=cardealer_settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
if (is_admin()) {
    function CarDealer_add_admstylesheet()
    {
        $color = get_user_meta(get_current_user_id(), 'admin_color', true);
        wp_enqueue_style('cardealer-metabox-tabs', CARDEALERURL .
            'includes/post-type/metabox-tabs.css');
        wp_enqueue_style("cardealer-$color", CARDEALERURL .
            'includes/post-type/metabox-$color.css');
        wp_enqueue_script('cardealer-metabox-tabs', CARDEALERURL .
            'includes/post-type/metabox-tabs.js', array('jquery'));
    }
    add_action('admin_print_styles-post.php', 'CarDealer_add_admstylesheet', 1000);
   // $path = dirname(plugin_basename(__file__)) . '/language/';
    $path = basename( dirname( __FILE__ ) ) . '/language';
    $loaded = load_plugin_textdomain('cardealer', false, $path);
    if (!$loaded and get_locale() <> 'en_US') {
        if (function_exists('CarDealer_localization_init_fail'))
            add_action('admin_notices', 'CarDealer_localization_init_fail');
    }
} else {
    add_action('plugins_loaded', 'CarDealer_localization_init');
}
add_filter("plugin_action_links_$cardealer_plugin",
    'cardealer_plugin_settings_link');
require_once (CARDEALERPATH . "settings/load-plugin.php");
require_once (CARDEALERPATH . "settings/options/plugin_options_tabbed.php");
require_once (CARDEALERPATH . 'includes/help/help.php');
require_once (CARDEALERPATH . 'includes/functions/functions.php');
require_once (CARDEALERPATH . 'includes/post-type/meta-box.php');
require_once (CARDEALERPATH . 'includes/post-type/post-functions.php');
require_once (CARDEALERPATH . 'includes/templates/template-functions.php');
require_once (CARDEALERPATH . 'includes/templates/redirect.php');
require_once (CARDEALERPATH . 'includes/widgets/widgets.php');
require_once (CARDEALERPATH . 'includes/search/search-function.php');
require_once (CARDEALERPATH . 'includes/multi/multi.php');
require_once (CARDEALERPATH . 'dashboard/main.php');
require_once (CARDEALERPATH . 'includes/contact-form/multi-contact-form.php');
require_once (CARDEALERPATH . 'includes/team/team.php');
if(is_admin())
{
  require_once (CARDEALERPATH . 'includes/functions/health.php');
  require_once (CARDEALERPATH . 'includes/functions/health_permalink.php');
}
$Cardealer_template_gallery = trim(get_option('CarDealer_template_gallery',
    'yes'));
if ($Cardealer_template_gallery == 'yes')
    require_once (CARDEALERPATH . 'includes/templates/template-showroom.php');
else
    require_once (CARDEALERPATH . 'includes/templates/template-showroom1.php');
require_once (CARDEALERPATH . 'includes/multi/multi-functions.php');
$cardealerurl = esc_url($_SERVER['REQUEST_URI']);
if (strpos($cardealerurl, 'product') !== false or strpos($cardealerurl, '/car/') !== false) {
    $CarDealer_overwrite_gallery = strtolower(get_option('CarDealer_overwrite_gallery',
        'yes'));
    if ($CarDealer_overwrite_gallery == 'yes')
        require_once (CARDEALERPATH . 'includes/gallery/gallery.php');
   // die('xxx');
}
add_action('wp_enqueue_scripts', 'CarDealer_add_files');
function CarDealer_add_files()
{
    wp_enqueue_style('show-room', CARDEALERURL . 'includes/templates/show-room.css');
    wp_enqueue_style('pluginStyleGeneral', CARDEALERURL .
        'includes/templates/template-style.css');
    wp_enqueue_style('pluginStyleSearch2', CARDEALERURL .
        'includes/search/style-search-box.css');
    wp_enqueue_style('pluginStyleSearchwidget', CARDEALERURL .
        'includes/widgets/style-search-widget.css');
    wp_enqueue_style('pluginStyleGeneral4', CARDEALERURL .
        'includes/gallery/css/flexslider.css');
    wp_register_style('jqueryuiSkin', CARDEALERURL . 'assets/jquery/jqueryui.css',
        array(), '1.12.1');
    wp_enqueue_style('jqueryuiSkin');
    wp_enqueue_style('bill-caricons', CARDEALERURL . 'assets/icons/icons-style.css');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_style('pluginStyleGeneral5', CARDEALERURL .
        'includes/contact-form/css/multi-contact-form.css');
    wp_enqueue_style('pluginTeam2', CARDEALERURL .
        'includes/team/team-custom.css'); 
    wp_enqueue_style('pluginTeam1', CARDEALERURL .
        'includes/team/team-custom-bootstrap.css');
    wp_register_style('fontawesome-css', CARDEALERURL . '/assets/fonts/font-awesome/css/font-awesome.min.css', array(), CARDEALERVERSION);
    wp_enqueue_style('fontawesome-css');
}
function CarDealer_activated()
{
    $cardealer_plugin_version = get_site_option('cardealer_plugin_version', '');
    if ($cardealer_plugin_version < CARDEALERVERSION) {
        if ($cardealer_plugin_version < '2.3') {
            if (cardealer_howmanycars() > 0) {
                ob_start();
                cardealer_add_default_fields();
                ob_end_clean();
            }
            add_action('wp_loaded', 'cardealer_update_files');
        }
        if (!add_option('cardealer_plugin_version', CARDEALERVERSION))
            update_option('cardealer_plugin_version', CARDEALERVERSION);
    }
    if (trim(get_option('CarDealer_activated', '')) != '')
        return;
    $w = update_option('CarDealer_activated', '1');
    if (!$w)
        add_option('CarDealer_activated', '1');
        add_action('admin_notices', 'CarDealer_plugin_was_activated');
    $admin_email = get_option('admin_email');
    $old_admin_email = trim(get_option('CarDealer_recipientEmail', ''));
    if (empty($old_admin_email)) {
        $w = update_option('CarDealer_recipientEmail', $admin_email);
        if (!$w)
            add_option('CarDealer_recipientEmail', $admin_email);
    }
    $a = array(
        'CarDealer_show_make',
        'CarDealer_show_type',
        'CarDealer_show_price',
        'CarDealer_show_year',
        'CarDealer_show_condition',
        'CarDealer_show_transmission',
        'CarDealer_show_fuel',
        'CarDealer_show_orderby',
        'CarDealer_show_price');
    $q = count($a);
    for ($i = 0; $i < $q; $i++) {
        $x = trim(get_option($a[$i], ''));
        if ($x != 'yes' and $x != 'no') {
            $w = update_option($a[$i], 'yes');
            if (!$w)
                add_option($a[$i], 'yes');
        }
    }
}
register_activation_hook(__file__, 'CarDealer_activated');
function CarDealer_localization_init()
{
    //$path = CARDEALERPATH . '/language/';
    $path = basename( dirname( __FILE__ ) ) . '/language';
    $loaded = load_plugin_textdomain('cardealer', false, $path);
}
function cardealerplugin_load_bill_stuff()
{
    wp_enqueue_script('jquery-ui-core');
    if( is_admin())
    {
       if( isset( $_GET[ 'taxonomy' ] ) ) 
          $active_tax = sanitize_text_field($_GET[ 'taxonomy' ]);
       if(isset($active_tax))
         if($active_tax == 'team')
             wp_enqueue_media();
    }    
}
add_action('wp_loaded', 'cardealerplugin_load_bill_stuff');
function cardealerplugin_load_feedback()
{
    if (is_admin()) {
        //ob_start();
        require_once (CARDEALERPATH . "includes/feedback/feedback.php");
        if (get_option('bill_last_feedback', '') != '1')
            require_once (CARDEALERPATH . "includes/feedback/feedback-last.php");
        //       ob_end_clean();
    }
}
function cardealerplugin_load_activate()
{
    if (is_admin()) {
        require_once (CARDEALERPATH . 'includes/feedback/activated-manager.php');
    }
}
add_action('wp_loaded', 'cardealerplugin_load_feedback');
add_action('in_admin_footer', 'cardealerplugin_load_activate'); 
if (is_admin()) {
    if (get_option('CarDealer_activated', '0') == '1') {
        add_action('admin_notices', 'CarDealer_plugin_was_activated');
        $r = update_option('CarDealer_activated', '0');
        if (!$r)
            add_option('CarDealer_activated', '0');
    }
}
add_action( 'admin_menu', 'cardealer_add_menu_gopro2' );
$body_type = __('Body Type', 'cardealer');
$condition = __('Condition','cardealer');?>
