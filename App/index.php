<?php
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

    switch(count($urlParams)){
      case 1://urls en que la ruta solo especifica el nombre del recurso o clase
        $controllerName = "App\\Controllers\\".ucfirst($urlParams[0]).'Controller';
        $controller = (empty($_REQUEST))?: new $controllerName; new $controllerName($_REQUEST);
        break;
      case 2://urls en que la ruta especifica clase y método
        $controllerName = "App\\Controllers\\".ucfirst($urlParams[0]).'Controller';
        $methodName = $urlParams[1];

        $controller = new $controllerName;
        (empty($_REQUEST))?$controller->$methodName():$controller->$methodName($_REQUEST);
        break;
      case 3://urls en que la ruta especifica clase y método e ID
        $controllerName = "App\\Controllers\\".ucfirst($urlParams[0]).'Controller';
        $methodName = $urlParams[1];

        parse_str(str_replace('?','',$urlParams[2]),$params);

        $controller = new $controllerName;
        (empty($params))?$controller->$methodName():$controller->$methodName($params);
        break;
    }
?>
