<?php

namespace app\components\abstractions;

use app\components\abstractions\interfaces\ModelInterface;
use app\components\ModelError;

/**
 * Abstract class that defines a model representation
 */
abstract class Model extends Base implements ModelInterface
{

    /**
     * @var array
     */
    public $errors = [];

    /**
     * Add errors to the model
     *
     * @param ModelError $error
     */
    public function addError(ModelError $error)
    {
        $this->errors[] = $error;
    }

    /**
     * Check if the model has errors
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * Return the errors of model
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Check if the model has data
     *
     * @return boolean
     */
    public function hasData()
    {
        return count($this->data) > 0;
    }

    /**
     * Get model name by class name
     *
     * @param $className
     *
     * @return string
     */
    public function getMyName($className)
    {
        $tmpArr = explode('\\', $className);
        return strtolower(array_pop($tmpArr));
    }
}
