<?php

namespace app\components\abstractions;

use app\traits\RoutingTrait;
use Exception;
use RuntimeException;

/**
 * Abstract class responsible to resolve the router finding the controller and action classes name
 */
abstract class Router
{
    use RoutingTrait;

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * @var array
     */
    private $paramsName;

    /**
     * Router constructor.
     *
     * @param $owner
     *
     * @throws Exception
     */
    public function __construct($owner)
    {
        $route = $_SERVER['REQUEST_URI'];

        if (!isset($route) || $route === '/') {
            $route = $owner->getConfig('DEFAULT_ROUTE');
        }

        $routeElements = self::routeElements($route);

        if (count($routeElements) < 1) {
            throw new RuntimeException('Route is not well configured');
        }

        if ($routeElements['controller'] === '') {
            throw new RuntimeException('Route controller is not well configured');
        }

        $this->controllerName = $routeElements['controller'];
        $this->actionName     = $routeElements['action'];
        $this->paramsName     = count($routeElements['params']) > 0 ? $routeElements['params'] : [];
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

    /**
     * Return the name of params
     */
    public function getParamsName()
    {
        return $this->paramsName;
    }

}