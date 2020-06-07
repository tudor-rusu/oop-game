<?php

namespace app\components\abstractions;

use app\components\FlashMessages;
use app\traits\RoutingTrait;
use Exception;
use RuntimeException;

/**
 * Class class to be inherited of controllers
 */
abstract class Controller extends Base
{
    use RoutingTrait;

    /**
     * @var array
     */
    public $config = [];

    /**
     * @var array
     */
    public $mainMenu = [];

    /**
     * @var object
     */
    public $flashMessages;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->flashMessages = new FlashMessages();
    }

    /**
     * Method that call the action of a controller
     *
     * @param $actionName
     *
     * @throws Exception
     */
    final public function callAction($actionName)
    {
        $realName = 'action' . ucfirst($actionName);
        if (is_callable([$this, $realName])) {
            $this->beforeAction($realName);
            $this->$realName();
            $this->afterAction($realName);
        } else if ($this->config['PROJECT_DEBUG']) {
            throw new RuntimeException("The action $realName does not exist!");
        } else {
            $this->redirect('/page/404');
        }
    }

    /**
     * Method to be overload if need for filters
     *
     * @param $actionName
     *
     * @throws Exception
     */
    protected function beforeAction($actionName)
    {
        if (is_null(self::configExist('main_menu'))) {
            throw new RuntimeException('Main Menu configuration does not exist on server.');
        }

        $menuKey    = strtolower(str_replace('Controller', '', substr(strrchr(get_class($this), "\\"), 1))) .
            DIRECTORY_SEPARATOR . strtolower(str_replace('action', '', $actionName));
        $configMenu = self::configExist('main_menu');

        if (array_key_exists($menuKey, $configMenu)) {
            $configMenu[$menuKey]['active'] = true;
        }

        $this->mainMenu = $configMenu;
    }

    /**
     * Method to be overload if need to do something after the action
     *
     * @param $actionName
     */
    protected function afterAction($actionName)
    {

    }

    /**
     * Redirect the browser to the specific router
     *
     * @param $route
     */
    public function redirect($route)
    {
        header("Location: $route");
        die();
    }

    /**
     * Render a php view file
     *
     * @param       $viewFile
     * @param array $params
     */
    public function render($viewFile, $params = [])
    {
        include $viewFile . '.php';
    }

}
