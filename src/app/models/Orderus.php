<?php

namespace app\models;

use app\components\abstractions\Model as ModelBase;
use app\components\abstractions\ModelFactory;
use app\traits\DataManipulationTrait;
use Exception;

class Orderus extends ModelBase
{
    use DataManipulationTrait;

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
        self::resolveAttributes($this);
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
     * Return Orderus skills
     *
     * @return mixed
     */
    public function getSkills()
    {
        return $this->data['skills'];
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