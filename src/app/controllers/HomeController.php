<?php

namespace app\controllers;

use app\components\abstractions\Controller as BaseController;
use app\components\abstractions\ModelFactory;

/**
 * Main controller class
 */
class HomeController extends BaseController
{

    /**
     * Main action for the application
     */
    public function actionIndex()
    {
        $heroModel = ModelFactory::create('orderus');

        $message = 'Home -> developing ...';
        $this->render('app/views/home/index',
            [
                'config'  => $this->config,
                'menu'    => $this->mainMenu,
                'message' => $message
            ]
        );
    }

}
