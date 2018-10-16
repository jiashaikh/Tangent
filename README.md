Please note this is a proof of concept application. The structure of the web app and consumer scripts have been built but they are not completed. 

* Web app: *
./CountryPopulation
On page load:
- It uses the HTML5 geolocation to get the latitude and longitude.
- It uses the google API to get the country using the latitude and longitude.
- Ajax call (using axios) to get the population from the database 
- If the details are available, it will return the population to display. If the details are not available, it will add the country code as a message onto the 'country' queue (using RabbitMQ).

Pending:
- Autoload of all modules
- A config file (autoload) at the application level, which holds i.e. google api key, rabbitMQ credentials, DB user/password/database etc.
- Some of the functions are not completed

* Consumer: *
./QueueService
The consumer script should be set up on the server to run by calling consumeMessage function in module/QueueService/src/CountryPopulation.php
- It picks the message (country code) on the queue
- It sends SOAP request to the API to get the country name/code/population etc.
- If it gets response, the details will be saved into the DB. If it is failed, it will be sent to the DLQ for re-processing

Pending:
- Set up consumer scripts to listen to the queue
- Autoload of all modules
- A config file (autoload) at the application leve, which holds i.e. rabbitMQ crednetials, DB user/password/database etc.
- Some of the functions are not completed 

* TO DO for web app and consumer *
- Lazy load classes
- Take out the DB Table and Model related classes and create them as a separate project so that it can be used/shared on both web app and consumer
- Logs
