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

// $title = 'Welcome :)';
// if(isset($_GET['id'])){
// 	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
// 	$sql = "SELECT * FROM topic WHERE id = {$filtered_id}";
// 	$result = mysqli_query($conn, $sql);
// 	$row = mysqli_fetch_array($result);
// 	$article['title'] = htmlspecialchars($row['title']);
// 	$article['description'] = htmlspecialchars($row['description']);
// }
//print_r($article);

$sql = "SELECT * FROM author";
$result = mysqli_query($conn, $sql);
$select_form = '<select>';
while($row = mysqli_fetch_array($result)){
	$select_form .= '<option>'.$row['name'].'</option>';
}
$select_form = $select_form.'</select>';
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
			<ol class="list">
				<?php
				//print_list();
				$j = 0;
				while ($j < count($arr)){
					// 현재창 열기
					echo "<li onclick=location.href='index.php?id={$arr2[$j]}'>{$arr[$j]}</li>";
					$j++;
				}
 				//echo $list;
				?>
			</ol>
		</div>
		<div id="article">
			<form action="create_process.php" method="post">
				<p>
					<?=$select_form?>
				</p>
				<p>
					<input class="title" type="text" name="title" placeholder="제목" onkeyup="characterCheck(this)" onkeydown="characterCheck(this)" onchange="characterCheck(this)" maxlength="30" >
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
		<form action="" method="post">
			<input id="darkmode" class="button" type="submit" value="Dark Mode" name="darkmode" onclick="
		ToggleTheme(this);">
		</form>
	</div>
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/git/jquery-git.slim.js"></script>
	<script src="colors.js"></script>
</body>
</html>