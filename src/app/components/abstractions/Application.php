<?php

namespace app\components\abstractions;

/**
 * Example of Singleton
 * http://designpatternsphp.readthedocs.io/en/latest/Creational/Singleton/README.html#
 */
abstract class Application extends Base
{

    /**
     * @var object
     */
    protected static $_app;

    /**
     * @var array
     */
    protected $_config;

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     *
     * @param array $config
     */
    private function __construct($config = [])
    {
        $this->_config = $config;
        self::$_app    = $this;
    }

    /**
     * @return mixed
     */
    public static function app()
    {
        return self::$_app;
    }

    /**
     * @param array $config
     *
     * @return static
     */
    public static function getInstance($config = [])
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static($config);
        }

        return $instance;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getConfig($name)
    {
        return $this->_config[$name];
    }

    /**
     * @return mixed
     */
    abstract public function run();

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {

    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {

    }
}