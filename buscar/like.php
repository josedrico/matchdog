<!-- Custom Fonts -->
<link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards%7CDosis:300,400,700%7COpen+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800;' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">

<?php 
include("../user_session.php"); 
if (isset($_GET["align"])){
	if ($_GET["align"]=="left"){
		echo '<div style="margin-top:-8px; margin-left:-7px;">';
	} else {
		echo '<div align="center" style="margin-top:-8px; margin-left:-7px;">';
	}
} 
if (isset($_GET["l"])){
	if ($_GET["l"]=="like"){
		$sql = "INSERT INTO Likes (id_pic, id_user) VALUES ('$_GET[pic]', '$userinfo[id_user]')";
		$like = $conn->query($sql);
	} elseif ($_GET["l"]=="dis"){
		$sql = "DELETE FROM Likes WHERE id_pic='$_GET[pic]' AND id_user='$userinfo[id_user]'";
		$like = $conn->query($sql);
	}
}
if (isset($_GET["pic"])){
	$sql = "SELECT * FROM Likes WHERE id_pic = '$_GET[pic]' AND id_user = '$userinfo[id_user]'";
	$like = $conn->query($sql);
	if (mysqli_num_rows($like) > 0){
		echo "<a class='lyes' href='like.php?pic=$_GET[pic]&l=dis&align=$_GET[align]'><i class='fa fa-heart'></i></a> ";
	} else {
		echo "<a class='lnot' href='like.php?pic=$_GET[pic]&l=like&align=$_GET[align]'><i class='fa fa-heart-o'></i></a> ";
	}
	$sql = "SELECT COUNT(id_pic) FROM Likes WHERE id_pic = '$_GET[pic]'";
	$likes = $conn->query($sql);
	$likes = $likes->fetch_assoc();
	echo $likes["COUNT(id_pic)"]. " me gusta";
}
?>
</div>
<style>
body {
	font-family:Open Sans,'Helvetica Neue',Arial,sans-serif;
	font-size:12px;
	color:#777;
	line-height:1.7;
}
.lnot {
	color: #d9d9d9;
	font-size:24px;
}
.lnot:hover {
	color: #bfbfbf;
}
.lyes {
	color: #f05f40;
	font-size:24px;
}
<style>