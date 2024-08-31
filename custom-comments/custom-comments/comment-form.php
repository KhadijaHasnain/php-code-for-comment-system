<?php include "db-config.php"; ?>
<?php include "comments-list.php"; ?>
<div class="container" style="padding:20px 0px;">
	<div class="comment-wrap">
		<?php //phpinfo(); ?>
		<?php if ( $result->num_rows > 0 ) : ?>
			<ul class="comment-list">
				<?php we_comment_list($output); ?>
			</ul>
		<?php else: ?>
			<?php echo "<span class='zero-result'>You will be the first to comment here.<span>"; ?>
		<?php endif; ?>

		<form id="topbutton" class="inser_form" action="" method="post
">
			<div class="comment-row">
				<div class="comment-col-50">
					<input type="text" required name="comment_author" class="comment_author" placeholder="Name" />
				</div>
				<div class="comment-col-50">
					<input type="email" required name="comment_author_email" class="comment_author_email" placeholder="Email" />
				</div>
			</div>
			<div class="comment-row">
				<div class="comment-col">
					<textarea required name="comment_content" class="comment_content" placeholder="Message..."></textarea>
				</div>
			</div>
			<input type="hidden" name="action" class="action" value="insert">
			<input type="hidden" name="comment_date" class="comment_date" value="<?php echo date("Y-m-d h:i:s"); ?>">
			<input type="hidden" name="source_type" class="source_type" value="<?php echo $source_type; ?>">
			<input type="hidden" name="slug" class="slug" value="<?php echo $page_slug; ?>">
			<input type="hidden" name="comment_parent" class="comment_parent" value="<?php echo $comment_parent; ?>">
			<input type="hidden" name="page_url" class="page_url" value="<?php echo $page_url; ?>">
			<div class="comment-row">
				<div class="comment-col">
					<button type="submit">Post Comment</button>
					<a href="#" class="cancel-comment">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>


<?php $conn->close(); ?>

<script>
	$(document).ready(function($){
		$("body").on("submit", '.inser_form', function(e){
			e.preventDefault();
			var data = $(this).serialize();
			$.ajax({
				url: "../custom-comments/includes/ajax.php",
				type: "POST",
				dataType: 'json',
				data: data,
				success:function(res) {
					alert(res.message);
					location.reload();
				}
			})
		});
	});

	$(".comment-wrap .we-reply").on("click", function(e){
		e.preventDefault();
		var action = $(this).data('action');
		var settings = $(this).data('settings');

		if ( action == 'reply' ) {
			var selector = $('.comment-wrap > .inser_form');

			$(this).parents('.comment-list-wrap').find('.inser_form').remove();
			var form = selector.prop('outerHTML');
			$(this).parents('.comment-list-wrap').append(form);

			var selector2 = $(this).parents('.comment-list-wrap').find('.inser_form');
			
			// action
			var action = action;
			selector2.find('.action').val(action);

			// date
			var comment_date = '<?php echo date("Y-m-d h:i:s"); ?>';
			selector2.find('.comment_date').val(comment_date);

			// source type
			var source_type = settings.source_type;
			selector2.find('.source_type').val(source_type);

			// slug
			var slug = settings.slug;
			selector2.find('.slug').val(slug);

			// comment parent
			var id = settings.comment_ID;
			selector2.find('.comment_parent').val(id);

			// page url
			var page_url = settings.page_url;
			selector2.find('.page_url').val(page_url);
		}
	});

	$('body').on('click', '.cancel-comment', function(e){
		e.preventDefault();
		$(this).parents('.comment-list-wrap').find('.inser_form').remove();
	});
</script>