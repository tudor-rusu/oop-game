<?php

namespace app\components\abstractions;

use Exception;

/**
 * Example of Simple Factory design Pattern
 * http://designpatternsphp.readthedocs.io/en/latest/Creational/SimpleFactory/README.html
 */
class ControllerFactory
{

    /**
     * Create the controller instance dynamically
     *
     * @param $controllerName
     *
     * @return mixed
     * @throws Exception
     */
    public static function create($controllerName)
    {
        $fileName  = ucfirst($controllerName) . 'Controller.php';
        $className = "app\controllers\\" . ucfirst($controllerName) . 'Controller';
        $filePath  = './app/controllers/' . $fileName;
        require_once($filePath);
        if (!class_exists($className)) {
            throw new Exception("Class $className not founded!");
        }
        return new $className();
    }

}
