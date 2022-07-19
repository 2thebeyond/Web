<!doctype html>
<html lang='kor'>
<head>
	<meta charset="utf-8">
	<title>로그인</title>
	<link rel="stylesheet" type="text/css" href="join.css">
</head>	
<body>
	<!-- <form action="login_server.php" method="post"> -->
	<form action="signup.php" method="post">
		<div class="input_section">
			<div class="center">
				<div class="form_login">
					<div class="title">
						<h1>로그인</h1>
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
							<label class="label">아이디</label>
							<input class="input_box" type="text" placeholder="아이디" name="user_id">
						</div>

						<div class="input_part">
							<label class="label">비밀번호</label>
							<input class="input_box" type="password" placeholder="비밀번호" name="password">
						</div>

						<div class="input_part">
							<input class="submit_btn" type="submit" value="로그인" name="login_btn"/>
						</div>
					</div>
					<div class="label_link">
						<a href = "register_view.php" class="text">아직 회원이 아니신가요? <br> (회원가입)</a>
					</div>
				</div>
			</div>
		</div>	
	</form>
</body>
</html>