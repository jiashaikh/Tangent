<?php
namespace Application\Table;

use Application\Model\CountryPopulation;
use Application\AbstractTable;

class LinkTable extends AbstractTable
{
    /**
     * @param string $country
     *
     * @return CountryPopulation|null
     */
    public function findByCountry($country)
    {
        return $this->tableGateway->select(['country' => $country])->current();
    }
}
