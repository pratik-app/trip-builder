<?php

// This controller will handle all request related to ariports

class airportController
{

    // Creating Constructor
    public function __construct(private airportGateway $airportGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method, ?string $iata_airportCode):void
    {
        if($iata_airportCode){
            $this->processResourceRequest($method, $iata_airportCode); //Calling function 
        }else
        {
            $this->processCollectionRequest($method);
        }
    }

    // Function to handle the Update Requests
    private function processResourceRequest (string $method, string $iata_airportCode):void
    {

        $airportCode = $this->airportGateway->get($iata_airportCode); //This is Airport Code
        if(!$airportCode)
        {
            http_response_code(404); //if Airport Code is wrong print error with status code 404 and error message
            echo json_encode(["message" => "No Airports Found"]);
            return;
        }
        // Creating Switch for Requests
        switch($method)
        {
            case "GET":
                echo json_encode($airportCode); //printing json encoded data of  flight
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
                $rows = $this->airportGateway->updateAirports($airportCode, $data); //Updating the Airport table
                echo json_encode([
                    "message" => "Airport Updated",
                    "rows" => $rows                    
                ]); //Sending Success Message in JSON format 
                break;
            case "DELETE":
                $rows = $this->airportGateway->deleteAirports($iata_airportCode); //Calling function and displaying success message
                echo json_encode([
                    "message" => "Airport Details are deleted!",
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
                echo json_encode($this->airportGateway->getAllAirports()); //This will show all Airport from Airports table
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
                $airport_Code = $this->airportGateway->createAirports($data); //Adding data to Database using the Gataway class 
                http_response_code(201); //Setting the HTTP status to 201 as Data is added in the database with the success message
                echo json_encode([
                    "message" => "Airline Added",
                    "data" => $airport_Code                    
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
        if(empty($data["iataAirportCode"]))
        {
            $errors[] = "Airport Code is Empty";
        }
        if(empty($data["name"]))
        {
            $errors[] = "Airport Name is Empty!";
        }
        
        if(empty($data["city"]))
        {
            $errors[] = "Airport City is Empty!";
        }
        
        if(empty($data["lat"]))
        {
            $errors[] = "Airport Latitude is Empty!";
        }
        
        if(empty($data["lng"]))
        {
            $errors[] = "Airport Longitude is Empty!";
        }
        
        if(empty($data["timezone"]))
        {
            $errors[] = "Airport Timezone is Empty!";
        }
        
        if(empty($data["cityCode"]))
        {
            $errors[] = "Airport City Code is Empty!";
        }
        
        if(empty($data["countryCode"]))
        {
            $errors[] = "Airport Country Code is Empty!";
        }
        if(empty($data["regionCode"]))
        {
            $errors[] = "Airport Region Code is Empty!";
        }
        return $errors;
    }
}
?>