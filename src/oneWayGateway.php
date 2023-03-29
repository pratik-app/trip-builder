<?php
class oneWayGateway
{
    private PDO $con;

    // Controller

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    public function getoneWayTrip($source, $destination):array
    {
        // SQL Query

        $sql = "SELECT a.iata_airline_code AS airline_code, 
        a.name AS airline_name, 
        a.description AS airline_description,
        ap.iata_airport_code AS airport_code,
        ap.name AS airport_name,
        ap.city AS airport_city,
        ap.latitude AS airport_latitude,
        ap.longitude AS airport_longitude,
        ap.timezone AS airport_timezone,
        ap.city_code AS airport_city_code,
        ap.country_code AS airport_country_code,
        ap.region_code AS airport_region_code,
        af.flight_number AS flight_number,
        af.airline_code AS flight_airline_code,
        af.departure_airport_code AS flight_departure_airport_code,
        af.departure_time AS flight_departure_time,
        af.arrival_airport_code AS flight_arrival_airport_code,
        af.arrival_time AS flight_arrival_time,
        af.price AS flight_price
    FROM flights AS af
        JOIN airports AS ap ON af.departure_airport_code = ap.iata_airport_code
        JOIN airlines AS a ON af.airline_code = a.iata_airline_code
    WHERE af.departure_airport_code = '$source' AND af.arrival_airport_code = '$destination'
    ";
        $stmt = $this->con->query($sql);
        $stmt->execute();
        $data = [];
        // Fetching Data
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data['airlines'][] = array(
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