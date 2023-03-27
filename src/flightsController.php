<?php

class flightsController
{
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