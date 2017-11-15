<?php
include("user_session.php");
if (isset($_GET["img"])) {
	$id_pic = $_GET["img"];
	$sql = "SELECT id_dog FROM Pics WHERE id_pic='$id_pic'";
	$result  = $conn->query($sql);
	$picinf = $result->fetch_assoc();
	$sql = "DELETE FROM Pics WHERE id_pic='$id_pic'";
	$result  = $conn->query($sql);
	echo "<script type='text/javascript'>window.location.href = 'select_img.php?dg=$picinf[id_dog]';</script>";	
}
?>