<?php

// This controller will handle all request related to flights

class flightsController
{
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
    {

    }

    private function processCollectionRequest(string $method):void
    {
        switch($method){
            case "GET":
                echo json_encode(["flight Number" => 123]);
                break;
        }
    }
}
?>