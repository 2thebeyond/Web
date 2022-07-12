 <?php
$db = mysqli_connect('localhost','root','test','level1');

if (!$db){
	echo "DB접속 실패" 
} else {
	echo "DB접속 성공" 
}
?>