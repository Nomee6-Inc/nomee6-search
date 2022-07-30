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
if (!isset($_SESSION['username'])) {
    header("Location: login?redir=account");
} else {
$query = mysqli_query($conn,"SELECT * FROM users WHERE email = '$getuseremail'");
$result = $query->fetch_assoc();
if($query->num_rows > 0) {
  //
} else {
  session_destroy();
  header("Location: login");
}
$usernow2fastatus = $result['2fastatus'];
$usernow2fatoken = $result['2fatoken'];
$usernowpasswd = $result['password'];

if (isset($_POST['changepasswd'])) {
  $getnowpasswd = $_POST['nowpassword'];
  $getnewpasswd = $_POST['newpassword'];
  if(hash('sha256', $getnowpasswd) == $usernowpasswd) {
    $hashnewpassword = hash('sha256', $getnewpasswd);
    $sql = "UPDATE users SET password = '$hashnewpassword' WHERE email = '$getuseremail'";
    $run_query = mysqli_query($conn, $sql);
    if($run_query) {
      header("Refresh:2 url=login");
      echo "<div class=\"alert alert-success\">
      <h4 class=\"lang alert-title\" key=\"passwordupdatedsuccess\" style=\"text-align:center\">Password updated successfully.</h4>
    </div>";
      session_destroy();
    } else {
      echo "<div class=\"alert alert-danger\">
      <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Bir hata oluştu!</h4>
    </div>";
    }
  } else {
    echo "<div class=\"alert alert-warning\">
    <h4 class=\"lang alert-title\" key=\"currentpasswordincorrect\" style=\"text-align:center\">Şimdiki şifrenizi doğru girmediniz!</h4>
  </div>";
  }
};

if (isset($_POST['updateemail'])) {
  $getnowpasswdce = $_POST['nowpasswordce'];
  $getnewemail = $_POST['newemail'];
  if(hash('sha256', $getnowpasswdce) == $usernowpasswd) {
    $sql1 = "UPDATE users SET email = '$getnewemail' WHERE email = '$getuseremail'";
    $run_query1 = mysqli_query($conn, $sql1);
    if($run_query1) {
      header("Refresh:2 url=login");
      echo "<div class=\"alert alert-success\">
      <h4 class=\"lang alert-title\" key=\"emailupdatedsuccess\" style=\"text-align:center\">Email updated successfully.</h4>
    </div>";
      session_destroy();
    } else {
      echo "<div class=\"alert alert-danger\">
      <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Something went wrong!</h4>
    </div>";
    }
  } else {
    echo "<div class=\"alert alert-warning\">
    <h4 class=\"lang alert-title\" key=\"currentpasswordincorrect\" style=\"text-align:center\">Şimdiki şifrenizi doğru girmediniz!</h4>
  </div>";
  }
};

if (isset($_POST['deleteaccount'])) {
  $getnowpasswdda = $_POST['yourcurrentpasswordda'];
  if(hash('sha256', $getnowpasswdda) == $usernowpasswd) {
    $generateaccdeletiontoken = openssl_random_pseudo_bytes(40);
    $generateaccdeletiontoken = bin2hex($generateaccdeletiontoken);
    $currentdate = date("Y-m-d");
    $now15dayafter = strtotime(date("Y-m-d", strtotime($currentdate)) . " +15 day");

    $sql2 = "INSERT INTO accountdeletion (deletiontoken, authoraccount, expiredate)
					VALUES ('$generateaccdeletiontoken', '$getuseremail', '$now15dayafter')";
	  $run_query2 = mysqli_query($conn, $sql2);
    $mail = new PHPMailer(true);
    $mail->isSMTP();           
    $mail->Host = "";
    $mail->SMTPAuth = true;
    $mail->Username = "";                 
    $mail->Password = "";
    $mail->SMTPSecure = "tls";
    $mail->verify_peer = false;
    $mail->verify_peer_name = false;
    $mail->allow_self_signed = true;
    $mail->Port = 587;
    $mail->From = "";
    $mail->FromName = "";
    $mail->addAddress($getuseremail);
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->Subject = "";
    $mail->ContentType = 'text/html; charset=utf-8';
    $mail->Body = "Hesabınızı silmek için aşağıda ki linke tıklayabilirsiniz. <br> <a href=\"https://search.nomee6.xyz/deleteaccount?token=$generateaccdeletiontoken\">Hesabı Sil</a> <br>Eğer bu işlemi siz gerçekleştirmediyseniz lütfen şifrenizi değiştirin.";
    $mail->Timeout       =   60;
    $mail->SMTPKeepAlive = true;
    if($run_query2 && $mail->send()) {
      echo "<div class=\"alert alert-success\">
      <h4 class=\"lang alert-title\" key=\"accountdeletionemailsended\" style=\"text-align:center\">Account deletion email sended succesfully.</h4>
    </div>";
    } else {
      echo "<div class=\"alert alert-danger\">
      <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Something went wrong!</h4>
    </div>";
    }
  } else {
    echo "<div class=\"alert alert-warning\">
    <h4 class=\"lang alert-title\" key=\"currentpasswordincorrect\" style=\"text-align:center\">Şimdiki şifrenizi doğru girmediniz!</h4>
  </div>";
  }
}

if (isset($_POST['activate2fa'])) {
  $authenticator2fa2 = new PHPGangsta_GoogleAuthenticator();
 
  $secret2fa2 = $_POST['activate2fa'];
  $otp2fa = $_POST['2facode'];
   
  $tolerance = 0;
  $checkResult2fa = $authenticator2fa2->verifyCode($secret2fa2, $otp2fa, $tolerance);
   
  if ($checkResult2fa) {
    $sql96 = "UPDATE users SET
     2fastatus = 'active',
     2fatoken = '$secret2fa2'
    WHERE email = '$getuseremail'";
    $run_query96 = mysqli_query($conn, $sql96);
      if($run_query96) {
        header("Refresh:2");
        echo "<div class=\"alert alert-success\">
        <h4 class=\"lang alert-title\" key=\"otpvalidatedsuccess2fa\" style=\"text-align:center\">OTP is Validated Succesfully.</h4>
      </div>";
      } else {
        echo "<div class=\"alert alert-danger\">
        <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Sometnig went wrong.</h4>
      </div>";
      }
  } else {
      echo "<div class=\"alert alert-warning\">
      <h4 class=\"lang alert-title\" key=\"incorrectotp2facode\" style=\"text-align:center\">You entered the wrong OTP Code!</h4>
    </div>";
  }
}

if (isset($_POST['deactivate2fa'])) {
  $authenticator2fa3 = new PHPGangsta_GoogleAuthenticator();
 
  $secret2fa3 = $usernow2fatoken;
  $otp2fa2 = $_POST['2facodedeactivate2fa'];
   
  $tolerance = 0;
  $checkResult2fa2 = $authenticator2fa3->verifyCode($secret2fa3, $otp2fa2, $tolerance);    
   
  if ($checkResult2fa2) {
    $sql97 = "UPDATE users SET
     2fastatus = 'deactive',
     2fatoken = ''
    WHERE email = '$getuseremail'";
    $run_query97 = mysqli_query($conn, $sql97);
      if($run_query97) {
        header("Refresh:2");
        echo "<div class=\"alert alert-success\">
        <h4 class=\"lang alert-title\" key=\"2fasuccessdisabled\" style=\"text-align:center\">2FA Successfully Disabled!</h4>
      </div>";
      } else {
        echo "<div class=\"alert alert-danger\">
        <h4 class=\"lang alert-title\" key=\"somethingwentwrong\" style=\"text-align:center\">Sometnig went wrong.</h4>
      </div>";
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
              <li class="nav-item active">
                <a class="nav-link" href="account" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
	                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><circle cx="12" cy="10" r="3" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                  </span>
                  <span class="lang nav-link-title" key="accountmngmnt">
                    Account Management
                  </span>
                </a>
              </li>
              <li class="nav-item">
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
                <h2 class="lang page-title" key="accountmngmnt">
                  Account Management
                </h2>
              </div>
            </div>
          </div>
        </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="col-12">
          <h4 class="lang" key="updatepersonalinfo">Update personal information</h4>
          <form action="" method="POST">
            <div class="card">
              <div class="card-body">
                <div class="mb-3">
                  <div class="lang form-label" key="nowpassword">Current password</div>
                  <input type="password" name="nowpasswordce" class="form-control" autocomplete="off" required/>
                </div>
                <div class="mb-3">
                  <div class="lang form-label" key="newemail">New Email</div>
                  <input type="email" class="form-control" name="newemail" required>
                </div>
                <div class="mt-2">
                  <button type="submit" name="updateemail" class="lang btn btn-primary w-100" key="update">
                    Update
                  </button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <div class="col-12">
                <h4 class="lang" key="changepassword">Change Password</h4>
                <form action="" method="POST">
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-3">
                        <div class="lang form-label" key="nowpassword">Current Password</div>
                        <input type="password" name="nowpassword" class="form-control" autocomplete="off" required/>
                      </div>
                      <div class="mb-3">
                        <div class="lang form-label" key="newpassword">New Password</div>
                        <input type="password" class="form-control" name="newpassword" required>
                      </div>
                      <div class="mt-2">
                        <button type="submit" name="changepasswd" class="lang btn btn-primary w-100" key="update">
                          Update
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div class="col-12">
                <h4 class="lang" key="additionalactions">Additional actions</h4>
                <form action="" method="POST">
                  <div class="card">
                    <div class="card-body">
                      <div class="mt-2">
                        <a class="lang btn btn-red" key="delaccount" data-bs-toggle="modal" data-bs-target="#modal-delaccount">
                          Delete Account
                        </a>
                        <?php
                        if($usernow2fastatus == "active") {
                            echo "<a class=\"lang btn btn-primary\" key=\"deactivate2fa\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-deactivate2fa\">
                            Deactivate 2FA
                          </a>";
                        } else {
                          echo "<a class=\"lang btn btn-primary\" key=\"activate2fa\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-activate2fa\">
                            Activate 2FA
                          </a>";
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
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
    <div class="modal modal-blur fade" id="modal-delaccount" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="lang modal-title" key="delaccount">Delete Account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label class="lang form-label" key="yourpassword">Your Password</label>
              <input type="password" class="form-control" name="yourcurrentpasswordda" required>
            </div>
            <label class="form-check mb-2">
              <input class="form-check-input" type="checkbox" required>
              <span class="lang form-check-label" key="yespermadelaccalert">
                Yes, I want to permanently delete my account and all its data.
              </span>
            </label>
          <small class="lang" key="afterproccessemaildelaccalert">
            After this process, you will receive an e-mail that will allow you to delete your account.
          </small>
          </div>
          <div class="modal-footer">
            <a class="lang btn btn-link link-secondary" data-bs-dismiss="modal" key="cancel">
              Cancel
            </a>
            <button type="submit" name="deleteaccount" class="lang btn btn-red" key="delaccount">
              Delete Account
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-activate2fa" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="lang modal-title" key="activate2fa">Activate 2FA</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="" method="POST">
            <?php
            $authenticator2fa = new PHPGangsta_GoogleAuthenticator();
            $secret2fa = $authenticator2fa->createSecret();

            $website2fa = 'https://search.nomee6.xyz';
            $title2fa = 'NOMEE6 Search';
            $qrCodeUrl2fa = $authenticator2fa->getQRCodeGoogleUrl($title2fa, $secret2fa, $website2fa);
            echo "<img src=\"$qrCodeUrl2fa\"></img><br>2FA Token: <a style=\"-webkit-user-select: text;user-select: text;\">$secret2fa</a><br>";
            ?>
            <br>
            <div class="mb-3">
              <label class="lang form-label" key="2facode">2FA Code</label>
              <input type="text" class="form-control" name="2facode" required>
            </div>
          </div>
          <div class="modal-footer">
            <a class="lang btn btn-link link-secondary" data-bs-dismiss="modal" key="cancel">
              Cancel
            </a>
            <button type="submit" name="activate2fa" class="lang btn btn-green" key="activate2fa" value="<?php echo $secret2fa; ?>">
              Activate 2FA
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-deactivate2fa" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="lang modal-title" key="deactivate2fa">Deactivate 2FA</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label class="lang form-label" key="2facode">2FA Code</label>
              <input type="text" class="form-control" name="2facodedeactivate2fa" required>
            </div>
          </div>
          <div class="modal-footer">
            <a class="lang btn btn-link link-secondary" data-bs-dismiss="modal" key="cancel">
              Cancel
            </a>
            <button type="submit" name="deactivate2fa" class="lang btn btn-red" key="deactivate2fa">
              Deactivate 2FA
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