<?php
function generate_calendar($month, $year) {
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $first_day = date('w', strtotime("$year-$month-01"));

    echo '<div class="a11y-calendar">';
    echo '<div class="a11y-calendar-nav">';
    echo '<a href="#" class="prev-month" data-month="' . ($month == 1 ? 12 : $month - 1) . '" data-year="' . ($month == 1 ? $year - 1 : $year) . '">Previous Month</a>';
    echo '<a href="#" class="next-month" data-month="' . ($month == 12 ? 1 : $month + 1) . '" data-year="' . ($month == 12 ? $year + 1 : $year) . '">Next Month</a>';
    echo '</div>';

    echo '<table>';
    echo '<caption><h2>' . date('F Y', strtotime("$year-$month-01")) . '</h2></caption>';
    echo '<thead><tr>';
    foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day) {
        echo "<th scope='col'>$day</th>";
    }
    echo '</tr></thead>';
    echo '<tbody><tr>';

    // Add empty cells for days before the first of the month
    for ($i = 0; $i < $first_day; $i++) {
        echo '<td></td>';
    }

    // Add days of the month
    for ($day = 1; $day <= $days_in_month; $day++) {
        echo '<td>' . $day . '</td>';
        if (($first_day + $day) % 7 == 0) {
            echo '</tr><tr>';
        }
    }

    // Add empty cells for the remaining days of the week
    while (($first_day + $days_in_month) % 7 != 0) {
        echo '<td aria-hidden="true"></td>';
        $days_in_month++;
    }

    echo '</tr></tbody>';
    echo '</table></div>';
}

generate_calendar($month, $year);
?>