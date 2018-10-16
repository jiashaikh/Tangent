<?php

namespace QueueService;

require_once __DIR__ . '/vendor/autoload.php';

use Application\Table\CountryPopulationTable;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class CountryPopulation
{
    private $countryPopulationTable;

    /**
     * @param CountryPopulationTable $countryPopulationTable
     */
    public function __construct(CountryPopulationTable $countryPopulationTable)
    {
	$this->countryPopulationTable = $countryPopulationTable;
    }

    /**
     * Get the country population
     *
     * @return int
     */
    public function consumeMessage() 
    {
	$connection = new AMQPStreamConnection('country', 5672, 'guest', 'guest');
	
	$channel = $connection->channel();
	$channel->queue_declare('country', false, false, false, false);

	$callback = function ($msg) {
	    $code = $msg->body;

	    // TO DO - trigging the API 
	    $getCountry = new GetCountry();
	    $response = $getCountry->get($code);
	    
            if (!$response) {
		// TO DO - put the message into DLQ
	    }

	    // TO DO - save into Database
	};

	$channel->basic_consume('country', '', false, true, false, false, $callback);
	while (count($channel->callbacks)) {
   	    $channel->wait();
	}

	$channel->close();
	$connection->close();

	return true;
    }
}
