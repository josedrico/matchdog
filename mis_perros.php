<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Jose David Rico">
<title>Mis Perros - MatchDog</title>
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
			<li>
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
				<div class="dropdown">
				  <button class="not dropdown-toggle" type="button" data-toggle="dropdown">
				  <i class="fa fa-2x fa-paw"></i>
				  <span class="caret"></span></button>
				  <ul class="dropdown-menu">
					<li><a href="#">HTML</a></li>
					<li><a href="#">CSS</a></li>
					<li><a href="#">JavaScript</a></li>
				  </ul>
				</div>
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
		
<!-- Section Contact
================================================== -->
<section id="perros">
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h2 class="section-heading"><b>Mis Perros</b></h2>
		<hr class="primary">
		<div class="equal-heights w-middle">
		<?php
			$sql = "SELECT * FROM Dogs WHERE id_user='$userinfo[id_user]'";
			$result = mysqli_query($conn, $sql);
			$count = mysqli_num_rows($result);
			if($count > 0) {
				while($row = $result->fetch_assoc()) 
				{
					$sql = "SELECT * FROM Pics WHERE id_dog = '$row[id_dog]' AND selected='1'";
					$pics = $conn->query($sql);
					$pics = $pics->fetch_assoc(); 
					$sql = "SELECT * FROM Zones WHERE id_zone = '$row[id_zone]'";
					$zone = $conn->query($sql);
					$zone = $zone->fetch_assoc();
					echo "
					<div class='col-md-6'>
						<a href='#' class='portfolio-box'>
						<img src='$pics[dir]' class='img-responsive img-rounded' alt=''>
						<div class='portfolio-box-title'>
							$row[name]
						</div>
						<div class='portfolio-box-caption'>
							<div class='portfolio-box-caption-content'>
								<div class='project-category text-faded'>
									 $row[name]
								</div>
								<div class='project-name'>
									 $row[breed]<br>
									 <i class='fa fa-map-marker'></i> $zone[name]<br>
									 $row[age]
									 "; 
									 if ($row['age']=='1'){ echo "año"; } 
									 else { echo "años"; } 
									 echo "<br>
								</div>
							</div>
						</div>
						</a>
					</div>
					<div class='col-md-6' style='text-align:left;'>
						<a href='buscar/index.php' class='btn btn-primary btn-xl'><i class='fa fa-venus-mars'></i> Buscar pareja</a>
						<a href='edit_dog.php' class='btn btn-grey btn-xl'><i class='fa fa-pencil-square-o'></i> Editar información</a>
						<a href='select_img.php?dg=$row[id_dog]' class='btn btn-grey btn-xl'><i class='fa fa-picture-o'></i> Editar imagenes</a>
					</div>
					";
				}		
			} 
		?>
		</div>
		<div class='col-md-12' style='height:100px;'>
			<hr>
			<a href='registro_perro.php' class='btn btn-primary btn-xl'>+ Agregar otro perro</a>
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
	<div align="center">
		<img src="img/logo3.png" width="160px" height="100px" ></i><br><br>
		<p class="fh5co-social-icons">
			<a href="#"><i class="fa fa-3x fa-facebook"></i></i></a>&nbsp&nbsp
			<a href="#"><i class="fa fa-3x fa-instagram"></i></i></a>&nbsp&nbsp
			<a href="#"><i class="fa fa-3x fa-twitter"></i></a>
		</p>
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