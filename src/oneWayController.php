<?php

// This controller will handle all request related to airline

class oneWayController
{

    // Creating Constructor
    public function __construct(private oneWayGateway $oneWayGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method):void
    {
        
            $this->processCollectionRequest($method);
        
    }

    // Function to handle the Update Requests
    private function processResourceRequest (string $method, string $source, string $destination):void
    {

        $data = $_GET;
        var_dump($data);
        // $dac = $this->oneWayGateway->getoneWayTrip($source, $destination); //This is Departure Airport Code
        // if(!$dac)
        // {
        //     http_response_code(404); //if Departure Airport Code is wrong print error with status code 404 and error message
        //     echo json_encode(["message" => "No Flights Found"]);
        //     return;
        // }
        // // Creating Switch for Requests
        // switch($method)
        // {
        //     case "GET":
        //         echo json_encode($dac); //printing json encoded data of  flight
        //         break;
        //     default:
        //         http_response_code(405);
        //         header("Allow: GET");
        // }
        
    }
    private function processCollectionRequest(string $method):void
    {
        // Using Switch method for various http methods
        // Using array to check whether the post request is empty or not
        switch($method){
            case "POST":
                $data = $_POST;
                $errors = $this->getValidationErrors($data); //Validating the data
                if(! empty($errors))
                {
                    http_response_code(422); //if errors found sending HTTP status 422 
                    echo json_encode(["errors" => $errors]); //Sending error message
                    break;
                }    
                $oneWayResp = $this->oneWayGateway->getoneWayTrip($data['source'],$data['destination']); //Adding data to Database using the Gataway class 
                http_response_code(201); //Setting the HTTP status to 201 as Data is added in the database with the success message
                echo json_encode($oneWayResp);
                break;
            default:
                http_response_code(405); //Setting the default call if other methods are used to call the data and displying the allowed request
                header("Allow: POST");
        }
    }

    // Creating function to validate the data 
    private function getValidationErrors(array $data):array
    {
        $errors = [];
        if(empty($data["source"]))
        {
            $errors[] = "Source is Empty";
        }
        if(empty($data["destination"]))
        {
            $errors[] = "Destination is Empty";
        }
        return $errors;
    }
}
?>