<?php
include '../config.php';
$search = $_GET['key'];
$sql = "SELECT * FROM urls WHERE sitename LIKE '$search%' LIMIT 4";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
	echo "<a href='search?q=".$row['sitename']."'>".$row['sitename']."</a>";
}
?>