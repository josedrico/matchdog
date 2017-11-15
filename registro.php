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
		<a class="navbar-brand page-scroll" href="#page-top"><img src="img/logo.png" width="160px" height="33px" ></a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
			<li>
			<a class="page-scroll" href="index.html">Inicio</a>
			</li>
			<li>
			<a class="page-scroll" href="#registro">Regístrate</a>
			</li>
			<li>
			<a class="page-scroll" href="#funciona">¿Cómo funciona?</a>
			</li>
			<li>
			<a class="page-scroll" href="#contact">Contacto</a>
			</li>
			<li>
			<a class="page-scroll" id="myBtn">Inicia sesión</a>
			</li>
		</ul>
	</div>
	<!-- /.navbar-collapse -->
</div>
<!-- /.container -->
</nav>


<?php
include("dbuser.php");
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

	if(!count($err)){		
		$sql = "INSERT INTO Users (name, lastname, email, pwd, tel1, tel2, dir, id_seller)
		VALUES ('$_POST[name]', '$_POST[lastname]', '$_POST[email]', '$_POST[pwd]', '$_POST[phone1]', '$_POST[phone2]', ' ', '1')";
		$result = $conn->query($sql);
		$sql = "SELECT id_user FROM Users WHERE email='$_POST[email]' AND pwd='$_POST[pwd]'";
		$result = $conn->query($sql);
		$userinf = $result->fetch_assoc();
		// --------- FILE UPLOAD -----------//
		if(!empty($_FILES["fileToUpload"]["tmp_name"])) {
			$target_dir = "uploads/";
			$uploadOk = 1;
			$imageFileType = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
			$target_file = $target_dir . $userinf['id_user'] . "_" . time() . "." . $imageFileType;
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check == false) {
				$err["file"]= "El archivo no es una imagen.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				$err["file"]= "Lo sentimos, el tamaño debe ser menor a los 500 Kb.";
				$uploadOk = 0;
			} 
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$err["file"]= "Lo sentimos, solo formatos JPG, JPEG, PNG & GIF son aceptados.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 1) {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$sql = "UPDATE Users SET dir='$target_file' WHERE id_user='$userinf[id_user]'";
					$result = $conn->query($sql);
				} else {
					$err["file"]= "Lo sentimos, hubo un error al subir el archivo. Intenta de nuevo.";
				}
			}
		} 
		if(isset($err["file"])){
			$sql = "DELETE FROM Users WHERE id_user='$userinf[id_user]'";
			$result = $conn->query($sql);
		} else {
			 session_start();
			 $_SESSION['login_user'] = $_POST["email"];
			 echo "<script type='text/javascript'>top.location.href = 'registro_perro.php';</script>";
		}
	}
}
?>

<!-- Section Contact
================================================== -->

<section id="registro">
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h2 class="section-heading"><b>REGISTRO</b></h2>
		<hr class="primary">
		<div class="regularform">
			<form method="post" action="" class="text-left" enctype="multipart/form-data">
				<?php if(isset($err['email'])){ echo "<div align='right'><font color='red'>$err[email]*</font></div>";} ?>
				<input name="name" type="text" class="col-md-3 norightborder <?php if(isset($err['name'])){ echo " error";} ?>" placeholder="Nombre(s) *" <?php if(isset($_POST['name'])){ echo "value='$_POST[name]'";} ?>>
				<input name="lastname" type="text" class="col-md-3 norightborder<?php if(isset($err['name'])){ echo " lastname";} ?>" placeholder="Apellido *" <?php if(isset($_POST['lastname'])){ echo "value='$_POST[lastname]'";} ?>>
				<input name="email" type="email" class="col-md-6 <?php if(isset($err['email'])){ echo " error";} ?>" placeholder="Email *" <?php if(isset($_POST['email'])){ echo "value='$_POST[email]'";} ?>>
				<input name="pwd" type="password" class="col-md-6 norightborder <?php if(isset($err['pwd'])){ echo " error";} ?>" placeholder="Contraseña *" <?php if(isset($_POST['pwd'])){ echo "value='$_POST[pwd]'";} ?>>
				<input name="pwd2" type="password" class="col-md-6 <?php if(isset($err['pwd'])){ echo " error";} ?>" placeholder="Confirmar contraseña *" <?php if(isset($_POST['pwd2'])){ echo "value='$_POST[pwd2]'";} ?>><?php if(isset($err['pwd'])){ echo "<div align='right'><font color='red'>$err[pwd]*</font></div>";} ?>
				<p><i class="fa fa-phone"></i><b> Telefonos de contacto</b></p>
				<input name="phone1" type="text" class="col-md-6 norightborder" placeholder="Telefono" <?php if(isset($_POST['phone1'])){ echo "value='$_POST[phone1]'";} ?>>
				<input name="phone2" type="text" class="col-md-6" placeholder="Celular" <?php if(isset($_POST['phone2'])){ echo "value='$_POST[phone2]'";} ?>>
				<p><i class="fa fa-user"></i><b> Foto de perfil</b></p>
				<input type="file" class="col-md-6 <?php if(isset($err['file'])){ echo " error";} ?>" name="fileToUpload" id="fileToUpload">
				<?php if(isset($err['file'])){ echo "<div align='right'><font color='red'>*$err[file]</font></div>";} ?>
				<div align='right'>
					<input type="submit" name="submit" class="contact submit btn btn-primary btn-xl" value="Siguiente">
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</section>

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


<div id="myModal" class="modal">
	<div class="modal-content" style='width: 420px;  height: 400px;'>
		<span class="close">&times;</span>
		<div align='center'><h2>Iniciar Sessión</h2></div>
		<hr>
		<iframe src="login.php" style="border:none;" width="378" height="270"></iframe>
	</div>
</div>		

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