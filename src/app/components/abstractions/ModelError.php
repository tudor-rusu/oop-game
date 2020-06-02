<?php

namespace app\components\abstractions;

/**
 * Class that abstract the model error
 */
abstract class ModelError
{

    /**
     * Name of field of the model associated
     *
     * @var string
     */
    public $attribute;

    /**
     * Text of error message
     *
     * @var string
     */
    public $message;

    /**
     * ModelError constructor.
     *
     * @param $attribute
     * @param $message
     */
    public function __construct($attribute, $message)
    {
        $this->attribute = $attribute;
        $this->message   = $message;
    }

}
