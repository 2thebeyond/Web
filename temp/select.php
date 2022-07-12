<?php
$conn = mysqli_connect(
	'localhost',
	'root',
	'test',
	'opentutorials'
);
echo "<h1>multi row</h1>";

$sql = "SELECT * FROM topic";
$result = mysqli_query($conn, $sql);
// print_r(mysqli_fetch_array($result));
//var_dump(mysqli_fetch_array($result));

while($row = mysqli_fetch_array($result)) {
	echo '<h2>'.$row['title'].'</h2>';
	echo $row['description'];
}
?>