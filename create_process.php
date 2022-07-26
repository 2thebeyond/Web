<?php
session_start();
$conn = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($conn, "utf8");
$filtered = array(
	'title'=>mysqli_real_escape_string($conn, $_POST['title']),
	'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);
print_r($filtered);

$sql = "
	INSERT INTO forum(
		title,
		description,
		created,
		author_id
		) VALUES(
			'{$filtered['title']}',
			'{$filtered['description']}',
			NOW(),
			'{$_SESSION['id']}'
		)
";

mysqli_set_charset($conn, "utf8");
$result2 = mysqli_query($conn, $sql);

if ($result2 === false){
	echo ("<script> alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); </script>");
	error_log(mysqli_error($conn));
} else {
	header('Location: index.php');
	//echo "<script> alert('게시물 업로드가 완료되었습니다.'); </script>";
	//echo '게시물 업로드가 완료되었습니다. <a href="index.php">돌아가기</a>';
}
echo $sql;
?>
