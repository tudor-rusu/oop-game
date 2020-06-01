<?php

namespace app\components\abstractions;

use OutOfRangeException;

/**
 * This class give the flexibility to insert properties to the object dynamically.
 */
abstract class Base
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Debug any object
     * Improvements: Get the level of debug just to human, excluding the recursion.
     *
     * @param $obj
     * @param $kill
     */
    public static function dd($obj, $kill = true)
    {
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
        if ($kill) {
            exit;
        }
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function loadAttributes($attributes = [])
    {
        if (isset($attributes) && is_array($attributes)) {
            foreach ($attributes as $attribute => $value) {
                $this->$attribute = $value;
            }
        }
        return $this;
    }

    /**
     * Magic method to get attribute of this instance
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Magic method to add attribute to the instance
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Magic method to check if the attribute exists
     *
     * @param $name
     *
     * @return mixed
     * @throws OutOfRangeException
     */
    public function __isset($name)
    {
        if (!isset($this->data[$name])) {
            throw new OutOfRangeException('Invalid name given');
        }

        return $this->data[$name];
    }

    /**
     * Magic method to kill the model attribute
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }

}
