<?php
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
session_start();
include 'config.php';

if (isset($_SESSION['username'])) {
  header("Location: index.php");
}

if (isset($_POST['createaccount'])) {
$getusername = $_POST['username'];
$getuseremail = $_POST['email'];
$getpassword = hash('sha256', $_POST['password']);

$sql = "SELECT * FROM users WHERE email='$getuseremail'";
$result = mysqli_query($conn, $sql);
if (!$result->num_rows > 0) {
    $sql1 = "INSERT INTO users (username, email, password)
    VALUES ('$getusername', '$getuseremail', '$getpassword')";
    $result1 = mysqli_query($conn, $sql1);
    if($result1) {
      header("Refresh:3");
      echo "<div class=\"alert alert-success\">
      <h4 class=\"lang alert-title\" key=\"registersuccess\">Registration completed successfully!</h4>
    </div>";
    } else {
      echo "<div class=\"alert alert-danger\">
      <h4 class=\"lang alert-title\" key=\"somethingwentwrong\">Something went wrong.</h4>
    </div>";
    }
} else {
  echo "<div class=\"alert alert-warning\">
  <h4 class=\"lang alert-title\" key=\"emailalreadyused\">Email address is already used.</h4>
</div>";
}
};
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Kayıt Ol | NOMEE6 Search</title>
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
  <body class="border-top-wide border-primary d-flex flex-column" style="-webkit-user-select: none;user-select: none;">
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
            <h2 class="lang card-title text-center mb-4" key="createnewaccount">Create new account</h2>
            <div class="mb-3">
              <label class="lang form-label" key="uname">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Name" required>
            </div>
            <div class="mb-3">
              <label class="lang form-label" key="companyemail">Email:</label>
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <label class="lang form-label" key="password">Password</label>
              <div class="input-group input-group-flat">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
                <span class="input-group-text">
                  <a id="togglePassword" class="link-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                  </a>
                </span>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" required/>
                <span class="form-check-label"><k class="lang" key="agreetos"></k> <a class="lang" href="terms-of-service" tabindex="-1" key="tospolicy">TOS Policy</a></span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" name="createaccount" class="lang btn btn-primary w-100" key="createnewaccount">Create new account</button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted mt-3">
          <k class="lang" key="alreadyhaveaccount">Already have account?</k> <a href="login" tabindex="-1" class="lang" key="login">Login</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="translate.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
        });
    </script>
  </body>
</html>