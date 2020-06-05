<?php

namespace app\models;

use app\components\abstractions\Model as ModelBase;
use app\components\abstractions\ModelFactory;
use app\traits\DataManipulationTrait;
use Exception;

class Beast extends ModelBase
{
    use DataManipulationTrait;

    /**
     * @var string
     */
    public $myName;

    /**
     * Wild Beast constructor.
     */
    public function __construct()
    {
        $this->myName = $this->getMyName(__CLASS__);
        self::resolveAttributes($this);
    }

    /**
     * Create Beast model
     *
     * @return mixed
     * @throws Exception
     */
    public static function create()
    {
        return ModelFactory::create('Beast');
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