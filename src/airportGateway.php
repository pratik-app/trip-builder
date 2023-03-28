<?php
class airportGateway
{
    private PDO $con;

    // Controller

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    // Creating function to get all Airlines details

    public function getAllAirports():array
    {
        // SQL Query

        $sql = "SELECT * FROM airports";

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

    public function createAirports(array $data):string
    {
        $sql = "INSERT INTO airports(iata_airport_code,name,city, latitude, longitude, timezone, city_code, country_code, region_code) 
        VALUES (:iac,:airport_name, :city, :lat, :lng, :timezone, :cityCode, :countryCode, :regionCode)";

        // Calling Prepare Method

        $stmt = $this->con->prepare($sql);

        // Binding Parameters

        $stmt->bindValue(":iac", $data["iataAirportCode"], PDO::PARAM_STR);
        $stmt->bindValue(":airport_name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":city", $data["city"], PDO::PARAM_STR);
        $stmt->bindValue(":lat", $data["lat"], PDO::PARAM_STR);
        $stmt->bindValue(":lng", $data["lng"], PDO::PARAM_STR);
        $stmt->bindValue(":timezone", $data["timezone"], PDO::PARAM_STR);
        $stmt->bindValue(":cityCode", $data["cityCode"], PDO::PARAM_STR);
        $stmt->bindValue(":countryCode", $data["countryCode"], PDO::PARAM_STR);
        $stmt->bindValue(":regionCode", $data["regionCode"], PDO::PARAM_STR);
        $stmt->execute();
        $returnData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $returnData;
    }

    // Creating function for getting Airport Code

    public function get(string $iata_airportCode): array | false
    {
        $sql = "SELECT * FROM airports WHERE iata_airport_code = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $iata_airportCode, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    // Creating Update Method

    public function updateAirports(array $CurrentFN, array $new): string
    {
        $sql = "UPDATE airports
                SET  
                name = :airport_name,
                city = :city,
                latitude = :latitude,
                longitude = :longitude,
                timezone = :timezone,
                city_code = :city_code,
                country_code = :country_code,
                region_code = :region_code
                WHERE iata_airport_code  = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $CurrentFN, PDO::PARAM_STR);
        $stmt->bindValue(":airport_name", $new["name"]);
        $stmt->bindValue(":city", $new["city"]);
        $stmt->bindValue(":latitude", $new["latitude"]);
        $stmt->bindValue(":longitude", $new["longitude"]);
        $stmt->bindValue(":timezone", $new["timezone"]);
        $stmt->bindValue(":city_code", $new["city_code"]);
        $stmt->bindValue(":country_code", $new["country_code"]);
        $stmt->bindValue(":region_code", $new["region_code"]);
        $stmt->execute();
        return $stmt->rowCount();
        
    }

    // Creating Delete Method
    public function deleteAirports(string $iata_airportCode): string
    {
        $sql = "DELETE FROM airports WHERE iata_airport_code = :iac";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":iac", $iata_airportCode, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>