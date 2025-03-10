<?php
date_default_timezone_set("Asia/Tehran");
$update = json_decode(file_get_contents("php://input"));
include_once "Bootstrap/init.php";

if (isset($text) && $type == "private" && $text == "/start") {
    $Tel->Send($chat_id, "سلام دوست من\nبا این ربات میتونی اوقات شرعی شهرها را مشاهده کنی.\n\nمثال : <code>اوقات تهران</code>");
}
elseif (isset($text) && preg_match('/اوقات\s+(.+)$/u', $text, $match)) {
    $cityName = $match[1];
    $selectCity = $City->getInfoCity($cityName);
    if (!$selectCity) {
        $data = getCity($cityName);
        if (is_array($data)) {
            $keyboard = [
                [
                    ['text' => "مشاهده در گوگل مپ", 'url' => $data["googlemap"]],
                ],
                [
                    ['text' => "تایید موقعیت مکانی", 'callback_data' => "accept-$cityName"],
                ]
            ];
            $Tel->Send($chat_id, "من موقعیت مکانی که شما گفتید رو در پایگاه داده خود ندارم، اما رفتم جستجو کردم و یک مکانی رو پیدا کردم.\n\nآیا مکان زیر همان مکانی است که شما مدنظرتون بود ؟\nدرصورت درست بودن تایید کنید.", $keyboard, "inline_keyboard");
            return;
        }
        return;
    }
    $selectProvince = $Province->getName($selectCity['province']);
    [$lg, $lat, $province] = [$selectCity['longitude'], $selectCity['latitude'], $selectProvince['name']];

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

    $Tel->Send($chat_id, "📆 $l $d $F $Y - ساعت $h:$i:$s\n🌏 شهر : $cityName\n┘ استان : $province\n\n🕰 اوقات شرعی\n┤ اذان صبح : {$AzanSobh}\n┤ اذان ظهر : {$AzanZohr}\n┘ اذان مغرب : {$AzanMaqreb}\n\n⏳ مانده تا سحر : {$hoursAS} ساعت {$minutesAS} دقیقه {$secondsAS} ثانیه\n⌛️ مانده تا افطار : {$hoursAM} ساعت {$minutesAM} دقیقه {$secondsAM} ثانیه");
}

elseif (isset($callback_query) && strpos($callback_query_data, "accept") !== false) {
    $ex = explode('-', $callback_query_data);
    $data = getCity($ex[1]);
    $Tel->EditMessage($chat_id, $message_id, "موقعیت مکانی برای تیم ما ارسال شد تا بررسی شود و در پایگاه داده اضافه گردد.");
    $Tel->Send(ADMIN_ID, "یک نفر درخواست اضافه کردن موقعیت مکانی داده.\nنام مکان : " . $data["city"] . "\n\n عرض : " . $data['latitude'] . "\nطول : " . $data['longitude'] . "\nگوگل مپ : " . $data['googlemap']);
}
