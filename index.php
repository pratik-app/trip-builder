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

$connection = new connection("localhost", "u498926327_tripbuilder","u498926327_pmtripbuilder","]/Vstmy=T6");  // Calling Connection class to connect with Database

// Getting Second part of url since the first part is Application name

if($parts[1] == "trips") 
{
    $id = $parts[2] ?? null;
    $flightGateway = new flightGateway($connection); //Calling flightGatway with connection variable
    $flightcontroller = new flightsController($flightGateway); // Calling flightController class with gatway variable
    $flightcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function     
}
if($parts[1] == "onewaytrip") 
{
    $oneWayGateway = new oneWayGateway($connection); //Calling flightGatway with connection variable
    $oneWaycontroller = new oneWayController($oneWayGateway); // Calling flightController class with gatway variable
    $oneWaycontroller->processRequest($_SERVER['REQUEST_METHOD']); //sending Method with id in proceess Request function     
}
if($parts[1] == "roundtrip") 
{
    $id = $parts[2] ?? null;
    $roundTripGateway = new roundTripGateway($connection); //Calling flightGatway with connection variable
    $roundTripcontroller = new roundTripController($roundTripGateway); // Calling flightController class with gatway variable
    $roundTripcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function     
}
if($parts[1] == "airlines")
{
    $id = $parts[3] ?? null;
    $airlineGateway = new airlineGateway($connection); //Calling Airline Gateway with connection variable
    $airlinescontroller = new airlinesController($airlineGateway); // Calling AirlineController class with gatway variable
    $airlinescontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function 

}
if($parts[1] == "airports")
{
    $id = $parts[2] ?? null;
    $airportGateway = new airportGateway($connection); //Calling Airport Gateway with connection variable
    $airportcontroller = new airportController($airportGateway); // Calling Airport class with gatway variable
    $airportcontroller->processRequest($_SERVER['REQUEST_METHOD'], $id); //sending Method with id in proceess Request function 

}



?>
<!Doctype html>
<head>
    <!-- Adding Meta Tags -->    
    <meta charset="UTF-8">
    <meta name="description" content="Flighthub Assesment">
    <meta name="author" content="Pratik More">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <title>
        Trip Builder - Flighthub Assesment
    </title>
    <!-- Linking Style css  -->
    <link href="assets/css/style.css" rel="stylesheet">    
    <!-- Adding Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    </head>
<body>
<div class="row">
    <div class="col-xl-12" style="text-align: center;">
        <h1>Search for Flights</h1>
    </div>
</div>
<!-- Linking the JavaScript File -->
<script src="assets/js/main.js"></script>
<!-- Adding JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.js" integrity="sha512-6DC1eE3AWg1bgitkoaRM1lhY98PxbMIbhgYCGV107aZlyzzvaWCW1nJW2vDuYQm06hXrW0As6OGKcIaAVWnHJw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.slim.js" integrity="sha512-G1QAKkF7DrLYdKiz55LTK3Tlo8Vet2JnjQHuJh+LnU0zimJkMZ7yKZ/+lQ/0m94NC1EisSVS1b35jugu3wLdQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.slim.min.js" integrity="sha512-fYjSocDD6ctuQ1QGIo9+Nn9Oc4mfau2IiE8Ki1FyMV4OcESUt81FMqmhsZe9zWZ6g6NdczrEMAos1GlLLAipWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Adding Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

</body>
</html>