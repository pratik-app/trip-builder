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
}
?>