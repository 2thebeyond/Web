<?php
session_start();
$conn = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($conn, "utf8");

$query = "SELECT * FROM forum WHERE id = {$_SESSION['curPost_id']}";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$author['author_id'] = htmlspecialchars($row['author_id']);

settype($_POST['id'], 'integer');
$filtered = array(
	'id'=>mysqli_real_escape_string($conn, $_POST['id']),
	'title'=>mysqli_real_escape_string($conn, $_POST['title']),
	'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);

if ($_SESSION['id'] == $author['author_id'])
{
	settype($_POST['id'], 'integer');
	$filtered = array(
		'id'=>mysqli_real_escape_string($conn, $_POST['id']),
		'title'=>mysqli_real_escape_string($conn, $_POST['title']),
		'description'=>mysqli_real_escape_string($conn, $_POST['description'])
	);

	$sql = "
		UPDATE forum
			SET
				title = '{$filtered['title']}',
				description = '{$filtered['description']}'
			WHERE
				id = {$filtered['id']}
	";
	$result = mysqli_query($conn, $sql);
	
	if ($result == false)
	{
		echo ("<script> alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. </script>");
		error_log(mysqli_error($conn));
	} 
	else 
	{
		header('Location: ../../index.php?id='.$filtered['id']);
	}
} 
else 
{
	echo ("<script> alert('잘못된 접근입니다.') </script>");
	header('Refresh: 0; URL=../../index.php');
}
?>