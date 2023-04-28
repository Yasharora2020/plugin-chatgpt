<?php
/**
 * Plugin Name: Custom Widget
 * Description: A custom widget that communicates with a chatgpt using aws lambda and api gateway.
 * Version: 1.0
 * Author: Your Name
 */

function register_custom_widget() {
    require_once plugin_dir_path(__FILE__) . 'custom-widget-class.php';
    register_widget('Custom_Widget');
}

add_action('widgets_init', 'register_custom_widget');

function custom_widget_shortcode() {
    $widget = new Custom_Widget();
    add_shortcode('custom_widget_input', array($widget, 'shortcode_input'));
    add_shortcode('custom_widget_response', array($widget, 'shortcode_response'));
}

add_action('init', 'custom_widget_shortcode');
