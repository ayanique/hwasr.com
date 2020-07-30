<?php

defined( 'ABSPATH' ) || exit;

$animate_bg = Carbonick_Theme_Helper::get_option('animate_bg');
$bool_animate = false;

if($animate_bg === '1') $animate = true;

if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
	$mb_animate_bg = rwmb_meta('mb_animate_bg');
	if ($mb_animate_bg === 'yes' || ($animate_bg === '1' && $mb_animate_bg === 'default') ) $bool_animate = true;
	else $bool_animate = false;
}


if( $bool_animate === true){
	?><div class="wgl-animate_bg">
        <div class="animate_bg-line"></div>
        <div class="animate_bg-line"></div>
    </div><?php
}

