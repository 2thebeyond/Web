<?php
	
$db = mysqli_connect('localhost','root','test','level1');

if (isset($_POST['save'])){
	$uid = mysqli_real_escape_string($db, $_POST['user_id']);
	$uname = mysqli_real_escape_string($db, $_POST['user_name']);
	$pwd1 = mysqli_real_escape_string($db, $_POST['password1']);
	$pwd2 = mysqli_real_escape_string($db, $_POST['password2']);
	
	if (empty($uid)){
		header("location: register_view.php?error=아이디가 비어있어요.");
		exit();
		// echo 
		// "<script> 
		// alert('아이디를 입력해주세요.');
		// history.back();
		// location.replace('register_view.php');
		// </script>";
	} else if (empty($uname)){
		header("location: register_view.php?error=닉네임이 비어있어요.");
		exit();
	} else if (empty($pwd1)){
		header("location: register_view.php?error=비밀번호가 비어있어요.");
		exit();
	} else if (empty($pwd2)){
		header("location: register_view.php?error=비밀번호 확인이 비어있어요.");
		exit();
	} else if ($pwd1 !== $pwd2){
		header("location: register_view.php?error=비밀번호가 일치하지 않습니다.");
		exit();
	} else {
		$pass1 = password_hash($pass1, PASSWORD_DEFAULT); // 단방향 암호화
	
		$sql_id_overlap = "SELECT * FROM member where user_id = '$uid'";
		$sql_nickName_overlap = "SELECT * FROM member where user_name = '$uname'";

		$id_overlapCheck = mysqli_query($db, $sql_id_overlap);
		$nick_overlapCheck = mysqli_query($db, $sql_nickName_overlap);

		if (mysqli_num_rows($id_overlapCheck) > 0){
			header("location: register_view.php?error=중복되는 아이디가 존재합니다.");
			exit();
		} else if (mysqli_num_rows($nick_overlapCheck) > 0){
			header("location: register_view.php?error=중복되는 닉네임이 존재합니다.");
			exit();
		} else {
			$sql_save = "insert into member(user_id, user_name, password) values('$uid', '$uname', '$pass1')";
			$result = mysqli_query($db, $sql_save);
			
			if($result){
				header("location: register_view.php?success=성공적으로 가입되었습니다.");
				exit();
			} else {
				header("location: register_view.php?error=가입에 실패하였습니다.");
				exit();
			}
		}
	}
} else {
	// blank
}
?> 