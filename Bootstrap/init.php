<?php
define('TOKEN', " "); // token bot
define('DIR', __DIR__ . "/../");

include_once DIR . "Core/Update.php";
include_once DIR . "Core/Api.php";
include_once DIR . "Functions/Database/Medoo.php";
include_once DIR . "Functions/Owghat/Owghat.php";
include_once DIR . "Functions/Owghat/jdf.php";
include_once DIR . "Helpers/RemaningAzanMaqreb.php";
include_once DIR . "Helpers/RemaningAzanSobh.php";
include_once DIR . "Functions/Database/City.php";
include_once DIR . "Functions/Database/Province.php";
use Medoo\Medoo;
$db = new Medoo([
	// [required]
	'type' => 'mysql',
	'host' => 'localhost',
	'database' => ' ',
	'username' => ' ',
	'password' => ' ',
	// [optional]
	'charset' => 'utf8mb4',
	'collation' => 'utf8mb4_general_ci',
	'port' => 3306,
    // [optional] To enable logging. It is disabled by default for better performance.
    'logging' => true,
    // [optional]
    'error' => PDO::ERRMODE_EXCEPTION,
]);
$City = new City($db);
$Province = new Province($db);
$Tel = new Telegram(TOKEN);
?>
