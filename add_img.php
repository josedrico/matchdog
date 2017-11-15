<?php
include("user_session.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$dog = $_POST["dg"];
	if(!empty($_FILES["files"]["tmp_name"][0])){
		$i = 0;
		$target_dir = "uploads/dogs/";
		foreach($_FILES["files"]["tmp_name"] as $row){
			$uploadOk = 1;
			$imageFileType = pathinfo(basename($_FILES["files"]["name"][$i]),PATHINFO_EXTENSION);
			$target_file = $target_dir . $dog . "_" . $i ."_" . time() . "." . $imageFileType;
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
					$sql = "INSERT INTO Pics (dir, id_dog) VALUES ('$target_file', '$dog')";
					$result = $conn->query($sql);
				} else {
					$err["file"]= "Lo sentimos, hubo un error al subir el archivo. Intenta de nuevo.";
				}
			}
			$i = $i + 1;
		}
		echo "<script type='text/javascript'>window.location.href = 'select_img.php?dg=$dog';</script>";
	} else {
		$err["file"]= "Se necesita subir al menos una imagen del perro.";
	}
	echo "<script type='text/javascript'>window.location.href = 'select_img.php?dg=$dog&e=$err[file]';</script>";
}
?>