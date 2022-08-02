<?php 
session_start();
require('lib/print.php');
$conn = mysqli_connect('localhost','root','test','level1');
// $conn = mysqli_connect(
// 	'localhost',
// 	'root',
// 	'test',
// 	'opentutorials');
//$sql = "SELECT * FROM topic";
$sql = "SELECT * FROM forum";
mysqli_set_charset($conn, "utf8");
$result = mysqli_query($conn, $sql);
$list = '';
$arr = array();
$arr2 = array();
$i = 0;
while($row = mysqli_fetch_array($result)){
	//echo ($row);
	$escaped_title = htmlspecialchars($row['title']);
	$arr[$i] = $escaped_title;
	// echo $escaped_title;
	$colored_title = "<div style=''>{$escaped_title}</div>";
	$list = $list."<li><a href=\"index.php?id={$row['id']}\">{$colored_title}</a></li>";
	$arr2[$i] = $row['id'];
	$i++;
}	
// while($row = mysqli_fetch_array($result)){
// 	$list = $list."<li><a href=\"index.php?id={$row['id']}\">{$row['title']}</a></li>";
// }

$article = array(
	'title'=>'Welcome :)',
	'description'=>'홈페이지에 오신 것을 환영합니다.'
);
$title = 'Welcome :)';
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
	//$sql = "SELECT * FROM topic WHERE id = {$filtered_id}";
	$sql = "SELECT * FROM forum WHERE id = {$filtered_id}";
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
	<script src="characters.js"></script>
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
			<!-- list -->
		</div>
		<div id="article">
			<form action="update_process.php" method="post">
				<p>
					<?=$_SESSION['user_nick'];?>
				</p>
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
		<div class="list">
			<table id="list" border="1" style="width: 100%; height:700px;">
			<?php
			//print_list();
			$j = 0;
			while ($j < count($arr)){
				// 현재창 열기
				echo "<tr><td>
				<ul onclick=location.href='index.php?id={$arr2[$j]}'>{$arr[$j]}</ul></td></tr>"; 
				// 새로운창 열기
				// echo "<li onclick=window.open(\"index.php?id={$arr2[$j]}\")>{$arr[$j]}</li>";
				$j++;
			}
			//echo $list;
			?>
			</table>
		</div>
	</div>
	<div class="footer">
		<form action="" method="get">
			<input id="darkmode" class="button" type="submit" value="Dark Mode" name="darkmode" onclick="
		ToggleTheme(this);">
		</form>
	</div>
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/git/jquery-git.slim.js"></script>
	<script src="colors.js"></script>
</body>
</html>