<?php
    /*
        Se importa la configuración que define las variables de servidor con los
        datos de autenticación HTTP para el uso de la API.
    */
    require_once 'App/Config/front_config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo API</title>
    <link rel="shortcut icon" href="">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand">Nombre de usuario</a>
        <button class="btn btn-outline-success my-2 my-sm-0" type="button">Salir</button>
    </nav>

    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Usuarios</div>
                    <div class="col-md-6"><button type="button" class="btn btn-primary btn-sm float-right">Agregar Usuario</button></div>
                </div>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Es Admin?</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="rowCount"></div>
            </div>
        </div>
    </div>
    <script lang="javascript">
        $.ajax({
            method: "GET",
            url: "api/v1/user/getAll",
            statusCode: {
                404: function(msg) {
                    $("#rowCount").html(msg.responseJSON.message);
                }
            },
            beforeSend : function(req) {
            req.setRequestHeader('Authorization', 'Basic <?=base64_encode(FRONT_API_USER.":".FRONT_API_PASSWORD)?>');
            }
        })
        .done(function( msg ) {
            $("#rowCount").html("Registros encontrados: " + msg.rowCount);
            $.each(msg.records, function(key,user){
                $('#userTable > tbody:last-child').append('<tr><th scope="row">'+user.id+'</th><td>'+user.username+'</td><td>'+user.fullname+'</td><td>'+(user.admin?"Si":"No")+'</td><td><button type="button" class="btn btn-secondary btn-sm">Editar</button></td><td><button type="button" class="btn btn-danger btn-sm">Editar</button></td></tr>');
            });
        });
    </script>
</body>
</html>
