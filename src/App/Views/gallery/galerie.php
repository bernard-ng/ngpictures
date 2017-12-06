<?php
session_start();
require '../php/fonction/functions.php';
$base = base_connexion("ngbdd");
include '../php/script/cookie.php';
include '../php/script/online.php'; 


if (isset($_SESSION['id']) and !empty($_SESSION['id']))
{

    $article = $base ->query("SELECT id  from ngarticle order by date_pub desc");

    if(isset($_GET['id']) and $_GET['id'] > 0 )
    {
        $getID=intval($_GET['id']);
        $verif=$base->prepare("SELECT * from membres where id=?");
        $verif->execute(array($getID));


        if(isset($_GET['q']) and !empty($_GET['q'])){

            $q = htmlspecialchars($_GET['q']);
            $userInfo=$verif->fetch();
            $photo = $base->prepare("SELECT * from galerie  where userID= ? and concat(tags,userID,date_pub) like '%".$q."%' order by date_pub desc ");
            $photo->execute(array($userInfo['id']));
            $Nump = $photo->rowcount();

        }

        if($verif->rowcount() == 1)
        {
            $userInfo = $verif->fetch();
            $photo = $base->prepare("SELECT * from galerie  where userID= ? order by date_pub desc ");
            $photo->execute(array($userInfo['id']));
            $Nump = $photo->rowcount();
        }


    }
    else{

            if(isset($_GET['q']) and !empty($_GET['q'])){

            $q = htmlspecialchars($_GET['q']);

            $photosParPage = 100;
            $photosTotalreq = $base->query("

                SELECT id 
                FROM nggalerie 
                WHERE concat(tags,userID,date_pub) 
                LIKE '%".$q."%' 
                ORDER BY date_pub desc"
            );

            $photoTotal = $photosTotalreq->rowcount();
            $pagestotals = ceil($photoTotal/$photosParPage);

            if(isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $pagestotals)
            {
                $_GET['page'] = intval($_GET['page']);
                $pagecourante = $_GET['page'];
            } 
            else{ $pagecourante = 1; }

            $depart = ($pagecourante-1)*$photosParPage;

            
            $photo = $base->query("

                SELECT * 
                FROM nggalerie 
                WHERE concat(tags,userID,date_pub) 
                LIKE '%".$q."%'
                ORDER BY date_pub DESC 
                LIMIT ".$depart.",".$photosParPage." "
            );

            $Nump = $photo->rowcount();

            }
            else{


            $photosParPage = 100;
            $photosTotalreq = $base->query('SELECT id FROM nggalerie ');
            $photoTotal= $photosTotalreq ->rowcount();
            $pagestotals=ceil($photoTotal/$photosParPage);

            if(isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $pagestotals)
            {
                $_GET['page'] = intval($_GET['page']);
                $pagecourante = $_GET['page'];
            } 
            else{ $pagecourante = 1; }

            $depart = ($pagecourante-1)*$photosParPage;

            $photo = $base->query("

                SELECT * 
                FROM nggalerie 
                ORDER BY date_pub DESC 
                limit ".$depart.",".$photosParPage." "
            );

            $Nump = $photo->rowcount();

            }   
        }
}
else{
  header("location:../membres/login.php");
  $_SESSION['msg'] = "vous devez vous connecter!";
  $_SESSION['type'] = "alert-danger";
}
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../require-files/favicon.php";?>
    <?php include '../require-files/all-meta.php'; ?>
    <title>Galerie</title>

    <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
    <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
    <script scr="/Mobile responsive/js/ng-js/ng-app.js"></script>
</head>
<body>
<section class="ng-bloc-principal">
  
<?php include '../require-files/galerie/menu.php'; ?>
<?php include '../require-files/flash.php'; ?>



<div class="jumbotron ng-margin-default">
    <div class="media">
        <div class="container">
            <div class="media-body" >
                <h2 id="page_title" class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Galerie</h2>
                <span id="page_desc">
                    hey <b><?= $_SESSION['pseudo']?></b>, Bienvenue dans ma galerie
                </span>
            </div>
        </div>
    </div>     
</div>
<div class="col-xs-12">
    <div class="row">
        <ul class="nav nav-tabs ng-margin-default">
            <li role="presentation">
                <?php if(isset($_GET['id']) and !empty($_GET['id'])){?>
                    <a  href="/galerie/galerie.php" >
                        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Galerie
                    </a>
                <?php }else{ ?>
                    <a  href="/galerie/galerie.php?id=<?=$_SESSION['id']?>" >
                        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Ma galerie
                    </a>
                <?php } ?>    
            </li>
        </ul>
    </div>
</div>

<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
      <div class="row">
            <div class="container-fluide">
                <form class="input-group ng-panel-info " method="GET" action="galerie.php">
                    <input name="q" type="text" class="form-control" placeholder="Rechercher une photo...">
                    <span class="input-group-btn" >
                        <button  type="submit" value="Go" class="btn btn-primary ng-input" type="button">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </span>
                </form>
           
