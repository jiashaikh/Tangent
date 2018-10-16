<?php

namespace CountryPopulation;

use Application\CountryPopulation;
use Application\Table\CountryPopulationTable;
use PHPUnit\Framework\TestCase;

class CountryPopulationTest extends TestCase
{
    private $countryPopulationTableMock;

    public function setUp()
    {
	$this->countryPopulationTableMock = $this->createMock(CountryPopulationTable::class);
    }

    public function testConstructStoresDependencies()
    {
        $countryPopulation = new CountryPopulation(
            $this->countryPopulationTableMock
        );

        // Assertions
        $this->assertAttributeEquals($this->countryPopulationTableMock, 'countryPopulationTable', $countryPopulation);
    }

    public function testGetPopulationCanBeAccessed()
    {
	// TO DO
    }

    public function testGetPopulationWillReturnErrorIfCountryIsEmpty()
    {
	// TO DO
    }

    public function testGetPopulationWillAddTheCountryOntoTheQueueIfTheDataIsNotAvailable()
    {
	// TO DO
    }

    public function testGetPopulationWillReturnThePopulationIfTheDataIsAvailable()
    {
        // TO DO
    }
}
