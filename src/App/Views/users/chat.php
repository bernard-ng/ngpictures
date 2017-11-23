<?php
session_start();
require '../php/fonction/functions.php';
$base = base_connexion("ngbdd");
include_once("../php/script/cookie.php");
  
if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{
    $last = $base->query("SELECT id FROM chat ORDER BY date_pub DESC LIMIT 0,1");
    $lastId = $last->fetch(); 

}else{
    
    header('location:/membres/login.php');
    $_SESSION['msg'] = "vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger";  }
    

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../require-files/favicon.php";?>
    <?php include '../require-files/all-meta.php'; ?>
    <title>Chat général</title>

    <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
    <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >

    <script type="text/javascript">
        var lastId = <?php echo $lastId['id'] ; ?> ;
    </script>
   

</head>
<body>

<div class="chatboxx">
    <div class="menu">

        <div class="back">
            <a href="profil.php?id=<?= $_SESSION['id']?>" class="ng-link-default">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <img src="/membres/Avatar/40-40/<?= poster_profil($_SESSION['id'])?>" draggable="false"/>
        </div>
        <div class="name">Chat-Général</div>
        <?= check_online_number(); ?>
           
    </div>
</div>
<br><br><br>
<?php include '../require-files/verset.php'; ?>
<?php include "../require-files/flash.php";?>

<div class="col-lg-3 col-sm-3 c col-md-3  hidden-xs ">
<div class="row">
<?php include '../require-files/last-ngpictures.php'; ?>
</div>
</div>

<div class="col-lg-6  col-sm-6  col-md-6  col-xs-12 ">
<div class="row">
<div class="chatboxx ng-panel-active" id="tchat">
    <ol class="chat">
        <center><span class="loader ng-loader-quart"></span></center>
    </ol>   
</div>
</div>
</div>

<div class="col-lg-3 col-sm-3 c col-md-3  hidden-xs ">
<div class="row">

<div class="ng-panel panel panel-default">
    <div class="box-header with-border">
        <h4 class="box-title"><span class="glyphicon glyphicon-chevron-right"></span> En ligne</h4>
    </div>
    <div class="box-body no-padding">
        <ul class="users-list clearfix">
            <?php $online = $base->query("SELECT userID from online limit 0,20");
            while ($m1 =  $online->fetch()){ ?>
            <li>
                <img src="/membres/Avatar/90-90/<?= poster_profil($m1['userID']) ?>" width="90" height="90">
                <a class="users-list-name" href="/membres/profil.php?id=<?= $m1['userID'] ?>">
                <?= poster_pseudo($m1['userID'])?></a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>

</div>
</div>

<div id="tchatFrom">
<form  action="" method="POST">
    <div class="textarea"> 
        <textarea name="message" placeholder="Message..."></textarea>
        <button class="textarea btn btn-primary" type="submit" name="message1" >
            <span class="glyphicon glyphicon-send"></span>
        </button>
    </div>
</form>
</div>

<!-- script -->

    <script>
    window.jQuery || document.write('<script src="../Mobile responsive/js/js+/jquery.min.js"><\/script>')
    </script>
    <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/ng-alert-v2.js"></script>
    <script src="/Mobile responsive/js/ng-js/tchat.js"></script>
     
<!-- / script -->

</body>
</html>