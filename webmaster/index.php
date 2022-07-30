<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
session_start();
error_reporting(0);
include_once '../config.php';
$getusername = $_SESSION['username'];
$getuseremail = $_SESSION['email'];
if (!isset($_SESSION['username'])) {
    header("Location: ../login?redir=webmaster");
} else {
    header("Location: panel");
}


?>