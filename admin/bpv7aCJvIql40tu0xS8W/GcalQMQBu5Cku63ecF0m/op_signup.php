<?php
session_start();
$db = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($db, "utf8");

// login server
if (isset($_POST['op_id']) && isset($_POST['password']))
{
	$oid = mysqli_real_escape_string($db, $_POST['op_id']);
	$pwd = mysqli_real_escape_string($db, $_POST['password']);
	
	if (empty($oid)){
		header("location: op_login_view.php?error=아이디가 비어있어요.");
		exit();
	} else if (empty($pwd)){
		header("location: op_login_view.php?error=비밀번호가 비어있어요.");
		exit();
	} else {
		$sql = "select * from op where op_id = '$oid'";
		$result = mysqli_query($db, $sql);
		
		if (mysqli_num_rows($result) === 1){
			$row = mysqli_fetch_assoc($result);
			$hash = $row['password'];
			
			if (password_verify($pwd, $hash)){
				$_SESSION['op_id'] = $row['op_id'];
				$_SESSION['op_nick']= $row['op_nick'];
				$_SESSION['id'] = $row['id'];
				
				//header("location: login_view.php?success=로그인에 성공하였습니다.");
				// header("location: mypage/mypage_view.php");
				exit();
			} else {
				header("location: op_login_view.php?error=로그인에 실패하였습니다.");
				exit();
			} 
		} else {
			header("location: op_login_view.php?error=아이디가 잘못되었습니다.");
			exit();
		}
	} 
} 

else 
{
	header("location: op_login_view.php?error=알 수 없는 오류가 발생하였습니다.");
	exit();
}
?> 
<html>
	<head>
		<meta name="robots" content="noindex, nofolloew"/>
	</head>
</html>