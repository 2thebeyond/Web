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
	<script src="characters.js"></script>
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
</head>
<body>
	<h1 class="header"><a href="index.php">WEB</a></h1>
	<div id="grid">
		<div class="nav">
			<div class="nav_header">
				<div class="nav_btns" style="width:360px;">
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button>
					<?php if(isset($_GET['id'])) { ?>
					<button class="nav_btn" type="button" onclick="location.href='update.php?id=<?=htmlspecialchars($_GET['id']);?>'">수정</button>
					<?php } ?>
				</div>
			</div>
			<ol class="list">
				<?php
				print_list();
				?>
			</ol>
		</div>
		<div id="article">
			<form action="update_process.php" method="post">
				<input type="hidden" name="old_title" value="<?=htmlspecialchars($_GET['id'])?>">
				<p>
					<input class="title" type="text" name="title" placeholder="제목" onkeyup="characterCheck(this)" onkeydown="characterCheck(this)" onchange="characterCheck(this)" maxlength="30" value="<?php print_title(); ?>">
				</p>
				<p>
					<textarea class="description" name="description" placeholder="내용"><?php print_description(); ?></textarea>
				</p>
				<p>
					<input class="button" type="submit" value="수정 완료">
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