<?php

namespace app\models;

use app\components\abstractions\Model as ModelBase;
use app\components\abstractions\ModelFactory;
use app\components\JsonConnection;
use app\components\ModelError;
use Exception;

class Orderus extends ModelBase
{
    /**
     * @var string
     */
    public $myName;

    /**
     * Orderus constructor.
     */
    public function __construct()
    {
        $this->myName = $this->getMyName(__CLASS__);
        $this->resolveAttributes();
    }

    /**
     * Set and populate model with attributes
     */
    private function resolveAttributes()
    {
        $connectionData = [
            'host'    => 'app/data/' . $this->myName . '.json',
            'command' => 'r'
        ];

        $connection = new JsonConnection($connectionData);
        if (is_string($connection->bootstrap())) {
            $this->addError(new ModelError('JsonConnection', $connection->bootstrap()));
        }
        $connection->bootstrap();
        $attributes = $connection->getDataCollection($connection->connection);
        if (!is_array($attributes)) {
            $this->addError(new ModelError('JsonConnection', $attributes));
        }
        $connection->end();

        if (!$this->hasErrors()) {
            $this->loadAttributes($attributes);
        }
    }

    /**
     * Create Orderus model
     *
     * @return mixed
     * @throws Exception
     */
    public static function create()
    {
        return ModelFactory::create('Orderus');
    }

    /**
     * @inheritDoc
     */
    public function validate()
    {
        // TODO: Implement validate() method.
    }

    /**
     * @inheritDoc
     */
    public static function findAll($params)
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @inheritDoc
     */
    public static function find($params)
    {
        // TODO: Implement find() method.
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function insert()
    {
        // TODO: Implement insert() method.
    }

    /**
     * @inheritDoc
     */
    public static function delete($params)
    {
        // TODO: Implement delete() method.
    }
}