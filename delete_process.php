<?php
session_start();
$conn = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($conn, "utf8");

settype($_POST['id'], 'integer');
$filtered = array(
	'id'=>mysqli_real_escape_string($conn, $_POST['id'])
);

$sql = "SELECT * FROM forum WHERE id = {$filtered['id']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$article['author_id'] = htmlspecialchars($row['author_id']);

if ($_SESSION['id'] == $article['author_id']){
	$sql = "
		DELETE 
			FROM forum
			WHERE id = {$filtered['id']}
	";
	
	$result = mysqli_query($conn, $sql);
	if ($result === false){
		echo ("<script> alert('삭제하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); </script>");
	} else {
		header('Location: index.php');
	}
}  else{
	echo ("<script> alert('삭제할 수 없는 게시물입니다.'); </script>");
}
?>