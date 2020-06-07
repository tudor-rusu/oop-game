<?php

namespace app\components\abstractions;

use Exception;
use RuntimeException;

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
        try {
            $fileName = ucfirst($controllerName) . 'Controller.php';
            if (!$fileName) {
                throw new RuntimeException("Controller $controllerName not founded!");
            }

            $className = "app\controllers\\" . ucfirst($controllerName) . 'Controller';

            $filePath = './app/controllers/' . $fileName;

            if (!file_exists($filePath)) {
                throw new RuntimeException("Controller $fileName does not exist.");
            }

            require_once($filePath);
            if (!class_exists($className)) {
                throw new RuntimeException("Class $className not founded!");
            }
            return new $className();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

}
