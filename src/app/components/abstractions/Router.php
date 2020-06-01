<?php

namespace app\components\abstractions;

use Exception;
use RuntimeException;

/**
 * Abstract class responsible to resolve the router finding the controller and action classes name
 */
abstract class Router
{

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * Router constructor.
     *
     * @param $owner
     *
     * @throws Exception
     */
    public function __construct($owner)
    {
        $r = $_GET['r'];
        if (!isset($r)) {
            $r = $owner->getConfig('DEFAULT_ROUTE');
        }
        $aux = explode('/', $r);

        if (count($aux) !== 2) {
            throw new RuntimeException('Route is not well configured');
        }

        $this->controllerName = $aux[0];
        $this->actionName     = $aux[1];
    }

    /**
     * Return the name of controller class
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * Return the name of action class
     */
    public function getActionName()
    {
        return $this->actionName;
    }

}