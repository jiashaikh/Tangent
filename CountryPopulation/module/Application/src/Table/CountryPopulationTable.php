<?php
namespace Application\Table;

use Application\Model\CountryPopulation;
use Application\AbstractTable;

class CountryPopulationTable extends AbstractTable
{
    /**
     * @param string $code
     *
     * @return CountryPopulation|null
     */
    public function findByCode($code)
    {
        return $this->tableGateway->select(['code' => $code])->current();
    }
}
