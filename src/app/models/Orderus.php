<?php

namespace app\models;

use app\components\abstractions\Model as ModelBase;
use app\components\abstractions\ModelFactory;
use Exception;

class Orderus extends ModelBase
{

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
     * Find and return results
     *
     * @param $params
     */
    public static function find($params)
    {
        // TODO Implement find method
    }

    /**
     * Add model validations
     */
    public function validate()
    {
        // TODO Validate this model attributes
    }
}