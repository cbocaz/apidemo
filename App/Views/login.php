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
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <form id="loginform">
        <input type="text" id="username" class="fadeIn second loginInput" name="username" placeholder="Username">
        <input type="password" id="password" class="fadeIn third loginInput" name="password" placeholder="Password">
        <input type="submit" class="fadeIn fourth" value="Login">
      </form>
    </div>
    <div id="loginalert" class="alert alert-warning" style="display:none;" role="alert">
      Debe completar todos los campos.
    </div>
    <div id="loginerror" class="alert alert-danger" style="display:none;" role="alert">
    </div>
  </div>
  <script lang="javascript">
    $( "#loginform" ).submit(function( event ) {
        if($("#username").val().length==0 || $("#password").val().length==0){
            $("#loginalert").fadeIn();
        }else{
          $.ajax({
              method: "POST",
              url: "login/makeLogin",
              data: { username: $('#username').val(), password: $('#password').val() },
              statusCode: {
                  401: function(msg) {
                      var response = JSON.parse(msg.responseText);
                      $("#loginerror").html(response.message);
                      $("#loginerror").fadeIn();
                  },
                  200: function(msg){
                    location.href='Home';
                  }
              }
          });
        }
        event.preventDefault();
      });
  </script>
</body>
</html>
