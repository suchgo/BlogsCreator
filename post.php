<?php include_once 'head.php'; ?>
	<div class="col-sm-9 col-lg-offset-1 col-lg-10 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><a href="/" style="text-decoration:none; color:black">My Test Blog</a></h1>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo $User->getCurrentPost()['title']?></div>
				<div class="panel-body">
					<p><?php echo $User->getCurrentPost()['content']?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="panel-container">
			</div>
		</div>
		<div class="row">
			<h3 style="margin-top:0">Add a comment</h3>
		</div>
		<div class="row">
			<div class="col-md-4" style ="padding: 0">
				<div>
					<label>Field marked as * is required</label>
					<form class="form-horizontal" id="add-comment-form" action="" method="post">
						<fieldset>
							<!-- Name input-->
							<div class="form-group">
								<label class="col-md-2 control-label" for="name" style="text-align: left">Name*</label>
								<div class="col-md-9">
									<input id="name" name="name" placeholder="Your name" class="form-control" type="text">
								</div>
							</div>
						
							<!-- Email input-->
							<div class="form-group">
								<label class="col-md-2 control-label" for="email" style="text-align: left">E-mail*</label>
								<div class="col-md-9">
									<input id="email" name="email" placeholder="Your email" class="form-control" type="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Input valid email address">
								</div>
							</div>
							
							<!-- Message body -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="message" style="text-align: left">Comment*</label>
								<div class="col-md-9">
									<textarea class="form-control" id="message" name="message" placeholder="Please enter your message here..." rows="5"></textarea>
								</div>
							</div>
							
							<!-- Form actions -->
							<div class="form-group">
								<div class="col-md-11 widget-right">
									<button type="submit" id="addComment" name="addComment" class="btn btn-primary btn-md pull-right">Send comment</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div class="row" id="comments-count">
			<h3 style="margin-top:0">Comments (<?php echo count($User->getComments())?>):</h3>
		</div>
		<div class="row">
			<div class="chat" id="comments">
				<?php foreach ($User->getComments() as $comment):?>			
					<span class="chat-img pull-left"><img src="http://placehold.it/60/30a5ff/fff" alt="User Avatar" class="img-circle"></span>
					<div class="chat-body clearfix" style="padding: 0 0 10px 94px;">
						<div class="header"><strong class="primary-font"><?=$comment['name']?></strong> <small><?=$comment['email']?></small></div>
						<span><?=$comment['text']?></span>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
		  $('#addComment').click(function() {
			  var data = $("#add-comment-form").serialize() + "&id=<?=$_GET['id']?>";
		      $.ajax({
		          url: 'controllers/comment-controller.php',
		          type: "POST",
		          data: data,
		          success: function(data) {
				   if(data=="ok")
				   {
					 $("<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-check'>&nbsp;</em>Comment successfully added!<a class='pull-right'></a></div> ").fadeIn(800).appendTo('#panel-container').fadeOut(3000);
					 $("#add-comment-form").get(0).reset();  
				   }
				   else if(data=="invalid")
					   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Invalid email address<a class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container');
				   else
					   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Fill in all the fields!<a class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container');
		          }
		      });
					return false;
		  });
		});
		$(document).ready(function() {
		  $('#addComment').click(function() {
			  var id = "<?=$_GET['id']?>";
		      $.ajax({
		          url: 'controllers/commentCount-controller.php',
		          type: "POST",
		          data: {id:id},
		          success: function(result) {
				   $('#comments-count').html(result);
		          }
		      });
					return false;
		  });
		});
		$(document).ready(function() {
		  $('#addComment').click(function() {
			  var data = $("#add-comment-form").serialize() + "&id=<?=$_GET['id']?>";
		      $.ajax({
		          url: 'controllers/commentShowNew-controller.php',
		          type: "POST",
		          data: data,
		          success: function(result) {
					 $(result).fadeIn(800).appendTo('#comments');
		          }
		      });
					return false;
		  });
		});
		$( document ).ajaxComplete(function() {
			$('.pull-right').click(function() {
				$('div.alert').fadeOut(1000);
			});
		});
	</script>		
<?php include_once 'footer.php'; ?>