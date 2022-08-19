<?php
session_start();
?>
<!doctype html>
<html lang='kor'>
<head>
	<meta charset="utf-8">
	<title>마이페이지</title>
	<link rel="stylesheet" type="text/css" href="mypage.css">
</head>	
<body>
	<div class="mypage_field">
		<div class="centered">
			<div class="form_mypage">
				<div class="title">
					<h1>마이페이지</h1>
				</div>
				<?php if(isset($_SESSION['id'])) { ?>
				
				<div class="message">
					<p class ="welcome"><?php echo $_SESSION['user_nick'];?> 회원님 환영합니다!</p>
				</div>
				<table class="table">
					<tr>
						<th>가입 순서</th>
						<td><?php echo $_SESSION['id'];?></td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><?php echo $_SESSION['user_id'];?></td>
					</tr>
				</table>
				<div class="nav_footer">
					<div class="nav_footer_btns">
						<button class="logout_btn" onclick="location.href='logout.php'">로그아웃</button>
					</div>
				</div>
				<?php } else { echo header("location: ../index.php"); }?>
				<div class="label_link">
					<div class="text" id="text" onclick="location.href='../index.php';">메인 페이지로 돌아가기</div>
					
					<!-- <a href = "../index.php" class="text">메인 페이지로 돌아가기</a> -->
				</div>
			</div>
		</div>
	</div>	
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/git/jquery-git.slim.js"></script>
	<script src="../theme-toggle/colors.js"></script>
</body>
</html>
<script>loadTheme();</script>