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

$connection = new connection("localhost", "tripbuilder","root","");  // Calling Connection class to connect with Database

// Getting Second part of url since the first part is Application name

if($parts[2] == "trips") 
{
    $id = $parts[3] ?? null;
    $flightGateway = new flightGateway($connection); //Calling flightGatway with connection variable
    $flightcontroller = new flightsController($flightGateway); // Calling flightController class with gatway variable
    $flightcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function     
}
if($parts[2] == "onewaytrip") 
{
    $oneWayGateway = new oneWayGateway($connection); //Calling flightGatway with connection variable
    $oneWaycontroller = new oneWayController($oneWayGateway); // Calling flightController class with gatway variable
    $oneWaycontroller->processRequest($_SERVER['REQUEST_METHOD']); //sending Method with id in proceess Request function     
}
if($parts[2] == "roundtrip") 
{
    $id = $parts[3] ?? null;
    $roundTripGateway = new roundTripGateway($connection); //Calling flightGatway with connection variable
    $roundTripcontroller = new roundTripController($roundTripGateway); // Calling flightController class with gatway variable
    $roundTripcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function     
}
if($parts[2] == "airlines")
{
    $id = $parts[3] ?? null;
    $airlineGateway = new airlineGateway($connection); //Calling Airline Gateway with connection variable
    $airlinescontroller = new airlinesController($airlineGateway); // Calling AirlineController class with gatway variable
    $airlinescontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function 

}
if($parts[2] == "airports")
{
    $id = $parts[3] ?? null;
    $airportGateway = new airportGateway($connection); //Calling Airport Gateway with connection variable
    $airportcontroller = new airportController($airportGateway); // Calling Airport class with gatway variable
    $airportcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function 

}



?>