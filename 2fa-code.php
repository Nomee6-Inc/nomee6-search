<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
session_start();
include 'config.php';
error_reporting(0);
$getredir = $_GET['redir'];
$get2fasesscookie = $_COOKIE['2fasession'];
$query = mysqli_query($conn,"SELECT * FROM 2faskipcodes WHERE code = '$get2fasesscookie'");
$result = $query->fetch_assoc();
$get2fasessloggingstatus = $result['status'];
if(!$get2fasesscookie || !$get2fasessloggingstatus) {
    header("Location: login");
} else {
if($get2fasessloggingstatus == "logined") {
    header("Location: account");
}

$getauthor2faacc = $result['author'];

$query1 = mysqli_query($conn,"SELECT * FROM users WHERE email = '$getauthor2faacc'");
$result1 = $query1->fetch_assoc();

$getauthor2fatoken =  $result1['2fatoken'];
$getauthorusername =  $result1['username'];

if (isset($_POST['confirmotp'])) {
    $authenticator2fa = new PHPGangsta_GoogleAuthenticator();
 
    $secret2fa = $getauthor2fatoken;
    $otp2fa = $_POST['otpcode'];
     
    $tolerance = 0;
    $checkResult2fa = $authenticator2fa->verifyCode($secret2fa, $otp2fa, $tolerance);

    if ($checkResult2fa) {
        $sql96 = "UPDATE 2faskipcodes SET status = 'logined' WHERE code = '$get2fasesscookie'";
        $run_query96 = mysqli_query($conn, $sql96);
        $_SESSION['username'] = $getauthorusername;
        $_SESSION['email'] = $getauthor2faacc;
        if($_GET['redir']) {
            header("Location: $getredir");
        } else {
            header("Location: ./");
        }
    } else {
      echo "<div class=\"alert alert-warning\">
      <h4 class=\"lang alert-title\" key=\"incorrectotp2facode\" style=\"text-align:center\">You entered the wrong OTP Code!</h4>
    </div>";
  }
}
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>2FA Authentication</title>
    <!-- CSS files -->
    <link href="https://devlet.nomee6.xyz/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/demo.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <meta property="og:title" content="NOMEE6 Search" />
	<meta property="og:description" content="NOMEE6 Search yenilikçi arama motoru!" />
	<meta property="og:url" content="https://search.nomee6.xyz" />
	<meta property="og:image" content="https://nomee6.xyz/assets/pp.png" />
	<!-- Matomo -->
	<script>
	  var _paq = window._paq = window._paq || [];
	  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  _paq.push(['enableHeartBeatTimer']);
	  (function() {
	    var u="//matomo.aliyasin.org/";
	    _paq.push(['setTrackerUrl', u+'matomo.php']);
	    _paq.push(['setSiteId', '19']);
	    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
	    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<!-- End Matomo Code -->
    <style>
    .footerdropbtn {
      background-color: #5170b2;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 25px;
    }
    .headerbtn {
      background-color: #5170b2;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 25px;
      display: right;
      float: right;
    }

    .footerdropdown {
      position: relative;
      display: inline-block;
    }

    .footerdropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .footerdropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      -webkit-user-select: none;
      user-select: none;
      font-family: "Roboto";
    }

    .footerdropdown-content a:hover {background-color: #f1f1f1}

    .footerdropdown:hover .footerdropdown-content {
      display: block;
    }

    .footerdropdown:hover .footerdropbtn {
      background-color: #5170b2;
    }
    </style>
  </head>
  <body class=" border-top-wide border-primary d-flex flex-column" style="-webkit-user-select: none;user-select: none;">
  <div class="footerdropdown">
  <button class="footerdropbtn lang" key="language" style="-webkit-user-select: none;user-select: none;">Dil</button>
  <div class="footerdropdown-content">
    <a id="en" class="translate">English</a>
    <a id="tr" class="translate">Türkçe</a>
    <a id="ar" class="translate">عربي</a>
    <a id="ru" class="translate">Русский</a>
    <a id="kur" class="translate">کوردی</a>
  </div>
</div>
    <div class="page page-center">
      <div class="container-tight py-4">
        <form class="card card-md" action="" method="POST">
          <div class="card-body">
            <h2 class="lang card-title text-center mb-4" key="2faauthentication2facodepage">OTP Verification</h2>
            <div class="mb-3">
              <label class="lang form-label" key="otpcode">OTP Code</label>
              <input type="number" name="otpcode" class="form-control" placeholder="OTP Code">
            </div>
            <div class="form-footer">
              <button name="confirmotp" class="lang btn btn-primary w-100" key="confirm">
                Confirm
              </buton>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
    <script src="translate.js"></script>
  </body>
</html>