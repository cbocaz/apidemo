<?php
    /*
        Se definen las credenciales necesarias para el uso de la api con autenticación HTTP
        para testing de forma momentanea.
        Posteriormente se debe usar jwt
    */
    define('BACKEND_API_USER','admin');
    define('BACKEND_API_PASSWORD','admin');
    /*
        Se definen los parámetros de conexión a la base de datos MYSQL mediante PDO
    */
    define('DB_HOST','127.0.0.1');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_DATABASE','api_cs');
?>
