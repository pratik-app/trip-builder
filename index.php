<?php
declare(strict_types=1);

spl_autoload_register(function($class){
    require __DIR__ ."/src/$class.php";
});

header("Content-type: application/json; charset=UTF-8");
$parts = explode("/", $_SERVER['REQUEST_URI']);

if($parts[2] != "trips")
{
    http_response_code(404);
    exit();
}
$id = $parts[3] ?? null;
$connection = new connection("localhost", "tripbuilder","root","");
// Keeping try catch block so errors will be also printed in JSON format

    $connection->getConnection();

$flightcontroller = new flightsController;
$flightcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id);
?>