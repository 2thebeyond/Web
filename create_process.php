<?php
session_start();
mysqli_set_charset($conn, "utf8");
$conn = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($conn, "utf8");
$sql = "SELECT * FROM member WHERE id = {$_SESSION['id']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$article['user_nick'] = htmlspecialchars($row['user_nick']);

if (empty($article['user_nick'])){
	// 계정이 존재하지 않는 회원	
	echo ("<script> alert('계정이 존재하는지 확인해주세요.') </script>");
	header('Refresh: 0; URL=mypage/logout.php');
} else {
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
	mysqli_set_charset($conn, "utf8");

	if ($result2 === false){
		echo ("<script> alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); </script>");
		error_log(mysqli_error($conn));
	} else {
		header('Location: index.php');
		//echo "<script> alert('게시물 업로드가 완료되었습니다.'); </script>";
	}
	echo $sql;
}
?>
