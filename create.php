<?php 
require('lib/print.php');
?>
<!doctype html>
<html>
<head>
	<title>
		<?php 
		print_title();
		?>
	</title>
	<meta charsett="utf-8"/>
	<link rel="stylesheet" href="style.css"/>
	<script src="colors.js"></script>
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
</head>
<body>
	<h1 class="header"><a href="index.php">WEB</a></h1>
	<div id="grid">
		<div class="nav">
			<div class="nav_header">
				<div class="nav_btns" style="width: 195px;">
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button>
				</div>
			</div>
			<ol class="list">
				<?php
				print_list();
				?>
			</ol>
		</div>
		<div id="article">
			<form action="create_process.php" method="post">
				<p>
					<input class="title" type="text" name="title" placeholder="제목">
				</p>
				<p>
					<textarea class="description" name="description" placeholder="내용"></textarea>
				</p>
				<p>
					<input class="button" type="submit" value="작성 완료">
				</p>
			</form>
		</div>
	</div>
	<div class="footer">
		<input id="darkmode" class="button" type="button" value="Dark Mode" onclick="
		darkmodeHandler(this);	
	">
	</div>
</body>
</html>