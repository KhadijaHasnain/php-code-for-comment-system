<?php 

session_start();

$servername = "localhost:3306";
$database = "admin_bikesqeemat";
$username = "admin_bikesqeemat";
$password = "beFGKa76AK4jbpu3pyuL";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$post_data = $_POST;

if ( isset( $post_data['form_login'] ) ) {

  if ( ! empty( $post_data['email'] ) && 
      ! empty( $post_data['password'] ) 
    ) { 

      
      $link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
      $page_url = $link . "://$_SERVER[HTTP_HOST]/custom-comments/admin/dashboard.php";

      $post_data['email'] = filter_var($post_data['email'], FILTER_SANITIZE_EMAIL);
      $email = protect_input( $post_data['email'] );
      $password = md5( protect_input( $post_data['password'] ) );
      // check user already extist
      $sql = "SELECT * from wp_bikes_user WHERE email='$email' AND password='$password'";

      $result = $conn->query($sql);

      if ( $result->num_rows > 0 ) {
          $_SESSION["login-email"] = 'new session';
          $link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
          $page_url = $link . "://$_SERVER[HTTP_HOST]/custom-comments/admin/dashboard.php";
          header("location: " . $page_url );
      } else {
          $link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
          $page_url = $link . "://$_SERVER[HTTP_HOST]/custom-comments/admin/we-login-register.php";
          header("location: " . $page_url );
      }

    }

}

function protect_input($data) {
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

