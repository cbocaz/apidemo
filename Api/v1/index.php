<?php
    require_once 'Config/api_config.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'Autoload.php';
    use Config\Autoload as Autoload;
    Autoload::run();

    //TODO: Se podrían verificar los métodos de los request en cada método

    $request = $_SERVER['REQUEST_URI'];
    $elements = str_replace("/api/v1/",'',$request);
    $urlParams = explode('/', $elements);

    $controllerName = "Controllers\\".ucfirst(array_shift($urlParams)).'Controller';
    $methodName = array_shift($urlParams);

    $controller = new $controllerName;
    (empty($_REQUEST))?$controller->$methodName():$controller->$methodName($_REQUEST);
?>
