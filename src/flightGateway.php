<?php
class flightGateway
{
    private PDO $con;

    // Controller

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    // Creating function to get all flights details

    public function getAllFlights():array
    {
        // SQL Query

        $sql = "SELECT * FROM flights";

        $stmt = $this->con->query($sql);

        $data = [];

        // Fetching Data

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = $row;
        }

        // Returning Data

        return $data;
    }
    
    // Create function

    public function createFlight(array $data):string
    {
        $sql = "INSERT INTO flights (flight_number, airline_code, departure_airport_code, departure_time, arrival_airport_code, arrival_time, price)
                VALUES (:flightNumber, :airLineCode, :departureAC, :departureTime, :arrivalAC, :arrivalTime, :price)";

        // Calling Prepare Method

        $stmt = $this->con->prepare($sql);

        // Binding Parameters

        $stmt->bindValue(":flightNumber", $data["flightNumber"], PDO::PARAM_INT);
        $stmt->bindValue(":airLineCode", $data["airlineCode"], PDO::PARAM_STR);
        $stmt->bindValue(":departureAC", $data["departureAirportCode"], PDO::PARAM_STR);
        $stmt->bindValue(":departureTime", $data["departureTime"],PDO::PARAM_STR);
        $stmt->bindValue(":arrivalAC", $data["arrivalAirportCode"], PDO::PARAM_STR);
        $stmt->bindValue(":arrivalTime", $data["arrivalTime"], PDO::PARAM_STR);
        $stmt->bindValue(":price", $data["price"], PDO::PARAM_STR);
        $stmt->execute();
        return $this->con->lastInsertId();
    }

    // Creating function for getting flight Number

    public function get(string $flightNumber): array | false
    {
        $sql = "SELECT * FROM flights WHERE flight_number = :flightN";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":flightN", $flightNumber, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    // Creating Update Method

    public function updateflight(array $CurrentFN, array $new): int
    {
        $sql = "UPDATE flights
                SET  
                airline_code = :AirlineCode,
                departure_airport_code = :DAC, 
                departure_time =:DT, 
                arrival_airport_code = :AAC, 
                arrival_time = :arrivalTime, 
                price = :Price
                WHERE flight_number  = :flightNumber";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":flightNumber", $CurrentFN, PDO::PARAM_INT);
        $stmt->bindValue(":airline_code", $new["airlineCode"]);
        $stmt->bindValue(":departure_airport_code", $new["departureAirportCode"]);
        $stmt->bindValue(":departure_time", $new["departureTime"]);
        $stmt->bindValue(":arrival_airport_code", $new["arrivalAirportCode"]);
        $stmt->bindValue(":arrival_time", $new["arrivalTime"]);
        $stmt->bindValue(":price", $new["price"]);
        
        $stmt->execute();
        return $stmt->rowCount();
        
    }

    // Creating Delete Method
    public function deleteflight(string $flightNumber): int
    {
        $sql = "DELETE FROM flights WHERE flight_number = :flightNum";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":flightNum", $flightNumber, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>