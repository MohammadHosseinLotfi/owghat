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

    return [
        "city" => $data[0]['display_name'],
        "latitude" => $data[0]['lat'],
        "longitude" => $data[0]['lon'],
        "googlemap" => "https://www.google.com/maps/@{$data[0]['lat']},{$data[0]['lon']},13z"
    ];
}
