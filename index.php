<?php 
require('lib/print.php');
$conn = mysqli_connect('localhost','root','test','level1');
$sql = "SELECT * FROM forum";
// $sql_ = "SELECT * FROM forum";
mysqli_set_charset($conn, "utf8");
$result = mysqli_query($conn, $sql);
// $result_ = mysqli_query($conn, $sql);
// $query = "SELECT * FROM forum LEFT JOIN member ON forum.author_id = member.id LIMIT 0, 10";

$list_num = 5;
if (isset($_GET['vpage'])){
	$vpage = $_GET['vpage'];
} else {
	$vpage = 1;
}
$v_page = (int)$vpage;
$index_no = ($v_page - 1) * $list_num;

$query = "SELECT * FROM forum ORDER BY id DESC LIMIT {$index_no}, {$list_num}";
$query2 = "SELECT * FROM forum ORDER BY id DESC";
$data = mysqli_query($conn, $query);
$data2 = mysqli_query($conn, $query2);
$total_posts2 = mysqli_num_rows($data2);
$total_posts = mysqli_num_rows($data);
// $lastpage = (int)ceil((double)$total_posts / 3);

$page_num = 5;

$total_page = ceil($total_posts2 / $list_num);
$now_block = ceil($vpage / $page_num);
$s_pageNum = ($now_block - 1) * $page_num + 1;
if ($s_pageNum <= 0){
	$s_pageNum = 1;
}
$e_pageNum = (int)($now_block * $page_num);
if($e_pageNum > $total_page){
	$e_pageNum = $total_page;
}


// $list = '';
$arr = array();
$descArr = array();
$arr2 = array();
$arr3 = array();
$i = 0;
while($row = mysqli_fetch_array($data)){
	$sql = "SELECT * FROM forum LEFT JOIN member ON forum.author_id = member.id WHERE forum.id = {$row['id']}";
	$result = mysqli_query($conn, $sql);
	$row_ = mysqli_fetch_array($result);
	$arr3[$i] = htmlspecialchars($row_['user_nick']);
	$escaped_title = htmlspecialchars($row['title']);
	$escaped_description = htmlspecialchars($row['description']);
	$arr[$i] = $escaped_title;
	$descArr[$i] = $escaped_description;
	$colored_title_ = "<div style=''>{$escaped_title}</div>";
	// $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$colored_title}</a></li>";
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
				<?php if(isset($_SESSION['id'])) { ?>
				<?php if($_SESSION['id'] == $article['author_id']) { ?> 520px; <?php } else { ?>
				195px; <?php } } ?> "> 
				<?php if(isset($_SESSION['id'])) {  ?>
					<button class="nav_btn" type="button" onclick="location.href='create.php'">글쓰기</button> 
				<?php } ?>
				<?php if(isset($_GET['id']) && isset($_SESSION['id'])) { ?>
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
					<td rowspan="2"> 
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
			<!-- <table id="list" style="width: 100%; "> -->
			<?php
			$j = 0;
			// $k = count($arr) -1;
			while ($j < count($arr)){
				
				// 현재창 열기
				echo "<table class='list_layout' border=1; style='border-left: 0px black solid; border-right: 0px black solid;> 
						<tr style='border-width: 6px; border-style: solid;'>
							<td class='profile_label' rowspan='3' style='width:50px; border:0px;'> 
								<img class='profile_img' src='images/profiles/default/blank_profile_picture.png'/>
							</td>
							<td class='title_label' style='border:0px; font-weight: bold;' onclick=location.href='index.php?id={$arr2[$j]}'>
								{$arr[$j]}
							</td>
						</tr>
						<tr>
							<td class='desc_label' style='border:0px; font-size: 80%;' onclick=location.href='index.php?id={$arr2[$j]}'>
							{$descArr[$j]}
							</td>
						</tr>
						<tr>
							<td class='nick_label' style='border:0px; font-size: 70%;' onclick=location.href='index.php?id={$arr2[$j]}'>
								{$arr3[$j]}
							</td>
						</tr>
					</table>";
				// 새로운창 열기
				// echo "<li onclick=window.open(\"index.php?id={$arr2[$j]}\")>{$arr[$j]}</li>";
				$j++;
				// $k--;
			}
			//echo $list;
			?>
			
		</div>
		<div class="pagination">
			<?php
			if($vpage <= 1){
    		?>
		 	<span onclick="location.href='index.php?vpage=1'">이전</span>
			<?php } else{ ?>
			<span onclick="location.href='index.php?vpage=<?php echo ($vpage-1); ?>'">이전</span>
			<?php };
			for ($i = $s_pageNum; $i<=$e_pageNum; $i++){
				echo "<span class='pageNum' onclick=location.href='index.php?vpage={$i}'>{$i}</span>";
			}
			if($vpage >= $total_page){
			?>
			<span onclick="location.href='index.php?vpage=<?php echo $total_page; ?>'">다음</span>
			<?php } else{ ?>
			<span onclick="location.href='index.php?vpage=<?php echo ($vpage+1); ?>'">다음</span>
			<?php };?>
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
