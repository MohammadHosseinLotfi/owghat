<?php
include_once "../Bootstrap/init.php";

[$city, $province, $lat, $long] = [$_GET['city'], $_GET['province'], $_GET['lat'], $_GET['long']];

if (empty($city)) {
    echo "city invalid";
    return;
}elseif (!intval($province)) {
    echo "province invalid";
    return;
}elseif (!is_numeric($lat)) {
    echo "latitude invalid";
    return;
}elseif (!is_numeric($long)) {
    echo "longitude invalid";
    return;
}

$data = $db->insert('cities', ['name' => $city, 'province' => $province, 'latitude' => $lat, 'longitude' => $long]);
if (is_numeric($data->rowCount())) {
    echo "City added successfully.\nID City : " . $db->id();
}
