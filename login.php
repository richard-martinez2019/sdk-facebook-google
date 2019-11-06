<?php
require_once('config.php');

if(isset($_SESSION['access_token'])){
	header("Location: index.php");
	exit();
}

$url_principal  = 'https://' . $_SERVER["HTTP_HOST"];
$redirectTo = "https://sdk.hostinggratis.cl/callback.php";
//$redirectTo = "http://localhost/loginfb/callback.php";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);
$googleURL = "https://sdk.hostinggratis.cl/google.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <title>SDK para Facebook</title>
</head>
<body>
  
<div class="container" style="margin-top: 100px">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3">
        <h1>Iniciar session</h1>
				<form>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password">
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="checkbox">
            <label class="form-check-label" for="checkbox">Recordar</label>
          </div>
          <input type="submit" value="Entrar" class="btn btn-primary">
          <input type="button" onclick="window.location = '<?php echo $fullURL; ?>'" value="Iniciar sesión con Facebook" class="btn btn-primary">
          <input type="button" onclick="window.location = '<?php echo $googleURL; ?>'" value="Iniciar sesión con Google" class="btn btn-primary">
        </form>
			</div>
		</div>
	</div>

</body>
</html>