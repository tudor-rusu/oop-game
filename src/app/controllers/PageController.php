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
                'config' => $this->config,
                'menu'   => $this->mainMenu,
                'title'  => 'About'
            ]
        );
    }

    /**
     * Show 404 page
     */
    public function action404()
    {
        $this->render('app/views/page/error',
            [
                'config'  => $this->config,
                'menu'    => $this->mainMenu,
                'code'    => '404',
                'message' => 'Not Found',
                'title'   => 'Not Found'
            ]
        );
    }

    /**
     * Show 403 page
     */
    public function action403()
    {
        $this->render('app/views/page/error',
            [
                'config'  => $this->config,
                'menu'    => $this->mainMenu,
                'code'    => '403',
                'message' => 'Forbidden',
                'title'   => 'Forbidden'
            ]
        );
    }

}
