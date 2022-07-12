<?php 
require('lib/print.php');
$conn = mysqli_connect(
	'localhost',
	'root',
	'test',
	'opentutorials');
$sql = "SELECT * FROM topic";
mysqli_set_charset($conn, "utf8");
$result = mysqli_query($conn, $sql);
$list = '';
while($row = mysqli_fetch_array($result)){
	$list = $list."<li><a href=\"index.php?id={$row['id']}\">{$row['title']}</a></li>";
}

$article = array(
	'title'=>'Welcome :)',
	'description'=>'홈페이지에 오신 것을 환영합니다.'
);
$title = 'Welcome :)';
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
	$sql = "SELECT * FROM topic WHERE id = {$filtered_id}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	$article['title'] = htmlspecialchars($row['title']);
	$article['description'] = htmlspecialchars($row['description']);
}
//print_r($article);
?>
<!doctype html>
<html>
<head>
	<title>
		<?php 
		echo $article['title'];
		?>
	</title>
	<meta charset="utf-8"/>
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
				<div class="nav_post_btns" style="width: 195px;">
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button>
				</div>
			</div>
			<ol class="list">
				<?php
				//print_list();
				echo $list;
				?>
			</ol>
		</div>
		<div id="article">
			<form action="update_process.php" method="post">
				<p>
					<input type="hidden" name="id" value="<?=$_GET['id']?>">
					<input class="title" type="text" name="title" placeholder="제목" onkeyup="characterCheck(this)" onkeydown="characterCheck(this)" onchange="characterCheck(this)" maxlength="30" value="<?=$article['title']?>">
				</p>
				<p>
					<textarea class="description" name="description" placeholder="내용"><?=$article['description']?></textarea>
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