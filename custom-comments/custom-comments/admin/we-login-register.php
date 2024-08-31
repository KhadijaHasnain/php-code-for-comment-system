<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login & Register</title>
	<!-- <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:400,300|Josefin+Slab' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'> -->

	<link rel="stylesheet" href="/custom-comments/assets/css/style.css"  type="text/css" />
	<!-- <link rel="stylesheet" href="css/responsive.css" type="text/css">
	<link rel="stylesheet" href="/css/icons.css" type="text/css">

	<link rel="stylesheet" href="css/lightbox.css"  type="text/css" />
	<link rel="stylesheet" href="css/tabcontent.css"  type="text/css" /> -->

	<script type="text/javascript" src="/custom-comments/assets//js/jquery-1.7.2.min.js"></script>
	<!-- <script type="text/javascript"	src="js/lightbox.js"></script>
	<script type="text/javascript"	src="js/tabcontent.js"></script> -->
	
	<!-- <link rel="icon" href="images/favicon.png" /> -->
	<base href="https://horoscopeurdu.com/">
</head>    
<body>
	
	<div class="we-login-register">
		<div class="we-login">
			<h2>Login</h2>
			<form method="post" action="https://horoscopeurdu.com/custom-comments/includes/login-session.php">
				<input type="hidden" name="we_login" value="1">
				<input type="hidden" name="action" value="login">
				<input type="text" name="email" required placeholder="Email">
				<input type="password" name="password" required placeholder="Password">
				<button type="submit" name="form_login" >Login</button>
			</form>
		</div>
	</div>

	<script>
		jQuery(document).ready(function($){
			$('.we-register form').on('submit', function(e) {
				e.preventDefault();

				var data = $(this).serialize();
				$.ajax({
					type: 'POST',
					url: 'custom-comments/includes/ajax.php',
					dataType: 'json',
					data: data,
					success: function(res){
						alert(res.message);
					}
				});
			});

			// $('.we-login form').on('submit', function(e) {
			// 	e.preventDefault();

			// 	var data = $(this).serialize();
			// 	$.ajax({
			// 		type: 'POST',
			// 		url: 'custom-comments/includes/ajax.php',
			// 		dataType: 'json',
			// 		data: data,
			// 		success: function(res){
			// 			alert(res.message);
			// 			window.location = res.redirect;
			// 		}
			// 	});
			// });
		});
	</script>
</body>
</html>