<?php
/**
 * Plugin Name: My Plugin
 * Description: This is a test Plugin.
 * Version: 1.0
 * Author: Tanuj
 * Author URI: https://itswebspace.in
 */

if(!defined('ABSPATH')){
    header("Location: /youtube");
    die();
}

function my_plugin_activation(){
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';

    $q = "CREATE TABLE IF NOT EXISTS `$wp_emp` ( `ID` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `email` VARCHAR(100) NOT NULL , `phone` VARCHAR(15) NOT NULL ,  `status` BOOLEAN NOT NULL , PRIMARY KEY (`ID`)) ENGINE = MyISAM;";
    $wpdb->query($q);

    $data = array(
        'name'  => 'Tanuj',
        'email' => 'tanuj@gmail.com',
        'phone' => '9235467811',
        'status'=> 1
    );

    $wpdb->insert($wp_emp, $data);

}
register_activation_hook(__FILE__, 'my_plugin_activation');

function my_plugin_deactivation(){
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';

    $q = "DROP TABLE `$wp_emp`";
    $wpdb->query($q);
}
register_deactivation_hook(__FILE__, 'my_plugin_deactivation');

function my_custom_scripts(){
    $path_js = plugins_url('js/main.js', __FILE__);
    $path_style = plugins_url('js/main.js', __FILE__);
    $dep = array('jquery');
    $ver = filemtime(plugin_dir_path(__FILE__).'js/main.js');
    $ver_style = filemtime(plugin_dir_path(__FILE__).'css/style.css');
    $is_login = is_user_logged_in() ? 1 : 0;

    wp_enqueue_style('my-custom-style', $path_style, '', $ver_style);

    wp_enqueue_script('my-custom-js', $path_js, $dep, $ver, true);
    wp_add_inline_script('my-custom-js', 'var ajaxUrl = "'.admin_url('admin-ajax.php').'";', 'before');

}
add_action('wp_enqueue_scripts', 'my_custom_scripts');
add_action('admin_enqueue_scripts', 'my_custom_scripts');

function youtube(){
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';

    $q = "SELECT * FROM `$wp_emp`;";
    $results = $wpdb->get_results($q);

    ob_start()
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($results as $row):
            ?>
            <tr>
                <td><?php echo $row->ID;?></td>
                <td><?php echo $row->name;?></td>
                <td><?php echo $row->email;?></td>
                <td><?php echo $row->phone;?></td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    $html = ob_get_clean();

    // return $html;
}
add_shortcode('youtube', 'youtube');

function my_posts(){
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_key' => 'views',
        'orderby' => 'meta_value',
        'order' => 'DESC'
    );

    $query = new WP_Query($args);

    ob_start();
    if($query->have_posts()):
    ?>
    <ul>
        <?php
        while($query->have_posts()){
            $query->the_post();
            echo '<li><a href="'.get_the_permalink().'">'.get_the_title(). '</a> ('.get_post_meta(get_the_ID(), 'views', true).') - > '.  get_the_content(). '</li>';
        }
        ?>
    </ul>
    <?php
    endif;
    wp_reset_postdata();
    $html = ob_get_clean();
    return $html;
}
add_shortcode('my-posts','my_posts');

function head_fun(){
    if(is_single()){
        global $post;
        $views = get_post_meta($post->ID, 'views', true);
        
        if($views == ''){
            add_post_meta($post->ID, 'views', 1);
        }else{
            $views++;
            update_post_meta($post->ID, 'views', $views);
        }
    }
}
add_action('wp_head', 'head_fun');

function views_count(){
    global $post;
    return 'Total views : '.get_post_meta($post->ID, 'views', true).'K';
}
add_shortcode('views-count', 'views_count');

function my_plugin_page_func(){
    include 'admin/main-page.php';
}
function my_plugin_subpage_func(){
    echo 'Hi from Sub page';
}
function my_plugin_menu(){
    add_menu_page('My Plugin Page', 'My Plugin Page', 'manage_options', 'my-plugin-page', 'my_plugin_page_func', '', 6);

    add_submenu_page('my-plugin-page', 'All Emp', 'All Emp', 'manage_options', 'my-plugin-page', 'my_plugin_page_func');

    add_submenu_page('my-plugin-page', 'My Plugin Sub page', 'My Plugin Sub page', 'manage_options', 'my-plugin-subpage', 'my_plugin_subpage_func');
}
add_action('admin_menu', 'my_plugin_menu');

