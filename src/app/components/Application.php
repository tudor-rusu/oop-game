<?php

namespace app\components;

use app\components\abstractions\Application as BaseApplication;
use app\components\abstractions\Controller as BaseController;
use app\components\abstractions\ControllerFactory;
use app\components\abstractions\Router as BaseRouter;
use Exception;

/**
 * Here is the backbone of application. On this class every request and response comes.
 * The parent class BaseApplication is a singleton to control de instances in memory.
 */
class Application extends BaseApplication
{

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var BaseRouter
     */
    public $router;

    /**
     * @var BaseController
     */
    public $controller;

    /**
     * Start the application
     *
     * @throws Exception
     */
    public function run()
    {
        $this->lifeCycle();
    }

    /**
     * It is the lifecycle of application. Every steps that application will call.
     *
     * @throws Exception
     */
    private function lifeCycle()
    {
        $this->preInit();
        $this->init();
        $this->bootstrap();
        $this->end();
    }

    /**
     * Load config from the .env file
     */
    private function preInit()
    {
        $this->name = $this->_config['PROJECT_NAME'];
    }

    /**
     * Initialize the components and resolve the routes
     *
     * @throws Exception
     */
    private function init()
    {
        $this->resolveRoutes();
    }

    /**
     * Create the router object and add that to the application instance
     * and delegate it to resolve the route of application.
     *
     * @throws Exception
     */
    private function resolveRoutes()
    {
        $router = new Router($this);
        $this->setRouter($router);

        $controller = ControllerFactory::create($router->getControllerName());
        $this->setController($controller);
        $this->controller->config = $this->_config;
    }

    /**
     * Set the router instance on application instance to be delegate on the future.
     *
     * @param BaseRouter $router
     */
    private function setRouter(BaseRouter $router)
    {
        $this->router = $router;
    }

    /**
     * Set the controller instance on application instance to be delegate on the future.
     *
     * @param BaseController $controller
     */
    private function setController(BaseController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Launch the action of controller
     *
     * @throws Exception
     */
    private function bootstrap()
    {
        $this->controller->callAction($this->router->getActionName());
    }

    /**
     * Finish the application correctly for every component
     */
    public function end()
    {
        if (is_array($this->_config['COMPONENTS'])) {
            foreach ($this->_config['COMPONENTS'] as $name => $component) {
                $this->$name->close();
            }
        }
    }

}
