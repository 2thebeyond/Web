<html>
	<head>
		<meta charset="utf-8"/>
	</head>
</html>
<?php
$conn = mysqli_connect(
	'localhost', 
	'root', 
	'test', 
	'opentutorials');

$filtered = array(
	'title'=>mysqli_real_escape_string($conn, $_POST['title']),
	'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);
print_r($filtered);

$sql = "
	INSERT INTO topic(
		title,
		description,
		created
		) VALUES(
			'{$filtered['title']}',
			'{$filtered['description']}',
			NOW()
		)
";
// '{$filtered['title']}',
// '{$filtered['description']}',

mysqli_set_charset($conn, "utf8");
$result = mysqli_query($conn, $sql);

// mysqli_query($conn, "set session character_set_connection=utf8;");
// mysqli_query($conn, "set session character_set_results=utf8;");
// mysqli_query($conn, "set session character_set_client=utf8;");

// mysqli_query($conn, "set session character_set_database=utf8;");
// mysqli_query($conn, "set session character_set_server=utf8;");
// mysqli_query($conn, "set session character_set_system=utf8;");

if ($result === false){
	echo ("<script> alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); </script>");
	//echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.';
	error_log(mysqli_error($conn));
} else {
	header('Location: index.php');
	//echo "<script> alert('게시물 업로드가 완료되었습니다.'); </script>";
	//echo '게시물 업로드가 완료되었습니다. <a href="index.php">돌아가기</a>';
	//header('Location: /index.php');
}
echo $sql;


// file_put_contents('data/'.$_POST['title'], $_POST['description']);
// header('Location: /index.php?id='.$_POST['title']);
?>
