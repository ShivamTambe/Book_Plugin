<?php

/*
 * Plugin Name:       Book Plugin
 * Plugin URI:        https://github.com/dashboard
 * Description:       Developed for Pratice.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shivam Tambe
 * Author URI:        https://github.com/dashboard
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       Book Plugin
 * Domain Path:       /languages
 */
 require_once __DIR__ . '/includes/schema.php';
 require_once __DIR__ . '/post-types/book.php';
 require_once __DIR__ . '/taxonomy/book-category.php';
 require_once __DIR__ . '/taxonomy/book-tag.php';
 require_once __DIR__ . '/extra/setting.php';
 require_once __DIR__ . '/shortcodes/shortcode1.php';
 require_once __DIR__ . '/Functionalities/customFun.php';
 require_once __DIR__ . '/Widgets/Books_Category_Widget.php';
 require_once __DIR__ . '/Widgets/Top_Books.php';

 function bk_acti(){
    // add functionality on activation
    
 }

 register_activation_hook(
	__FILE__,
	'bk_acti'
);

function bk_deacti(){
    // add functionality on deactivation
 }

register_deactivation_hook(
	__FILE__,
	'bk_deacti'
);
