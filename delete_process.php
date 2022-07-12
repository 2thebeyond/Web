<?php
$conn = mysqli_connect(
	'localhost', 
	'root', 
	'test', 
	'opentutorials');

settype($_POST['id'], 'integer');
$filtered = array(
	'id'=>mysqli_real_escape_string($conn, $_POST['id'])
);
print_r($filtered);

$sql = "
	DELETE 
		FROM topic
		WHERE id = {$filtered['id']}
";
// '{$filtered['title']}',
// '{$filtered['description']}',

//$sqli_set_charset($conn, "utf8");
mysqli_set_charset($conn, "utf8");
$result = mysqli_query($conn, $sql);
if ($result === false){
	echo ("<script> alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); </script>");
	//error_log(mysqli_error($conn));
} else {
	header('Location: /index.php');
}
echo $sql;

// unlink('data/'.basename($_POST['id']);
// header('Location: /index.php');
?>