<?php

function getTimes ($default = '00:00') {
    $output = '';

    $current = strtotime('00:00');
    $end = strtotime('23:59');

    while ($current <= $end) {
        $time = date('H:i', $current);
        $selected = ($time == $default) ? ' selected' : '';

        $output .= '<option value='. $time . $selected . '>' . date('h:i A', $current) .'</option>';
        $current = strtotime('+30 minutes', $current);
    }

    return $output;
}
?>