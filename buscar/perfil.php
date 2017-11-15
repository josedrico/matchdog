
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Perro - MatchDog</title>
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
				<a class="page-scroll" href="index.php">Buscar</a>
				</li>
				<li>
				<a class="page-scroll" href="mi_cuenta.php">Mi cuenta</a>
				</li>
				<li>
				<a class="page-scroll" href="../logout.php">Salir</a>
				</li>
				<li>
				<table><tr>
				<?php
					echo '<td style="margin-top:15px;">&nbsp&nbsp&nbsp&nbsp<a><b>'.$userinfo['name'].'</a>&nbsp&nbsp</b>';
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
	
	<br><br><br><br>
	<?php
		if(isset($_GET["dg"])){
			$sql = "SELECT * FROM Dogs WHERE id_dog = '$_GET[dg]'";
			$dog = $conn->query($sql);
			$dog = $dog->fetch_assoc();
			$sql = "SELECT * FROM Zones WHERE id_zone = '$dog[id_zone]'";
			$zone = $conn->query($sql);
			$zone = $zone->fetch_assoc();
			$sql = "SELECT name, lastname, dir FROM Users WHERE id_user = '$dog[id_user]'";
			$owner = $conn->query($sql);
			$owner = $owner->fetch_assoc();
			$sql = "SELECT * FROM Pics WHERE id_dog = '$dog[id_dog]' AND selected='1'";
			$pic = $conn->query($sql);
			$pic = $pic->fetch_assoc(); 	
		}
	?>
	<div class="col-md-8 col-md-offset-2 text-center">
		<div class='col-md-6'>
			<a href="<?php echo "../".$pic["dir"];?>" class="image-popup fh5co-board-img"><img src="<?php echo "../".$pic["dir"];?>" alt="Imagen" class="img-rounded img-responsive"></a>
			<?php echo "<iframe src='like.php?pic=$pic[id_pic]&align=center' height='36' width='150' style='border:none; margin-top:5px;'></iframe>";?>
		</div>
		<div class='col-md-6' align = 'left'>
			<h3><?php echo "<b>".$dog["name"]."</b>"; ?></h3>
			<h4><?php echo "<b>".$dog["breed"]."</b> - $dog[age] "; if ($dog["age"] == 1){ echo "año"; } else { echo "años"; } ?></h4>
			<h4><?php echo "<i class='fa fa-map-marker'></i> $zone[name] | $dog[colonia]"; ?></h4>
			<?php echo "<i>".$dog["description"]."</i>"; ?>
			<hr>
		</div>
		<div class='col-md-6' align = 'left' style='height:135px;'>
			<table align='right'><tr>
			<?php
				echo '<td align = "right">
					<font size="5">'.$owner['name']." ".$owner['lastname'].'</font></b><br>
					Dueño de ';
					$sql = "SELECT id_dog, name FROM Dogs WHERE id_user = '$dog[id_user]'";
					$dogs = $conn->query($sql);
					$count = mysqli_num_rows($result);
					$i = 1;
					while($row = $dogs->fetch_assoc()) 
					{
						if ($row["id_dog"]==$dog["id_dog"]){ echo $row["name"]; } 
						else { echo "<a href='perfil.php?dg=$row[id_dog]'>".$row["name"]."</a>"; }
						if ($count == ($i-1)){ echo " y "; }
						elseif ($count > $i){ echo ", "; }
					}
				echo '<div align="center" style="margin-top:10px;">
						<button id="myBtn" class="btn btn-primary btn-xl"><i class="fa fa-paw"></i> Solictud de Match</button>
					</div>
				</td><td width="15px"></td>';
				$dir = "../".$owner["dir"];
				$sizes = getimagesize($dir);
				if ($sizes["0"] > $sizes["1"]){
					$prop = 135/$sizes["1"];
					$imgsize = number_format($prop*$sizes["0"], 2). "px 135px";
				} else {
					$prop = 135/$sizes["0"];
					$imgsize = "135px ". number_format($prop*$sizes["0"], 2). "px";
				}
				echo "<td align='left'><div class='img-princip' style='background-image: url(../$owner[dir]); background-size: $imgsize;'></div></td>";
			?>
			</tr></table>
		</div>
		
		<div class='col-md-12'>
			<hr>
		</div>
		<?php
			$sql = "SELECT * FROM Pics WHERE id_dog = '$dog[id_dog]'";
			$pics = $conn->query($sql);
			while($row = $pics->fetch_assoc()) 
			{
				echo "
					<div class='col-md-3'>
						<div class='animate-box'>
							<font size='1'>HACE 2 DIAS</font>
							<a href='../$row[dir]'  title='$row[caption]' class='image-popup fh5co-board-img'><img src='../$row[dir]' alt='Imagen' class='img-cropped img-rounded'></a>
							<iframe src='like.php?pic=$row[id_pic]&align=center' height='36' width='180' style='border:none; margin-top:5px;'></iframe>
							<div style='margin-top:-15px;'><font>$row[caption]</font></div><br>
						</div>
					</div>
				";
			}
		?>
	</div>
	<div id="myModal" class="modal">
		<div class="modal-content" style='width: 420px;  height: 480px;'>
			<span class="close">&times;</span>
			<div align='center'><h2>Enviar solicitud de match</h2></div>
			<hr>
			<div class="col-md-12 text-center">
				<div class='col-md-5'>
					<img src="<?php echo "../".$pic["dir"];?>" alt="Imagen" class="img-rounded img-responsive">
					<?php echo $dog["name"];?>
				</div>
				<div class='col-md-2' align='center'><i class='fa fa-2x fa-long-arrow-right'></i><br><i class='fa fa-2x fa-long-arrow-left'></i></div>
				<div class='col-md-5'>
					<a href="<?php echo "../".$pic["dir"];?>" class="image-popup fh5co-board-img"><img src="<?php echo "../".$pic["dir"];?>" alt="Imagen" class="img-rounded img-responsive"></a>
					<?php echo $dog["name"];?>
				</div>
				<div class='col-md-12'>
					<font size="1"><i class='fa fa-2x fa-comment-o'></i></font>
					<font size="3"> Incluye un mensaje</font>
					<textarea name="description" class="col-md-12" placeholder="" value="" style="height:100px;" maxlength="800"></textarea>
					<input type="submit" name="submit" class="contact submit btn btn-primary" value="ENVIAR" style="margin-top:15px; width:100%;">
				</div>
			</div>
		</div>
	</div>	
	
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
	<script src="../js/modal.js"></script>
	</body>
</html>
