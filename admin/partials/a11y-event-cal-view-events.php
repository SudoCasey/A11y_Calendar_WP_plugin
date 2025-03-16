<?php
if (!defined('ABSPATH')) {
    exit;
}

// Handle event deletion
if (isset($_GET['delete_event'])) {
    $delete_index = intval($_GET['delete_event']);
    $events = get_option('a11y_events', []);
    
    if (isset($events[$delete_index])) {
        unset($events[$delete_index]);
        update_option('a11y_events', array_values($events));
    }
    
    wp_redirect(admin_url('admin.php?page=a11y-event-calendar'));
    exit;
}

// Fetch all stored events
$events = get_option('a11y_events', []);
if (!is_array($events)) {
    $events = [];
}

// Sort events by date
usort($events, function($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});
?>

<div class="wrap">
    <h1>Registered Events</h1>

    <?php if (empty($events)) : ?>
        <p>No events have been registered.</p>
    <?php else : ?>
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 20%;">Event Title</th>
                    <th style="width: 15%;">Event Date</th>
                    <th style="width: 30%;">Description</th>
                    <th style="width: 15%;">Location</th>
                    <th style="width: 10%;">URL</th>
                    <th style="width: 5%;">Cancelled</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $index => $event) : ?>
                    <tr>
                        <td><?php echo esc_html($event['title']); ?></td>
                        <td><?php echo esc_html($event['date']); ?></td>
                        <td><?php echo esc_html($event['description']); ?></td>
                        <td><?php echo esc_html($event['location']); ?></td>
                        <td>
                            <?php if (!empty($event['url'])) : ?>
                                <a href="<?php echo esc_url($event['url']); ?>" target="_blank">Link</a>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html($event['cancelled']); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=a11y-event-calendar-add&edit_event=' . $index); ?>" class="button button-primary">Edit</a>
                            <a href="<?php echo admin_url('admin.php?page=a11y-event-calendar&delete_event=' . $index); ?>" class="button button-secondary" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
