<?php

namespace app\components\abstractions;

use \app\components\ModelError;

/**
 * Abstract class that defines a model representation
 */
abstract class Model extends Base
{

    /**
     * @var array
     */
    public $errors = [];

    /**
     * Validate the model
     */
    abstract public function validate();

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

}
