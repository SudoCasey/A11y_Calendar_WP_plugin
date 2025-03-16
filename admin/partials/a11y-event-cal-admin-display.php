<?php
if (!defined('ABSPATH')) {
    exit;
}

ob_start(); // Prevent any output before handling redirects

// Retrieve existing events
$events = get_option('a11y_events', []);
if (!is_array($events)) {
    $events = [];
}

// Check if editing an existing event
$edit_index = isset($_GET['edit_event']) ? intval($_GET['edit_event']) : null;
$editing = ($edit_index !== null && isset($events[$edit_index]));

// Load existing event data if editing
$event = $editing ? $events[$edit_index] : [
    'title' => '',
    'date' => '',
    'description' => '',
    'location' => '',
    'url' => '',
    'cancelled' => ''
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['a11y_event_title'], $_POST['a11y_event_date'])) {
    $new_event = [
        'title' => sanitize_text_field($_POST['a11y_event_title']),
        'date' => sanitize_text_field($_POST['a11y_event_date']),
        'description' => sanitize_textarea_field($_POST['a11y_event_description']),
        'location' => sanitize_text_field($_POST['a11y_event_location']),
        'url' => esc_url($_POST['a11y_event_url']),
        'cancelled' => isset($_POST['a11y_event_cancelled_status']) ? 'Yes' : 'No'
    ];

    if ($editing) {
        $events[$edit_index] = $new_event;
    } else {
        $events[] = $new_event;
    }

    update_option('a11y_events', $events);

    // Redirect to "View Events" page
    add_action('init', function() {
        wp_safe_redirect(admin_url('admin.php?page=a11y-event-calendar'));
        exit;
    });

    return;
}

?>

<div class="wrap">
    <h1><?php echo $editing ? 'Edit Event' : 'Add Event'; ?></h1>

    <form method="post">
        <div style="display:flex; flex-direction: column;">
            <div style="width: 75%; padding: 10px; display:flex; flex-direction: row;">
                <label for="a11y_event_title" style="width: 25%; padding: 10px;"><strong>Event Title (required):</strong></label>
                <input type="text" name="a11y_event_title" id="a11y_event_title" value="<?php echo esc_attr($event['title']); ?>" style="width:75%;">
            </div>
            <div style="width: 75%; padding: 10px; display:flex; flex-direction: row;">
                <label for="a11y_event_date" style="width: 25%; padding: 10px;"><strong>Event Date (required):</strong></label>
                <div style="width: 75%">
                    <input type="date" name="a11y_event_date" id="a11y_event_date" value="<?php echo esc_attr($event['date']); ?>" style="max-width:100%; height: 100%;">
                </div>
            </div>
            <div style="width: 75%; padding: 10px; display:flex; flex-direction: row;">
                <label for="a11y_event_description" style="width: 25%; padding: 10px;"><strong>Event Description:</strong></label>
                <textarea name="a11y_event_description" id="a11y_event_description" style="width:75%; border-radius: 5px;"><?php echo esc_textarea($event['description']); ?></textarea>
            </div>

            <div style="width: 75%; padding: 10px; display:flex; flex-direction: row;">
                <label for="a11y_event_location" style="width: 25%; padding: 10px;"><strong>Event Location:</strong></label>
                <input type="text" name="a11y_event_location" id="a11y_event_location" value="<?php echo esc_attr($event['location']); ?>" style="width:75%;">
            </div>
            <div style="width: 75%; padding: 10px; display:flex; flex-direction: row;">
                <label for="a11y_event_url" style="width: 25%; padding: 10px;"><strong>Event URL:</strong></label>
                <input type="text" name="a11y_event_url" id="a11y_event_url" value="<?php echo esc_attr($event['url']); ?>" style="width:75%;">
            </div>
            <div style="width: 75%; padding: 10px; display:flex; flex-direction: row;">
                <label for="a11y_event_cancelled_status" style="width: 25%; padding: 10px;"><strong>Event Cancelled:</strong></label>
                <input type="checkbox" name="a11y_event_cancelled_status" id="a11y_event_cancelled_status" <?php checked($event['cancelled'], 'Yes'); ?>>
            </div>
        </div>

        <?php submit_button($editing ? 'Update Event' : 'Save Event'); ?>
    </form>
</div>
