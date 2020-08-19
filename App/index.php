<?php
    require_once 'Config/front_config.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: text/html; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'Autoload.php';
    use Config\Autoload as Autoload;
    Autoload::run();

    $request = ltrim($_SERVER['REQUEST_URI'], '/');
    $urlParams = explode('/', $request);
    
    $controllerName = "App\\Controllers\\".ucfirst(array_shift($urlParams)).'Controller';
    $methodName = array_shift($urlParams);
    $id = array_shift($urlParams);

    $controller = new $controllerName;
    (empty($_REQUEST))?$controller->$methodName():$controller->$methodName($_REQUEST);
?>