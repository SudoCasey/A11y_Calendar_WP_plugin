<?php
/*
Plugin Name: A11y Event Calendar
Description: A WCAG 2.2 compliant event calendar for WordPress.
Version: 1.0
Author: Casey Friedrich
*/

// Register the shortcode
function a11y_calendar_shortcode() {
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/calendar.php';
    return ob_get_clean();
}
add_shortcode('a11y_calendar', 'a11y_calendar_shortcode');

// Enqueue styles and scripts
function a11y_calendar_enqueue_assets() {
    wp_enqueue_style('a11y-calendar-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('a11y-calendar-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
    wp_localize_script('a11y-calendar-script', 'a11yCalendarAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'a11y_calendar_enqueue_assets');

// AJAX handler for updating the calendar
function a11y_calendar_update() {
    $month = isset($_POST['month']) ? intval($_POST['month']) : date('n');
    $year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/calendar.php';
    wp_send_json_success(ob_get_clean());
}
add_action('wp_ajax_a11y_calendar_update', 'a11y_calendar_update');
add_action('wp_ajax_nopriv_a11y_calendar_update', 'a11y_calendar_update');
?>