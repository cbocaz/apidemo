<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo API</title>
    <link rel="shortcut icon" href="">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand">Usuario: <?=$activeuser->record->fullname?></a>
        <span>Última conexión: <?=(!empty($activeuser->record->lastlogin))?date('d-m-Y H:i:s',strtotime($activeuser->record->lastlogin)):'-'?></span>
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="location.href='login/logOut'">Salir</button>
    </nav>

    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Crear nuevo usuario</div>
                </div>
            </div>
            <div class="card-body">
              <form id="newuserform">
                <div class="form-group row">
                  <label for="username" class="col-4 col-form-label">Nombre de Usuario</label>
                  <div class="col-8">
                    <input id="username" name="username" type="text" class="form-control" required="required">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-4 col-form-label" for="fullname">Nombre Completo</label>
                  <div class="col-8">
                    <input id="fullname" name="fullname" type="text" class="form-control" required="required">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-4 col-form-label" for="password">Password</label>
                  <div class="col-8">
                    <input id="password" name="password" type="password" class="form-control" required="required">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-4">Administrador</label>
                  <div class="col-8">
                    <div class="custom-control custom-checkbox custom-control-inline">
                      <input name="admin" id="admin" type="checkbox" class="custom-control-input" value="1">
                      <label for="admin" class="custom-control-label"></label>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-4 col-8">
                    <button onclick="location.href='/Home'" name="cancel" type="button" class="btn btn-secondary mr-2">Cancelar</button>
                    <button name="submit" type="submit" class="btn btn-primary ml-2">Crear Usuario</button>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
    <script lang="javascript">
      $( "#newuserform" ).submit(function( event ) {
        $.ajax({
            method: "POST",
            url: "/user/createUser",
            data: { username: $('#username').val(), fullname: $('#fullname').val(), password: $('#password').val(), admin: $('#admin').prop('checked')},
            statusCode: {
                401: function(msg) {
                    var response = JSON.parse(msg.responseText);
                    alert(response.message);
                },
                200: function(msg){
                  location.href='/Home';
                }
            }
        });
          event.preventDefault();
        });
    </script>
</body>
</html>
