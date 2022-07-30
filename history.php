<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
session_start();
error_reporting(0);
include_once 'config.php';
$getusername = $_SESSION['username'];
$getuseremail = $_SESSION['email'];
$historystatuscookie = $_COOKIE['historystatus'];
if (!isset($_SESSION['username'])) {
    header("Location: login?redir=history");
} else {
$query = mysqli_query($conn,"SELECT * FROM users WHERE email = '$getuseremail'");
$result = $query->fetch_assoc();
if($query->num_rows > 0) {
  //
} else {
  session_destroy();
  header("Location: login");
}

if(isset($_POST['deletesearch'])) {
  $deletingsearchquery = $_POST['deletesearch'];
  $query3 = mysqli_query($conn,"SELECT * FROM searchs WHERE id = '$deletingsearchquery'");
  $result3 = $query3->fetch_assoc();
  $getdeletesearchqueryauthor = $result3['author'];
  if($getdeletesearchqueryauthor == $getuseremail) {
    $query7 = mysqli_query($conn, "DELETE FROM searchs WHERE `searchs`.`id` = $deletingsearchquery");
    if($query7) {
      echo "<div class=\"alert alert-success\">
      <h4 class=\"lang alert-title\" key=\"searchquerydeletesuccess\" style=\"text-align:center\">Your search query has been successfully deleted.</h4>
    </div>";
    } else {
      echo "<div class=\"alert alert-danger\">
        <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Something went wrong!</h4>
      </div>";
    }
  } else {
    echo "<div class=\"alert alert-danger\">
      <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Bir hata oluştu!</h4>
    </div>";
  }
}

if(isset($_POST['cleanhistory'])) {
$historysql2 = "SELECT * FROM searchs WHERE author = '$getuseremail'";
$historyresult2 = mysqli_query($conn, $historysql2);
while($row = mysqli_fetch_array($historyresult2)){
    $getsearchqueryid = $row['id'];
    $query65 = mysqli_query($conn, "DELETE FROM searchs WHERE `searchs`.`id` = $getsearchqueryid");
};
}

if(isset($_POST['hidehistory'])) {
  setcookie("historystatus", "hide", time() + (10 * 365 * 24 * 60 * 60), "/");
  header("Refresh:0");
}

}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Account | NOMEE6 Search</title>
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
  <body style="-webkit-user-select: none;user-select: none;">
    <div class="page">
      <aside class="navbar navbar-vertical navbar-expand-lg navbar-transparent">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand">
            <a href=".">
              <img src="https://nomee6.xyz/assets/pp.png" class="navbar-brand-image">
            </a>
          </h1>
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
          <div class="navbar-nav flex-row d-lg-none">
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Koyu temayı etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Açık temayı etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
            </a>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(./avatars/<?php echo $getavatar; ?>)"></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo $getusername; ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="account" class="lang dropdown-item" key="accountmngmnt">Account Management</a>
                <div class="dropdown-divider"></div>
                <a href="logout" class="lang dropdown-item" key="logout">Logout</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
              <li class="nav-item">
                <a class="nav-link" href="account" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
	                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><circle cx="12" cy="10" r="3" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                  </span>
                  <span class="lang nav-link-title" key="accountmngmnt">
                    Account Management
                  </span>
                </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="history" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
	                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 8 12 12 14 14" /><path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" /></svg>
                  </span>
                  <span class="lang nav-link-title" key="history">
                    History
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </aside>
      <div class="page-wrapper">
        <div class="container-xl">
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="lang page-title" key="history">
                  History
                </h2>
              </div>
            </div>
          </div>
        </div>
    <div class="page-body">
      <div class="container-xl">
      <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="lang card-title" key="history">History</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                    <form method="POST" action="" class="d-flex">
                      <div class="text-muted">
                      <?php
                      if($historystatuscookie == "hide") {

                      } else {
                        echo "
                        <a class=\"lang btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-delhistory\" key=\"cleanhistory\">Clean History</a>
                        <button name=\"hidehistory\" type=\"submit\" class=\"lang btn btn-primary\" key=\"hidehistory\">Hide History</button>";
                      }
                      ?>
                      </form>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="lang" key="searchvaluehistorypage">Search Value</th>
                          <th class="lang" key="searchdatehistorypage">Search Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <form action="" method="POST">
                        <?php
                      if($historystatuscookie == "hide") {
                        $getnowdate = date("d.m.Y");
                        echo "<tr>
                        <td><a href=\"search?q=bilim videoları\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">bilim videoları</a></td>
                        <td>$getnowdate</td>
                      </tr>
                      <tr>
                        <td><a href=\"search?q=uzay nasıl işler\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">uzay nasıl işler</a></td>
                        <td>$getnowdate</td>
                      </tr>
                      <tr>
                        <td><a href=\"search?q=tarih videoları\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">tarih videoları</a></td>
                        <td>$getnowdate</td>
                      </tr>
                      <tr>
                        <td><a href=\"search?q=dini terimler\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">dini terimler</a></td>
                        <td>$getnowdate</td>
                      </tr>
                      <tr>
                        <td><a href=\"search?q=lozan\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">lozan</a></td>
                        <td>$getnowdate</td>
                      </tr>
                      <tr>
                        <td><a href=\"search?q=türkiyenin tarihi\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">türkiyenin tarihi</a></td>
                        <td>$getnowdate</td>
                      </tr>";
                      } else {
                        $historysql1 = "SELECT * FROM searchs WHERE author = '$getuseremail' ORDER BY id DESC";
                        $historyresult = mysqli_query($conn, $historysql1);
                        while($row = mysqli_fetch_array($historyresult)){
                            $getsearchvalue = $row['searchvalue'];
                            $getsearchdate = $row['date'];
                            $getsearchqueryid = $row['id'];
                            echo "<tr>
                            <td><a href=\"search?q=$getsearchvalue\" class=\"text-reset\" tabindex=\"-1\" target=\"_blank\">$getsearchvalue</a></td>
                            <td>$getsearchdate</td>
                            <td class=\"text-end\">
                              <span class=\"dropdown\">
                                <button class=\"lang btn align-text-top\" key=\"deletesearch\" name=\"deletesearch\" value=\"$getsearchqueryid\">Delete Search</button>
                              </span>
                            </td>
                          </tr>";
                        };
                      }
                        ?>
                        </form>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item"><a href="https://github.com/Nomee6-Inc" target="_blank" class="link-secondary" rel="noopener">Github</a></li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; 2022
                    <a href="." class="link-secondary">Nomee6 Inc</a>.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-delhistory" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="lang modal-title" key="cleanhistory">Clean History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="" method="POST">
            <label class="form-check mb-2">
              <span class="lang form-label" key="cleanhistoryalert">
              All your history will be deleted!
              </span>
            </label>
          </div>
          <div class="modal-footer">
            <a class="lang btn btn-link link-secondary" data-bs-dismiss="modal" key="cancel">
              Cancel
            </a>
            <button type="submit" name="cleanhistory" class="lang btn btn-primary" key="cleanhistory">
              Clean History
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
    <script src="translate.js"></script>
  </body>
</html>