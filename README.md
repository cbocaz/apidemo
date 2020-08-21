# API DEMO


Ejemplo de creación de una API y Aplicación web en PHP, que permite a los usuarios registrados acceder a un Home.

# Características

  - Permite usuarios de tipo administrador.
  - Api separada de la aplicación web.
  - Autenticación mediante JWT.
  - Enrutador de Requests para Aplicación y Api.
  - Listar usuarios en Home.
  - Crear usuario.
  - Editar usuario.
  - Eliminar usuario.
  - Ocultar funcionalidades de escritura para usuarios normales.
  - Muestra fecha de última conexión.
  - Muestra Nombre del usuario conectado
  - Cierre de sesión por inactividad de usuario (**pendiente**).

### Requerimientos
  - PHP 7+
  - Base de datos MySQL o María Database.
  - PDO - Mysql
  - Curl


### Instalación
**Mediante GIT**  
Clonar el repositorio mediante GIT
```sh
$ git clone https://github.com/cbocaz/apidemo.git
```
**Mediante descarga**  
Descargar y descomprimir el archivo zip desde la siguiente URL:
https://github.com/cbocaz/apidemo/archive/master.zip

Posteriormente, es necesario crear una base de datos Mysql y ejecutar el siguiente script para crear la tabla de usuarios y algunos registros de ejemplo:

```sql
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `admin` tinyint(1) DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `admin`, `lastlogin`)
VALUES
	(1,'cbocaz','098f6bcd4621d373cade4e832627b4f6','Christian Bocaz',1,'2020-08-21 08:32:28'),
	(2,'user1','24c9e15e52afc47c225b757e7bee1f9d','Usuario 1',NULL,NULL),
	(3,'user2','098f6bcd4621d373cade4e832627b4f6','Usuario 2',1,'2020-08-21 10:21:29');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

```
### Configuración
**Configuración de la API**  
Se debe configurar los parámetros de la base de datos en el archivo ubicado en la ruta:
```
Apis/v1/Config/api_config.php
```
Los parámetros que se deben configurar son los siguientes:
```php
    define('BACKEND_API_KEY','953a3220084d73ea9948e3046c3c242d'); //Key para otorgar acceso a la API
    define('DB_HOST','127.0.0.1'); //Host de Myslq
    define('DB_USER','root'); //Usuario de acceso a la base de datos
    define('DB_PASSWORD',''); //Password de acceso a la base de datos
    define('DB_DATABASE','api_cs'); //Nombre de la base de datos
```

### Testing

La aplicación y la Api deben ser levantadas en hilos distintos del servidor interno de PHP.  
Esto es necesario porque se utiliza Curl para el consumo de la API.  
Ref: https://stackoverflow.com/a/57572727

La apliación, mediante puerto 80 y el enrutador app_router.php.

La Api Rest, mediante puerto 8080 y el enrutador api_router.php.

```sh
$ cd [ruta_del_proyecto]
$ php -S 127.0.0.1:80 app_router.php
```
Otra ventana de terminal
```sh
$ cd [ruta_del_proyecto]
$ php -S 127.0.0.1:8080 api_router.php
```

Para ambientes basados en linux, es necesario ejecutar los comandos con sudo.

Luego, desde un navegador web, ingresar la url:
```
htp://localhost
```

Finalmente, los password de los usuarios son almacenados en MD5.

Los usuarios creados mediante el script poseen las siguientes credenciales:

Administrador  
cbocaz:test

Usuarios Normales  
user1:user1
user2:user2

### To-do

 - Cierre de sesión por inactividad de usuario.


Licencia
----

MIT
