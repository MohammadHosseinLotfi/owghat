<?php
function getCity($cityName) {
    $cityName = urlencode($cityName);
    $url = "https://nominatim.openstreetmap.org/search?q={$cityName}&format=json&limit=1";
    $options = [
        "http" => [
            "header" => "User-Agent: GeocodingScript/1.0"
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    $data = json_decode($response, true);

    if (empty($data)) {
        return false;
    }

    list($name, $lat, $lon) = [$data[0]['display_name'], $data[0]['lat'], $data[0]['lon']];

    if (strpos($name, "ایران") !== false || strpos($name, "iran") !== false) {
        return [
            "status" => true,
            "city" => $name,
            "latitude" => $lat,
            "longitude" => $lon,
            "googlemap" => "https://www.google.com/maps/@{$lat},{$lon},13z"
        ];
    } else {
        return [
            "status" => false
        ];
    }
}
