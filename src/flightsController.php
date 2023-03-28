<?php

// This controller will handle all request related to flights

class flightsController
{

    public function __construct(private flightGateway $flightGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method, ?string $flightNumber):void
    {
        if($flightNumber){
            $this->processResourceRequest($method, $flightNumber);
        }else
        {
            $this->processCollectionRequest($method);
        }
    }
    private function processResourceRequest (string $method, string $flightNumber):void
    {}

    private function processCollectionRequest(string $method):void
    {
        // Using Switch method for various http methods
        // Using array to check whether the post request is empty or not
        switch($method){
            case "GET":
                echo json_encode($this->flightGateway->getAllFlights());
                break;
            case "POST":
                // $data = (array)json_decode(file_get_contents("php://input"),true);
                $data = $_POST;
                // Calling the Error Validation Method

                $errors = $this->getValidationErrors($data);
                if(! empty($errors))
                {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                // Calling the create method from the Gateway
                $fNumber = $this->flightGateway->createFlight($data);
                http_response_code(201);
                echo json_encode([
                    "message" => "Flight Added",                    
                ]);
                break;
        }
    }
    private function getValidationErrors(array $data):array
    {
        $errors = [];
        if(empty($data["flightNumber"]))
        {
            $errors[] = "Flight Number is Empty";
        }
        if(empty($data["airlineCode"]))
        {
            $errors[] = "Air Line Code is Empty!";
        }
        if(empty($data["departureAirportCode"]))
        {
            $errors[] = "Departure Airport Code is Empty";
        }
        if(empty($data["departureTime"]))
        {
            $errors[] = "Departure Date and Time is Empty!";
        }
        if(empty($data["arrivalAirportCode"]))
        {
            $errors[] = "Arrival Airport Code is Empty!";
        }
        if(empty($data["arrivalTime"]))
        {
            $errors[] = "Arrival Time is Empty!";
        }
        if(empty($data["price"]))
        {
            $errors[] = "Price is Empty!";
        }
        if(array_key_exists("flightNumber", $data)){
            if(filter_var($data["flightNumber"], FILTER_VALIDATE_INT) === false){
                $errors[]  = "Flight Number Must be an Integer";
            }
        }
        return $errors;
    }
}
?>