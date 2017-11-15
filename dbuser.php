<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'admin');
   define('DB_PASSWORD', 'admin');
   define('DB_DATABASE', 'matchdog');
   $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>