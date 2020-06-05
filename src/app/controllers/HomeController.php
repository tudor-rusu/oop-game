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

        $beastModel = ModelFactory::create('beast');
        if ($beastModel->hasErrors()) {
            foreach ($beastModel->errors as $error) {
                $this->flashMessages->addMessage($error->attribute . ': ' . $error->message, FlashMessages::ERROR);
            }
        }

        $hero = [];
        $beast = [];
        if (!$this->flashMessages->hasMessages(FlashMessages::ERROR)) {
            $heroModel::initAttributes($heroModel);
            $hero = [
                'name' => ucfirst($heroModel->data['name']),
                'attributes' => $heroModel->data['attributes'],
                'skills' => $heroModel->data['skills'],
                'first_strike' => false
            ];
            $beastModel::initAttributes($beastModel);
            $beast = [
                'name' => ucfirst($beastModel->data['name']),
                'attributes' => $beastModel->data['attributes'],
                'first_strike' => false
            ];

            if ($hero['attributes']['speed'] === $beast['attributes']['speed']) {
                if ($hero['attributes']['luck'] > $beast['attributes']['luck']) {
                    $hero['first_strike'] = true;
                } else {
                    $beast['first_strike'] = true;
                }
            } else if ($hero['attributes']['speed'] > $beast['attributes']['speed']) {
                $hero['first_strike'] = true;
            } else {
                $beast['first_strike'] = true;
            }
        }

        $messages = $this->flashMessages->hasMessages();
        $this->flashMessages->clear();

        $this->render('app/views/home/index',
            [
                'config'   => $this->config,
                'menu'     => $this->mainMenu,
                'messages' => $messages,
                'hero'     => $hero,
                'beast'    => $beast
            ]
        );
    }

}
