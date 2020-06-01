<?php

namespace app\components\abstractions;

use Exception;

/**
 * Class class to be inherited of controllers
 */
abstract class Controller extends Base
{
    /**
     * @var array
     */
    public $config = [];

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
        } else {
            throw new Exception("The action $realName does not exist!");
        }
    }

    /**
     * Method to be overload if need for example filters
     *
     * @param $actionName
     */
    protected function beforeAction($actionName)
    {

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
        header("Location: index.php?r=$route");
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
