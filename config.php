<?php
$server = "";
$user = "";
$pass = "";
$database = "";

$conn = mysqli_connect($server, $user, $pass, $database);
if(!$conn){
	die("<script>alert(Veritabanına bağlanılırken bir hata oluştu!)</script>");
}

// HEADERS
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("X-Content-Type-Options: nosniff");
?>