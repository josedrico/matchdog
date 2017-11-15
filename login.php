<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Entrar - MatchDog</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<!-- Custom Fonts -->
<link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards%7CDosis:300,400,700%7COpen+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800;' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
<!-- Plugin CSS -->
<link rel="stylesheet" href="css/animate.min.css" type="text/css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>

<?php
	include("dbuser.php");
	session_start();
	$error="";
   
    if($_SERVER["REQUEST_METHOD"] == "POST") {
	  // username and password sent from form 
	  
	  $myemail = $_POST['email'];
	  $mypassword = $_POST['pwd']; 
	  
	  $sql = "SELECT id_user FROM Users WHERE email = '$myemail' and pwd = '$mypassword'";
	  $result = mysqli_query($conn, $sql);
	  $count = mysqli_num_rows($result);
	  
	  // If result matched $myusername and $mypassword, table row must be 1 row
	  if($count == 1) {
	     $_SESSION['login_user'] = $myemail;
		 echo "<script type='text/javascript'>top.location.href = 'mis_perros.php';</script>";
		} else {
			$err = "Usuario o contraseña incorrectos.";
		}
	}
?>

<!-- Section Contact
================================================== -->
<div class="container">
<div class="row">
	<div class="regularform">
		<form method="post" action="" class="text-left">
			<input name="email" type="email" class="col-md-6 error<?php if(isset($error)){ echo " error";} ?>" placeholder="Email *" <?php if(isset($_POST['email'])){ echo "value='$_POST[email]'";} ?>>
			<input name="pwd" type="password" class="col-md-6 <?php if(isset($error)){ echo " error";} ?>" placeholder="Contraseña *" <?php if(isset($_POST['pwd'])){ echo "value='$_POST[pwd]'";} ?>>
			<font color="red"><?php if(isset($err)){ echo $err; } ?></font>
			<div align='right'>
				<input type="submit" name="submit" class="contact submit btn btn-primary btn-xl" value="Siguiente">
			</div>
		</form>
	</div>
</div>
</div>
</body>
</html>