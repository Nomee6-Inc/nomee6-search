<?php
session_start();
error_reporting(0);
session_destroy();
setcookie("historystatus", "", time() - 3600, "/");
setcookie("2fasession", "", time() - 3600, "/");
header("Refresh:1 url=login");
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logout | NOMEE6 Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
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
</head>
<body>
    <h2 style="font-family: 'Roboto', sans-serif;">Logging out...</h2>
</body>
</html>