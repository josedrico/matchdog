<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Jose David Rico">
<meta name="author" content="">
<title>Imágenes - MatchDog</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<!-- Custom Fonts -->
<link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards%7CDosis:300,400,700%7COpen+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800;' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
<!-- Plugin CSS -->
<link rel="stylesheet" href="css/animate.min.css" type="text/css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/style.css" type="text/css">
<!-- Modal CSS -->
<link rel="stylesheet" href="css/modal.css" type="text/css">
<!-- Radio CSS -->
<link rel="stylesheet" href="css/radio.css" type="text/css">
</head>

<?php include("user_session.php"); ?>

<body id="page-top">
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand page-scroll" href="#page-top"><img src="img/logo.png" width="160px" height="33px" ></a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
			<li class="active-link">
			<a class="page-scroll" href="#page-top">Mis Perros</a>
			</li>
			<li>
			<a class="page-scroll" href="buscar/index.php">Buscar</a>
			</li>
			<li>
			<a class="page-scroll" href="mi_cuenta.php">Mi cuenta</a>
			</li>
			<li>
			<a class="page-scroll" href="logout.php">Salir</a>
			</li>
			<li>
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
		
<!-- Section Contact
================================================== -->
<section id="perros">
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h2 class="section-heading"><b>Selecciona imagen principal</b></h2>
		<hr class="primary">
		<form method="post" action="">
		<?php
			if(isset($_GET["dg"])){
				$dog = $_GET["dg"];
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$selected = $_POST["selected"];
					if(!empty($selected)){
						if($selected != $_SESSION['selected']){
							$_SESSION['selected'] = $selected;
							$sql = "UPDATE Pics SET selected='0' WHERE id_dog='$dog'";
							$result  = $conn->query($sql);
							$sql = "UPDATE Pics SET selected='1' WHERE id_pic='$selected'";
							$result  = $conn->query($sql);
							$ready = "ok";
						} else {
							unset($_POST["selected"]);
							$keys = array_keys($_POST);
							foreach($keys as $key){	
								if (!empty($_POST[$key])){
									$sql = "UPDATE Pics SET caption='$_POST[$key]' WHERE id_pic='$key'";
									$result  = $conn->query($sql);
								}
							}
							unset($_SESSION["selected"]);
							echo "<script type='text/javascript'>window.location.href = 'mis_perros.php';</script>";	
						}
					} else {
						echo "SELECIONA UNA IMAGEN";
					}
				} else {
					$_SESSION['selected']='';
				}
				
				$sql = "SELECT * FROM Dogs WHERE id_dog = '$dog' AND id_user='$userinfo[id_user]'";
				$result = mysqli_query($conn, $sql);
				$count = mysqli_num_rows($result);
				if($count == 1) {
					$sql = "SELECT * FROM Pics WHERE id_dog = '$dog'";
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()) 
					{
						echo 
							'<div class="col-md-4">
							<input type="radio" id="'.$row['id_pic'].'" value="'.$row['id_pic'].'" name="selected" onchange="this.form.submit()"';
						if ($row['selected']){ echo 'checked'; }
						echo ' >
							<label for="'.$row['id_pic'].'"><br>'.
							'<img src="'.$row['dir'].'" class="img-responsive" alt="">
							<div class="delete-img"><a href="delete_img.php?img='.$row['id_pic'].'" <i class="fa fa-times-circle"></i></a></div>
							<textarea placeholder="Añade una descripción.." class="caption" name="'.$row['id_pic'].'">'.$row["caption"].'</textarea>
							</label></div>';
					}
				} else {
					
				}
			}
			
		?>
		<br><br>
		<div class='col-md-12' align='center' style='height:250px;'>
			<input type="submit" value='Listo!' href="mis_perros.php" style='width:200px;' class="contact submit btn btn-primary btn-xl">
			</form>
			<hr>
			<h3><i class="fa fa-picture-o"></i><b> Agregar más fotos</b></h3><br>
			<form method="post" action="add_img.php" enctype="multipart/form-data">
				<input type="file" name="files[]" multiple onchange="this.form.submit()" class="<?php if(isset($_GET['e'])){ echo " error";}?>">
				<input type="hidden" name="dg" value="<?php echo $dog;?>">
			</form>
			<?php if(isset($_GET['e'])){ echo "<div align='right'><font color='red'>*$_GET[e]</font></div>";} ?>
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

<!-- jQuery -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/parallax.js"></script>
<!--  <script src="js/contact.js"></script> -->
<script src="js/countto.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/common.js"></script>
</body>
</html>