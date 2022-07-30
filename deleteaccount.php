<?php
session_start();
include_once 'config.php';
date_default_timezone_set('Europe/Istanbul');
$getdeletiontoken = $_GET['token'];
$query = mysqli_query($conn,"SELECT * FROM accountdeletion WHERE deletiontoken = '$getdeletiontoken'");
$result = $query->fetch_assoc();
if ($query->num_rows > 0) {
$getauthoraccountmail = $result['authoraccount'];
$gettokenexpiredate = $result['expiredate'];
$getnowdate = strtotime(date("Y-m-d"));
$ifdate15day = ($getnowdate - $gettokenexpiredate) / 86400;
    if($ifdate15day > 0) {
        header("Location: ./");
    } else {
        if (isset($_POST['deleteaccount'])) {
            $query1 = mysqli_query($conn,"SELECT * FROM users WHERE email = '$getauthoraccountmail'");
            $result1 = $query1->fetch_assoc();
            if($query1->num_rows > 0) {
              $getuseriddb = $result1['id'];
              $sql6 = "DELETE FROM users WHERE `users`.`id` = $getuseriddb";
              $query6 = mysqli_query($conn, $sql6);
              if($query6) {
                echo "<div class=\"alert alert-success\">
                <h4 class=\"lang alert-title\" key=\"accountdeletionsuccess\" style=\"text-align:center\">Your account deletion has been successfully deleted.</h4>
              </div>";
              } else {
                echo "<div class=\"alert alert-danger\">
                <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Something went wrong.</h4>
              </div>";
              }
            } else {
                echo "<div class=\"alert alert-warning\">
                <h4 class=\"lang alert-title\" key=\"accountnotfoundaccdeletionpage\" style=\"text-align:center\">This account was not found! Your account may have already been deleted before.</h4>
              </div>";
            }
        }
    }
} else {
    header("Location: ./");
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Account Deletion | Nomee6 Search</title>
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
<form action="" method="POST">
  <div class="page page-center">
      <div class="container-tight py-4">
        <div class="card card-md">
          <div class="card-body text-center py-4">
            <h1 class="lang mt-5" key="weresorryyouleft">We're sorry you left!</h1>
            <p class="lang text-muted" key="accdeletionpagedesc">Hesabınızı kalıcı olarak silmek için aşağıda ki butona tıklayın.</p>
          </div>
        </div>
        <div class="row align-items-center mt-3">
          <div class="col">
            <div class="btn-list justify-content-end">
              <button type="submit" name="deleteaccount" class="lang btn btn-red" key="delaccount">
                Delete Account
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
    <script src="translate.js"></script>
  </body>
</html>