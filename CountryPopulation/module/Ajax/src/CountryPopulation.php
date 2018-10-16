<?php

namespace CountryPopulation;

require_once __DIR__ . '/vendor/autoload.php';

use Application\Table\CountryPopulationTable;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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
     * Get the population
     *
     * @return int
     */
    public function getPopulation() 
    {
	$code = $_GET['code'];

	if (!$country) {
	    return ['error' => 'Missing country'];	
	}

	$countryPopulation = $this->countryPopulationTable->findByCode($code);

	if (!$countryPopulation) {
	    $this->addCountryToQueue($code);

	    return ['population' => null];
	}

	return ['population' => $countryPopuation['population'];
    }

    protected function addCountryToQueue($country) 
    {
	$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	$channel = $connection->channel();

	// To add into 'country' queue
	$channel->queue_declare('country', false, false, false, false);

	$msg = new AMQPMessage($country);
	$channel->basic_publish($msg, '', 'country');

	$channel->close();
	$connection->close();

	return true;
    }
}
