<?php /**
 * @author Bill Minozzi
 * @copyright 2017
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function cardealer_show_cars($atts)
{
    Global $CarDealer_hp_or_kw;
 
  $output = '<div id="cardealer_content">';
      
  if (isset($atts['onlybar']))
      {
         $output .= carDealer_search(1);
         $output .= '</div'; 
         return $output;
       }
 
 
          
  $cardealer_pagination = 'yes';
    if (!isset($postNumber)) {
        $postNumber = get_option('CarDealer_quantity', 6);
    }
    if (empty($postNumber)) {
        $postNumber = get_option('CarDealer_quantity', 6);
    }
    $output .= CarDealer_search(1);
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    }
    if(! isset($paged))
       $paged = cardealer_get_page();
    global $wp_query;
    wp_reset_query();
            $args = array(
                'post_type' => 'cars',
                'showposts' => $postNumber,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'ASC');
        if (!empty($orderby)) {
            $args['orderby'] = 'meta_value';
            $args['meta_type'] = 'NUMERIC';
            if ($orderby == 'price_high') {
                $args['meta_key'] = 'car-price';
                $args['order'] = 'DESC';
            }
            if ($orderby == 'price_low') {
                $args['meta_key'] = 'car-price';
                $args['order'] = 'ASC';
            }
            if ($orderby == 'year_high') {
                $args['meta_key'] = 'car-year';
                $args['order'] = 'DESC';
            }
            if ($orderby == 'year_low') {
                $args['meta_key'] = 'car-year';
                $args['order'] = 'ASC';
            }
        } else {
            $args['orderby'] = 'date';
            $args[] = 'ASC';
        }
    $wp_query = new WP_Query($args);
    $qposts = $wp_query->post_count;
    $ctd = 0;
    $CarDealer_measure = get_option('CarDealer_measure', 'M2');
    $output .= '<div class="carGallery">';
    $output .= '<div class="CarDealer_container">';
    while ($wp_query->have_posts()):
        $wp_query->the_post();
        $ctd++;
        $price = get_post_meta(get_the_ID(), 'car-price', true);
        if ($price <> '' and $price != '0') {
            $price = number_format($price);
        } else
            $price = '';
        $image_id = get_post_thumbnail_id();
        if (empty($image_id)) {
            $image = CARDEALERIMAGES . 'image-no-available-800x400_br.jpg';
            $image = str_replace("-", "", $image);
        } else {
            $image_url = wp_get_attachment_image_src($image_id, 'medium', true);
            $image = str_replace("-" . $image_url[1] . "x" . $image_url[2], "", $image_url[0]);
        }
        $CarDealer_thumbs_format = trim(get_option('CarDealer_thumbs_format', '1'));
        if ($CarDealer_thumbs_format == '2')
            $thumb = CarDealer_theme_thumb($image, 300, 225, 'br'); // Crops from bottom right
        else
            $thumb = CarDealer_theme_thumb($image, 400, 200, 'br'); // Crops from bottom right
        $hp = get_post_meta(get_the_ID(), 'car-hp', true);
        $year = get_post_meta(get_the_ID(), 'car-year', true);
        $fuel = get_post_meta(get_the_ID(), 'car-fuel', true);
        $transmission = get_post_meta(get_the_ID(), 'transmission-type', true);
        $miles = get_post_meta(get_the_ID(), 'car-miles', true);
        $output .= '<div>';
        $output .= '<a href="' . get_permalink() . '">';
        $output .= '<div class="CarDealer_gallery_2016">';
        $output .= '<img class="CarDealer_caption_img" src="' . $thumb . '" alt="' .
            get_the_title() . '" />';
        $output .= '<div class="CarDealer_caption_text">';
        $output .= ($price <> '' ? cardealer_currency() . $price : __('Call for Price',
            'cardealer'));
        // $output .= ($price <> '' ? '<br />' : '');
        $output .= '<br />';
       
        //  $output .= ($hp <> '' ? $hp . ' ' . __('HP', 'cardealer') . '<br />' : '');
        if ($hp <> '')
        {
          if ($CarDealer_hp_or_kw == 'hp')
            $output .= ' ' . $hp . __('HP', 'cardealer'). '<br />';
            else
            $output .= ' ' . $hp . __('KW', 'cardealer'). '<br />';   
        }
        $output .= ($year <> '' ? __('Year', 'cardealer') . ': ' . $year . '<br />' : '');
        $output .= ($fuel <> '' ? __('Fuel', 'cardealer') . ': ' . $fuel . '<br />' : '');
        $output .= ($transmission <> '' ? __('Transmission', 'cardealer') . ': ' . $transmission .
            '<br />' : '');
        $miles_label = get_option("CarDealer_measure", "Miles");
        $output .= ($miles <> '' ? __($miles_label, 'cardealer') . ': ' . $miles .
            '<br />' : '');
        $output .= '</div>';
        $output .= '<div class="carTitle">' . get_the_title() . '</div>';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '</div>';
        if ($ctd < $qposts) {
            if ($ctd % 3 == 0) {
                $output .= '</div>';
                $output .= '<div class="CarDealer_container">';
            }
        }
    endwhile;   
    $output .= '</div>'; 
    $output .= '<br/> <br/>';  
    if ($cardealer_pagination == 'yes') {
        $output .= '<div class="cardealer_navigation">';
        $output .= '';
        ob_start();
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => __('Back', 'cardealer'),
            'next_text' => __('Onward', 'cardealer'),
            ));
        $output .= ob_get_contents();
        ob_end_clean();
        $output .= '</div>';
    }
    $output .= '</div>';
    wp_reset_postdata();
    wp_reset_query();
    if ($qposts < 1) {
        $output .= '<h4>' . __('Not Found !', 'cardealer') . '</h4>';
    }
    $output .= '</div>'; /* cardealer_content */
    return $output;
}
add_shortcode('car_dealer', 'cardealer_show_cars'); ?>