<?php

use app\components\Application;
use app\components\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    protected $app;
    protected $router;

    /**
     * @covers \app\components\Router
     */
    public function setup()
    {
        $env_array    = parse_ini_file('.env');
        $this->app    = Application::getInstance($env_array);
        $this->router = new Router($this->app);
    }

    /**
     * @covers \app\components\Router
     */
    public function testCanBeRouterInstance()
    {
        $this->assertInstanceOf(\app\components\abstractions\Router::class, $this->router);
    }

    /**
     * @covers \app\components\Router
     */
    public function testCanBeHomeController()
    {
        $this->assertEquals($this->app->getConfig('DEFAULT_ROUTE'), $this->router->getControllerName());
    }

    /**
     * @covers \app\components\Router
     */
    public function testBadRoute()
    {
        $this->expectException(RuntimeException::class);
    }
}