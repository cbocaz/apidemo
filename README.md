# API DEMO


Ejemplo de creación de una API y Aplicación web en PHP, que permite a los usuarios registrados acceder a un Home.

# Características

  - Permite usuarios de tipo administrador.
  - Api separada de la aplicación web.
  - Autenticación mediante JWT (pendiente).
  - Enrutador de Requests.
  - Listar usuarios en Home.
  - Crear usuario (pendiente).
  - Editar usuario (pendiente).
  - Eliminar usuario (pendiente).
  - Ocultar funcionalidades de escritura para usuarios normales (pendiente).
  - Cierre de sesión por inactividad de usuario (pendiente).

### Requerimientos
  - PHP 7+
  - Base de datos MySQL o María Database.
  - PDO - Mysql


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `admin`)
VALUES
	(1,'cbocaz','098f6bcd4621d373cade4e832627b4f6','Christian Bocaz',1),
	(2,'user1','24c9e15e52afc47c225b757e7bee1f9d','Usuario 1',NULL),
	(3,'user2','7e58d63b60197ceb55a1c487989a3720','Usuario 2',NULL);

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
    define('BACKEND_API_USER','admin'); //Usuario temporal para otorgar acceso a la API
    define('BACKEND_API_PASSWORD','admin');//Password temporal para otorgar acceso a la API
    define('DB_HOST','127.0.0.1'); //Host de Myslq
    define('DB_USER','root'); //Usuario de acceso a la base de datos
    define('DB_PASSWORD',''); //Password de acceso a la base de datos
    define('DB_DATABASE','api_cs'); //Nombre de la base de datos
```
De momento, se utiliza un usuario y password temporal de acceso a la API, que posteriormente será modificado para hacer uso de JWT

**Configuración de la APP**  
La aplicación web, contiene un archivo de configuración separado de la API, ubicado en la ruta:
```
App/Config/front_config.php
```
Los parámetros a configurar son los siguientes:
```php
    define('FRONT_API_USER','admin'); //Usuario temporal para acceder a la API
    define('FRONT_API_PASSWORD','admin');//Password temporal para acceder a la API
```
### Testing

Para levantar la aplicación, se debe realizar mediante el servidor web interno de PHP, utilizando como enrutador el archivo index.php ubicado en la raíz.

```sh
$ cd [ruta_del_proyecto]
$ php -S 127.0.0.1:80 index.php
```
Luego, desde un navegador web, ingresar la url:
```
htp://localhost
```



### To-do

 - Completar la autenticación de usuarios mediante JWT.
 - Crear las funcionalidades de Agregar, Editar y Eliminar usuarios.
 - Bloquear a usuarios normales el acceso a las funcionalidades de escritura en usuarios.
 - Crear funcionalidad de cierre de sesión por inactividad.
 - Agregar comentarios al código

Licencia
----

MIT
