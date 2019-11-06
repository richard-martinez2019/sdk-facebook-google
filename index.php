<?php
session_start();

if(!isset($_SESSION['access_token'])){
	header("Location: login.php");
	exit();
}

/*include 'database.php';

$id_facebook = $_SESSION['userData']['id'];
$imagen = $_SESSION['userData']['picture']['url'];
$nombre = $_SESSION['userData']['first_name'];
$apellido = $_SESSION['userData']['last_name'];
$email = $_SESSION['userData']['email'];

$actualizar     = new DataBase();
$actualizar     = $actualizar->actualizarDatos($id_facebook, $imagen, $nombre, $apellido, $email);*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Bienvenido <?php echo $_SESSION['userData']['first_name'] ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>

<div class="container" style="margin-top: 100px">
	<div class="row justify-content-center">
		<div class="col-md-3">
			<img src="<?php echo $_SESSION['userData']['picture']['url']; ?>">
		</div>

		<div class="col-md-9">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
						<td>ID</td>
						<td><?php echo $_SESSION['userData']['id']; ?></td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td><?php echo $_SESSION['userData']['first_name']; ?></td>
					</tr>
					<tr>
						<td>Apellido</td>
						<td><?php echo $_SESSION['userData']['last_name']; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $_SESSION['userData']['email']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<a href="/cerrar-sesion.php">Cerrar sesión</a>
</div>


</body>
</html>