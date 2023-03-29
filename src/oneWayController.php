<?php

// This controller will handle all request related to airline

class oneWayController
{

    // Creating Constructor
    public function __construct(private oneWayGateway $oneWayGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method, ?string $source, ?string $destination):void
    {
        if($source || $destination){
            $this->processResourceRequest($method, $source, $destination); //Calling function 
        }
    }

    // Function to handle the Update Requests
    private function processResourceRequest (string $method, string $source, string $destination):void
    {

        $dac = $this->oneWayGateway->getoneWayTrip($source, $destination); //This is Departure Airport Code
        if(!$dac)
        {
            http_response_code(404); //if Departure Airport Code is wrong print error with status code 404 and error message
            echo json_encode(["message" => "No Flights Found"]);
            return;
        }
        // Creating Switch for Requests
        switch($method)
        {
            case "GET":
                echo json_encode($dac); //printing json encoded data of  flight
                break;
            default:
                http_response_code(405);
                header("Allow: GET");
        }
        
    }

    // Creating function to validate the data 
    private function getValidationErrors(array $data):array
    {
        $errors = [];
        if(empty($data["dept-airport-code"]))
        {
            $errors[] = "Departure Airport Code is Empty";
        }
        return $errors;
    }
}
?>