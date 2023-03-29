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

        $sql = "SELECT f1.flight_number, f1.airline_code, f1.departure_time AS departure_datetime, f1.arrival_airport_code, f2.departure_time AS return_datetime, f2.arrival_airport_code, f1.price + f2.price AS total_price,
        a1.name AS departure_airport_name, a1.city AS departure_city, a2.name AS arrival_airport_name, a2.city AS arrival_city,
        al.name AS airline_name, al.description AS airline_description
        FROM flights f1
        INNER JOIN flights f2 ON f1.arrival_airport_code = f2.departure_airport_code AND f1.airline_code = f2.airline_code
        INNER JOIN airports a1 ON f1.departure_airport_code = a1.iata_airport_code
        INNER JOIN airports a2 ON f2.arrival_airport_code = a2.iata_airport_code
        INNER JOIN airlines al ON f1.airline_code = al.iata_airline_code
        WHERE f1.departure_airport_code = 'YUL' AND f1.arrival_airport_code = 'YVR' AND
              DATE(f1.departure_time) = '2023-04-04 07:35' AND DATE(f2.departure_time) = '2023-04-05 12:35'";
        $stmt = $this->con->query($sql);
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':dep_airport', $departureAirport);
        $stmt->bindParam(':arr_airport', $arrivalAirport);
        $stmt->bindParam(':dep_date', $departureDate);
        $stmt->bindParam(':ret_date', $returnDate);
        $stmt->execute();
        $data = [];
        // Fetching Data
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data = [
                'price' => number_format($row['total_price'], 2),
                'flights' => [
                    [
                        'airline' => $row['airline_code'],
                        'number' => $row['flight_number'],
                        'departure_airport' => $row['departure_airport_code'],
                        'departure_datetime' => $row['departure_datetime'],
                        'arrival_airport' => $row['arrival_airport_code'],
                        'arrival_datetime' => $row['arrival_airport_name']
                    ],
                    [
                        'airline' => $row['airline_code'],
                        'number' => $row['flight_number'],
                        'departure_airport' => $row['departure_airport_code'],
                        'departure_datetime' => $row['departure_datetime'],
                        'arrival_airport' => $row['arrival_airport_code'],
                        'arrival_datetime' => $row['arrival_airport_name']
                    ]

                ]
            ];
        }
        // Returning Data
        return $data;
    }
}
?>