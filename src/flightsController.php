<?php

// This controller will handle all request related to flights

class flightsController
{

    // Creating Constructor
    public function __construct(private flightGateway $flightGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method, ?string $flightNumber):void
    {
        if($flightNumber){
            $this->processResourceRequest($method, $flightNumber); //Calling function 
        }else
        {
            $this->processCollectionRequest($method);
        }
    }

    // Function to handle the Update Requests
    private function processResourceRequest (string $method, string $flightNumber):void
    {

        $flight = $this->flightGateway->get($flightNumber); //This is Flight Number
        if(!$flight)
        {
            http_response_code(404); //if Flight number is wrong print error with status code 404 and error message
            echo json_encode(["message" => "No Flights Found"]);
            return;
        }
        // Creating Switch for Requests
        switch($method)
        {
            case "GET":
                echo json_encode($flight); //printing jsong encoded data of  flight
                break;
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"),true);
                print_r($data);
                // $errors = $this->getValidationErrors($data); //Validating the data
                // if(! empty($errors))
                // {
                //     http_response_code(422); //if errors found sending HTTP status 422 
                //     echo json_encode(["errors" => $errors]); //Sending error message
                //     break;
                // }
                // // Calling the create method from the Gateway
                // $rows = $this->flightGateway->updateflight($flight, $data); //Updating the flight table
                
                // echo json_encode([
                //     "message" => "Flight Added",
                //     "rows" => $rows                    
                // ]); //Sending Success Message in JSON format 
                break;
            case "DELETE":
                $rows = $this->flightGateway->deleteflight($flightNumber); //Calling function and displaying success message
                echo json_encode([
                    "message" => "flight Details are deleted!",
                    "rows"=> $rows
                ]);
                break;
        }
        
    }

    // Creating function for prossing the POST and GET Request 

    private function processCollectionRequest(string $method):void
    {
        // Using Switch method for various http methods
        // Using array to check whether the post request is empty or not
        switch($method){
            case "GET":
                echo json_encode($this->flightGateway->getAllFlights()); //This will show all flights from flight table
                break;
            case "POST":
                $data = $_POST;
                // Calling the Error Validation Method

                $errors = $this->getValidationErrors($data); //Validating the Data 
                if(! empty($errors))
                {
                    http_response_code(422); //Providing Errors if there is error in data with Status code 422 and error message in JSON Format
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                // Calling the create method from the Gateway
                $fNumber = $this->flightGateway->createFlight($data); //Adding data to Database using the Gataway class 
                http_response_code(201); //Setting the HTTP status to 201 as Data is added in the database with the success message
                echo json_encode([
                    "message" => "Flight Added",                    
                ]);
                break;
            default:
                http_response_code(405); //Setting the default call if other methods are used to call the data and displying the allowed request
                header("Allow: GET, POST");
        }
    }
    // Creating function to validate the data 
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
            
            // Generating the error if the flight number is not integer

            if(filter_var($data["flightNumber"], FILTER_VALIDATE_INT) === false){
                $errors[]  = "Flight Number Must be an Integer";
            }
        }
        return $errors;
    }
}
?>