<?php 

session_start();

unset( $_SESSION['login-email'] );

$link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
	$page_url = $link . "://$_SERVER[HTTP_HOST]/custom-comments/admin/we-login-register.php";

	header('location: '. $page_url);

?> 