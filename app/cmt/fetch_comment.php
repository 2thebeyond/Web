<html>
	<head>
		<link rel="stylesheet" href="styles/comment.css"/>
	</head>
</html>
<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
//fetch_comment.php

$connect = new PDO('mysql:host=localhost;dbname=level1;charset=utf8', 'root', 'test');
$conn = mysqli_connect('localhost'
					   ,'root'
					   ,'test'
					   ,'level1'
);
mysqli_set_charset($conn, "utf8");

$post_id = $_SESSION['curPost_id'];

$query = "
SELECT * FROM tbl_comment
WHERE board_id = '".$post_id."' AND parent_comment_id = '0' 
ORDER BY comment_id
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
$i = 0;
foreach($result as $row)
{
	if (date('Y') == date('Y', strtotime($row["date"]))){
		$formated_DATETIME = date('m-d H:i', strtotime($row["date"]));
	} else {
			$formated_DATETIME = date('y-m-d H:i', strtotime($row["date"]));
	}
	$sql = "SELECT * FROM member WHERE member.id = {$row['comment_sender_name']}";
	$result_ = mysqli_query($conn, $sql);
	$nick_row = mysqli_fetch_array($result_);
	$nick[$i] = htmlspecialchars($nick_row['user_nick']);
	
	if ($_SESSION['user_nick'] == $nick[$i] && $row["isdelete"] == 0){
		$output .= '
		<div class="reply-panel-container">
			<table class="panel panel-default">
			<tr>
				<td class="panel-heading">
					<b>'.$nick[$i].'</b>
				</td>
				<td class="panel-heading" align="right">
					<div class="btn_container" style="float: right; width: 220px;">
								<button type="button" class="btn btn-default reply"  id="'.$row["comment_id"].'">💬</button>
								<button type="button" class="btn btn-default delete" onclick="location.href=\'app/cmt/delete_comment.php?cid='.$row["comment_id"].'&cnik='.$nick[$i].'\'">❌</button>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="panel-body">'.$row["comment"].'</td>
			</tr>
			<tr>
				<td colspan="2" class="panel-footer">'.$formated_DATETIME.'</td>
			</tr>
			</table>
			<div class="reply_section"></div>
		</div>
 		';
 		$output .= get_reply_comment($connect, $row["comment_id"]);
	} else if ($_SESSION['user_nick'] != $nick[$i] && $row["isdelete"] == 0){
		$output .= '
		<div class="reply-panel-container">
			<table class="panel panel-default">
			<tr>
				<td class="panel-heading">
					<b>'.$nick[$i].'</b>
				</td>
				<td class="panel-heading" align="right">
					<div class="btn_container" style="float: right; width: 110px;">
								<button type="button" class="btn btn-default reply"  id="'.$row["comment_id"].'">💬</button>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="panel-body">'.$row["comment"].'</td>
			</tr>
			<tr>
				<td colspan="2" class="panel-footer">'.$formated_DATETIME.'</td>
			</tr>
		</table>
		<div class="reply_section"></div>
	</div>
	';
	$output .= get_reply_comment($connect, $row["comment_id"]);
	} else if ($row["isdelete"] == 1) {
		$sql = "SELECT * FROM tbl_comment WHERE parent_comment_id = {$row["comment_id"]} AND isdelete = 0";
		$result_ = mysqli_query($conn, $sql);
		$child_row = mysqli_fetch_array($result_);
		if (count($child_row) != 0) {
			$output .= '
			<div class="reply-panel-container">
				<table class="panel panel-default">
					<tr>
						<td class="panel-heading">
							<b>알수없음</b>
						</td>
						<td class="panel-heading" align="right">
							<div class="btn_container" style="float: right; width: 110px;">
								<button type="button" class="btn btn-default reply"  id="'.$row["comment_id"].'">💬</button>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="panel-body">삭제된 댓글입니다.</td>
					</tr>
					<tr>
						<td colspan="2" class="panel-footer">'.$formated_DATETIME.'</td>
					</tr>
				</table>
				<div class="reply_section"></div>
			</div>';
			$output .= get_reply_comment($connect, $row["comment_id"]);
		} else {
			
		}
	}
	$i++;
}
 mysqli_close($conn);

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
	session_start();
	$conn = mysqli_connect('localhost'
					   ,'root'
					   ,'test'
					   ,'level1'
	);
	mysqli_set_charset($conn, "utf8");
	$query = "
	SELECT * FROM tbl_comment WHERE parent_comment_id = '".$parent_id."'
	";
 	$output = '';
 	$statement = $connect->prepare($query);
 	$statement->execute();
 	$result = $statement->fetchAll();
 	$count = $statement->rowCount();
 
	if($parent_id == 0){
  		$marginleft = 0;
 	} else {
 		$marginleft = 70;
	// $marginleft = $marginleft + 48;
 	}
	
 	if($count > 0) {
		$i = 0;
		foreach($result as $row) {
			if (date('Y') == date('Y', strtotime($row["date"]))){
				$formated_DATETIME = date('m-d H:i', strtotime($row["date"]));
			} else {
					$formated_DATETIME = date('y-m-d H:i', strtotime($row["date"]));
			}
			$sql = "SELECT * FROM member WHERE member.id = {$row['comment_sender_name']}";
			$result = mysqli_query($conn, $sql);
			$nick = mysqli_fetch_array($result);
			$nick[$i] = htmlspecialchars($nick['user_nick']);
			
			if ($_SESSION['user_nick'] == $nick[$i] && $row["isdelete"] == 0){
				$output .= '
				<div class="reply-panel-container">
					<table class="panel panel-default-reply" style="margin-left:'.$marginleft.'px;">
						<tr>
							<td class="panel-heading">
								↪️ <b>'.$nick[$i].'</b>
							</td>
							<td>
								<div class="btn_container" style="float: right; display: inline-block; width: 220px;">
									<button type="button" class="btn btn-default reply"  id="'.$row["comment_id"].'">💬</button>

									<button type="button" class="btn btn-default delete" onclick="location.href=\'app/cmt/delete_comment.php?cid='.$row["comment_id"].'&cnik='.$nick[$i].'\'">❌</button>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="panel-body">'.$row["comment"].'</td>
						</tr>
						<tr>
							<td colspan="2" class="panel-footer">'.$formated_DATETIME.'</td>
						</tr>

					</table>
					<div class="reply_section"></div>
				</div>
				';
				$output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
			
			} else if ($_SESSION['user_nick'] != $nick[$i] && $row["isdelete"] == 0) {
				$output .= '
				<div class="reply-panel-container">
					<table class="panel panel-default-reply" style="margin-left:'.$marginleft.'px;">
						<tr>
							<td class="panel-heading">
								↪️ <b>'.$nick[$i].'</b>
							</td>
							<td>
								<div class="btn_container" style="float: right; display: inline-block; width: 130px;">
									<button type="button" class="btn btn-default reply"  id="'.$row["comment_id"].'">💬</button>

								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="panel-body">'.$row["comment"].'</td>
						</tr>
						<tr>
							<td colspan="2" class="panel-footer">'.$formated_DATETIME.'</td>
						</tr>

					</table>
					<div class="reply_section"></div>
				</div>
				';
				$output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
			
			} else if ($row["isdelete"] == 1) {
			
			
			}
			
			$i++;
		}
	}
	return $output;
}
?>