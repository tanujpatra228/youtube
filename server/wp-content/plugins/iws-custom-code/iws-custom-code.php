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

function iwsCreatePostWithFeaturedImg($request) {
    $params = $request->get_params();
    $title = sanitize_text_field($params['title']);
    $content = wp_kses_post($params['content']);

    $post = [
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'post'
    ];

    $postId = wp_insert_post($post);

    // Image upload
    if (isset($_FILES['featured_img']) && !empty($_FILES)) {
        $img = $_FILES['featured_img'];
        $img_name = str_replace(' ', '-', $title.'.'.explode('.', $img['name'])[1]);
        $file = wp_upload_bits($img_name, null, file_get_contents($img['tmp_name']));
        $fileType = wp_check_filetype($file['file'], null);

        $attachmentData = [
            'post_mime_type' => $fileType['type'],
            'post_title' => $img_name,
            'post_content' => '',
            'post_status' => 'inherit'
        ];
        $attachmentId = wp_insert_attachment($attachmentData, $file['file'], $postId);

        set_post_thumbnail($postId, $attachmentId);
    }

    return [
        'status' => 'success',
        'post' => $postId
    ];
}

function iwsRegisterUser($request) {
    $params = $request->get_params();
    $username = sanitize_text_field($params['username']);
    $email = wp_kses_post($params['email']);
    $password = wp_kses_post($params['password']);

    $user = wp_create_user($username, $password, $email);

    if (is_wp_error($user)) {
        return ['status' => 'REGISTER_FAILED', 'error', $user->get_error_message()];
    }

    return [
        'user' => $user,
        'starus' => 201,
    ];
}

add_action('rest_api_init', function () {
    register_rest_field('post', 'featured_src', [
        'get_callback' => 'iwsGetFeaturedImgSrc',
    ]);

    register_rest_route('wp/v2', 'create-post', [
        'methods' => "POST",
        'callback' => 'iwsCreatePostWithFeaturedImg'
    ]);

    register_rest_route('wp/v2', 'register', [
        'methods' => "POST",
        'callback' => 'iwsRegisterUser'
    ]);
});