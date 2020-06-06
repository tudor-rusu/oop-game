<?php

namespace app\traits;

trait RoutingTrait
{

    /**
     * Split the route in parts
     *
     * @param $route
     *
     * @return mixed
     */
    public static function routeElements($route)
    {
        $routeElements = [];
        $route         = (strpos($route, '/') === 0) ? ltrim($route, '/') : $route;
        $tempArray     = explode('/', filter_var(trim($route), FILTER_SANITIZE_STRING));

        $routeElements['controller'] = $tempArray[0];
        $routeElements['action']     = $tempArray[1] && $tempArray[1] !== '' ? $tempArray[1] : 'index';
        $routeElements['params']     = [];

        foreach ($tempArray as $key => $value) {
            if ($key > 1) {
                $routeElements['params'][] = $value;
            }
        }

        return $routeElements;
    }

    /**
     * Check if config exist and return configuration
     *
     * @param $configName
     *
     * @return mixed|null
     */
    public static function configExist($configName)
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/config/' . $configName . '.json')) {
            return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/app/config/' . $configName . '.json'), true);
        }

        return null;
    }

    /**
     * Return a CSRF token
     *
     * @return false|string|null
     */
    public static function generateCsrfToken()
    {
        $_SESSION['token'] = microtime();
        $options           = [
            'salt' => '$2y$11$' . substr(md5(uniqid(mt_rand(), true)), 0, 22),
            'cost' => 10
        ];

        return password_hash($_SESSION['token'], PASSWORD_BCRYPT, $options);
    }

    /**
     * Check if request is AJAX
     *
     * @param $serverRequest
     * @param $token
     *
     * @return bool
     */
    public static function isAjaxRequest($serverRequest, $token)
    {
        return !empty($serverRequest['HTTP_X_REQUESTED_WITH'])
            && strtolower($serverRequest['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
            && crypt($token, $serverRequest['HTTP_X_CSRF_TOKEN']) === $serverRequest['HTTP_X_CSRF_TOKEN'];
    }

}
