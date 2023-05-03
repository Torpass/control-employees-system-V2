<?php
session_start();  
include('dbConnections/db.php');
include('dbConnections/dbUsersConnections.php');
$connect = new UsersConnection();

if(isset($_POST['btnLogin'])){
    $usuario = $connect->get_user($_POST['txtUserName'],$_POST['txtPassword']); 
    if($usuario){
      $_SESSION['user'] = $usuario['name'];
      $_SESSION['logueado'] = true;
      header('Location: index.php');
    }else{
      $message = "Erro: El usuario o contraseña son incorrectos";
    } 
}
?>



<!doctype html>
<html lang="en">
<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>

</div>
<div class="container d-flex align-items-center justify-content-center vh-100">


  <form class="border p-3 rounded" method="post" action="login.php ">
      <?php if(isset($message)){?>
    <div class="alert alert-danger" role="alert">
      <strong><?php echo $message?></strong>
    </div>
    <?php }?>
    <div class="mb-3">
      <label for="username" class="form-label">Nombre de usuario</label>
      <input type="text" name="txtUserName" class="form-control" id="username" placeholder="Ingresa tu nombre de usuario">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" name="txtPassword" class="form-control" id="password" placeholder="Ingresa tu contraseña">
    </div>
    <button type="submit" name="btnLogin" class="btn btn-primary">Iniciar sesión</button>
  </form>
</div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>