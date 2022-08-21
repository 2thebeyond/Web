<?php
session_start();
$conn = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($conn, "utf8");

if ($_GET['cnik'] == $_SESSION['user_nick']){
	settype($_GET['cid'], 'integer');
	$filtered = array(
		'cid'=>mysqli_real_escape_string($conn, $_GET['cid'])
	);

	$sql = "SELECT * FROM tbl_comment WHERE comment_id = {$filtered['cid']}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);

	if ($_GET['cnik'] == $_SESSION['user_nick']){
		// $sql = "
		// 	DELETE 
		// 		FROM tbl_comment
		// 		WHERE comment_id = {$filtered['cid']}
		// ";
		$sql = "
			UPDATE tbl_comment
				SET
					isdelete = '1'
				WHERE
					comment_id = {$filtered['cid']}
		";

		$result = mysqli_query($conn, $sql);
		if ($result === false){
			echo ("<script> alert('삭제하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); </script>");
		} else {
			header('Location: ../../index.php?id='.$_SESSION['curPost_id']);
		}
	}  else{
		echo ("<script> alert('삭제할 수 없는 게시물입니다.'); </script>");
	}
} else {
	// echo $_GET['cnik'];
}
?>