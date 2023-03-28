<?php

// This controller will handle all request related to airline

class airlinesController
{

    // Creating Constructor
    public function __construct(private airlineGateway $airlineGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method, ?string $iata_airlineCode):void
    {
        if($iata_airlineCode){
            $this->processResourceRequest($method, $iata_airlineCode); //Calling function 
        }else
        {
            $this->processCollectionRequest($method);
        }
    }

    // Function to handle the Update Requests
    private function processResourceRequest (string $method, string $iata_airlineCode):void
    {

        $airlineCode = $this->airlineGateway->get($iata_airlineCode); //This is Airline Code
        if(!$airlineCode)
        {
            http_response_code(404); //if Airline Code is wrong print error with status code 404 and error message
            echo json_encode(["message" => "No Airlines Found"]);
            return;
        }
        // Creating Switch for Requests
        switch($method)
        {
            case "GET":
                echo json_encode($airlineCode); //printing json encoded data of  flight
                break;
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"),true);
                $errors = $this->getValidationErrors($data); //Validating the data
                if(! empty($errors))
                {
                    http_response_code(422); //if errors found sending HTTP status 422 
                    echo json_encode(["errors" => $errors]); //Sending error message
                    break;
                }
                // Calling the create method from the Gateway
                $rows = $this->airlineGateway->updateAirline($airlineCode, $data); //Updating the Airline table
                echo json_encode([
                    "message" => "Airline Updated",
                    "rows" => $rows                    
                ]); //Sending Success Message in JSON format 
                break;
            case "DELETE":
                $rows = $this->airlineGateway->deleteAirlines($iata_airlineCode); //Calling function and displaying success message
                echo json_encode([
                    "message" => "Airline Details are deleted!",
                    "rows"=> $rows
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
        
    }

    // Creating function for prossing the POST and GET Request 

    private function processCollectionRequest(string $method):void
    {
        // Using Switch method for various http methods
        // Using array to check whether the post request is empty or not
        switch($method){
            case "GET":
                echo json_encode($this->airlineGateway->getAllAirlines()); //This will show all airline from airline table
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
                $airline_Code = $this->airlineGateway->createAirlines($data); //Adding data to Database using the Gataway class 
                http_response_code(201); //Setting the HTTP status to 201 as Data is added in the database with the success message
                echo json_encode([
                    "message" => "Airline Added",                    
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
        if(empty($data["iataAirlineCode"]))
        {
            $errors[] = "Airline Code is Empty";
        }
        if(empty($data["name"]))
        {
            $errors[] = "Air Line Name is Empty!";
        }
        return $errors;
    }
}
?>