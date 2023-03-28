<?php
class airlineGateway
{
    private PDO $con;

    // Controller

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    // Creating function to get all Airlines details

    public function getAllAirlines():array
    {
        // SQL Query

        $sql = "SELECT * FROM airlines";

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

    public function createAirlines(array $data):string
    {
        $sql = "INSERT INTO airlines (iata_airline_code,name,description) VALUES (:iac,:airline_name, :airline_description)";

        // Calling Prepare Method

        $stmt = $this->con->prepare($sql);

        // Binding Parameters

        $stmt->bindValue(":iac", $data["iataAirlineCode"], PDO::PARAM_STR);
        $stmt->bindValue(":airline_name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":airline_description", $data["description"], PDO::PARAM_STR);
        $stmt->execute();
        $returnData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $returnData;
    }

    // Creating function for getting Airline Code

    public function get(string $iata_airlineCode): array | false
    {
        $sql = "SELECT * FROM airlines WHERE iata_airline_code = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $iata_airlineCode, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    // Creating Update Method

    public function updateAirline(array $CurrentFN, array $new): string
    {
        $sql = "UPDATE airlines
                SET  
                name = :name,
                description = :description, 
                WHERE iata_airline_code  = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $CurrentFN, PDO::PARAM_STR);
        $stmt->bindValue(":name", $new["name"]);
        $stmt->bindValue(":description", $new["description"]);
        $stmt->execute();
        return $stmt->rowCount();
        
    }

    // Creating Delete Method
    public function deleteAirlines(string $iata_airlineCode): string
    {
        $sql = "DELETE FROM airlines WHERE iata_airline_code = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $iata_airlineCode, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>