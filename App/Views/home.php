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
                    <div class="col-md-6">Usuarios</div>
                    <div class="col-md-6"><?php if($activeuser->record->admin){ ?><button onclick="location.href='user/newUser'" type="button" class="btn btn-primary btn-sm float-right">Agregar Usuario</button><?php } ?></div>
                </div>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Es Admin?</th>
                            <?php if($activeuser->record->admin){ ?>
                            <th scope="col">Editar</th>
                            <th scope="col">Eliminar</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($userlist as $user){
                          ?>
                          <tr>
                              <td><?=$user->id?></td>
                              <td><?=$user->username?></td>
                              <td><?=$user->fullname?></td>
                              <td><?=($user->admin==1)?'Si':'No';?></td>
                              <?php if($activeuser->record->admin){ ?>
                              <td><button onclick="location.href='/user/editUser/?id=<?=$user->id?>'" type="button" class="btn btn-warning btn-sm">Editar</button></td>
                              <td><button onclick="if(confirm('Seguro quiere eliminar el usuario?')){location.href='/user/deleteUser/?id=<?=$user->id?>';}" type="button" class="btn btn-danger btn-sm">Eliminar</button></td>
                              <?php } ?>
                          </tr>
                          <?php
                        }
                       ?>
                    </tbody>
                </table>
                <div id="rowCount">Registros: <?=$rowCount?></div>
            </div>
        </div>
    </div>
</body>
</html>
