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
	<h1 class="header"><a href="index.php">Web</a></h1>
	<div id="grid">
		<div class="nav">
			<div class="nav_header">
				<div class="nav_btns" style="width: 
											 <?php if(isset($_GET['id'])) { ?> 520px; <?php } else { ?>
											 195px; <?php } ?> "> 
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button>
				<?php if(isset($_GET['id'])) { ?>
					<button class="nav_btn" type="button" onclick="location.href='update.php?id=<?=htmlspecialchars($_GET['id'])?>'">수정</button>
					<button class="nav_btn" type="submit" form="delete" style="color:red;">삭제</button>
						<form id="delete" action="delete_process.php" method="post">
							<input type="hidden" name="id" value="<?=htmlspecialchars($_GET['id'])?>">
						</form>
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
			<h2>
				<?php 
				print_title();
				?>
			</h2>
			<p style="overflow: auto;">
				<?php
				print_description();	
				?>
			</p>
		</div>
	</div>
	<div class="footer">
		<input id="darkmode" class="button" type="button" value="Dark Mode" onclick="
		darkmodeHandler(this);	
	">
	</div>
</body>
</html>