<?php 
	session_start();
	require 'koneksi.php';
	if($_SESSION['status']!="login"){
		header("location:proses-login.php?pesan=belum_login");
	}
?> 