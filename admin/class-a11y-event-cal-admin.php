<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    A11y_Event_Cal
 * @subpackage A11y_Event_Cal/admin
 */

class A11y_Event_Cal_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/a11y-event-cal-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/a11y-event-cal-admin.js', array('jquery'), $this->version, false);
    }

    public function add_admin_menu() {
        add_menu_page(
            'Event Calendar', 
            'Event Calendar', 
            'manage_options', 
            'a11y-event-calendar', 
            array($this, 'view_events_page'), // Default page when clicking the menu
            'dashicons-calendar-alt', 
            20
        );

        add_submenu_page(
            'a11y-event-calendar', 
            'View Events', 
            'View Events', 
            'manage_options', 
            'a11y-event-calendar', 
            array($this, 'view_events_page')
        );

        add_submenu_page(
            'a11y-event-calendar', 
            'Add Event', 
            'Add Event', 
            'manage_options', 
            'a11y-event-calendar-add', 
            array($this, 'add_event_page')
        );
    }

    public function view_events_page() {
        include plugin_dir_path(__FILE__) . 'partials/a11y-event-cal-view-events.php';
    }

    public function add_event_page() {
        include plugin_dir_path(__FILE__) . 'partials/a11y-event-cal-admin-display.php';
    }

    public function register_settings() {
        register_setting('a11y_event_calendar_group', 'a11y_event_title');
        register_setting('a11y_event_calendar_group', 'a11y_event_dates');
    }
}
