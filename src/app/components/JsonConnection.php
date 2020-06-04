<?php

namespace app\components;

use app\components\abstractions\interfaces\ConnectionInterface;
use RuntimeException;

/**
 *  Class for manipulate JSON Data type connection
 */
class JsonConnection implements ConnectionInterface
{

    /**
     * @var mixed
     */
    public $connection;

    /**
     * @var array
     */
    protected $_config;

    /**
     * JsonConnection constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->_config = $config;
    }

    /**
     * Starting method
     *
     * @return string
     */
    public function bootstrap()
    {
        return $this->connect($this->_config);
    }

    /**
     * Finishing method
     *
     * @return string
     */
    public function end()
    {
        return $this->close($this->connection);
    }

    /**
     * Initialize the connection with the JSON file repository on config parameters passed.
     *
     * @param array $params
     *
     * @return bool|string
     */
    public function connect(array $params = [])
    {

        if (count($params) < 1) {
            throw new RuntimeException('Connection Params array must have parameters');
        }
        if (!isset($params['host'])) {
            throw new RuntimeException('Connection Host must be passed');
        }
        if (!is_readable($params['host'])) {
            throw new RuntimeException('Connection Host is not readable or does not exist in the server');
        }

        try {
            $this->connection = fopen($params['host'], $params['command']);
            if (!$this->connection) {
                throw new RuntimeException('Connection is not valid');
            }
            return true;
        } catch (RuntimeException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Return data collection from source
     *
     * @param $connection
     *
     * @return mixed|string
     */
    public function getDataCollection($connection)
    {
        if (!$connection) {
            return 'Connection is not valid';
        }

        $getContent = fread($connection, filesize($this->_config['host']));
        if (!$getContent) {
            return $this->_config['host'] . ' is empty';
        }
        if (!json_decode($getContent, true)) {
            return 'Content is not valid';
        }

        return json_decode($getContent, true);
    }

    /**
     * Kill the connection with data source
     *
     * @param $connection
     *
     * @return bool
     */
    public function close($connection)
    {
        fclose($connection);
        $this->connection = null;
        return true;
    }

}
