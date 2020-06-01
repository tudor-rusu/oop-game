<?php

namespace app\controllers;

use \app\components\abstractions\Controller as BaseController;

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
        echo 'Home Controller -> developing ...';
    }

}
