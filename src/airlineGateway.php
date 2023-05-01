<?php
class airlineGateway
{
    private PDO $con;

    /**
     * 
     * Constructor returns the connection variable
     * 
     */

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    /**
     * 
     * Creating function for getting all airlines
     * 
     * If will fetch all the avaiable airlines from the database.
     * 
     * @return void 
     */

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
    
    /**
     * 
     * Creating function to add new airline details
     * 
     * This function will add new airline details in the database
     * 
     * @param array $data airline code, airline name and airline description as parameter
     * @return void
     * 
     */

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

    /**
     * 
     * Creating function to get the airline details from the database.
     * 
     * This function will fetch all the airline details.
     * 
     * @param string $iata_airlineCode
     * @return void
     * 
     */

    public function get(string $iata_airlineCode): array | false
    {
        $sql = "SELECT * FROM airlines WHERE iata_airline_code = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $iata_airlineCode, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * 
     * Creatuing function to update the airline details.
     * 
     * This function will update specific details of airline.
     * 
     * @param array $new new parameter for iata airline Code
     * @return rowcount
     */

    public function updateAirline(array $new): string
    {
        $sql = "UPDATE airlines SET name = :airline_name, description = :airline_description WHERE iata_airline_code  = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $new["iataAirlineCode"], PDO::PARAM_STR);
        $stmt->bindValue(":airline_name", $new["name"]);
        $stmt->bindValue(":airline_description", $new["description"]);
        $stmt->execute();
        return $stmt->rowCount();
        
    }

    /**
     * 
     * Creating function to delete specific airline detail.
     * 
     * @param string $iata_airlineCode airline code as parameter
     * @return rowcount
     * 
     */
    
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