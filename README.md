# Trip-Builder

This is a collection of API's to manage flights and airlines information in the Trip-Builder application. NOTE: This is Assesment

## Getting Started

This API is built using the localhost server. The API endpoints can be accessed by sending HTTP requests using a tool like Postman or a similar tool.

### Prerequisites

To be able to use this API, you will need the following installed on your system:

- A tool to send HTTP requests such as POSTMAN.
- A local server like XAMPP.

### Installation

1. Clone or download the repository to your local machine.
2. Import the sql file attached in this repository to phpmyadmin.
3. Store the project in htdocs, inside a folder like Trip-Builder.
4. Now send request using POSTMAN with the help of API Endpints.


## Live Application Requests

- https://trip-builder.pratikmore.com/
- Please send request using postman or view this website with EndPoints 
    for example:
        
        This will fetch all trips details

        - https://trip-builder.pratikmore.com/trips/ 

        This will fetch One Way Trip Details 

        - https://trip-builder.pratikmore.com/onewaytrip/

        NOTE: Data must be passed with the request
        NOTE: Data must be passed with the Details For Example using postman pass data using Body data must be 
        Key =  "source"  | Value "YUL" 
        Key = "destination" | Value "YVR" 
        
        This will fetch Round Trip Details

        - https://trip-builder.pratikmore.com/roundtrip

        NOTE: Data must be passed with the Details For Example using postman pass data using Body data must be 
        Key =  "departure_airport"  | Value "YUL" 
        Key = "arrival_airport" | Value "YVR" 
        Key = "departure_date"| Value "2023-04-04 07:35" 
        key = "return_date" | Value "2023-04-05 12:35"


## API ENDPOINTS

### ONE-WAY-FLIGHTS

- POST`/onewaytrip` - Get details as mentioned in the task. NOTE: use POST request insted of GET.Example will be shown in Request Examples.


### Flights

- GET`/trips/` - get all the flights.
- POST`/trips` - add new flight details to the flight table. NOTE: If using POSTMAN send a form data in JSON format Example will be shown in Request Examples. KEY: flightNumber,airlineCode, departureAirportCode, departureTime, arrivalAirportCode, arrivalTime, price.
- GET`/trips/{flightNumber}` - Get flight details from the flight number. NOTE: The flight Number must be in INT format you can try /trips/301.
- PATCH`/trips/{flightNumber}` - Update flight details NOTE: If using POSTMAN send a raw data in JSON format Example will be shown in Request Examples.
- DELETE`/trips/{flightNumber}` - DELETE any flight details.

### Airline

- GET`/airlines/` - Get all Airline Details.
- GET`/airlines/{iataAirlineCode}` - GET Specific Airline Detail. NOTE: AirlineCode is String For example, AC stands for Air Canada
- POST`/airlines` - ADD new Airline Detail. NOTE: Data must be pass via form-data KEY: iataAirlineCOde, name, description.
- PATCH`/airlines/{iataAirlineCode}` - Update existing record. NOTE: If using POSTMAN send a raw data in JSON format Example will be shown in Request Examples.
- DELETE`/airlines/{iataAirlineCode}` - DELETE any Airline Details.

### Airport

- GET`/airports/` - Get all Airline Details.
- GET`/airports/{iataAirportCode}` - GET Specific Airline Detail. NOTE: AirlineCode is String For example, AC stands for Air Canada
- POST`/airlines` - ADD new Airline Detail. NOTE: Data must be pass via form-data KEY: iataAirlineCOde, name, description.
- PATCH`/airlines/{iataAirportCode}` - Update existing record. NOTE: If using POSTMAN send a raw data in JSON format Example will be shown in Request Examples.
- DELETE`/airlines/{iataAirportCode}` - DELETE any Airline Details.

## REQUEST SAMPLES

- POST Request

One Way Trip Request

![alt text](https://github.com/pratik-app/trip-builder/blob/main/OneWayTrip.jpg)

- GET Request

![alt text](https://github.com/pratik-app/trip-builder/blob/main/Test1.jpg)

- POST Request

![alt text](https://github.com/pratik-app/trip-builder/blob/main/SendingPostRequestData.jpg)

- PATCH Request

![alt text](https://github.com/pratik-app/trip-builder/blob/main/PATCH%20Method%20Solved.jpg)

- DELETE Request

![alt text](https://github.com/pratik-app/trip-builder/blob/main/Delete%20Record%20from%20Database.jpg)

