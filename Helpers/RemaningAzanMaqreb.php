<?php

function RemaningAzanMaqreb($TimeAzanMaqreb, $lg, $lat)
{
    if (time() > $TimeAzanMaqreb) {
        $TimestampTomorrow = strtotime('tomorrow');
        [$d, $m, $Y] = [(int)jdate('d', $TimestampTomorrow), (int)jdate('m', $TimestampTomorrow), (int)jdate('Y', $TimestampTomorrow)];
        $owghat = owghat($m, $d, $lg, $lat, 0);

        // list($h, $i, $s) = explode(':', $owghat['m']);
        list($h, $i) = explode(':', $owghat['m']);
        $Tomorrow_AzanMaqreb = jmktime((int)$h, (int)$i, 00, $m, $d, $Y);

        $remaining = $Tomorrow_AzanMaqreb - time();
    } else {
        $remaining = $TimeAzanMaqreb - time();
    }

    $hours = floor($remaining / 3600);
    $minutes = floor(($remaining % 3600) / 60);
    // $seconds = $remaining % 60;

    // return ['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds];
    return ['hours' => $hours, 'minutes' => $minutes];
}
