<?php 
session_start();
require('lib/print.php');
$conn = mysqli_connect('localhost'
					   ,'root'
					   ,'test'
					   ,'level1'
);
mysqli_set_charset($conn, "utf8");
$sql = "SELECT * FROM forum";
$result = mysqli_query($conn, $sql);

///////////////////////// PAGINATION 
$list_num = 5;
$page_num = 5;

if (isset($_GET['vpage'])){
	$vpage = $_GET['vpage'];
} else {
	$vpage = 1;
}

$v_page = (int)$vpage;
$index_no = ($v_page - 1) * $list_num;

$postQuery = "SELECT * FROM forum ORDER BY id";
$total_post = mysqli_query($conn, $postQuery);
$total_post_result = mysqli_num_rows($total_post);

$query = "SELECT * FROM forum ORDER BY id DESC LIMIT {$index_no}, {$list_num}";
$data = mysqli_query($conn, $query);

$total_page = ceil($total_post_result / $list_num);
$now_block = ceil($vpage / $page_num);

$s_pageNum = ($now_block - 1) * $page_num + 1;
if ($s_pageNum <= 0){
	$s_pageNum = 1;
}

$e_pageNum = (int)($now_block * $page_num);
if($e_pageNum > $total_page){
	$e_pageNum = $total_page;
}

///////////////////////// POST LIST
$postIdArr = array();
$nickArr = array();
$titleArr = array();
$descArr = array();

$i = 0;
while($row = mysqli_fetch_array($data)){
	$sql = "SELECT * FROM forum LEFT JOIN member ON forum.author_id = member.id WHERE forum.id = {$row['id']}";
	$result = mysqli_query($conn, $sql);
	$nick_row = mysqli_fetch_array($result);
	
	$escaped_title = htmlspecialchars($row['title']);
	$escaped_description = htmlspecialchars($row['description']);
	
	$nickArr[$i] = htmlspecialchars($nick_row['user_nick']);
	$titleArr[$i] = $escaped_title;
	$descArr[$i] = $escaped_description;
	$postIdArr[$i] = $row['id'];
	
	$i++;
}

