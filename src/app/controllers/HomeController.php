<?php

namespace app\controllers;

use app\components\abstractions\Controller as BaseController;
use app\components\abstractions\ModelFactory;
use app\components\FlashMessages;
use Exception;

/**
 * Main controller class
 */
class HomeController extends BaseController
{

    /**
     * Main action for the application
     *
     * @throws Exception
     */
    public function actionIndex()
    {
        $heroModel = ModelFactory::create('orderus');
        if ($heroModel->hasErrors()) {
            foreach ($heroModel->errors as $error) {
                $this->flashMessages->addMessage($error->attribute . ': ' . $error->message, FlashMessages::ERROR);
            }
        }

        $messages = $this->flashMessages->hasMessages();
        $this->flashMessages->clear();

        $this->render('app/views/home/index',
            [
                'config'   => $this->config,
                'menu'     => $this->mainMenu,
                'messages' => $messages
            ]
        );
    }

}
