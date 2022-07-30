<?php
session_start();
$getuseremail = $_SESSION['email'];
$getusername = $_SESSION['username'];
include 'config.php';
$getsearchquery = $_GET['q'];
if(!$getsearchquery) {
    header("Location: ./");
};


if (isset($_POST['searchsubmit'])) {
    $getsearchquerybox = $_POST['searchquery'];
    header("Location: search?q=$getsearchquerybox");

    if (isset($_SESSION['username'])) {
        $getdate = date("d.m.Y");
        $sql = "INSERT INTO searchs (searchvalue, author, date)
                        VALUES ('$getsearchquerybox', '$getuseremail', '$getdate')";
        $run_query = mysqli_query($conn, $sql);
    }
};
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title><?php echo $getsearchquery; ?> Sonuçları | NOMEE6 Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style1.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <script type="text/javascript" src="translate.js"></script>
    <link rel="search" href="https://search.nomee6.xyz/opensearch.xml" title="Nomee6 Search" type="application/opensearchdescription+xml" />
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
<a href="./"><img src="https://nomee6.xyz/assets/pp.png" class="imgsrchresults"></a>
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
<a href="account" class="headerbtn lang" key="account" style="color: white;text-decoration: none;">Hesabım</a>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="search-result-box card-box">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="pt-3 pb-4">
                            <form method="POST" action="" accept-charset="utf-8">
                                <div class="input-group">
                                    <input type="text" name="searchquery" class="form-control" value="<?php echo $getsearchquery; ?>" required>
                                    <div class="input-group-append">
                                        <button type="submit" name="searchsubmit" class="btn waves-effect waves-light btn-custom"><a class="lang" key="search">Ara</a></button>
                                    </div>
                                </div>
                            </form>
                                <div class="mt-4 text-center">
                                    <h4>"<?php echo $getsearchquery; ?>"</h4></div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs tabs-bordered">
                        <li class="nav-item"><a href="#home" data-toggle="tab" aria-expanded="true" class="lang nav-link active" key="web">Web</a></li>
                        <?php
                        $sql2 = "SELECT * FROM companies WHERE name LIKE '%$getsearchquery%'";
                        $result2 = mysqli_query($conn, $sql2);
                        if(mysqli_num_rows($result2) != 0) {
                            echo "<li class=\"nav-item\"><a href=\"#company\" data-toggle=\"tab\" aria-expanded=\"false\" class=\"nav-link\"><z class=\"lang\" key=\"companyinfo\">Şirket Bilgisi</z> <span class=\"badge badge-danger ml-1\">BETA</span></a></li>";
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-md-12">
                                <?php
                                    $sql = "SELECT * FROM urls WHERE tags LIKE '%$getsearchquery%'";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($result)){
                                        $sitename = $row['sitename'];
                                        $sitedesc = $row['description'];
                                        $siteurl = $row['url'];
                                       echo "<div class=\"search-item\">
                                       <h4 class=\"mb-1\"><a href=\"$siteurl\">$sitename</a></h4>
                                       <div class=\"font-13 text-success mb-3\">$siteurl</div>
                                       <p class=\"mb-0 text-muted\">$sitedesc</p>
                                   </div>";
                                    };
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="company">
                            <?php
                            if(mysqli_num_rows($result2) != 0) {
                            $rowcompany = mysqli_fetch_array($result2);
                                $companyname = $rowcompany['name'];
                                $companybio = $rowcompany['bio'];
                                $companycontactmail = $rowcompany['contactmail'];
                                $companyphoto = $rowcompany['photo'];
                                $companywebsite = $rowcompany['website'];
                                $companyceo = $rowcompany['ceo'];
                                $companyfoundation = $rowcompany['foundation'];
                               echo "<div class=\"search-item\">
                               <div class=\"media mt-1\"><img class=\"d-flex mr-3 rounded-circle\" src=\"$companyphoto\" height=\"54\">
                                   <div class=\"media-body\">
                                       <h5 class=\"media-heading mt-0\"><a class=\"text-dark\">$companyname</a></h5>
                                       <p class=\"font-13\"><b class=\"lang\" key=\"companyemail\">Email:</b> <span><a href=\"mailto:$companycontactmail\" class=\"text-muted\" style=\"text-decoration: none;\">$companycontactmail</a></span></p>
                                       <p class=\"font-13\"><b class=\"lang\" key=\"companywebsite\">Website: </b> <span><a href=\"$companywebsite\" target=\"_blank\" class=\"text-muted\" style=\"text-decoration: none;\">$companywebsite</a></span></p>
                                       <p class=\"font-13\"><b class=\"lang\" key=\"companyceo\">Şirket CEO:</b> <span><a class=\"text-muted\" style=\"text-decoration: none;font-family: Roboto;\">$companyceo</a></span></p>
                                       <p class=\"font-13\"><b class=\"lang\" key=\"companyfounddate\">Kuruluş Tarihi:</b> <span><a class=\"text-muted\" style=\"text-decoration: none;font-family: Roboto;\">$companyfoundation</a></span></p>
                                       <p class=\"mb-0 font-13\"><b class=\"lang\" key=\"companybio\">Bio:</b>
                                           <br><span class=\"text-muted\">$companybio</span></p>
                                   </div>
                               </div>
                            </div>";
                            };
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
