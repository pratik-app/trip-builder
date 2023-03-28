<?php

declare(strict_types=1); // Declaring strict type

// Autoload function

spl_autoload_register(function($class){
    require __DIR__ ."/src/$class.php";
});

set_error_handler("ErrorHandler::handleError"); //calling error handle to display error in JSON format
set_exception_handler("ErrorHandler::handleException"); // Class will loaded automatically

header("Content-type: application/json; charset=UTF-8"); // Setting Header type to JSON format

$parts = explode("/", $_SERVER['REQUEST_URI']); // Getting URL

// Getting Second part of url since the first part is Application name

if($parts[2] != "trips")
{
    http_response_code(404);
    exit();
}

$id = $parts[3] ?? null; // Getting Part 3 if available

$connection = new connection("localhost", "tripbuilder","root","");  // Calling Connection class to connect with Database
$flightGateway = new flightGateway($connection); //Calling flightGatway with connection variable
$flightcontroller = new flightsController($flightGateway); // Calling flightController class with gatway variable
$flightcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function 
?>