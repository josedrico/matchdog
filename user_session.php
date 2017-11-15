<?php
   include('dbuser.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($conn, "SELECT email FROM Users WHERE email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['email'];
   
   if(!isset($_SESSION['login_user']) or ($login_session == '')){
	  //echo "<script type='text/javascript'>window.location.href = 'login.php';</script>";
   }
   
	$sql = "SELECT * FROM Users WHERE email = '$login_session'";
	$result = $conn->query($sql);
	$userinfo = $result->fetch_assoc(); 
?>