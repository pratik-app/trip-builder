<?php
class oneWayGateway
{
    private PDO $con;

    // Controller

    public function __construct(connection $connection)
    {
        $this->con = $connection->getConnection();
    }

    public function getoneWayTrip():array
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
        af.price AS flight_price,
        ap2.code AS arrival_airport_code,
        ap2.city_code AS arrival_city_code,
        ap2.name AS arrival_airport_name,
        ap2.city AS arrival_city,
        ap2.country_code AS arrival_country_code,
        ap2.region_code AS arrival_region_code,
        ap2.latitude AS arrival_latitude,
        ap2.longitude AS arrival_longitude,
        ap2.timezone AS arrival_timezone
    FROM flights AS af
        JOIN airport AS ap ON af.departure_airport_id = ap.id
        JOIN airport AS ap2 ON af.arrival_airport_id = ap2.id
        JOIN airline AS a ON af.airline_id = a.id;
    ";
        $stmt = $this->con->query($sql);
        $stmt->execute();
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