<?php
	$conn = mysqli_connect('localhost','root','test','level1');
	mysqli_set_charset($conn, "utf8");
?>
<html>
	<head>
		<meta name="robots" content="noindex, nofolloew"/>
		<title>관리자 페이지</title>
	</head>
	<body>
		<h1>Admin Page</h1>
		<?php //if (isset($_SESSION['op_id'])) { ?>
		<table border="1">
			<tr>
				<td>번호</td><td>게시글</td><td>작성자</td>
				<?php
				$sql = "SELECT * FROM forum";
				$result = mysqli_query($conn, $sql);
				
				while($row = mysqli_fetch_array($result)){
					$filtered = array(
						'id'=>htmlspecialchars($row['id']),
						'title'=>htmlspecialchars($row['title']),
					);
					
					$sql_ = "SELECT * FROM member WHERE id = {$row['author_id']}";
					$result_ = mysqli_query($conn, $sql_);
					$row_ = mysqli_fetch_array($result_);
					$filtered_ = array(
						'nick'=>htmlspecialchars($row_['user_nick'])
					)
				?>
				<tr>
					<td><?=$filtered['id']?></td>
					<td><?=$filtered['title']?></td>
					<td><?=$filtered_['nick']?></td>
				</tr>
				<?php } ?>
			</tr>
		</table>
		<?php //} else {  
			// header('Refresh: 0; URL=op_login_view.php');?>
		<?php //} ?>
		
	</body>
</html>