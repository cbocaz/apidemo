<?php
    if(isset($_SERVER['QUERY_STRING'])){
        $request = str_replace($_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
    }else{
        $request = $_SERVER['REQUEST_URI'];
    }
    /*
    API URLs
    Las urls para la API están basadas en el arquetipo de controlador:
       /api/v1/[controlador]/[metodo]
       Version: v1
       Controlador: Controlador en minúsculas.
       Método: Método del controlador que ejecuta la acción, formato camelCase (primer caracter minúscula).

       Las URL no registradas, no podrán ser ejecutadas como endpoints
    */
    switch ($request) {
        case '/api/v1/user/logIn' :
            require __DIR__ . '/Api/v1/index.php';
            break;
        case '/api/v1/user/getAll' :
            require __DIR__ . '/Api/v1/index.php';
            break;
        case '/api/v1/user/createUser' :
            require __DIR__ . '/Api/v1/index.php';
            break;
        case '/api/v1/user/deleteUser' :
            require __DIR__ . '/Api/v1/index.php';
            break;
        case '/api/v1/user/getUser' :
            require __DIR__ . '/Api/v1/index.php';
            break;
        case '/api/v1/user/updateUser' :
            require __DIR__ . '/Api/v1/index.php';
            break;
        default:
            http_response_code(404);
            die("Not Found!");
            break;
    }
?>
