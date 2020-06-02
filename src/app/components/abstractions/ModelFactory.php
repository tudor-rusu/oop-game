<?php

namespace app\components\abstractions;

use Exception;
use RuntimeException;

/**
 * Class that instantiates the model class
 */
class ModelFactory
{

    /**
     * Create the model based on type
     *
     * @param $type
     *
     * @return mixed
     * @throws Exception
     */
    public static function create($type = '')
    {
        if ($type === '') {
            throw new RuntimeException('Invalid Model Type.');
        }

        $className = 'app\models\\' . ucfirst($type);
        if (class_exists($className)) {
            return new $className();
        }

        throw new RuntimeException("Model type {$className} not found.");
    }

}
