<?php
date_default_timezone_set("Asia/Tehran");
$update = json_decode(file_get_contents("php://input"));
include_once "Bootstrap/init.php";

if ($type == "private" && $text == "/start") {
    $Tel->Send($chat_id, "سلام دوست من\nبا این ربات میتونی اوقات شرعی شهرها را مشاهده کنی.\n\nمثال : <code>اوقات تهران</code>");
}
elseif (preg_match('/اوقات\s+(.+)$/u', $text, $match)) {
    $city = $match[1];
    $selectCity = $City->getlgAndlat($city);
    if (sizeof($selectCity) == 0) {
        return;
    }
    [$lg, $lat] = [$selectCity[0]['lg'], $selectCity[0]['lat']];

    [$l, $d, $m, $F, $Y, $h, $i, $s] = [jdate('l'), jdate('d', time(), '', 'Asia/Tehran', 'en'), jdate('m', time(), '', 'Asia/Tehran', 'en'), jdate('F'), jdate('Y', time(), '', 'Asia/Tehran', 'en'), jdate('h', time(), '', 'Asia/Tehran', 'en'), jdate('i', time(), '', 'Asia/Tehran', 'en'), jdate('s', time(), '', 'Asia/Tehran', 'en')];

    $owghat = owghat($m, $d, $lg, $lat, 1, 0, 0);
    [$AzanSobh, $AzanZohr, $AzanMaqreb] = [$owghat['s'], $owghat['z'], $owghat['m']];

    list($TAS_h, $TSA_m, $TSA_s) = explode(':', $AzanSobh);
    $TimeAzanSobh = jmktime($TAS_h , $TSA_m , $TSA_s , $m , $d , $Y , ''); // timestamp

    list($TAM_h, $TSM_m, $TSM_s) = explode(':', $AzanMaqreb);
    $TimeAzanMaqreb = jmktime($TAM_h, $TSM_m, $TSM_s , $m , $d , $Y , ''); // timestamp

    // Azan Sobh
    $RemaningAzanSobh = RemaningAzanSobh($TimeAzanSobh, $lg, $lat);
    list($hoursAS, $minutesAS, $secondsAS) = [$RemaningAzanSobh['hours'], $RemaningAzanSobh['minutes'], $RemaningAzanSobh['seconds']];

    // Azan Maqreb
    $RemaningAzanMaqreb = RemaningAzanMaqreb($TimeAzanMaqreb, $lg, $lat);
    list($hoursAM, $minutesAM, $secondsAM) = [$RemaningAzanMaqreb['hours'], $RemaningAzanMaqreb['minutes'], $RemaningAzanMaqreb['seconds']];

    $Tel->Send($chat_id, "📆 $l $d $F $Y - ساعت $h:$i:$s\n🌏 شهر : $city\n┤ اذان صبح : {$AzanSobh}\n┤ اذان ظهر : {$AzanZohr}\n┘ اذان مغرب : {$AzanMaqreb}\n\n⏳ مانده تا سحر : {$hoursAS} ساعت {$minutesAS} دقیقه {$secondsAS} ثانیه\n⌛️ مانده تا افطار : {$hoursAM} ساعت {$minutesAM} دقیقه {$secondsAM} ثانیه");
}
