<?php

// This controller will handle RoundTrip request

class roundTripController
{

    // Creating Constructor
    public function __construct(private roundTripGateway $roundTripGateway)
    {
        
    }
    // Creating function tor process the data provided from Index.php with id and method 

    public function processRequest(string $method):void
    {
        
            $this->processCollectionRequest($method);
        
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
                $oneWayResp = $this->roundTripGateway->getRoundTrip($data['departure_airport'],$data['arrival_airport'], $data['departure_date'], $data['return_date']); 
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
        if(empty($data["departure_airport"]))
        {
            $errors[] = "Departure Airport is Empty";
        }
        if(empty($data["arrival_airport"]))
        {
            $errors[] = "Arrival Airport is Empty";
        }
        
        if(empty($data["departure_date"]))
        {
            $errors[] = "Departure Date is Empty";
        }
        
        if(empty($data["return_date"]))
        {
            $errors[] = "Return Date is Empty";
        }
        return $errors;
    }
}
?>