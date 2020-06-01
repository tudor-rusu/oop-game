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
        $message = 'Home -> developing ...';
        $this->render('app/views/home/index',
            [
                'config'  => $this->config,
                'menu'    => [
                    [
                        'active' => true,
                        'name'   => 'Link',
                        'route'  => 'javascript:void(0);'
                    ],
                    [
                        'active' => false,
                        'name'   => 'Link',
                        'route'  => 'javascript:void(0);'
                    ]
                ],
                'message' => $message
            ]
        );
    }

}
