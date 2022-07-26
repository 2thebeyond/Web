<?php
session_start();
$db = mysqli_connect('localhost','root','test','level1');
mysqli_set_charset($db, "utf8");

// register server
if (isset($_POST['user_id']) && isset($_POST['user_nick']) && isset($_POST['password1']) && isset($_POST['password2']))
{
	$uid = mysqli_real_escape_string($db, $_POST['user_id']);
	$unick = mysqli_real_escape_string($db, $_POST['user_nick']);
	$pwd = mysqli_real_escape_string($db, $_POST['password1']);
	$pwdCheck = mysqli_real_escape_string($db, $_POST['password2']);
	
	if (empty($uid)){
		header("location: register_view.php?error=아이디가 비어있어요.");
		exit();
	} else if (empty($unick)){
		header("location: register_view.php?error=닉네임이 비어있어요.");
		exit();
	} else if (empty($pwd)){
		header("location: register_view.php?error=비밀번호가 비어있어요.");
		exit();
	} else if (empty($pwdCheck)){
		header("location: register_view.php?error=비밀번호 확인이 비어있어요.");
		exit();
	} else if ($pwd !== $pwdCheck){
		header("location: register_view.php?error=비밀번호가 일치하지 않습니다.");
		exit();
	} else {
		$hash = password_hash($pwd, PASSWORD_DEFAULT); // 단방향 암호화
		
		$sql_id_overlap = "SELECT * FROM member where user_id = '$uid'";
		$sql_nickName_overlap = "SELECT * FROM member where user_nick = '$unick'";

		$id_overlapCheck = mysqli_query($db, $sql_id_overlap);
		$nick_overlapCheck = mysqli_query($db, $sql_nickName_overlap);

		if (mysqli_num_rows($id_overlapCheck) > 0){
			header("location: register_view.php?error=중복되는 아이디가 존재합니다.");
			exit();
		} else if (mysqli_num_rows($nick_overlapCheck) > 0){
			header("location: register_view.php?error=중복되는 닉네임이 존재합니다.");
			exit();
		} else {
			$sql_save = "insert into member(user_id, user_nick, password) values('$uid', '$unick', '$hash')";
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
} 
// login server
else if (isset($_POST['user_id']) && isset($_POST['password']))
{
	$uid = mysqli_real_escape_string($db, $_POST['user_id']);
	$pwd = mysqli_real_escape_string($db, $_POST['password']);
	
	if (empty($uid)){
		header("location: login_view.php?error=아이디가 비어있어요.");
		exit();
	} else if (empty($pwd)){
		header("location: login_view.php?error=비밀번호가 비어있어요.");
		exit();
	} else {
		$sql = "select * from member where user_id = '$uid'";
		$result = mysqli_query($db, $sql);
		
		if (mysqli_num_rows($result) === 1){
			$row = mysqli_fetch_assoc($result);
			$hash = $row['password'];
			
			if (password_verify($pwd, $hash)){
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['user_nick']= $row['user_nick'];
				$_SESSION['id'] = $row['id'];
				
				//header("location: login_view.php?success=로그인에 성공하였습니다.");
				header("location: mypage/mypage_view.php");
				exit();
			} else {
				header("location: login_view.php?error=로그인에 실패하였습니다.");
				exit();
			} 
		} else {
			header("location: login_view.php?error=아이디가 잘못되었습니다.");
			exit();
		}
	} 
} 

else 
{
	header("location: login_view.php?error=알 수 없는 오류가 발생하였습니다.");
	exit();
}
?> 