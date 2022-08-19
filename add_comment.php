<?php
session_start();
//add_comment.php

$connect = new PDO('mysql:host=localhost;dbname=level1;charset=utf8', 'root', 'test');

$error = '';
$comment_name = '';
$comment_content = '';
$board_id = '';

if(empty($_SESSION["id"]))
{
	$error .= '<p class="text-danger">Name is required</p>';
	echo "<script>console.log('Console: " . $_SESSION["id"] . "' );</script>";
} else {
	$comment_name = $_SESSION["id"];
}

if(empty($_POST["comment_content"]))
{
	$error .= '<p class="text-danger">Comment is required</p>';
} else {
	$comment_content = $_POST["comment_content"];
}

if(empty($_SESSION['curPost_id'])){
	$error .= '<p class="text-danger">Board Num is required</p>';
} else {
	$board_id = $_SESSION['curPost_id'];
}


if($error == '')
{
	$query = "
	INSERT INTO tbl_comment 
	(board_id, parent_comment_id, comment, comment_sender_name) 
	VALUES (:board_id, :parent_comment_id, :comment, :comment_sender_name)
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
		 ':board_id'			=>	$board_id,
		 ':parent_comment_id'	=>	$_POST["comment_id"],
		 ':comment'				=>	$comment_content,
		 ':comment_sender_name' =>	$comment_name
 		)
	);
	$error = '<label class="text-success">Comment Added</label>';
	
}
$data = array(
 'error'  => $error
);
echo json_encode($data);
?>