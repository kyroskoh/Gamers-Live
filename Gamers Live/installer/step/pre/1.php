<?php
error_reporting(0);
session_start();

if($_POST['serial_key'] == ""){

}else{
    $_SESSION['serial_key'] = $_POST['serial_key'];
}

$key = $_SESSION['serial_key'];

$app = "Gamers Live";

if($key == ""){
    header('Location: http://www.gamers-live.net/installer/?error=Please enter a valid serial key&app='.$app.'');
    exit;
}

if($key == null){
    header('Location: http://www.gamers-live.net/installer/?error=Please enter a valid serial key&app='.$app.'');
    exit;
}

// Database info
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("store", $connect) or die(mysql_error());

// first we check if there is a key wihh that string

$select_key = mysql_query("SELECT * FROM store_nexus_licensekeys WHERE lkey_key = '$key' AND lkey_active = '1'") or die(mysql_error());
$select_key_results = mysql_fetch_array($select_key);
$select_key_count = mysql_num_rows($select_key);

if($select_key_count < "1"){
    header('Location: http://www.gamers-live.net/installer/?error=The serial key is not valid&app='.$app.'');
    exit;
}
$app = "Gamers Live";
// setting variable
$ps_member = $select_key_results['lkey_member'];

// new we need to check if the key is expired

$select_product = mysql_query("SELECT * from store_nexus_purchases WHERE ps_member = '$ps_member' AND ps_active = '1'") or die(mysql_error());
$select_product_count = mysql_num_rows($select_product);

if($select_product_count == "0"){
    header('Location: http://www.gamers-live.net/installer/?error=The entered serial key is has expired&app='.$app.'');
    exit;
}else{
    $_SESSION['valid_key'] = true;
    $_SESSION['version'] = $_POST['version'];
}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">

    <!-- www.phpied.com/conditional-comments-block-downloads/ -->
    <!--[if IE]><![endif]-->

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame  -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Gamers Live</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="http://gamers-live.net/favicon.ico">
    <link rel="apple-touch-icon" href="http://gamers-live.net/apple-touch-icon.png">

    <!-- CSS - Setup -->
    <link href="http://gamers-live.net/css/style.css" rel="stylesheet" type="text/css" />
    <link href="http://gamers-live.net/css/base.css" rel="stylesheet" type="text/css" />
    <link href="http://gamers-live.net/css/grid.css" rel="stylesheet" type="text/css" />
    <!-- CSS - Theme -->
    <link id="theme" href="http://gamers-live.net/css/themes/light.css" rel="stylesheet" type="text/css" />
    <link id="color" href="http://gamers-live.net/css/themes/blue.css" rel="stylesheet" type="text/css" />

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="http://gamers-live.net/js/modernizr-1.5.min.js"></script>
</head>

<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->
<div id="wrapper">



    <!-- start header -->
    <header>
        <!-- logo -->
        <h1 id="logo"><a href="../">Gamers Live</a></h1>
        <!-- nav -->
        <br class="cl" />
    </header>
    <!-- end header -->
    <!-- page container -->
    <div id="page">
        <!-- page title -->
        <h2 class="ribbon blue full">Installer<span>You are about to to install <?=$app?></span> </h2>
        <div class="triangle-ribbon blue"></div>
        <br class="cl">
        <!-- page content -->
        <div id="page-content">
            <div class="grid_12">
                <div class="notification success"> <span class="strong">Success!</span> The key: <?=$key?> is valid!</div>
                <h3>WOWZA installation</h3>
                <p>Before we can start to install Gamers Live, we need to make sure you have installed and configured WOWZA Media Server correctly to work with Gamers Live</p>
                <p><b>Have you installed and configured WOWZA media server 3.5 or above to work with Gamers Live?</b></p>

                <form method="post" action="2.php">
                    <button class="fr blue" type="submit" id="submit">No - Help me install WOWZA</button>
                </form>                
                <form method="post" action="../check.php">
                    <button class="fr" type="submit" id="submit">Yes</button>
                </form>
            </div>
        </div>
        <br class="cl">
        <br class="cl">
    </div>
    <!-- footer Start -->
    <footer>

        <p>Copyright ©2013 <a href="http://www.gamers-live.net">Gamers Live</a></p>
        <br class="cl" />
    </footer>
    <!-- footer end -->

    <!-- Javascript at the bottom for fast page loading -->
    <script src="http://gamers-live.net/js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.tools.min.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.form.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/cufon-yui.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/Aller.font.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.tipsy.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/functions.js" type="text/javascript"></script>
    <!--[if lt IE 7 ]>
    <script src="http://gamers-live.net/js/dd_belatedpng.js"></script>
    <![endif]-->
</div>

</body>
</html>