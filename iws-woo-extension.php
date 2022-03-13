<?php
/**
 * Plugin Name: IWS - Woo Extension
 * Description: All the code in this plugin are for learning purpose only, It is recommended not use this on live projects
 * Author: Tanuj Patra
 * Author URI: https://www.youtube.com/channel/UChvgNtbMI8Pnan7R7FrSIng
 * Version: 1.0.0
 * Requires at least: 5.7
 * Requires PHP: 7.2
 * Plugin URI: https://github.com/tanujpatra228/youtube/tree/iws-woo-extension
 * Text Domain: iws-woo-extension
 */

// Terminate if accessed directly
if(!defined('ABSPATH')){
    die();
}

define('IWS_WOO_EXT_TXT_DOMAIN', 'iws-geo-form-fields');
define('IWS_WOO_EXT_SLUG', 'iws-geo-form-fields');
define('IWS_WOO_EXT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('IWS_WOO_EXT_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Include scripts
 */
function iws_load_scripts(){
    $style_src = 'https://unpkg.com/swiper/swiper-bundle.min.css';
    $style_ver = '1.0.0';
    wp_enqueue_style('iws-swiper-slider', $style_src, '', $style_ver);
    
    $style_src = IWS_WOO_EXT_PLUGIN_URL.'assets/css/style.css';
    $style_ver = filemtime(IWS_WOO_EXT_PLUGIN_PATH.'assets/css/style.css');
    wp_enqueue_style('iws-style', $style_src, 'iws-swiper-slider', $style_ver);

    $script_src = 'https://unpkg.com/swiper/swiper-bundle.min.js';
    $script_ver = '1.0.0';
    wp_enqueue_script('iws-swiper-slider', $script_src, array('jquery'), $script_ver, true);
    
    $script_src = IWS_WOO_EXT_PLUGIN_URL.'assets/js/main.js';
    $script_ver = filemtime(IWS_WOO_EXT_PLUGIN_PATH.'assets/js/main.js');
    wp_enqueue_script('iws-script', $script_src, array('jquery', 'iws-swiper-slider'), $script_ver, true);
}
add_action('wp_enqueue_scripts', 'iws_load_scripts');

function iws_get_product_disc($product){
    if($product->is_type('simple')){
        $reg_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        
        // Discount%=(Original Price - Sale price)/Original price*100
        $disc = (($reg_price - $sale_price) / $reg_price) * 100;
    }
    else if($product->is_type('variable')){
        $disc_percentage = [];
        $prices = $product->get_variation_prices();
        foreach($prices['price'] as $key => $price){
            if($prices['regular_price'][$key] !== $price){
                $disc_percentage[] = round((($prices['regular_price'][$key] - $prices['sale_price'][$key]) / $prices['regular_price'][$key]) * 100);
            }
        }
        $disc = max($disc_percentage);
    }
    elseif($product->is_type('grouped')){
        $child_products = $product->get_children();
        $discount = [];
        foreach($child_products as $product_id){
            $child_product = wc_get_product($product_id);
            $reg_price = $child_product->get_regular_price();
            $sale_price = $child_product->get_sale_price();
            
            if(!empty($sale_price) && $sale_price != 0){
                // Discount%=(Original Price - Sale price)/Original price*100
                $discount[] = round((($reg_price - $sale_price) / $reg_price) * 100);
            }
        }
        $disc = max($discount);
    }

    
    $html = "<span class='variant-offer'>$disc% Off</span>";
    return $html;
}

function iws_product_slider($atts){
    $atts = shortcode_atts(
        array(
            'tag' => '',
            'count' => 6,
        ), 
        $atts
    );

    // $tag = 'hoodie,t-shirt,beanie';
    $tag = sanitize_text_field($atts['tag']);
    $tag = explode(',', $tag);
    $count = sanitize_text_field($count);

    $query = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'post_per_page' => $count,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_tag',
                'field' => 'slug',
                'terms' => $tag,
            )
        ),
    );

    $products = new WP_Query($query);

    ob_start();
    if($products->have_posts()):
        ?>
    <div class="iws-product-slider woocommerce">
        <div class="iws-inner">
            <div class="iws-swiper">
                <div class="swiper-wrapper">

        <?php
        while($products->have_posts()):
            $products->the_post();
            $title = get_the_title();
            $permalink = get_the_permalink();
            $product = wc_get_product(get_the_id());
            $img = $product->get_image('woocommerce_thumbnail');
            $avg_rating = $product->get_average_rating();
            $rating_percent = ($avg_rating / 5) * 100;
            $rating_count = $product->get_review_count();
            $price = $product->get_price_html();
            // $disc_percentage = iws_get_product_disc($product);
        ?>
            <div class="swiper-slide">
                <div class="iws-slide-content">
                    <div class="iws-product-img">
                        <!-- <img src="http://localhost/youtube/wp-content/uploads/2022/02/cap-2-300x300.jpg" alt="product"> -->
                        <?php echo $img;?>
                        <!-- <i class="far fa-heart"></i> -->
                        <?php echo do_shortcode('[ti_wishlists_addtowishlist loop=yes]'); ?>
                    </div>
                    <div class="iws-product-detail">
                        <p><a href="<?php echo $permalink;?>"><?php echo $title;?></a></p>
                        <div class="star-rating-wrap">
                            <div class="star-rating">
                                <span style="width:<?php echo $rating_percent;?>%">
                                Rated <strong class="rating"><?php echo $avg_rating;?></strong> out of 5
                                </span>
                            </div>
                            <span class="total-review">( <?php echo $rating_count;?> Reviews )</span>
                        </div>
                        <div class="price-wrap">
                            <!-- <span class="amount">Rs.7,500</span>
                            <del class="amount">Rs.12,400</del> -->
                            <?php echo $price;?>
                            <?php
                                if($product->is_on_sale()){
                                    echo iws_get_product_disc($product);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div> 
        <?php
        endwhile;
        ?>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
        <?php
    endif;
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('iws-product-slider', 'iws_product_slider');