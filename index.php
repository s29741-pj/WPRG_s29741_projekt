<?php
echo "INDEX.PHP HIT<br>";

require_once 'Core/Router.php';
require_once 'Controller/TicketController.php';

$router = new Router();
$router->route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);












//
//$servername = "localhost";
//$username = "root"; // default for XAMPP
//$password = "";     // default for XAMPP
//$dbname = "wprg_ticketpro";
//
//// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//
//echo "Connected successfully";

