<?php
session_start();
include  $_SERVER['DOCUMENT_ROOT'].'/_app/functions/functions.php';
$GLOBALS['error_db_user'];
$GLOBALS['error_log_user'];

class User
{ 

  private $conn;

  
  public function __construct()
  {
    $database = new Database();
    $db = $database->dbConnection();
    $this->conn = $db;
  }
  
  public function __destruct()
  {
    $this->db = null;
  }

  public function runQuery($sql)
  {
    $stmt = $this->conn->prepare($sql);
    return $stmt;
  }

  public function lasdID()
  {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
  }

  public function getPosts()
  {
    try
    {  
      $stmt = $this->runQuery("SELECT * FROM posts ORDER BY id DESC");
      $stmt->execute();
      $postRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $postRow;
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }
  
  public function editPost() {

    try {
		$postID = $_POST['id'];
		$title = $_POST['title'];
		$content = $_POST['message'];
		if (!empty($postID) && !empty($title) && !empty($content)) {
			$stmt = $this->runQuery("UPDATE posts SET title=:title, content=:content WHERE id=:id");
			$stmt->bindValue(":id", $postID);
			$stmt->bindValue(":title", $title);
			$stmt->bindValue(":content", $content);			
			$stmt->execute();
			echo "ok";
		}
	}
    catch(PDOException $e)
    {
      echo "<div class='alert bg-denger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>An error has occurred. Contact your administrator!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
    }

  }
  
  public function addPost() {

    try {
		$title = $_POST['title'];
		$content = $_POST['message'];
		if (!empty($title) && !empty($content)) {
			$stmt = $this->runQuery("INSERT INTO posts (title, content) 
									VALUES (:title, :message)");
			$stmt->bindValue(":title", $title);
			$stmt->bindValue(":message", $content);
			$stmt->execute();
			echo "ok";
		}
	}
    catch(PDOException $e)
    {
      echo "Ошибка. Что-то не так... Свяжитесь с администратором!";
    }

  }
  
  public function deletePost()
  {
    try
    {
	  $idForDell = $_POST['id'];
      $stmt = $this->runQuery("DELETE FROM posts WHERE id=:id");
	  $stmt->bindValue(":id", $idForDell);
	  $stmt->execute();
	  $stmt = $this->runQuery("DELETE FROM comments WHERE post_id=:id");
	  $stmt->bindValue(":id", $idForDell);
	  $stmt->execute();
	  echo "ok";
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }
  
  public function getCurrentPost()
  {
    try
    {
		$postID = $_GET['id'];
		$stmt = $this->runQuery("SELECT * FROM posts WHERE id=:id");
		$stmt->bindValue(":id", $postID);
		$stmt->execute();
		$currentPostRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $currentPostRow;
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }
  
  public function getComments()
  {
    try
    {
	  $postID = $_GET['id'];
      $stmt = $this->runQuery("SELECT * FROM comments WHERE post_id=:id");
	  $stmt->bindValue(":id", $postID);
      $stmt->execute();
      $commentRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $commentRow;
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }
  
  public function addNewComment()
  {
    try{
		$postID = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			echo "invalid";
		else{
			if (!empty($name) && !empty($email) && !empty($message)) {
			$stmt = $this->runQuery("INSERT INTO comments (post_id, name, email, text) 
									VALUES (:id, :name, :email, :message)");
			$stmt->bindValue(":id", $postID);
			$stmt->bindValue(":name", $name);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":message", $message);
			$stmt->execute();
			echo "ok";
			}
		}
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }
  }
  
  public function getCommentsCount()
  {
    try
    {
	  $postID = $_POST['id'];
      $stmt = $this->runQuery("SELECT * FROM comments WHERE post_id=:id");
	  $stmt->bindValue(":id", $postID);
      $stmt->execute();
      $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo '<h3 style="margin-top:0">Comments ('.count($comments).'):</h3>';
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }

  public function showNewComment()
  {
    try{
		$postID = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			if (!empty($name) && !empty($email) && !empty($message)) {
			$stmt = $this->runQuery("SELECT * FROM comments WHERE post_id=:id ORDER BY ID DESC LIMIT 1");
			$stmt->bindValue(":id", $postID);
			$stmt->execute();
			$comment = $stmt->fetch(PDO::FETCH_ASSOC);
			echo '<span class="chat-img pull-left"><img src="http://placehold.it/60/30a5ff/fff" alt="User Avatar" class="img-circle"></span>
				  <div class="chat-body clearfix" style="padding: 0 0 10px 94px;">
					<div class="header"><strong class="primary-font">'.$comment['name'].'</strong> <small>'.$comment['email'].'</small></div>
					<span>'.$comment['text'].'</span>
				  </div>';
		}
		}
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }
  }
  
  public function getError($error)
  {
    if(isset($error)) 
    {
      foreach($error as $error) 
      {
        echo $error;
      }
    }
    return true;
  }

  public function redirect($url)
  {
      echo '<script>window.location.href = "'.$url.'"</script>';
  }
}
