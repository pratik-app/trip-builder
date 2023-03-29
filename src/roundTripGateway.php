<?php
class roundTripGateway
{
    private PDO $con;

    // Controller

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    public function getRoundTrip($departure_airport, $arrival_airport, $departure_date, $return_date):array
    {
        // SQL Query

        $sql = "SELECT * FROM flights";
        $stmt = $this->con->query($sql);
        $stmt->execute();
        $data = [];
        // Fetching Data
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data['request'][] = array(
            'airline_code' => $row['airline_code'],
            'airline_name' => $row['airline_name'],
            'airline_description' => $row['airline_description'],
            );
            $data['airports'][] = array(
            'airport_code' => $row['airport_code'],
            'airport_name' => $row['airport_name'],
            'airport_city' => $row['airport_city'],
            'airport_latitude' => $row['airport_latitude'],
            'airport_longitude' => $row['airport_longitude'],
            'airport_timezone' => $row['airport_timezone'],
            'airport_city_code' => $row['airport_city_code'],
            'airport_country_code' => $row['airport_country_code'],
            'airport_region_code' => $row['airport_region_code'],
            );
            $data['flights'][] = array(
                'flight_number' => $row['flight_number'],
                'flight_airline_code'=> $row['flight_airline_code'],
                'flight_departure_airport_code' => $row['flight_departure_airport_code'],
                'flight_departure_time' => $row['flight_departure_time'],
                'flight_arrival_airport_code' => $row['flight_arrival_airport_code'],
                'flight_arrival_time' => $row['flight_arrival_time'],
                'flight_price' => $row['flight_price']
            );
        }
        // Returning Data
        return $data;
    }
}
?>