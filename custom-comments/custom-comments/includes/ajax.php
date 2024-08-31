 <?php 
 // session_start();
 class we_ajax {

  function __construct() {
    $this->ajax_handler();
  }

  private function ajax_handler() {
    $method = $_REQUEST['action'];
    if ( method_exists( $this, $method ) ) {
      // db connection
      
    $servername = "localhost:3306";
    $database = "admin_bikesqeemat";
    $username = "root";
    $password = "";

      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $database);

      // Check connection
      if ( ! $conn ) {
        die("Connection failed: " . mysqli_connect_error());
      } 

      $this->$method( $conn );

      // close connection
      $conn->close();
    }
    exit;
  }

  public function protect_input( $data ) {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function login( $conn ) {

    $post_data = $_POST;

    if ( ! empty( $post_data['email'] ) && 
      ! empty( $post_data['password'] ) 
    ) { 

      
      $link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
      $page_url = $link . "://$_SERVER[HTTP_HOST]/custom-comments/admin/dashboard.php.php";

      $post_data['email'] = filter_var($post_data['email'], FILTER_SANITIZE_EMAIL);
      $email = $post_data['email'];
      $password = $post_data['password'];
      // check user already extist
      $sql = "SELECT * from wp_bikes_user WHERE email='$email' AND password='$password'";


      $result = $conn->query($sql);

      if ( $result->num_rows > 0 ) {
        $_SESSION["we_login_email"] = $email;

        // echo $_SESSION["we_login_email"]; exit('ss');

        echo json_encode( [ 'message' => "You are succcessfully logged in.", 'redirect' => $page_url ] );
        exit();
      } 

    }
  }

  public function register( $conn ) {
    $post_data = $_POST;
    if ( ! empty( $post_data['email'] ) && 
      ! empty( $post_data['password'] ) 
    ) { 
      $post_data['email'] = filter_var($post_data['email'], FILTER_SANITIZE_EMAIL);
      $email = $post_data['email'];
      // check user already extist
      $sql = "SELECT * from wp_bikes_user WHERE email='$email'";
      $result = $conn->query($sql);
      if ( $result->num_rows > 0 ) {
        echo json_encode( [ 'message' => "Sorry, this user already exist." ] );
        exit();
      } 
      // prepare and bind
      $stmt = $conn->prepare("INSERT INTO wp_bikes_user (name, email, password ) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $password);

      extract($post_data);

      $stmt->execute();
      $stmt->close();

      echo json_encode( [ 'message' => "Congratulations, your account has been successfully created." ] );
    }
  }

  public function insert($conn) {
    $post_data = $_POST;
    if (!empty($post_data['comment_author']) && 
        !empty($post_data['comment_author_email']) && 
        !empty($post_data['comment_content'])
    ) {
        // Sanitize input
        $comment_author = $this->protect_input($post_data['comment_author']);
        $comment_author_email = filter_var($post_data['comment_author_email'], FILTER_SANITIZE_EMAIL);
        $comment_content = $this->protect_input($post_data['comment_content']);

        // Assuming these variables are defined elsewhere in your code
        $comment_date = $post_data['comment_date'];
        $source_type = $post_data['source_type'];
        $slug = $post_data['slug'];
        $page_url = $post_data['page_url'];
        $comment_parent = $post_data['comment_parent'];

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO wp_bikes_comments (comment_author, comment_author_email, comment_content, comment_date, comment_date_gmt, source_type, slug, page_url, comment_parent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            // Handle prepare error
            echo json_encode(['error' => "Prepare statement error: " . $conn->error]);
            exit();
        }

        $stmt->bind_param("ssssssssi", $comment_author, $comment_author_email, $comment_content, $comment_date, $comment_date, $source_type, $slug, $page_url, $comment_parent);

        // Execute the statement
        if ($stmt->execute()) {
            // Sending email notification
            $msg = 'A new comment added (' . $comment_author . ')';
            $msg .= '<a href="' . $page_url . '">' . 'post link </a>';
            $sendmail = mail("awaismushtaqfp724@gmail.com", "Qeemat Comment", $msg);
            if ($sendmail) {
                // Email sent successfully
            } else {
                // Failed to send email
            }

            echo json_encode(['message' => "Comment successfully added"]);
            exit();
        } else {
            // Error occurred while executing the statement
            echo json_encode(['error' => "Error: " . $stmt->error]);
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle case where required fields are empty
        echo json_encode(['error' => "Required fields are empty"]);
    }
}


  public function reply( $conn ) {
    $post_data = $_POST;
    if ( ! empty( $post_data['comment_author'] ) && 
      ! empty( $post_data['comment_author_email'] ) && 
      ! empty( $post_data['comment_content'] ) 
    ) {
      $post_data['comment_author_email'] = filter_var($post_data['comment_author_email'], FILTER_SANITIZE_EMAIL);
      // prepare and bind
      $stmt = $conn->prepare("INSERT INTO wp_bikes_comments (comment_author, comment_author_email, comment_content, comment_date, comment_date_gmt, source_type, slug, page_url, comment_parent ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssssss", $comment_author, $comment_author_email, $comment_content, $comment_date, $comment_date, $source_type, $slug, $page_url, $comment_parent);

      extract($post_data);

      $stmt->execute();
      $stmt->close();

      $msg = 'A reply to your comment to view commment click on';
      $msg .= '<a href="'.$page_url.'">' . 'post link </a>';
      $sendmail = mail( $comment_author_email,"Qeemat Comment", $msg );
      if ( $sendmail ) {
        //print_r('1111111111111');
      } else {
        //print_r('222222222222');
      }

      echo json_encode( [ 'message' => "Comment successfully added" ] );
    }

  }

  public function unapprove( $conn ) {
    $id = $_POST['id'];
    $sql = "UPDATE wp_bikes_comments SET comment_approved='0' WHERE comment_ID='$id'";

    if ($conn->query($sql) === TRUE) {
      echo json_encode( [ 'message' => "Record unapproved successfully" ] );
    } else {
      echo json_encode( [ 'message' => "Error updating record: " . $conn->error ] );
    }
  }

  public function approve( $conn ) {
    $id = $_POST['id'];
    $sql = "UPDATE wp_bikes_comments SET comment_approved='1' WHERE comment_ID='$id'";

    if ($conn->query($sql) === TRUE) {
      echo json_encode( [ 'message' => "Record approved successfully" ] );
    } else {
      echo json_encode( [ 'message' => "Error updating record: " . $conn->error ] );
    }
  }

  public function trash( $conn ) {
    $id = $_POST['id'];
    // sql to delete a record
    $sql = "DELETE FROM wp_bikes_comments WHERE comment_ID='$id'";

    if ($conn->query($sql) === TRUE) {
      echo json_encode( [ 'message' => "Record deleted successfully" ] );
    } else {
      echo json_encode( [ 'message' => "Error deleting record: " . $conn->error ] );
    }
  }

  public function edit( $conn ) {
    $id = $_POST['comment_ID'];
    
    $comment_author = $_POST['comment_author'];
    $comment_author_email = $_POST['comment_author_email'];
    $comment_content = $_POST['comment_content'];

    $sql = "UPDATE wp_bikes_comments SET comment_author='$comment_author', comment_author_email='$comment_author_email', comment_content='$comment_content' WHERE comment_ID='$id'";

    if ($conn->query($sql) === TRUE) {
      echo json_encode( [ 'message' => "Record updated successfully" ] );
    } else {
      echo json_encode( [ 'message' => "Error updating record: " . $conn->error ] );
    }
  }

}

new we_ajax();
 /*$servername = "localhost:3306";
 $database = "qeemat_bike";
 $username = "qeemat";
 $password = "2%a97flS5";

 // Create connection
 $conn = mysqli_connect($servername, $username, $password, $database);

 // Check connection
 if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 } 

 function we_input_validate($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }

if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'insert' || $_POST['action'] == 'reply' ) ) {
    //print_r( $_POST ); exit('eeeeeeeeeee');
   $post_data = $_POST;
   $post_data['comment_author_email'] = filter_var($comment_author_email, FILTER_SANITIZE_EMAIL);
   // prepare and bind
   $stmt = $conn->prepare("INSERT INTO wp_bikes_comments (comment_author, comment_author_email, comment_content, comment_date, source_type, slug, page_url, comment_parent ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
   $stmt->bind_param("ssssssss", $comment_author, $comment_author_email, $comment_content, $comment_date, $source_type, $slug, $page_url, $comment_parent);

   extract($post_data);

   $stmt->execute();
   $stmt->close();

   echo json_encode( [ 'message' => "Comment successfully added" ] );

} 

if ( isset($_POST['action']) && $_POST['action'] == 'unapprove' ) {
  $id = $_POST['id'];
  $sql = "UPDATE wp_bikes_comments SET comment_approved='0' WHERE comment_ID='$id'";

  if ($conn->query($sql) === TRUE) {
    echo json_encode( [ 'message' => "Record unapproved successfully" ] );
  } else {
    echo json_encode( [ 'message' => "Error updating record: " . $conn->error ] );
  }
} elseif ( isset($_POST['action']) && $_POST['action'] == 'approve' ) {
  $id = $_POST['id'];
  $sql = "UPDATE wp_bikes_comments SET comment_approved='1' WHERE comment_ID='$id'";

  if ($conn->query($sql) === TRUE) {
   echo json_encode( [ 'message' => "Record approved successfully" ] );
  } else {
    echo json_encode( [ 'message' => "Error updating record: " . $conn->error ] );
  }
} elseif ( isset($_POST['action']) && $_POST['action'] == 'trash' ) {
  $id = $_POST['id'];
  // sql to delete a record
  $sql = "DELETE FROM wp_bikes_comments WHERE comment_ID='$id'";

  if ($conn->query($sql) === TRUE) {
    echo json_encode( [ 'message' => "Record deleted successfully" ] );
  } else {
    echo json_encode( [ 'message' => "Error deleting record: " . $conn->error ] );
  }
} elseif ( isset($_POST['action']) && $_POST['action'] == 'edit' ) {
  $id = $_POST['comment_ID'];
  
  $comment_author = $_POST['comment_author'];
  $comment_author_email = $_POST['comment_author_email'];
  $comment_content = $_POST['comment_content'];

  $sql = "UPDATE wp_bikes_comments SET comment_author='$comment_author', comment_author_email='$comment_author_email', comment_content='$comment_content' WHERE comment_ID='$id'";

  if ($conn->query($sql) === TRUE) {
    echo json_encode( [ 'message' => "Record updated successfully" ] );
  } else {
    echo json_encode( [ 'message' => "Error updating record: " . $conn->error ] );
  }
}

$conn->close();*/

?>