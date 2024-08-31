<?php 

$link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
$page_url = $link . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parse_url = parse_url( $page_url );
$domains = [ 'qeemat', 'bikes', 'cars', 'electronics', 'laptops', 'mobiles', 'samsunggalaxys4', 'horoscopeurdu' ];
$explode = explode( '.', $parse_url['host'] )[0];

if ( $explode == 'www' ) {
	$explode = explode( '.', $parse_url['host'] )[1];
}

if ( in_array( $explode, $domains ) ) {
	$source_type = $explode;
}

$page_slug = '';
if ( $parse_url['path'] ) {
	$page_slug = str_replace( '.php', '', $parse_url['path'] );
}

$comment_parent = 0;

?>

<?php 
$servername = "localhost:3306";
$database = "admin_bikesqeemat";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

?> 