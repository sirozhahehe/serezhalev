<?php

class Router{
    private $routes;

    /** Includes file with routes */
    public function __construct()
    {
        $routes_path = ROOT . '/config/Routes.php';
        $this->routes = include($routes_path);
    }

    /** getURI - checks URI for data, if URI exists - returns URI
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /** run - compares URI from getURI with URIs from Routes.php
     * If URI from getURI and some URI from Routes.php matches  - function explodes $path from Routes by divider(/),
     * First part = controller that after some modifications is 'include_once' here
     * Second part = method that after some modifications will be called in controller
     * Next parts can be variables that are transfers to method in $parameters
     * Expects not NULL from called method(function), so methods must return something that not NULL.
     */
    public function run()
    {
        $uri = $this->getURI();
        foreach($this->routes as $uri_pattern => $path){
            if (preg_match("~$uri_pattern~", $uri)){

                $internal_route = preg_replace("~$uri_pattern~", $path, $uri);
                $segments = explode('/',$internal_route);
                $controller_name = ucfirst(array_shift($segments).'Controller');
                $action_name = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;

                $controller_file= ROOT . '/controllers/'.$controller_name.'.php';
                if (file_exists($controller_file)){
                    include_once $controller_file;
                }
                $controller_object = new $controller_name;
                $result = call_user_func_array(array($controller_object,$action_name), $parameters);
                if ($result != NULL){
                    break;
                }
            }
        }
    }
}
