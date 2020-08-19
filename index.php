<?php
    /*
    Rutas para Assets
    */
    if(strstr($_SERVER['REQUEST_URI'],'assets/')!=FALSE){
      $resource = str_replace('assets/','',$_SERVER['REQUEST_URI']);
      if (preg_match('/\.css|\.js|\.jpg|\.png|\.map$/', $resource, $match)) {
          $mimeTypes = [
              '.css' => 'text/css',
              '.js'  => 'application/javascript',
              '.jpg' => 'image/jpg',
              '.png' => 'image/png',
              '.map' => 'application/json'
          ];
          $path = __DIR__ ."/App/Public". $resource;
          if (is_file($path)) {
              header("Content-Type: {$mimeTypes[$match[0]]}");
              require $path;
              exit;
          }
      }
    }

    if(isset($_SERVER['QUERY_STRING'])){
        $request = str_replace($_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
    }else{
        $request = $_SERVER['REQUEST_URI'];
    }

    switch ($request) {
        /*
          APP URLs.
        */
        case '/' :
            require __DIR__ . '/App/Views/login.php';
            break;
        case '' :
            require __DIR__ . '/App/Views/login.php';
            break;
        case '/Login' :
            require __DIR__ . '/App/Views/login.php';
            break;
        case '/Home' :
            require __DIR__ . '/App/Views/home.php';
            break;
        case '/login/makeLogin':
            require __DIR__ . '/App/index.php';
            break;
         /*
         API URLs
         Las urls para la API están basadas en el arquetipo de controlador:
            /api/v1/[controlador]/[metodo]/{id}
            Version: v1
            Controlador: Controlador en minúsculas.
            Método: Método del controlador que ejecuta la acción, formato camelCase (primer caracter minúscula).
            id: identificador del elemento.
         */
        case '/api/v1/user/logIn' :
            require __DIR__ . '/Apis/v1/index.php';
            break;
        case '/api/v1/user/getAll' :
            require __DIR__ . '/Apis/v1/index.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/App/Views/404.php';
            break;
    }
?>
