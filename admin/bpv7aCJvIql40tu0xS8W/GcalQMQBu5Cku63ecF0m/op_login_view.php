<?php
session_start();
?>
<!doctype html>
<html lang='kor'>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex, nofolloew"/>
	<title>관리자용 로그인</title>
	<link rel="stylesheet" type="text/css" href="../../../join.css">
</head>	
<body>
	<!-- <form action="login_server.php" method="post"> -->
	<form action="op_signup.php" method="post">
		<div class="input_section">
			<div class="center">
				<div class="form_login">
					<div class="title">
						<h1>관리자 로그인</h1>
					</div>
					<div class="message">
						<?php if(isset($_GET['error'])) { ?>
						<p class ="error"><?php echo $_GET['error']; ?></p>
						<?php } ?>
						<?php if(isset($_GET['success'])) { ?>
						<p class ="success"><?php echo $_GET['success']; ?></p>
						<?php } ?>	
					</div>
					<div class="input_fields">
						<div class="input_part">
							<label class="label">이메일</label>
							<input class="input_box" type="text" placeholder="이메일" name="op_id">
						</div>

						<div class="input_part">
							<label class="label">비밀번호</label>
							<input class="input_box" type="password" placeholder="비밀번호" name="password">
						</div>

						<div class="input_part">
							<input class="submit_btn" type="submit" value="로그인" name="login_btn"/>
						</div>
					</div>
					<!-- <div class="label_link">
						<div class="text" id="text" onclick="location.href='register_view.php';">아직 회원이 아니신가요? <br> (회원가입)</div>
					</div> -->
				</div>
			</div>
		</div>	
	</form>
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/git/jquery-git.slim.js"></script>
	<script src="../../../colors.js"></script>
</body>
</html>