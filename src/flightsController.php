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
                // Calling the create method from the Gateway
                $fNumber = $this->flightGateway->createFlight($data);
                http_response_code(201);
                echo json_encode([
                    "message" => "Flight Added",                    
                ]);
                break;
        }
    }
}
?>