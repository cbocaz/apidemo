<?php
    require_once 'Config/api_config.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    /*
        Se valida autenticación HTTP de forma simple usando Base64, pero la cadena es fija, por tanto lo óptimo sería
        hacer la autenticación usando JWT con el esquema Bearer y HTTPS
    */
    $headers = Apache_request_headers();

    if(!is_array($headers) or !isset($headers['Authorization']) or $headers['Authorization']!="Basic ".base64_encode(BACKEND_API_USER.":".BACKEND_API_PASSWORD)){
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode(['message'=>'No se encuentra autorizado']);
        die();
    }

    unset($headers);

    require_once 'Autoload.php';
    use Config\Autoload as Autoload;
    Autoload::run();

    $request = $_SERVER['REQUEST_URI'];
    $elements = str_replace("/api/v1/",'',$request);
    $urlParams = explode('/', $elements);

    $controllerName = "Controllers\\".ucfirst(array_shift($urlParams)).'Controller';
    $methodName = array_shift($urlParams);
    $id = array_shift($urlParams);

    $controller = new $controllerName;
    $controller->$methodName();
?>
