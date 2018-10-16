<?php

namespace Application;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Exception;

abstract class AbstractTable
{
    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    protected $tableGateway;

    /**
     * Create a new instance of the class.
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Returns ONE record, selecting by the id key.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }

    /**
     * Returns all the records matching the filters.
     *
     * @param $filters
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findBy($filters)
    {
        return $this->tableGateway->select($filters);
    }

    /**
     * Returns all the records.
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Returns all records in the order specified by the $order array
     *
     * @param $order
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function findAllInOrder(array $order)
    {
        return $this->tableGateway->selectWith(
            $this->getSelect()->order($order)
        );
    }

    /**
     * @param Select     $select
     * @param array|null $parameters
     *
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function execute(Select $select, $parameters = null)
    {
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
        return $statement->execute($parameters);
    }

    /**
     * @param string $select namespace of the select class
     * @return \Zend\Db\Sql\Select
     */
    public function getSelect($select = null)
    {
        if ($select === null) {
            return $this->tableGateway->getSql()->select();
        }

        if (class_exists($select)) {
            $selectInstance = new $select();
            $selectInstance->init();

            return $selectInstance;
        }
    }

    /**
     * Returns the name of the table.
     *
     * @param String $table - If specified it will return the name of the table
     *                        from the config file.
     * @return String
     */
    public function getTable($table = null)
    {
        if ($table === null) {
            return $this->tableGateway->getTable();
        }

        return self::getTableFromConfig($table);
    }

    /**
     * Obtains the table name from the config. We need the static method to be
     * able to access the table names from outside the table instances.
     *
     * @param String $table
     * @return String
     * @throws Exception
     */
    public static function getTableFromConfig($table = null)
    {
        $tablesConfig = include 'config/tables.config.php';

        if (isset($tablesConfig[$table]) && $table !== null) {
            return $tablesConfig[$table];
        }

        throw new Exception("$table table does not exist!");
    }

    /**
     * Returns the adapter
     *
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }

    /**
     * @return int
     */
    public function getLastInsertValue()
    {
        return $this->tableGateway->getLastInsertValue();
    }
}
