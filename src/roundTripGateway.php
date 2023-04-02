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

        $sql = "SELECT  f1.flight_number AS firstFlightNumber, f2.flight_number AS secondFlightNumber, f1.airline_code AS firstFlightAC, f2.airline_code AS secondFlightAC, al.name AS airline_name, f1.departure_time AS departure_datetime, f1.departure_airport_code AS departure_airport_code, f2.departure_time AS return_datetime, f1.arrival_airport_code AS arrival_airport_code, f1.price + f2.price AS total_price,f1.price AS firstflight_price, f2.price AS secondflight_price                
        FROM flights f1
        INNER JOIN flights f2 ON f1.arrival_airport_code = f2.departure_airport_code AND f1.airline_code = f2.airline_code
        INNER JOIN airports a1 ON f1.departure_airport_code = a1.iata_airport_code
        INNER JOIN airports a2 ON f2.arrival_airport_code = a2.iata_airport_code
        INNER JOIN airlines al ON f1.airline_code = al.iata_airline_code
        WHERE f1.departure_airport_code = '$departure_airport' AND f1.arrival_airport_code = '$arrival_airport' AND
              f1.departure_time = '$departure_date' AND f2.departure_time = '$return_date'";
        $stmt = $this->con->query($sql);
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $data = [];
        // Fetching Data
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data = [
                'trips' =>[
                    'price' => number_format($row['total_price'], 2),
                    'flights' =>[

                        [
                            'airline'=>$row['airline_code'],
                            'number' =>$row['flight_numer'],
                            'departure_airport' =>$row['departure_airport_code'],
                            'departure_datetime' =>$departure_date,
                            'arrival_airport' =>$row['arrival_airport_code'],
                            'arrival_datetime' =>$arrival_airport,
                            'price' =>$row['price']
                        ],
                        [
                            'airline'=>$row['airline_code'],
                            'number' =>$row['flight_numer'],
                            'departure_airport' =>$row['departure_airport_code'],
                            'departure_datetime' =>$departure_date,
                            'arrival_airport' =>$row['arrival_airport_code'],
                            'arrival_datetime' =>$arrival_airport,
                            'price' =>$row['price']
                        ]

                    ]
                    
                ]
            ];     
        }
        // Returning Data
        return $data;
    }
}
?>