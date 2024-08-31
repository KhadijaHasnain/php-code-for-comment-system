<?php

$sql = "SELECT * FROM wp_bikes_comments WHERE slug='$page_slug' AND source_type='$source_type' AND comment_approved='1'";
$result = $conn->query($sql);

$output = [];
while( $row = $result->fetch_assoc() ) {
	$output[] = $row;
}

?>

<?php function we_reply_list($id, $data) { ?>
	<?php foreach ( $data as $key => $value ) : ?>
		<?php if ( $id == $value['comment_parent'] ) :  ?>
			<ul>
				<li class="comment-<?php echo $value['comment_ID'] ?>">
					<div class="comment-list-wrap">
						<div class="comment-avatar">
							<image src="/custom-comments/assets/images/user.png" alt="user-avatar"/>
						</div>
						<div class="comment-content">
							<div class="comment-meta">
								<h3><?php echo $value['comment_author'] ?></h3>
								<time><?php echo date( 'M d, Y', strtotime( $value['comment_date'] ) ) ?></time>
							</div>
							<p><?php echo $value['comment_content']; ?></p>
							<a href="#" class="we-reply" 
							data-id="<?php echo $value['comment_ID'] ?>" 
							data-action="reply" 
							data-settings='<?php echo json_encode($value) ?>'
							>Reply</a>
						</div>
					</div>
					<?php we_reply_list($value['comment_ID'], $data); ?>
				</li>
			</ul>
		<?php endif; ?>
	<?php endforeach; ?>
<?php } ?>

<?php function we_comment_list( $data ) { ?>
	<?php foreach ( $data as $key => $value ) : ?>
			<?php 
			$comment_ID = $value['comment_ID']; 
			?>
			<?php if ( $value['comment_parent'] == '0' ) : ?>
				<li id="comment-<?php echo $comment_ID ?>">
					<div class="comment-list-wrap">
						<div class="comment-avatar">
							<image src="/custom-comments/assets/images/user.png" alt="user-avatar"/>
						</div>
						<div class="comment-content">
							<div class="comment-meta">
								<h3><?php echo $value['comment_author'] ?></h3>
								<time><?php echo date( 'M d, Y', strtotime( $value['comment_date'] ) ) ?></time>
							</div>
							<p><?php echo $value['comment_content']; ?></p>
							<a href="#" class="we-reply" 
							data-id="<?php echo $value['comment_ID'] ?>" 
							data-action="reply" 
							data-settings='<?php echo json_encode($value) ?>'
							>Reply</a>
						</div>
					</div>
					<?php we_reply_list( $comment_ID, $data ); ?>
				</li>
			<?php endif; ?>
	<?php endforeach; ?>
<?php	} ?> 