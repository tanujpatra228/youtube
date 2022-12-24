<?php
/*
 * Plugin Name:       IWS Custom Code
 * Description:       Add custom code
 * Author:            Tanuj G. Patra
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 */

remove_filter('the_excerpt', 'wpautop');
remove_filter('the_content', 'wpautop');

function iwsGetFeaturedImgSrc($obj, $fieldName, $request)
{
    if ($obj['featured_media']) {
        $img = wp_get_attachment_image_src($obj['featured_media'], 'full');
        return $img[0];
    }

    return false;
}
add_action('rest_api_init', function () {
    register_rest_field('post', 'featured_src', [
        'get_callback' => 'iwsGetFeaturedImgSrc',
    ]);
});