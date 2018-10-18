<?php include_once 'head.php'; ?>
	<div class="col-sm-9 col-lg-offset-1 col-lg-10 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">My Test Blog</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><div id="panel-container"></div>	
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><a href="add-post">Add new post</a></div>
		</div>
		<div class="row">
			<div class="panel-body" style="overflow: auto; height: 750px">
				<form id="deletePostForm">
					<?php if($User->getPosts()==null)echo "<label>Empty. Add a new post click on the link above.</label>";
					foreach ($User->getPosts() as $post):?>			
						<div class="panel panel-info">
							<div class="panel-heading"><?=$post["title"]?></div>
							<div class="panel-body post-body">
								<div><?=substr(strip_tags($post["content"]), 0, 300)?><?php if(strlen($post["content"]) > 300) echo"..."?> <a href="/post?id=<?=$post['id']?>">Read more</a></div>
								<div class="post-functions"><a class="btn btn-md btn-link" href="/edit-post?id=<?=$post['id']?>">edit</a><a class="btn btn-md btn-link deletePost" name="deletePost<?=$post["id"]?>" data-id="<?=$post["id"]?>" style="color:red !important">delete</a></div>
							</div>
						</div>
					<?php endforeach;?>
				</form>
			</div>
		</div>
	</div>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
		  $('.post-body').on('click', '.deletePost', function() { 
			  var dell = $(this).attr('data-id');
			  var dellName = $(this).attr('name');
		      $.ajax({
		          url: 'controllers/deletePost-controller.php',
		          type: "POST",
		          data: {id:dell, action:dellName},
		          success: function(data) {
			           if(data=="ok")
			           {
						 $("<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-check'>&nbsp;</em>Post successfully deleted!<a class='pull-right'></a></div> ").fadeIn(500).appendTo('#panel-container').fadeOut(1700);
			             setTimeout(function(){
			             location.reload();
			             }, 1800);  
			           }
					   else
			           {
						 $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Error deleting post. Contact your administrator!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container')
			           }
		          }
		      });
			return false;
		  });
		});
	</script>
<?php include_once 'footer.php'; ?>