<?php 

session_start();

if ( ! isset( $_SESSION['login-email'] ) ) {
	$link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
	$page_url = $link . "://$_SERVER[HTTP_HOST]/custom-comments/admin/we-login-register.php";
	header('location: '. $page_url);
} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Suzuki Bandit Heavy Bike Prices 2021 Details and Pictures</title>
	<!-- <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:400,300|Josefin+Slab' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'> -->

	<link rel="stylesheet" href="/custom-comments/assets/css/style.css"  type="text/css" />
	<!-- <link rel="stylesheet" href="../css/responsive.css" type="text/css">
	<link rel="stylesheet" href="/css/icons.css" type="text/css">

	<link rel="stylesheet" href="../css/lightbox.css"  type="text/css" />
	<link rel="stylesheet" href="../css/tabcontent.css"  type="text/css" /> -->

	<script type="text/javascript" src="/custom-comments/assets//js/jquery-1.7.2.min.js"></script>
	<!-- <script type="text/javascript"	src="../js/lightbox.js"></script>
	<script type="text/javascript"	src="../js/tabcontent.js"></script> -->
	
	<!-- <link rel="icon" href="images/favicon.png" /> -->
	<base href="https://horoscopeurdu.com/">
</head>    
<body>
	


	<?php 
	$link = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? "https" : "http";
	$page_url = $link . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$parse_url = parse_url( $page_url );
	$domains = [ 'qeemat', 'bikes', 'cars', 'electronics', 'laptops', 'mobiles', 'samsunggalaxys4' ];
	$explode = explode( '.', $parse_url['host'] )[0];

	$source_type = '';
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
	$username = "admin_bikesqeemat";
	$password = "beFGKa76AK4jbpu3pyuL";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	} 

	$sql = "SELECT * FROM wp_bikes_comments WHERE source_type = 'horoscopeurdu' ";
	$result = $conn->query($sql);

	$output = [];
	while( $row = $result->fetch_assoc() ) {
		$output[] = $row;
	}

	?>

	<a href="./custom-comments/admin/logout.php"> Logout </a>

	<?php if ( $result->num_rows > 0 ) : ?>
		<div class="dashboard comment-wrap">
			<table class="comment-list">
				<thead>
					<tr>
						<td>Author</td>
						<td>Comment</td>
						<td>In Response To</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $output as $key => $value ) : ?>
						<?php 
						$comment_ID = $value['comment_ID']; 
						?>
						<tr id="comment-<?php echo $comment_ID ?>">
							<td>
								<h3><?php echo $value['comment_author'] ?></h3>
								<a href="mail:<?php echo $value['comment_author_email'] ?>">
									<?php echo $value['comment_author_email'] ?>
								</a>
								<time><?php echo date( 'M d, Y', strtotime( $value['comment_date'] ) ) ?></time>
							</td>
							<td>
								<?php 
								$comment_parent = $value['comment_parent'];
								$sql = "SELECT * FROM wp_bikes_comments WHERE comment_ID='$comment_parent'";
								$result = $conn->query($sql);
								//print_r($result->fetch_assoc()['comment_author']);//exit('eeeeeeeeeeeee');
								$data = $result->fetch_assoc();
								?>		
								<?php if ( ! empty( $data['comment_author'] ) ) : ?>
									<?php //print_r($result->fetch_assoc()); ?>
									<p>In reply to <a href="<?php echo $value['page_url'] ?>"><?php echo $data['comment_author'] ?></a></p>
								<?php endif; ?>
								<p><?php echo $value['comment_content']; ?></p>
								<div class="row-actions">
									<?php if ( $value['comment_approved'] == 0 ) : ?>
										<a href="#" class="we-approve" data-action="approve" data-id="<?php echo $comment_ID ?>">Approve</a>
									<?php else: ?>
										<a href="#" class="we-unapprove" data-action="unapprove" data-id="<?php echo $comment_ID ?>">Unapprove</a>
									<?php endif; ?>
									<a href="#" class="we-reply" 
									data-id="<?php echo $comment_ID ?>" 
									data-action="reply" 
									data-settings='<?php echo json_encode($value) ?>'
									>Reply</a>
									<a href="#" class="we-edit"
									data-id="<?php echo $comment_ID ?>"
									data-action="edit" 
									data-settings='<?php echo json_encode($value) ?>' 
									>Edit</a>
									<a href="#" class="we-trash" data-action="trash" data-id="<?php echo $comment_ID ?>">Trash</a>
								</div>
							</td>
							<td>
								<a class="response-link" href="<?php echo $value['page_url'] ?>"> 
									<?php echo $value['page_url'] ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="get-comment-form" style="display: none;">
				<form class="inser_form" action="" method="post">
					<input type="text"  name="comment_author" class="comment_author" placeholder="Name" />
					<input type="email" required name="comment_author_email" class="comment_author_email" placeholder="Email" />
					<textarea required name="comment_content" class="comment_content" placeholder="Message..."></textarea>
					<input type="hidden" name="comment_ID" class="comment_ID" value="0">
					<input type="hidden" name="action" class="action" value="">
					<input type="hidden" name="comment_date" class="comment_date" value="<?php echo date("Y-m-d h:i:s"); ?>">
					<input type="hidden" name="source_type" class="source_type" value="">
					<input type="hidden" name="slug" class="slug" value="">
					<input type="hidden" name="comment_parent" class="comment_parent" value="">
					<input type="hidden" name="page_url" class="page_url" value="">
					<button type="submit">Post Comment</button>
					<a href="#" class="cancel-comment">Cancel</a>
				</form>
			</div>
		</div>
	<?php else: ?>
		<?php echo "0 results"; ?>
	<?php endif; ?>

	<?php $conn->close(); ?>

	<script>
		$(document).ready(function($){
			$(".row-actions > .we-approve, .row-actions > .we-unapprove, .row-actions > .we-trash").on("click", function(e){
				e.preventDefault();
				var id = $(this).data('id');
				var action = $(this).data('action');

				$.ajax({
					url: "custom-comments/includes/ajax.php",
					type: "POST",
					dataType: 'json',
					data: "id=" + id + "&action=" + action,
					success: function(res) {
						alert(res.message);
						location.reload();
					}
				})
			});

			$("body").on("submit", ".inser_form", function(e){
				e.preventDefault();
				var data = $(this).serialize();

				$.ajax({
					url: "custom-comments/includes/ajax.php",
					type: "POST",
					dataType: 'json',
					data: data,
					success: function(res) {
						alert(res.message);
						location.reload();
					}
				})
			});

			$(".row-actions > .we-reply").on("click", function(e){
				e.preventDefault();
				var action = $(this).data('action');
				var settings = $(this).data('settings');

				if ( action == 'reply' ) {
					var selector = $('.get-comment-form .inser_form');
					
					// action
					var action = action;
					selector.find('.action').val(action);

					// date
					var comment_date = '<?php echo date("Y-m-d h:i:s"); ?>';
					selector.find('.comment_date').val(comment_date);

					// source type
					var source_type = settings.source_type;
					selector.find('.source_type').val(source_type);

					// slug
					var slug = settings.slug;
					selector.find('.slug').val(slug);

					// comment parent
					var id = settings.comment_ID;
					selector.find('.comment_parent').val(id);

					// page url
					var page_url = settings.page_url;
					selector.find('.page_url').val(page_url);

					$(this).parents('td').find('.inser_form').remove();
					var form = selector.prop('outerHTML');
					$(this).parents('td').append(form);
				}
			});

			$(".row-actions > .we-edit").on("click", function(e){
				e.preventDefault();
				var action = $(this).data('action');
				var settings = $(this).data('settings');

				if ( action == 'edit' ) {
					$(this).parents('td').find('.inser_form').remove();

					var selector = $('.get-comment-form .inser_form');
					var form = selector.prop('outerHTML');
					$(this).parents('td').append(form);

					var selector2 = $(this).parents('td').find('.inser_form');

					// comment author
					var action = action;
					selector2.find('.action').val(action);

					// comment author
					var comment_ID = settings.comment_ID;
					selector2.find('.comment_ID').val(comment_ID);

					// comment author
					var comment_author = settings.comment_author;
					selector2.find('.comment_author').val(comment_author);

					// comment author email
					var comment_author_email = settings.comment_author_email;
					selector2.find('.comment_author_email').val(comment_author_email);

					// comment content
					var comment_content = settings.comment_content;
					selector2.find('.comment_content').html(comment_content);

					// comment date
					var comment_date = settings.comment_date;
					selector2.find('.comment_date').val(comment_date);

					// source type
					var source_type = settings.source_type;
					selector2.find('.source_type').val(source_type);

					// slug
					var slug = settings.slug;
					selector2.find('.slug').val(slug);

					// comment parent
					var comment_parent = settings.comment_parent;
					selector2.find('.comment_parent').val(comment_parent);

					// page url
					var page_url = settings.page_url;
					selector2.find('.page_url').val(page_url);
					
				}
			});

			$('body').on('click', '.cancel-comment', function(e){
				e.preventDefault();
				$(this).parent().remove();
			});
		});
	</script>

	<script>
		$(document).ready(function($){
			$(".inser_form").on("submit", function(e){
				e.preventDefault();
				var data = $(".inser_form").serialize();
				$.ajax({
					url: "custom-comments/includes/ajax.php",
					type: "POST",
					data: data,
					success:function(data,status) {
						console.log( data );
					}
				})
			});
		});
	</script>
</body>
</html>