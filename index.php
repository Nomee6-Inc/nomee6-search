<?php
include 'config.php';
session_start();
error_reporting(0);
$getuseremail = $_SESSION['email'];
$getusername = $_SESSION['username'];
if (isset($_POST['searchsubmit'])) {
    $getsearchquery = $_POST['searchquery'];
    header("Location: search?q=$getsearchquery");

    if (isset($_SESSION['username'])) {
        $getdate = date("d.m.Y");
        $sql = "INSERT INTO searchs (searchvalue, author, date)
                        VALUES ('$getsearchquery', '$getuseremail', '$getdate')";
        $run_query = mysqli_query($conn, $sql);
    }
};
?>
<!doctype html>
<html lang="tr">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>NOMEE6 Search</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.2/css/flag-icons.min.css">
    <meta property="og:title" content="NOMEE6 Search" />
	<meta property="og:description" content="NOMEE6 Search yenilikçi arama motoru!" />
  	<link rel="search" href="https://search.nomee6.xyz/opensearch.xml" title="Nomee6 Search" type="application/opensearchdescription+xml" />
	<meta property="og:url" content="https://search.nomee6.xyz" />
	<meta property="og:image" content="https://nomee6.xyz/assets/pp.png" />
	<!-- Matomo -->
	<script>
	  var _paq = window._paq = window._paq || [];
	  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  _paq.push(['enableHeartBeatTimer']);
	  _paq.push(['setUserId', '<?php echo $getusername; ?>']);
	  (function() {
	    var u="//matomo.aliyasin.org/";
	    _paq.push(['setTrackerUrl', u+'matomo.php']);
	    _paq.push(['setSiteId', '19']);
	    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
	    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<!-- End Matomo Code -->
</head>
<body>
<div class="footerdropdown">
  <button class="footerdropbtn lang" key="language">Dil</button>
  <div class="footerdropdown-content">
    <a id="en" class="translate">English</a>
    <a id="tr" class="translate">Türkçe</a>
    <a id="ar" class="translate">عربي</a>
    <a id="ru" class="translate">Русский</a>
    <a id="kur" class="translate">کوردی</a>
  </div>
</div>
    <input type="checkbox" id="toggle">
    <div class="topnav">
        <a href="account" class="lang" key="account">Hesabım</a>
        <a class="active lang" href="." key="home">Ana Sayfa</a>
    </div>
<div>
    <h4 style="font-family: Roboto; text-align: center;font-size: 30px;-webkit-user-select: none;user-select: none;">NOMEE6 SEARCH</h4>
    <img src="https://nomee6.xyz/assets/pp.png" class="centerimghome">
    <br>
    <form class="searchboxhome" method="POST" action="" accept-charset="utf-8" style="margin:auto;max-width:600px">
        <input id="searchquery" name="searchquery" type="text" autocomplete="off" placeholder="Ara..." required>
        <button name="searchsubmit" type="submit"><i class="fa fa-search"></i></button>
        <div id="dropdown" class="dropdown">
            <div id="results" class="dropdown-content">
            </div>
          </div>
    </form>
</div>

<div class="footer">
    <ul>
        <li style="list-style:none;background-image:none;background-repeat:none;background-position:0;-webkit-user-select: none;user-select: none;"><h4 style="font-family: Roboto; text-align: left;font-size: 20px;">Nomee6 Inc.</h4></li>
        <li style="list-style:none;background-image:none;background-repeat:none;background-position:0;text-align: initial;-webkit-user-select: none;user-select: none;"><a href="https://github.com/Nomee6-Inc" style="font-family: Roboto;text-decoration: none;color: grey;"><i class="fab fa-github"></i>Github</a></li>
    </ul>
</div>
<script type="text/javascript" src="translate.js"></script>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
