<?php
if (!defined('ABSPATH')) {
    exit;
}

// Fetch all stored events
$events = get_option('a11y_events', []);

// Ensure it's an array
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
                    <th style="width: 10%;">Cancelled</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event) : ?>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
