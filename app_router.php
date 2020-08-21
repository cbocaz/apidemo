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
              die();
          }
      }
    }

    if(isset($_SERVER['QUERY_STRING'])){
        $request = str_replace($_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
    }else{
        $request = $_SERVER['REQUEST_URI'];
    }

    switch ($request) {
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
            require __DIR__ . '/App/index.php';
            break;
        case '/login/makeLogin':
            require __DIR__ . '/App/index.php';
            break;
        case '/login/logOut':
            require __DIR__ . '/App/index.php';
            break;
        case '/user/newUser':
            require __DIR__ . '/App/index.php';
            break;
        case '/user/editUser/?':
            require __DIR__ . '/App/index.php';
            break;
        case '/user/createUser':
            require __DIR__ . '/App/index.php';
            break;
        case '/user/deleteUser/?':
            require __DIR__ . '/App/index.php';
            break;
        case '/user/updateUser':
            require __DIR__ . '/App/index.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/App/Views/404.php';
            break;
    }
?>
