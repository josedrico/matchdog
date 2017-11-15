
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Buscar - MatchDog</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="Jose David Rico" />

	<?php include("../user_session.php"); ?>
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- Salvattore -->
	<link rel="stylesheet" href="css/salvattore.css">
	<!-- Theme Style -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Plugin CSS -->
	<link rel="stylesheet" href="../css/animate.min.css" type="text/css">
	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- Modal CSS -->
	<link rel="stylesheet" href="../css/modal.css" type="text/css">
	<!-- Custom Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards%7CDosis:300,400,700%7COpen+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800;' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">
	
	</head>
	<body>
	
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
			<img src="../img/logo.png" style="margin-top:15px;" width="160px" height="33px" >
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li>
				<a class="page-scroll" href="../mis_perros.php">Mis Perros</a>
				</li>
				<li class='active'>
				<a class="page-scroll" href="#buscar">Buscar</a>
				</li>
				<li>
				<a class="page-scroll" href="../mi_cuenta.php">Mi cuenta</a>
				</li>
				<li>
				<a class="page-scroll" href="../logout.php">Salir</a>
				</li>
				<li>
				<table><tr>
				<?php
					echo '<td>&nbsp&nbsp&nbsp&nbsp<a class="page-scroll"><b>'.$userinfo['name'].'</a>&nbsp&nbsp</b>';
					$dir = "../".$userinfo["dir"];
					$sizes = getimagesize($dir);
					if ($sizes["0"] > $sizes["1"]){
						$prop = 40/$sizes["1"];
						$imgsize = number_format($prop*$sizes["0"], 2). "px 40px";
					} else {
						$prop = 40/$sizes["0"];
						$imgsize = "40px ". number_format($prop*$sizes["0"], 2). "px";
					}
					echo "<td><div class='img-prof' style='background-image: url(../$userinfo[dir]); background-size: $imgsize; margin-top:16px;'></div></td>";
				?>
				</tr></table>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
	</nav>
	
	<div id="fh5co-offcanvass">
		<a href="#" class="fh5co-offcanvass-close js-fh5co-offcanvass-close">Filtrar <i class="fa fa-filter"></i> </a>
		<h1 class="fh5co-logo"><a class="navbar-brand" href="index.html">Filtrar <i class="fa fa-filter"></i></a></h1>
		<h1>&nbsp</h1>
		<ul>
			<li>
				<b><i class="fa fa-map-marker"></i> Ciudad</b><br>
				<select name="dog" class="" class="col-md-6">
					<option value=''> Misma ciudad </option>
					<option value=''> Cualquier ciudad </option>
				</select>
			</li>
			<li>
				<br><i class="fa fa-paw"></i><b> Raza</b><br>
				<select name="dog" class="">
					<option value=''> Solo la misma raza </option>
					<option value=''> Cualquier raza </option>
				</select>
			</li>
			<li>
				<br><i  class='fa fa-venus-mars'></i><b> Sexo</b><br>
				<input type="radio" name="contract"> Mismo
				<input type="radio" name="contract"> Cualquiera
			</li>
		</ul>
	</div>
	<header id="fh5co-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="#" class="fh5co-menu-btn js-fh5co-menu-btn">Filtrar <i class="fa fa-filter"></i></a>
					<a class="navbar-brand">Buscando para
						<?php
						$sql = "SELECT * FROM Dogs WHERE id_user='$userinfo[id_user]'";
						$result = mysqli_query($conn, $sql);
						$count = mysqli_num_rows($result);
						if($count > 1) {
							echo '<select name="dog" class="dog-select">';
							while($row = $result->fetch_assoc()) 
							{
								echo "<option value=''>$row[name]</option>";
							}
							echo '</select>';
						} else {
							$row = $result->fetch_assoc();
							echo " $row[name]";
						}
						?>
					</a>
					</h3>
				</div>
			</div>
		</div>
	</header>
	<!-- END .header -->
	
	<section id="perros">
	<div id="fh5co-main">
		<div class="container">
		<div class="row">
        <div id="fh5co-board" data-columns>
			<?php
				$sql = "SELECT * FROM Dogs";
				$result = mysqli_query($conn, $sql);
				$count = mysqli_num_rows($result);
				while($row = $result->fetch_assoc()) 
				{
					$sql = "SELECT * FROM Pics WHERE id_dog = '$row[id_dog]' AND selected='1'";
					$pics = $conn->query($sql);
					$pics = $pics->fetch_assoc(); 
					$sql = "SELECT * FROM Zones WHERE id_zone = '$row[id_zone]'";
					$zone = $conn->query($sql);
					$zone = $zone->fetch_assoc();
					$sql = "SELECT name, dir FROM Users WHERE id_user = '$row[id_user]'";
					$owner = $conn->query($sql);
					$owner = $owner->fetch_assoc();
					echo "
					<div class='item'>
						<div class='animate-box'>
							<a href='perfil.php?dg=$row[id_dog]' class='image-pops fh5co-board-img'><img src='../$pics[dir]' alt='No hay foto'></a>
						</div>
						<div class='fh5co-desc'>
							<table width='100%'>
								<tr>
									<td>
										<iframe src='like.php?pic=$pics[id_pic]&align=left' height='36' width='150' style='border:none; margin-top:5px; margin-left:-5px;'></iframe>
									</td>
									<td align='right'>
										$owner[name] &nbsp <div class='img-buscar' style='background-image: url(../$owner[dir]); background-size: $imgsize;'></div>
									</td>
								</tr>	
							</table>
							<div style='margin-top:-15px;'>
							<b>$row[name]</b> - $row[breed] <br>
							<font size='2'><i class='fa fa-map-marker'></i> $zone[name] | $row[age] ";
							if ($row["age"] == 1){ echo "año"; } else { echo "años"; }
							echo "</font>";
							$sizes = getimagesize("../".$owner["dir"]);
							if ($sizes["0"] > $sizes["1"]){
								$prop = 30/$sizes["1"];
								$imgsize = number_format($prop*$sizes["0"], 2). "px 30px";
							} else {
								$prop = 30/$sizes["0"];
								$imgsize = "30px ". number_format($prop*$sizes["0"], 2). "px";
							}
							echo "
							</div>
						</div>
					</div>
					";
				}
			?>
        	<div class="item">
        		<div class="animate-box">
	        		<a href="perfil.php" class="image-pops fh5co-board-img"><img src="images/1.jpg"></a>
        		</div>
        		<div class="fh5co-desc">
					<b>Freddy</b> - Bulldog <br>
					<font size='2'><i class="fa fa-map-marker"></i> Hermosillo | 2 años</font>
					<div align="right">
						Antonio <img src="images/p1.jpg" width="30" height="30">
					</div>
				</div>
        	</div>
			<div class="item">
        		<div class="animate-box">
	        		<a href="images/2.jpg" class="image-pops fh5co-board-img" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, eos?"><img src="images/2.jpg" alt="Free HTML5 Bootstrap template"></a>
        		</div>
        		<div class="fh5co-desc">
					<b>Lexie</b> - Labrador Retriever <br>
					<font size='2'><i class="fa fa-map-marker"></i> Hermosillo | 5 años</font>
					<div align="right">
						Rebeca <img src="images/p2.jpg" width="30" height="30">
					</div>
				</div>
        	</div>
			<div class="item">
        		<div class="animate-box">
	        		<a href="images/3.jpg" class="image-popup fh5co-board-img" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, eos?"><img src="images/3.jpg" alt="Free HTML5 Bootstrap template"></a>
        		</div>
        		<div class="fh5co-desc">
					<b>Sparki</b> - Beagle <br>
					<font size='2'><i class="fa fa-map-marker"></i> Hermosillo | 4 años</font>
					<div align="right">
						Manuel <img src="images/p3.jpg" width="30" height="30">
					</div>
				</div>
        	</div>
     
        </div>
        </div>
       </div>
	</div>
	</section>
	
	<footer id="fh5co-footer">
		
		<div class="container">
			<div class="row row-padded">
				<div class="col-md-12 text-center">
					<p class="fh5co-social-icons">
						<a href="#"><i class="icon-twitter"></i></a>
						<a href="#"><i class="icon-facebook"></i></a>
						<a href="#"><i class="icon-instagram"></i></a>
						<a href="#"><i class="icon-dribbble"></i></a>
						<a href="#"><i class="icon-youtube"></i></a>
					</p>
					<p><small>&copy; Hydrogen Free HTML5 Template. All Rights Reserved. <br>Designed by: <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> | Images by: <a href="http://pexels.com" target="_blank">Pexels</a> </small></p>
				</div>
			</div>
		</div>
	</footer>


	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<!-- Salvattore -->
	<script src="js/salvattore.min.js"></script>
	<!-- Main JS -->
	<script src="js/main.js"></script>

	

	
	</body>
</html>
