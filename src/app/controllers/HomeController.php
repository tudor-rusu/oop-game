<?php

namespace app\controllers;

use app\components\abstractions\Controller as BaseController;
use app\components\abstractions\ModelFactory;
use app\components\FlashMessages;
use app\traits\DataManipulationTrait;
use app\traits\RoutingTrait;
use Exception;

/**
 * Main controller class
 */
class HomeController extends BaseController
{
    use RoutingTrait,
        DataManipulationTrait;

    /**
     * @var array
     */
    private $hero;

    /**
     * @var array
     */
    private $beast;

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

        $hero  = [];
        $beast = [];
        if (!$this->flashMessages->hasMessages(FlashMessages::ERROR)) {
            $heroModel::initAttributes($heroModel);
            $hero = [
                'name'         => ucfirst($heroModel->data['name']),
                'attributes'   => $heroModel->data['attributes'],
                'first_strike' => false
            ];
            $beastModel::initAttributes($beastModel);
            $beast = [
                'name'         => ucfirst($beastModel->data['name']),
                'attributes'   => $beastModel->data['attributes'],
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
                'token'     => self::generateCsrfToken(),
                'config'    => $this->config,
                'menu'      => $this->mainMenu,
                'messages'  => $messages,
                'turn'      => 1,
                'max-turns' => $this->config['MAX_TURNS'],
                'hero'      => $hero,
                'beast'     => $beast
            ]
        );
    }

    /**
     * Action for the fight analise
     * accept only POST AJAX Request
     *
     * @throws Exception
     */
    public function actionAnalise()
    {
        if (!self::isAjaxRequest($_SERVER, $_SESSION['token'])) {
            $this->redirect('/page/403');
        }

        $resultsData = [];
        $turn        = (int)$_POST['turn'];
        $maxTurns    = (int)$this->config['MAX_TURNS'];
        $this->hero  = $_POST['hero'];
        $this->beast = $_POST['beast'];

        $resultsData['post'] = $_POST;
        $resultsData['turn'] = $turn;

        $resultsData = ($this->hero['action'] === '1') ?
            array_merge($resultsData, $this->turnResults('hero', 'beast')) :
            array_merge($resultsData, $this->turnResults('beast', 'hero'));

        if ($turn === $maxTurns) {
            $resultsData['winner']          = $resultsData['hero']['health'] > $resultsData['beast']['health'] ?
                'hero' : 'beast';
            $resultsData['stats']['winner'] = $this->{$resultsData['winner']}['name'];
        }

        echo json_encode($resultsData);
    }

    /**
     * Calculate turn results
     *
     * @param $attacker
     * @param $defender
     *
     * @return array
     * @throws Exception
     */
    private function turnResults($attacker, $defender)
    {
        $resultsData  = [];
        $attackerData = $this->{$attacker};
        $defenderData = $this->{$defender};

        $heroModel  = ModelFactory::create('orderus');
        $heroSkills = $heroModel->getSkills();

        $resultsData['stats']['attacker']   = $attackerData['name'];
        $resultsData['stats']['winner']     = 'not yet';
        $resultsData['stats']['hero_skill'] = 'no';
        $resultsData[$attacker]['action']   = 0;
        $resultsData[$attacker]['health']   = $attackerData['health'];
        $resultsData[$defender]['action']   = 1;

        $damage = $attackerData['strength'] - $defenderData['defence'];
        if ($attacker === 'hero' && self::probabilityByPercent($heroSkills['rapid_strike'])) {
            $resultsData['stats']['hero_skill'] = 'Rapid strike';
            $damage                             *= 2;
        }
        if ($defender === 'hero' && self::probabilityByPercent($heroSkills['magic_shield'])) {
            $resultsData['stats']['hero_skill'] = 'Magic shield';
            $damage                             = ceil($damage / 2);
        }

        if (!self::probabilityByPercent($defenderData['luck'])) {
            $resultsData[$defender]['luck']        = 0;
            $resultsData['stats']['defender_luck'] = 'no';
            if ($defenderData['health'] <= $damage) {
                $resultsData['winner']                   = $attacker;
                $resultsData[$defender]['health']        = 0;
                $resultsData['stats']['defender_health'] = 0;
                $resultsData['stats']['winner']          = $attackerData['name'];
                $resultsData['stats']['damage']          = $damage;
            } else {
                $resultsData[$defender]['health']        = $defenderData['health'] - $damage;
                $resultsData['stats']['damage']          = $damage;
                $resultsData['stats']['defender_health'] = $resultsData[$defender]['health'];
            }
        } else {
            $resultsData[$defender]['luck']          = 1;
            $resultsData['stats']['defender_luck']   = 'yes';
            $resultsData['stats']['damage']          = 0;
            $resultsData[$defender]['health']        = $defenderData['health'];
            $resultsData['stats']['defender_health'] = $defenderData['health'];
        }

        return $resultsData;
    }

}
