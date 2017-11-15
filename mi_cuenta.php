<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Jose David Rico">
<title>Registro - MatchDog</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<!-- Custom Fonts -->
<link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards%7CDosis:300,400,700%7COpen+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800;' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
<!-- Plugin CSS -->
<link rel="stylesheet" href="css/animate.min.css" type="text/css">
<!-- Modal CSS -->
<link rel="stylesheet" href="css/modal.css" type="text/css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body id="page-top">

<?php include("user_session.php"); ?>

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		<span class="sr-only">Registro - MatchDog</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand page-scroll" href="#page-top"><img src="img/logo.png" width="160px" height="33px" ></i></a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
			<li>
			<a class="page-scroll" href="mis_perros.php">Mis Perros</a>
			</li>
			<li>
			<a class="page-scroll" href="buscar/index.php">Buscar</a>
			</li>
			<li>
			<a class="page-scroll" href="#page-top">Mi cuenta</a>
			</li>
			<li>
			<a class="page-scroll" href="logout.php">Salir</a>
			</li>
			<li>
			<i class="fa fa-2x fa-paw" style="margin-top:6px; margin-left:10px;"></i>
			</li>
			<table><tr>
			<?php
				echo '<td>&nbsp&nbsp&nbsp&nbsp<a class="page-scroll">'.$userinfo['name'].'</a>&nbsp&nbsp</b>';
				$sizes = getimagesize($userinfo["dir"]);
				if ($sizes["0"] > $sizes["1"]){
					$prop = 40/$sizes["1"];
					$imgsize = number_format($prop*$sizes["0"], 2). "px 40px";
				} else {
					$prop = 40/$sizes["0"];
					$imgsize = "40px ". number_format($prop*$sizes["0"], 2). "px";
				}
				//echo "<td width='40px' height='40px'><img src='$userinfo[dir]' class='img-circle img-cropped'></td>";
				echo "<td><div class='img-prof' style='background-image: url($userinfo[dir]); background-size: $imgsize;'></div></td>";
			?>
			</tr></table>
			</li>
		</ul>
	</div>
	<!-- /.navbar-collapse -->
</div>
<!-- /.container -->
</nav>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$success = FALSE;
	$err = array();
	if (empty($_POST["name"])) {
		$err["name"]= "El nombre es requerido. ";
	}
	if (empty($_POST["lastname"])) {
		$err["lastname"]= "El apellido es requerido. ";
	}
	if ($_POST["pwd"] !== $_POST["pwd2"]) 
	{
		$err["pwd"]='Las contraseñas no coinciden! ';
	} else {
		if (strlen($_POST["pwd"])<6) {
			$err["pwd"]= "La contraseña debe tener al menos 6 caracteres. ";
		}
	}
	if (empty($_POST["email"])) {
		$err["email"]= "El e-mail es requerido. ";
	} else {
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$err["email"]= "Formato de e-mail incorrecto"; 
		}
	}

	$sql = "SELECT id_user FROM Users WHERE email = '$_POST[email]'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if($count > 0) {
		$err["email"]= "Este e-mail ya esta registrado.";	
	}
}
?>

<!-- Section Contact
================================================== -->
<br><br><br>
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h2 class="section-heading"><b>Mi Cuenta</b></h2>
		<hr class="primary">
		<div class="regularform">
			<form method="post" action="" class="text-left" enctype="multipart/form-data">
				<?php if(isset($err['email'])){ echo "<div align='right'><font color='red'>$err[email]*</font></div>";} ?>
				<input name="name" value="<?php echo $userinfo["name"]; ?>" type="text" class="col-md-3 norightborder <?php if(isset($err['name'])){ echo " error";} ?>" placeholder="Nombre(s) *" <?php if(isset($_POST['name'])){ echo "value='$_POST[name]'";} ?>>
				<input name="lastname" value="<?php echo $userinfo["lastname"]; ?>" type="text" class="col-md-3 norightborder<?php if(isset($err['name'])){ echo " lastname";} ?>" placeholder="Apellido *" <?php if(isset($_POST['lastname'])){ echo "value='$_POST[lastname]'";} ?>>
				<input name="email"  value="<?php echo $userinfo["email"]; ?>" type="email" class="col-md-6 <?php if(isset($err['email'])){ echo " error";} ?>" placeholder="Email *" <?php if(isset($_POST['email'])){ echo "value='$_POST[email]'";} ?>>
				<p><i class="fa fa-phone"></i><b> Telefonos de contacto</b></p>
				<input name="phone1"  value="<?php echo $userinfo["tel1"]; ?>" type="text" class="col-md-6 norightborder" placeholder="Telefono" <?php if(isset($_POST['phone1'])){ echo "value='$_POST[phone1]'";} ?>>
				<input name="phone2"  value="<?php echo $userinfo["tel2"]; ?>" type="text" class="col-md-6" placeholder="Celular" <?php if(isset($_POST['phone2'])){ echo "value='$_POST[phone2]'";} ?>>
				<a href='edit_dog.php' class='btn btn-grey btn-xl'><i class="fa fa-user"></i> Editar imagen de perfil</a>
				<a href='edit_dog.php' class='btn btn-grey btn-xl'><i class="fa fa-user"></i> Cambiar contraseña</a>
				<div align='right'>
					<input type="submit" name="submit" class="contact submit btn btn-primary btn-xl" value="Guardar">
				</div>
			</form>
			<br><br>
		</div>
	</div>
</div>
</div>

<!-- Section Footer
================================================== -->
<!-- Icomoon Icon Fonts-->
<link rel="stylesheet" href="buscar/css/icomoon.css">
<section class="bg-dark">
<div class="container">
	<div class="row row-padded">
		<div class="col-md-12 text-center">
			<img src="img/logo3.png" width="160px" height="100px" ></i><br><br>
			<p class="fh5co-social-icons">
				<a href="#"><i class="fa fa-3x fa-facebook"></i></i></a>&nbsp&nbsp
				<a href="#"><i class="fa fa-3x fa-instagram"></i></i></a>&nbsp&nbsp
				<a href="#"><i class="fa fa-3x fa-twitter"></i></a>
			</p
		</div>
	</div>
</div>
</section>

<!-- jQuery -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/parallax.js"></script>
<script src="js/countto.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/common.js"></script>
<script src="js/modal.js"></script>
</body>
</html>