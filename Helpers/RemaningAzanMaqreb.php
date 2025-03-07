<?php

function RemaningAzanMaqreb($TimeAzanMaqreb, $lg, $lat)
{
    if (time() > $TimeAzanMaqreb) {
        $TimestampTomorrow = $TimeAzanMaqreb + 86400;
        [$d, $m, $Y] = [jdate('d', $TimestampTomorrow, '', 'Asia/Tehran', 'en'), jdate('m', $TimestampTomorrow, '', 'Asia/Tehran', 'en'), (int)jdate('Y', $TimestampTomorrow, '', 'Asia/Tehran', 'en')];
        $owghat = owghat($m, $d, $lg, $lat);

        list($h, $i, $s) = explode(':', $owghat['m']);
        $Tomorrow_AzanMaqreb = jmktime($h, $i, $s, $m, $d, $Y);

        $remaining = $Tomorrow_AzanMaqreb - time();

        $hours = floor($remaining / 3600);
        $minutes = floor(($remaining % 3600) / 60);
        $seconds = $remaining % 60;
    } else {
        $remaining = $TimeAzanMaqreb - time();

        $hours = floor($remaining / 3600);
        $minutes = floor(($remaining % 3600) / 60);
        $seconds = $remaining % 60;
    }

    return ['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds];
}
