<?php include_once 'head.php'; ?>

	<div class="col-sm-9 col-lg-offset-1 col-lg-10 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><a href="/" style="text-decoration:none; color:black">My Test Blog</a></h1>
			</div>
		</div>
		<div class="row">
			<div id="panel-container">
			</div>
		</div>
		<div class="row">
			<h3 style="margin-top:0">Add new post</h3>
		</div>
		<form id="add-post-form" action="" method="post">
			<div class="row">
				<div class="form-group">
					<input required autofocus title="Please fill this field." id="title" name="title" placeholder="Title" class="form-control" type="text">
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<textarea required class="form-control" id="message" name="message"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<button type="submit" id="save" name="save" class="btn btn-primary btn-md pull-right" style="margin-left: 30px;">Save</button>
					<a href="/" id="cancel" name="cancel" class="btn btn-primary btn-md pull-right">Cancel</a>
				</div>
			</div>
		</form>
	</div>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<!-- Include Editor style. -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_style.min.css" rel="stylesheet" type="text/css" />
	<!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
 
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/js/froala_editor.pkgd.min.js"></script>
 
    <!-- Initialize the editor. -->
    <script> $(function() { $('textarea').froalaEditor() }); </script>
	
	<script>
		$(document).ready(function() {
		  $('#save').click(function() {
			  var data = $("#add-post-form").serialize();
		      $.ajax({
		          url: 'controllers/addPost-controller.php',
		          type: "POST",
		          data: data,
		          success: function(data) {
				   if(data=="ok")
				   {
					 $("<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-check'>&nbsp;</em>Post successfully added!<a class='pull-right'></a></div> ").fadeIn(800).appendTo('#panel-container').fadeOut(3000);
					 $("#add-post-form").get(0).reset(); 
				   }
				   else
					   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Fill in all the fields!<a class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container');
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