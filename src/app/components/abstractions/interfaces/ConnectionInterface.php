<?php

namespace app\components\abstractions\interfaces;

/**
 * Interface to be implemented in all data type connections classes
 */
interface ConnectionInterface
{

    /**
     *  The data connection
     *
     * @param array $config
     */
    public function connect(array $config);

    /**
     *  Close the connection
     *
     * @param $connection
     */
    public function close($connection);
}
