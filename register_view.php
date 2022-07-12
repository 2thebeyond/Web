<!doctype html>
<html lang='kor'>
<head>
	<meta charset="utf-8">
	
	<title>회원가입</title>
	<link rel="stylesheet" type="text/css" href="join.css">
</head>	
<body>
	<form action="register_server.php" method="post">
		<div class="input_section">
			<div class="center">
				<div class="title">
					<h1>회원가입</h1>
				</div>

				<?php if(isset($_GET['error'])) { ?>
				<p class ="error"><?php echo $_GET['error']; ?></p>
				<?php } ?>	
				
				<div class="input_part">
					<label class="label">아이디</label>
					<input class="input_box" type="text" placeholder="아이디" name="user_id">
				</div>

				<div class="input_part">
					<label class="label">닉네임</label>
					<input class="input_box" type="text" placeholder="닉네임" name="user_name">
				</div>

				<div class="input_part">
					<label class="label">비밀번호</label>
				<input class="input_box" type="password" placeholder="비밀번호" name="password1">
				</div>

				<div class="input_part">
					<label class="label">비밀번호 확인</label>
					<input class="input_box" type="password" placeholder="비밀번호 확인" name="password2">
				</div>

				<div class="input_part">
					<input class="submit_btn" type="submit" value="회원가입" name="save">
					<a href = "" class="text">이미 회원이신가요?</a>
					
				</div>
			</div>

		</div>
	</form>
</body>
</html>