///////////////////////// POST CONTENTS
$article = array(
	'title'=>'Welcome :)',
	'description'=>'홈페이지에 오신 것을 환영합니다.'
);
$title = 'Welcome :)';
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
	$sql = "SELECT * FROM forum LEFT JOIN member ON forum.author_id = member.id WHERE forum.id = {$filtered_id}";
	$result = mysqli_query($conn, $sql);
	echo mysqli_error($conn);
	$row = mysqli_fetch_array($result);
	$article['title'] = htmlspecialchars($row['title']);
	$article['description'] = htmlspecialchars($row['description']);
	$article['date'] = htmlspecialchars($row['created']);
	$article['nick'] = htmlspecialchars($row['user_nick']);
	$article['author_id'] = htmlspecialchars($row['author_id']);
	$_SESSION['curPost_id'] = $_GET['id'];
	if (isset($_GET['vpage'])){
		$_SESSION['vpage'] = $_GET['vpage'];
	}  else {
	
	}
	if (empty($article['nick'])){
		$author = "<p>unknown</p>";
	} 
	else {
		$author = "<p>{$article['nick']}</p>";
	}
} else {
	$_SESSION['curPost_id'] = '0';
	$_SESSION['vpage'] = 1;
}
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
					<?php } else { ?>
					<button class="nav_btn" type="button" onclick="location.href='register_view.php'">회원가입</button>
					<button class="nav_btn" type="button" onclick="location.href='login_view.php'">로그인</button>
					<?php } ?>
				</div>
				<div class="nav_post_btns" style="width: 
					<?php if(isset($_SESSION['id']) && isset($article['author_id'])) { ?>
					<?php if($_SESSION['id'] == $article['author_id']) { ?> 520px; <?php } else { ?> 195px; <?php } } ?> "> 
					<?php if(isset($_SESSION['id'])) {  ?>
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button> 
					<?php } ?>
					<?php if(isset($_GET['id']) && isset($_SESSION['id'])) { ?>
					<?php if($_SESSION['id'] == $article['author_id']) { ?>	
					<button class="nav_btn" type="button" onclick="location.href='update.php?id=<?=htmlspecialchars($_GET['id'])?>'">수정</button>
					<button class="nav_btn" type="submit" form="delete" style="color:red;">삭제</button>
						<form id="delete" action="delete_process.php" method="post">
							<input type="hidden" name="id" value="<?=$_GET['id']?>">
						</form>
					<?php }	} ?>
				</div>
			</div>
		</div>
		<div id="article">
			<?php if(isset($_GET['id'])) { ?>
			<table border="0">
				<tr>
					<td rowspan="2"> 
						<?php
						if ($_GET['id'] != '0'){
							$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

							if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
								?> <img src="images/profiles/default/blank_profile_picture.png" style="width:80px; height:80px; padding: 0px; margin: 0px;"/> <?php
							} else {
								?> <img src="images/profiles/default/blank_profile_picture.png" style="width:60px; height:60px; padding: 0px; margin: 0px;"/> <?php
							}
						} 
						?>
					</td>
					<td style="font-weight:bold; padding-left:20px;">
						<?php 
						if ($_GET['id'] != '0'){
							echo $author;
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="padding-left:20px;"> 
						<?php
						if ($_GET['id'] != '0'){
							echo $article['date'];
						}
						?>
					</td>
				</tr>
			</table>
			<?php } ?>
			<h2 style="overflow: auto; margin-top: 20px">
				<?php
				if (isset($_GET['id']) && $_GET['id'] != '0'){
					echo $article['title'];
				} else {
					echo 'Welcome :)';
				}
				?>
			</h2>
			<p style="overflow: auto; white-space:pre-line;">
				<?php
				if ($_GET['id'] != '0'){
					echo $article['description'];
				} else {
					echo '홈페이지에 오신 것을 환영합니다.';
				}
				?>
			</p>
		</div>
		<div class="list">
			<?php
			$j = 0;
			while ($j < count($titleArr)){
				echo "<table class='list_layout' border=1; style='border-left: 0px black solid; border-right: 0px black solid;> 
						<tr style='border-width: 6px; border-style: solid;'>
							<td class='profile_label' rowspan='3' style='width:50px; border:0px;'> 
								<img class='profile_img' src='images/profiles/default/blank_profile_picture.png'/>
							</td>
							<td class='title_label' style='border:0px; font-weight: bold;' onclick=location.href='index.php?id={$postIdArr[$j]}&vpage={$_SESSION['vpage']}'>
								{$titleArr[$j]}
							</td>
						</tr>
						<tr>
							<td class='desc_label' style='border:0px; font-size: 80%;' onclick=location.href='index.php?id={$postIdArr[$j]}&vpage={$_SESSION['vpage']}'>
							{$descArr[$j]}
							</td>
						</tr>
						<tr>
							<td class='nick_label' style='border:0px; font-size: 70%;' onclick=location.href='index.php?id={$postIdArr[$j]}&vpage={$_SESSION['vpage']}'>
								{$nickArr[$j]}
							</td>
						</tr>
					</table>";
				$j++;
			}
			?>
		</div>
		<div class="pagination">
			<?php
			if($vpage <= 1){
    		?>
			<span onclick="location.href='index.php?id=<?php echo $_SESSION['curPost_id']?>&vpage=1'">이전</span>
			<?php } else{ ?>
			<span onclick="location.href='index.php?id=<?php echo $_SESSION['curPost_id'];?>&vpage=<?php echo ($vpage-1);?>'">이전</span>
			<?php }; 
			for ($i = $s_pageNum; $i<=$e_pageNum; $i++){
				echo "<span class='pageNum' onclick=location.href='index.php?id={$_SESSION['curPost_id']}&vpage={$i}'>{$i}</span>";
			}
			if($vpage >= $total_page) { ?>
			<span onclick="location.href='index.php?id=<?php echo $_SESSION['curPost_id']; ?>&vpage=<?php echo $total_page; ?>'">다음</span>
			<?php } else { ?>
			<span onclick="location.href='index.php?id=<?php echo $_SESSION['curPost_id']; ?>&vpage=<?php echo ($vpage+1); ?>'">다음</span>
			<?php } ?>
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
