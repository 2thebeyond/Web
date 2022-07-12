<?php
$conn = mysqli_connect(
	'localhost', 
	'root', 
	'test', 
	'opentutorials');

settype($_POST['id'], 'integer');
$filtered = array(
	'id'=>mysqli_real_escape_string($conn, $_POST['id']),
	'title'=>mysqli_real_escape_string($conn, $_POST['title']),
	'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);
print_r($filtered);

$sql = "
	UPDATE topic
		SET
			title = '{$filtered['title']}',
			description = '{$filtered['description']}'
		WHERE
			id = {$filtered['id']}
";
// '{$filtered['title']}',
// '{$filtered['description']}',

//$sqli_set_charset($conn, "utf8");
mysqli_set_charset($conn, "utf8");
$result = mysqli_query($conn, $sql);


if ($result === false){
	echo ("<script> alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. </script>");
	//error_log(mysqli_error($conn));
} else {
	header('Location: /index.php?id='.$filtered['id']);
}
echo $sql;

// rename('data/'.$_POST['old_title'], 'data/'.$_POST['title']);
// file_put_contents('data/'.$_POST['title'], $_POST['description']);
// header('Location: /index.php?id='.$_POST['title']);
?>