<?php
    namespace Config;
    Class Autoload{
        public static function run(){
            spl_autoload_register(function($class){
                $path =  str_replace("\\","/",$class).".php";
                
                if(is_readable($path)){
                    require_once $path;
                }else{
                    die("No se encontro: ".$path);
                }
            });
        }
    }
?>