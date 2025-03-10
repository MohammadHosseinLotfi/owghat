<?php

function RemaningAzanSobh($TimeAzanSobh, $lg, $lat)
{
    if (time() > $TimeAzanSobh) {
        $TimestampTomorrow = strtotime('tomorrow');
        [$d, $m, $Y] = [(int)jdate('d', $TimestampTomorrow), (int)jdate('m', $TimestampTomorrow), (int)jdate('Y', $TimestampTomorrow)];
        $owghat = owghat($m, $d, $lg, $lat);

        list($h, $i, $s) = explode(':', $owghat['s']);
        $Tomorrow_AzanSobh = jmktime((int)$h, (int)$i, (int)$s, $m, $d, $Y);

        $remaining = $Tomorrow_AzanSobh - time();
    } else {
        $remaining = $TimeAzanSobh - time();
    }

    $hours = floor($remaining / 3600);
    $minutes = floor(($remaining % 3600) / 60);
    $seconds = $remaining % 60;

    return ['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds];
}
