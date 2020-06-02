<?php

use app\components\abstractions\Controller;
use app\controllers\HomeController;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{

    protected $controller;
    protected $config;
    protected $menu;

    /**
     * @covers \app\controllers\HomeController
     */
    public function setup()
    {
        $this->controller = new HomeController();
        $this->config     = parse_ini_file('.env');
        if (file_exists('./app/config/main_menu.json')) {
            $this->menu = json_decode(file_get_contents('./app/config/main_menu.json'), true);
        }
    }

    /**
     * @covers \app\controllers\HomeController
     */
    public function testCanBeControllerInstance()
    {
        $this->assertInstanceOf(Controller::class, $this->controller);
    }

}