<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Jose David Rico">
<title>Registro Perro - MatchDog</title>
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
</head>

<?php
	include("user_session.php");
?>

<body id="page-top">
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		<span class="sr-only">Registro Perro - MatchDog</span>
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
			<a class="page-scroll" href="#perros">Mis Perros</a>
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
	$id = $userinfo['id_user'];
	if (empty($_POST["name"])) {
		$err["name"]= "el";
	}
	if (empty($_POST["age"])) {
		$err["age"]= "el";
	}
	if (empty($_POST["breed"])) {
		$err["breed"]= "el";
	}
	if (empty($_POST["zone"])) {
		$err["zone"]= "el";
	}
	if (empty($_POST["colonia"])) {
		$err["colonia"]= "el";
	}
	if(!count($err)){		
		$sql = "INSERT INTO Dogs (name, breed, age, cat, colonia, description, id_zone, id_user)
		VALUES ('$_POST[name]', '$_POST[breed]', '$_POST[age]', '1', '$_POST[colonia]', '$_POST[description]', '$_POST[zone]', '$id')";
		$result = $conn->query($sql);
		$sql = "SELECT id_dog FROM Dogs WHERE name='$_POST[name]' AND id_zone='$_POST[zone]' AND id_user='$id'";
		$result = $conn->query($sql);
		$doginf = $result->fetch_assoc();
		// --------- FILE UPLOAD -----------//
		if(!empty($_FILES["files"]["tmp_name"][0])){
			$i = 0;
			$target_dir = "uploads/dogs/";
			foreach($_FILES["files"]["tmp_name"] as $row){
				$uploadOk = 1;
				$imageFileType = pathinfo(basename($_FILES["files"]["name"][$i]),PATHINFO_EXTENSION);
				$target_file = $target_dir . $doginf['id_dog'] . "_" . $i ."_" . time() . "." . $imageFileType;
				$check = getimagesize($_FILES["files"]["tmp_name"][$i]);
				if($check == false) {
					$err["file"]= "El archivo no es una imagen.";
					$uploadOk = 0;
				}
				// Check file size
				if ($_FILES["files"]["size"][$i] > 500000) {
					$err["file"]= "Lo sentimos, el tamaño de la imagen". $_FILES["files"]["name"][$i]. "es mayor a los 500 Kb.";
					$uploadOk = 0;
				} 
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
				&& $imageFileType != "GIF") {
					$err["file"]= "Lo sentimos, solo formatos JPG, JPEG, PNG & GIF son aceptados.";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
						$sql = "INSERT INTO Pics (dir, id_dog) VALUES ('$target_file', '$doginf[id_dog]')";
						$result = $conn->query($sql);
					} else {
						$err["file"]= "Lo sentimos, hubo un error al subir el archivo. Intenta de nuevo.";
					}
				}
				$i = $i + 1;
			}
			echo "<script type='text/javascript'>top.location.href = 'select_img.php?dg=$doginf[id_dog]';</script>";
		} else {
			$err["file"]= "Se necesita subir al menos una imagen del perro.";
		}
		if(isset($err["file"])){
			$sql = "DELETE FROM Dogs WHERE id_dog='$doginf[id_dog]'";
			$result = $conn->query($sql);
		}
	}
}
?>
<!-- Section Contact
================================================== -->
<section id="perros">
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h2 class="section-heading"><b>Registro de Perro</b></h2>
		<hr class="primary">
		<div class="regularform">
			<form method="post" action="" class="text-left" enctype="multipart/form-data">
				<b><p><i class="fa fa-paw"></i> Información del perro</p></b>
				<input name="name" type="text" class="col <?php if(isset($err['name'])){ echo " error";} ?>" style="width:360px" placeholder="Nombre" maxlength="50" <?php if(isset($_POST['name'])){ echo "value='$_POST[name]'";} ?>>
				<input name="breed" placeholder="Raza" style="width:280px" class="col <?php if(isset($err['breed'])){ echo " error";} ?>" list="razas" <?php if(isset($_POST['breed'])){ echo "value='$_POST[raza]'";} ?>>
				<datalist id="razas">
					<option value= "Airedale Terrier">
					<option value= "Akita Inu">
					<option value= "Alaskan Malamute">
					<option value= "American Cocker Spaniel">
					<option value= "American Pit bull Terrier">
					<option value= "Australian Terrier">
					<option value= "Balkan Hound">
					<option value= "Basenji">
					<option value= "Basset Hound">
					<option value= "Beagle">
					<option value= "Bearded Collie">
					<option value= "Beauceron">
					<option value= "Bichón Habanero">
					<option value= "Bichón Maltés">
					<option value= "Bloodhound (Perro de San Huberto)">
					<option value= "Bobtail">
					<option value= "Border Terrier">
					<option value= "Borzoi">
					<option value= "Boston Terrier">
					<option value= "Bóxer">
					<option value= "Boyero Australiano">
					<option value= "Boyero de Flandes">
					<option value= "Braco Alemán">
					<option value= "Braco Francés">
					<option value= "Bretón Español">
					<option value= "Bull Terrier">
					<option value= "Bulldog Francés">
					<option value= "Bulldog Inglés">
					<option value= "Bullmastiff">
					<option value= "Caniche">
					<option value= "Carlino">
					<option value= "Chart Polski">
					<option value= "Chihuahua">
					<option value= "Chin Japonés">
					<option value= "Chow chow">
					<option value= "Cimarrón Uruguayo">
					<option value= "Cocker Spaniel Inglés">
					<option value= "Collie">
					<option value= "Crestado Chino">
					<option value= "Dálmata">
					<option value= "Deutsch Drahthaar">
					<option value= "Doberman">
					<option value= "Dogo Alemán">
					<option value= "Dogo Argentino">
					<option value= "Dogo de Burdeos">
					<option value= "Fila Brasileño">
					<option value= "Fox Terrier">
					<option value= "Foxhound Inglés">
					<option value= "Galgo Español">
					<option value= "Golden Retriever">
					<option value= "Gos D'Atura">
					<option value= "Grifón de Bohemia">
					<option value= "Hovawart">
					<option value= "Husky Siberiano">
					<option value= "Iceland Sheepdog">
					<option value= "Irish Wolfhound">
					<option value= "Jack Russell Terrier">
					<option value= "Kelpie Australiano">
					<option value= "Kuvasz">
					<option value= "Labrador Retriever">
					<option value= "Lebrel Afgano">
					<option value= "Lebrel Escocés">
					<option value= "Leonberger">
					<option value= "Lhasa Apso">
					<option value= "Mastín de los Pirineos">
					<option value= "Otterhound">
					<option value= "Pastor Alemán">
					<option value= "Pastor Belga">
					<option value= "Pastor Ganadero Australiano">
					<option value= "Pastor Garafiano">
					<option value= "Papillón">
					<option value= "Pequinés">
					<option value= "Pembroke Welsh Corgi">
					<option value= "Perro de Agua Español">
					<option value= "Perro de Agua Francés">
					<option value= "Xoloitzcuintle (Perro sin Pelo Mexicano)">
					<option value= "Perro sin Pelo del Perú">
					<option value= "Petit Basset Griffon">
					<option value= "Pinscher">
					<option value= "Podenco Canario">
					<option value= "Podenco Ibicenco">
					<option value= "Pointer Inglés">
					<option value= "Pomerania">
					<option value= "Presa Canario">
					<option value= "Puli">
					<option value= "Ratón Bodeguero Andaluz">
					<option value= "Retriever de pelo rizado">
					<option value= "Rottweiler">
					<option value= "San Bernardo">
					<option value= "Samoyedo">
					<option value= "Schnauzer">
					<option value= "Scottish Terrier">
					<option value= "Setter Irlandés">
					<option value= "Shar Pei">
					<option value= "Shetland Sheepdog">
					<option value= "Shih Tzu">
					<option value= "Spinone italiano">
					<option value= "Teckel">
					<option value= "Terranova">
					<option value= "Terrier Australiano">
					<option value= "Terrier Checo">
					<option value= "Terrier Japonés">
					<option value= "Terrier Tibetano">
					<option value= "Tosa Inu">
					<option value= "Weimaraner">
					<option value= "West Highland White Terrier">
					<option value= "Yorkshire Terrier">
				</datalist>
				<select name="age" class="col <?php if(isset($err['age'])){ echo " error";} ?>" placeholder="Edad" >
					<option value=''> Edad </option>
					<option value="1" <?php if(isset($_POST['age']) AND $_POST['age']=='1'){ echo " selected";} ?>>1</option>
					<option value="2" <?php if(isset($_POST['age']) AND $_POST['age']=='2'){ echo " selected";} ?>>2</option>
					<option value="3" <?php if(isset($_POST['age']) AND $_POST['age']=='3'){ echo " selected";} ?>>3</option>
					<option value="4" <?php if(isset($_POST['age']) AND $_POST['age']=='4'){ echo " selected";} ?>>4</option>
					<option value="5" <?php if(isset($_POST['age']) AND $_POST['age']=='5'){ echo " selected";} ?>>5</option>
					<option value="6" <?php if(isset($_POST['age']) AND $_POST['age']=='6'){ echo " selected";} ?>>6</option>
					<option value="7" <?php if(isset($_POST['age']) AND $_POST['age']=='7'){ echo " selected";} ?>>7</option>
					<option value="8" <?php if(isset($_POST['age']) AND $_POST['age']=='8'){ echo " selected";} ?>>8</option>
					<option value="9" <?php if(isset($_POST['age']) AND $_POST['age']=='9'){ echo " selected";} ?>>9</option>
					<option value="10" <?php if(isset($_POST['age']) AND $_POST['age']=='10'){ echo " selected";} ?>>10</option>
					<option value="11" <?php if(isset($_POST['age']) AND $_POST['age']=='11'){ echo " selected";} ?>>11</option>
					<option value="12" <?php if(isset($_POST['age']) AND $_POST['age']=='12'){ echo " selected";} ?>>12</option>
					<option value="13" <?php if(isset($_POST['age']) AND $_POST['age']=='13'){ echo " selected";} ?>>13</option>
					<option value="14" <?php if(isset($_POST['age']) AND $_POST['age']=='14'){ echo " selected";} ?>>14</option>
					<option value="15" <?php if(isset($_POST['age']) AND $_POST['age']=='15'){ echo " selected";} ?>>15</option>
					<option value="16" <?php if(isset($_POST['age']) AND $_POST['age']=='16'){ echo " selected";} ?>>16</option>
				</select>
				<p><i class="fa fa-map-marker"></i><b> Zona o localidad</b></p>
				<select name="zone" class="col <?php if(isset($err['zone'])){ echo " error";} ?>" style="width:360px">
					<option value=''>Ciudad</option>
					<?php 
						$sql = "SELECT * FROM Zones";
						$result = $conn->query($sql);
						while($row = $result->fetch_assoc()) {
							echo "<option value='$row[id_zone]' ";
							if(isset($_POST['zone']) AND $_POST['zone']==$row["id_zone"]){ echo " selected";}
							echo ">$row[name]</option>";
						}
					?>
				</select>
				<input name="colonia" type="text" class="col <?php if(isset($err['colonia'])){ echo " error";} ?>" style="width:360px" placeholder="Colonia" maxlength="100" <?php if(isset($_POST['colonia'])){ echo "value='$_POST[colonia]'";} ?>>
				<div class="col <?php if(isset($err['name'])){ echo " error";} ?>" style="width:360px">
					<p><b> Describe a tu perro </b></p>
				</div>
				<textarea name="description" class="col-md-12" placeholder="" value='' maxlength="800"><?php if(isset($_POST['description'])){ echo $_POST["description"];} ?></textarea>
				<p><i class="fa fa-picture-o"></i><b> Fotos</b></p>
				<input type="file" class="col-md-6 <?php if(isset($err['file'])){ echo " error";} ?>" name="files[]" multiple>
				<?php if(isset($err['file'])){ echo "<div align='right'><font color='red'>*$err[file]</font></div>";} ?>
				<div align='right'>
					<input type="submit" id="submit" class="contact submit btn btn-primary btn-xl" value="Publicar">
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