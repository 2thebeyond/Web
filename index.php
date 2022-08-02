<?php 
session_start();
require('lib/print.php');
$conn = mysqli_connect('localhost','root','test','level1');
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
// var_dump($arr);

$article = array(
	'title'=>'Welcome :)',
	'description'=>'홈페이지에 오신 것을 환영합니다.'
);
$title = 'Welcome :)';
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
	// $sql = "SELECT * FROM topic LEFT JOIN author ON topic.author_id = author.id WHERE topic.id = {$filtered_id}";
	$sql = "SELECT * FROM forum LEFT JOIN member ON forum.author_id = member.id WHERE forum.id = {$filtered_id}";
	$result = mysqli_query($conn, $sql);
	echo mysqli_error($conn);
	$row = mysqli_fetch_array($result);
	$article['title'] = htmlspecialchars($row['title']);
	$article['description'] = htmlspecialchars($row['description']);
	$article['date'] = htmlspecialchars($row['created']);
	$article['nick'] = htmlspecialchars($row['user_nick']);
	$article['author_id'] = htmlspecialchars($row['author_id']);
	if (empty($article['nick'])){
		$author = "<p>unknown</p>";
		
	} else {
		$author = "<p>{$article['nick']}</p>";
	}
}
//print_r($article);

// $update = '<a href="update.php?id='.$_GET['id'].'">update</a>';
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
	<link rel="shortcut icon" href="#"/>
	<link rel="stylesheet" href="style.css"/>
</head>
<body>
	<h1 class="header" onclick="location.href='index.php';">Web</h1>
	<div id="grid">
		<div class="nav">
			<div class="nav_header">
				<div class="nav_account_btns" style="width: 
				<?php if(isset($_SESSION['id'])) { ?> 560px; <?php  } else { ?> 460px; <?php } ?> ">
				<?php if(isset($_SESSION['id'])) { ?>
					<button class="nav_btn" type="button" onclick="location.href='mypage/mypage_view.php'">마이페이지</button>
					<button class="nav_btn" type="button" onclick="location.href='mypage/logout.php'">로그아웃</button>
				<?php  } else { ?>
					<button class="nav_btn" type="button" onclick="location.href='register_view.php'">회원가입</button>
					<button class="nav_btn" type="button" onclick="location.href='login_view.php'">로그인</button>
				<?php } ?>
				</div>
				<div class="nav_post_btns" style="width: 
											 <?php if($_SESSION['id'] == $article['author_id']) { ?> 520px; <?php } else { ?>
											 195px; <?php } ?> "> 
				<?php if(isset($_SESSION['id'])) {  ?>
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button> 
				<?php } ?>
				<?php if(isset($_GET['id'])) { ?>
				<?php if($_SESSION['id'] == $article['author_id']) { ?>	
					<button class="nav_btn" type="button" onclick="location.href='update.php?id=<?=htmlspecialchars($_GET['id'])?>'">수정</button>
					<button class="nav_btn" type="submit" form="delete" style="color:red;">삭제</button>
						<form id="delete" action="delete_process.php" method="post">
							<!-- <input type="hidden" name="id" value="htmlspecialchars($_GET['id'])?>"> -->
							<input type="hidden" name="id" value="<?=$_GET['id']?>">
						</form>
				<?php }	} ?>
				</div>
			</div>
			<!-- list -->
		</div>
		<div id="article">
			<?php if(isset($_GET['id'])) { ?>
			<table border="0">
				<tr>
					<td rowspan="2" style="width:50px;"> 
						<?php
						$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

						if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
							?> <img src="images/profiles/default/blank_profile_picture.png" style="width:80px; height:80px; padding: 0px; margin: 0px;"/> <?php
						}else{
							?> <img src="images/profiles/default/blank_profile_picture.png" style="width:60px; height:60px; padding: 0px; margin: 0px;"/> <?php
						}
						?>
					</td>
				<td style="font-weight:bold; padding-left:20px;">
					<?php 
					//print_title();
					echo $author;
					//echo $article['name'];
					?>
				</td>
				</tr>
				<tr>
					<td style="padding-left:20px;"> 
						<?php
						echo $article['date'];
						?>
					</td>
				</tr>
			</table>
			<?php } ?>
			<h2 style="overflow: auto; margin-top: 20px">
				<?php
				//print_description();
				echo $article['title'];
				?>
			</h2>
			<p style="overflow: auto; white-space:pre-line;">
				<?php
				echo $article['description'];
				?>
			</p>
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
			<input id="darkmode" class="button" type="submit" value="Dark Mode" name="darkmode" onclick="ToggleTheme(this);">
		</form>
	</div>
	<script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/git/jquery-git.slim.js"></script>
	<script src="colors.js"></script>
</body>
</html>