add_action('wp_ajax_my_serch_func', 'my_serch_func');
add_action('wp_ajax_nopriv_my_serch_func', 'my_serch_func');
function my_serch_func(){
    // include 'admin/main-page.php';
    
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';
    $search_term = $_POST['search_term'];

    if(!empty($search_term)){
        $q = "SELECT * FROM `$wp_emp` WHERE 
        `name` LIKE '%".$search_term."%'
        OR `email` LIKE '%".$search_term."%'
        OR `phone` LIKE '%".$search_term."%';";
    }else{
        $q = "SELECT * FROM `$wp_emp`;";
    }

    $results = $wpdb->get_results($q);
    ob_start();
    foreach($results as $row):
        ?>
        <tr>
            <td><?php echo $row->ID;?></td>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo $row->phone;?></td>
        </tr>
        <?php
    endforeach;
    echo ob_get_clean();
    wp_die();
}

function my_table_data(){
    include 'admin/main-page.php';
}
add_shortcode('my-data', 'my_table_data');

function register_my_cpt(){
    $labels = array(
        'name' => 'Cars',
        'singular_name' => 'Car'
    );
    $supports = array('title', 'editor', 'thumbnail', 'comments', 'excerpts');
    $options = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug'=> 'cars'),
        'show_in_rest' => true,
        'supports' => $supports,
        'taxonomies' => array('car_types'),
        'publicly_queryable' => true,
        'publicly_queryable'  => true,
    );
    register_post_type('cars', $options);
}
add_action('init', 'register_my_cpt');

function register_car_types(){
    $labels = array(
        'name' => 'Car Type',
        'singular_name' => 'Car Types'
    );
    $options = array(
        'labels' => $labels,
        'hierarchical' => true,
        'rewrite' => array('slug'=> 'car-type'),
        'show_in_rest' => true,
    );
    register_taxonomy('car-type', array('cars'), $options);
}
add_action('init', 'register_car_types');



function my_register_form(){
    ob_start();
    include 'public/register.php';
    return ob_get_clean();
}
add_shortcode('my-register-form', 'my_register_form');

function my_login_form(){
    ob_start();
    include 'public/login.php';
    return ob_get_clean();
}
add_shortcode('my-login-form', 'my_login_form');

function my_login(){
    if(isset($_POST['user_login'])){
        $username = esc_sql($_POST['username']);
        $pass = esc_sql($_POST['pass']);
        $credentials = array(
            'user_login' => $username,
            'user_password' => $pass,
        );
        $user = wp_signon($credentials);

        if(!is_wp_error($user)){
            if($user->roles[0] == 'administrator'){
                wp_redirect(admin_url());
                exit;
            }else{
                wp_redirect(site_url('profile'));
                exit;
            }
        }else{
            echo $user->get_error_message();
        }
    }
}
add_action('template_redirect', 'my_login');

function my_profile(){
    ob_start();
    include 'public/profile.php';
    return ob_get_clean();
}
add_shortcode('my-profile', 'my_profile');

function my_check_redirect(){
    $is_user_logged_in = is_user_logged_in();

    if($is_user_logged_in && (is_page('login') || is_page('register'))){
        wp_redirect(site_url('profile'));
        exit;
    }elseif(!$is_user_logged_in && is_page('profile')){
        wp_redirect(site_url('login'));
        exit;
    }
}
add_action('template_redirect', 'my_check_redirect');

function redirect_after_loguot(){
    wp_redirect(site_url('login'));
    exit;
}
add_action('wp_logout', 'redirect_after_loguot');

function my_meta_fields(){
    ?>
    <label for="my-meta-field1">My Meta Field 1</label>
    <input type="text" name="my-meta-field1" id="my-meta-field1" value="<?php echo get_post_meta(get_the_ID(), 'my-meta-data', true);?>"/>
    <?php
}
function add_my_meta_box(){
    add_meta_box('my-meta-box', 'My Meta Box', 'my_meta_fields', 'cars');
}
add_action('add_meta_boxes', 'add_my_meta_box');

function save_my_meta_data($post_id){
    $field_data = $_POST['my-meta-field1'];
    if(isset($_POST['my-meta-field1'])){
        if(get_post_meta($post_id, 'my-meta-data', true) != ''){
            update_post_meta($post_id, 'my-meta-data', $field_data);
        }else{
            add_post_meta($post_id, 'my-meta-data', $field_data);
        }
    }
}
add_action('save_post', 'save_my_meta_data');

function add_my_plugin_action_links($actions, $plugin){
    $plugin_path = plugin_dir_path(__FILE__);
    $new_actions = array();
    if(basename($plugin_path).'/my-plugin.php' == $plugin){
        $new_actions['my_plugin'] = "<a href='admin.php?page=my-plugin-page'>Settings</a>";
        $new_actions['my_plugin2'] = "<a href='admin.php?page=my-plugin-page'>Something</a>";
    }
    return array_merge($new_actions, $actions);
}
add_filter('plugin_action_links', 'add_my_plugin_action_links', 10, 2);