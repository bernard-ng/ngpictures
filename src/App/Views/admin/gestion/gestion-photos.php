<?php
session_start();
require '../../php/fonction/functions.php';
$base = base_connexion("ngbdd"); 


if (isset($_SESSION['id']) and !empty($_SESSION['id']))
{
    $photo = $base->query("SELECT * from nggalerie  order by  date_pub desc");
    $Nump = $photo->rowcount();

    if(isset($_GET['q']) and !empty($_GET['q']))
    {
        $q = htmlspecialchars($_GET['q']);
        $photo = $base->query("SELECT * from nggalerie where concat(id,tags,nom,date_pub) like '%".$q."%' order by id desc");
        $Nump = $photo->rowcount();
    }

    if(isset($_GET['id']) and !empty($_GET['id']))
    {

        $info = $base->prepare("SELECT confirme from nggalerie where id = ?  limit 0,1");
        $getID = htmlspecialchars($_GET['id']);
        $info->execute(array($getID));
        $info = $info->fetch();
    }

}
else{
    header("location:/membres/login.php");
    $_SESSION['msg'] = "vous devez vous connecter!";
    $_SESSION['type'] = "alert-danger"; }
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width" />
        <?php include "../../require-files/favicon.php";?>
        <title>Gestion-galerie</title>
        <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
        <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
        <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >

    </head>

<body>
<section class="ng-bloc-principal">

<?php include '../../require-files/admin/menu.php'; ?>
<?php include '../../require-files/flash.php'; ?>

<div class="jumbotron ng-margin-default">
    <div class="media">
        <div class="container">
            <div class="media-body" >
                <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>  Gestion photos</h2>
                ma galerie, confirmation,suppression, et autre...
            </div>
        </div>
    </div>     
</div>

<div class="col-lg-4 col-md-4 col-xs-12 col-sm-4">
    <div class="row">

        <div class="container-fluide">
            <form class="input-group ng-panel-info " method="get" action=" ">
                <input name="q" type="text" class="form-control" placeholder="Recherche...">
                <span class="input-group-btn" >
                    <button  type="submit" value="Go" class="btn btn-primary ng-input" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </span>
            </form>
        </div>


        <div class="ng-panel panel panel-default ng-panel-active">

            <div class="ng-panel panel-heading ng-margin-default">
                <span class="glyphicon glyphicon-chevron-left pull-right"></span> ACTIONS
            </div>


            <?php 
            if(isset($_GET['id']) and !empty($_GET['id'])){?>


            <div class="btn-group btn-group-justified ng-margin-default" role="group">

                <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><a href="/admin/index.php?type=photo&p_supprime=<?= $_GET['id'] ?>">supprimer</a></button>
                </div>

                <?php if(empty($info['confirme'])){?>
                <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><a href="/admin/index.php?type=photo&p_aprouve=<?= $_GET['id'] ?>">confirmer</a></button>
                </div>
                <?php }?>

                <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><a href="/galerie/ngphoto.php?id=<?= $_GET['id'] ?>">voir</a></button>
                </div>

            </div>

                <ul class="list-group">
                    <li class="list-group-item ng-panel-img">
                    <div class="container-fluide">
                        <img src="/galerie/ngimages/640-640/<?= ngphoto_min($getID)?>" class="img-responsive" >                
                    </div>
                    </li>
                </ul>

            <?php }else{?>

                <ul class="list-group">
                    <li class="list-group-item ng-panel-img">
                    <div class="container-fluide">
                        <img src="/article/miniature/rien.jpg" class="img-responsive" >                
                    </div>
                    </li>
                </ul>

            <?php } ?>
        </div>

    </div>
</div>



<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12" >
    <div class="row">
        <div class="ng-panel panel panel-default ng-panel-active">
            <div class="ng-panel panel-heading ng-margin-default"><span class="glyphicon glyphicon-camera pull-right"></span> DEEP SHOOTING...</div>

            <?php 

                if($Nump == 0)
                {?>

                <div class="ng-panel panel-heading ng-margin-default"><span class="glyphicon glyphicon-alert pull-right"></span> AUCUNE PUBLICATION POUR L'INSTANT</div>
                <ul class="list-group">
                    <li class="list-group-item ng-panel-img">
                        <div class="container-fluide">
                            <a><img src="/article/miniature/rien.jpg" class="img-responsive" ></a>                                   
                        </div>
                    </li>
                </ul>


               <?php }else{

                  while($p = $photo->fetch()){?>

                    <div class= "col-lg-2 col-sm-2 col-md-2 col-xs-3">
                        <div class="row">
                            <div class="ng-img">
                                <a href="gestion-photos.php?id=<?= $p['id']; ?>">      
                                    <img class="img text-right" width="100%" src="/galerie/ngimages/640-640/<?= ngphoto_min($p['id']); ?>"/>          
                                </a>
                            </div>
                        </div>
                    </div>

                 <?php  }


                } ?>
        </div>
    </div>
    <div class="ng-espace-fantom"></div>
</div>


</section>

<?php include "../../require-files/footer.php" ?>

<!--importation des script -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script>
      window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
      </script>
      <script src="/Mobile responsive/js/bootstrap.min.js"></script>
      <script src="/Mobile responsive/js/ng-alert-V2.js"></script>
<!-- /importation des script -->

</body>
</html>