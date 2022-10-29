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