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
}
?>