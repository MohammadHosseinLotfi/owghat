<?php
date_default_timezone_set("Asia/Tehran");
include_once "Functions/Owghat/Owghat.php";
include_once "Functions/Owghat/jdf.php";
include_once "Helpers/RemaningAzanSobh.php";
$lat = 33.985;
$long = 51.4096;

[$l, $d, $m, $F, $Y, $h, $i, $s] = [jdate('l'), jdate('d'), jdate('m'), jdate('F'), jdate('Y'), jdate('h'), jdate('i'), jdate('s')];
$owghat = owghat((int)jdate('m'), (int)jdate('d'), $long, $lat, 0, 0, 0);

// print_r($owghat);
// print_r(RemaningAzanSobh(1741660179, $long, $lat));
echo jdate('h:i:s',time());
echo "\n";
echo date('h:i:s', time());