<!-- carousel -->               
                <div class="ng-alert ng-panel panel panel-primary">
                    <div class="ng-panel panel-heading " role="tab" id="headingOne1"><span class="glyphicon glyphicon-camera"></span>  #NGPICTURES                             
                    </div>

                <div class="panel-body">
                    <p>
                        Hey <b><?= poster_pseudo($_SESSION['id'])?></b> Tu peux Rétrouver ces articles Tout de suite...<br> en un clique
                    </p>                  
                </div>

                <ul class="list-group">
                    <li class="list-group-item ng-panel-img">    
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                <center>
                                    <img class="img img-responsive" src="/article/miniature/640-640/rien.jpg" height="640" />
                                </center> 
                                </div>

                                <?php while($a = $article->fetch()){?>

                                    <div class="item" >
                                        <a href="/ngarticle/ngarticle.php?id=<?= $a['id'] ?>"/>
                                        <center>
                                            <img class="img img-responsive" src="../ngarticle/miniature/640-640/<?= ngarticle_min($a['id']); ?>"/>
                                        </center>
                                        </a>
                                    </div>           
                                                    
                                <?php } ?>
                            </div>

                            <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                                <span class="icon-prev"></span>
                            </a>
                            <a class="carousel-control right" href="#myCarousel" data-slide="next">
                                <span class="icon-next"></span>
                            </a>

                        </div>
                    </li>
                </ul>
<!-- /carousel -->
    </div>
</div>

</div><!-- important -->
</div><!-- important -->

<section id="ng-bloc-contenu">
<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12" >
    <div class="row">
        <div class="ng-panel panel panel-default ng-panel-active">
        <div class="ng-panel panel-heading ng-margin-default"><span class="glyphicon glyphicon-camera pull-right"></span> DEEP SHOOTING...</div>

        <?php if($Nump == 0) {?>

            <div class="ng-panel panel-heading ng-margin-default"><span class="glyphicon glyphicon-alert pull-right"></span> AUCUNE PUBLICATION POUR L'INSTANT</div>
                <ul class="list-group">
                    <li class="list-group-item ng-panel-img">
                        <div class="container-fluide">
                            <a><img src="/article/miniature/640-640/rien.jpg" class="img-responsive" ></a>                                   
                        </div>
                    </li>
                </ul>

        <?php }else{
            if(isset($_GET['id']) and !empty($_GET['id'])){
            while($p = $photo->fetch()){?>

            <div class="col-sm-3 col-lg-3 col-md-3 col-xs-3" id="galerie">
                    <div class="row">
                        <div class="ng-img">
                            <a href="/galerie/photo.php?type=user&id=<?= $p['id']; ?>">      
                                <img class="img text-right" width="100%" src="/galerie/images/640-640/<?= photo_min($p['id']); ?>" />          
                            </a>
                        </div>
                    </div>
            </div>
        <?php  }

            }else{ 
            while($p = $photo->fetch()){?>

                <div class="col-sm-3 col-lg-3 col-md-3 col-xs-4" id="galerie" >
                    <div class="row">
                        <div class="ng-img">
                             <a href="/galerie/ngphoto.php?id=<?= $p['id']; ?>">      
                                <img class="img img-responsive" width="640" src="/galerie/ngimages/640-640/<?= ngphoto_min($p['id']); ?>"/>          
                            </a>
                        </div>
                    </div>
                </div>

           <?php } // while
            } // else
        }  // else principal
        ?> 


        </div>
    </div>

    <div class="ng-espace-fantom"><?php include '../require-files/galerie/pagination.php'; ?></div>

</div>
</section>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="row">
    <div class="ng-panel panel-primary panel-heading ">
        <span class="left">NAVIGATION</span><br>
          
        <a class="btn btn-primary btn-xs ng-btn" href="/home.php" >
              <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
        </a>
        <a class="btn btn-primary btn-xs ng-btn" href="/article/actualite.php" >
              <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
        </a>

        <a class="btn btn-primary btn-xs ng-btn" href="/membres/profil.php?id=<?= $_SESSION['id']?>" >
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        </a>

        <a class="btn btn-primary btn-xs ng-btn" href="/article/news.php" >
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </a>

        <a class="btn btn-primary btn-xs ng-btn" href="/galerie/galerie.php">
              <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
        </a>
    </div>


<?php include '../require-files/last-ngpictures.php'; ?>


</div>

</div>


</section>
<?php include "../require-files/footer.php"; ?>

<!--importation des script -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script>
      window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
      </script>
      <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/ng-alert-V2.js"></script>
    <script src="/Ngpictures 2.0/js/velocity.min.js"></script>
    <script src="/Mobile responsive/js/ng-js/ng-app.js"></script>
<!-- /importation des script -->

  </body>
</html>