<?php

namespace app\controllers;

use \app\components\abstractions\Controller as BaseController;

/**
 * Main controller class
 */
class PageController extends BaseController
{

    /**
     * Show About page
     */
    public function actionAbout()
    {
        $this->render('app/views/page/about',
            [
                'config'  => $this->config,
                'menu'    => $this->mainMenu
            ]
        );
    }

}
