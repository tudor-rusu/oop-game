<?php

namespace app\components;

use app\components\abstractions\Router as BaseRouter;
use Exception;

/**
 * Class responsible for resolve the Requests router finding the controller and action that will further be called.
 */
class Router extends BaseRouter
{

    /**
     * Router constructor.
     *
     * @param $owner
     *
     * @throws Exception
     */
    public function __construct($owner)
    {
        parent::__construct($owner);
        /**
         * Implement here if you have a different route.
         */
    }

}