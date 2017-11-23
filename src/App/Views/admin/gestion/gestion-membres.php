<?php 
session_start();
require "../../php/fonction/functions.php";
$base= base_connexion("ngbdd");

if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{

    $users=$base->query("SELECT * from membres order by date_ins desc");
    $last=$base->query("SELECT * from membres order by date_ins desc limit 0,8");


    if(isset($_GET['q']) and !empty($_GET['q']))
    {
        $q= htmlspecialchars($_GET['q']);
        $users=$base->query("SELECT * from membres where pseudo like '%".$q."%' order by id desc");
    }

}else{

    header("location:../membres/login.php");
    $_SESSION['msg'] = "vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger";}

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width" />
        <?php include "../../require-files/favicon.php";?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Gestion-membres</title>

        <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
        <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
        <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
    </head>

<body>
<section class="ng-bloc-principal">

<!--nav bar--> 
<?php require "../../require-files/admin/menu.php"; ?>
<?php require "../../require-files/flash.php";?>
<!-- /navbar -->

<div class="jumbotron ng-margin-default">
    <div class="media">
        <div class="container">
            <div class="media-body" >
                <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Gestion membres</h2>
                mes membres, confirmation si sa n'as pas été fait par mail, suppression...
                ajout des grades...
            </div>
        </div>
    </div>
    <br>   
</div>


<div class="col-xs-12 col-lg-3 col-md-3 col-sm-3">
<div class="row">

    <form class="input-group ng-panel-info" method="GET" action="">
        <input name="q" type="text" class="form-control" placeholder="recherche">
        <span class="input-group-btn" >
        <button  type="submit" value="Go" class="btn btn-primary ng-input" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </span>
    </form>

<div class="box box-default ng-panel-active">
    <div class="box-header with-border">
        <h4 class="box-title"><span class="glyphicon glyphicon-chevron-right"></span> DERNIER MEMBRES</h4>
    </div>
    <div class="box-body no-padding">
        <ul class="users-list clearfix">
            <?php for($i = 8; $m1 = $last->fetch();$i--){?>
            <li>
                <img src="/membres/Avatar/90-90/<?= poster_profil($m1['id']) ?>" width="90" height="90">
                <a class="users-list-name" href="/membres/profil.php?id=<?= $m1['id'] ?>"><?= poster_pseudo($m1['id'])?></a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>

</div>
</div>


<div class="col-xs-12 col-lg-9 col-md-9 col-sm-9">
<div class="row">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" >
        <li role="presentation" class="active">
            <a href="#membres">
                Membres
            </a>
        </li>
    </ul>



<?php $Nm = $users->rowcount(); ?>
<h2>Résultat<?= $t = ($Nm > 1) ? "s" : "" ;?> <span class="ng-badge badge"><?= KM_format($Nm) ?></span></h2>

                 
<?php if($users->rowcount() > 0 ){?>
    <?php while ($m = $users->fetch()){?>
                       
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="ng-user-box">

                            <img src="/membres/Avatar/40-40/<?= poster_profil($m['id'])?>" width="40px" height="40px" class="img img-circle"/>
                            <?= poster_pseudo($m['id']) ?>

                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class=" glyphicon glyphicon-option-vertical pull-right"></span></a>
                                <span class="pull-right"><?= Check_user_online($m['id'])?></span>
                            
                                <ul class="dropdown-menu panel-heading">

                                    <li><a>Follower<?= $t=(Check_follower_num($m['id']) > 1) ? "s" : ""?>: <?= KM_format(Check_follower_num($m['id']))?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a>Following: <?= KM_format(Check_following_num($m['id']))?></a></li>
                                    <li role="separator" class="divider"></li>

                                    <?php $poste = photo_info($m['id'],"nombre") + article_info($m['id'],"nombre") ?>         
                                    <li><a>Poste<?= $test = ($poste > 1) ? "s" : "" ;?>: <?php echo KM_format($poste); ?> </a></li>

                                </ul>
                            </li>
                            
                                            
                            <?php if(empty($m['statut'])){?>
                                <h5>Hey tout le monde, suis sur #Ngpictures...</h5>
                            <?php }?>

                            <h5><?= nl2br(user_mention_verif($m['statut'])) ?></h5>


                            <?php if($_SESSION['id'] != $m['id']){?>

                                <?php $photo= $base->prepare("SELECT * from galerie where userID = ? order by date_pub desc limit 0,3");           
                                $photo->execute(array($m['id']));?>
                                <?php while($p = $photo->fetch()){ ?>
                                    
                                <?php
                                    // les photo doit fit avec la taille d l'ecran c prkoi y a toute ces class la...
                                    if($photo ->rowcount() >= 3){ $class ="col-lg-4 col-sm-4 col-md-4 col-xs-4 pull-left";
                                    }elseif($photo ->rowcount() == 2){  $class="col-lg-6 col-sm-6 col-md-6 col-xs-6 pull-left";
                                    }else{ $class="hidden-lg hidden-sm hidden-xs hidden-md";}
                                ?>

                                <div class="<?= $class ?>">
                                    <div class="row">
                                        <div class="ng-img-default">
                                            <a href="/galerie/photo.php?id=<?= $p['id']; ?>">      
                                                <img class="img img-responsive" src="/galerie/images/640-640/<?= $p['nom'] ?>" alt="...">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php }?>
                                <div class="btn-group btn-sm " role="group">

                                <?php if($m['confirme'] == 0 ){?>
                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/admin/index.php?type=membre&confirme=<?= $m['id']; ?>">confirmer</a>
                                </button> 
                                <?php }?>



                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/admin/index.php?type=membre&supprime=<?= $m['id']; ?>">supprimer</a>
                                </button>


                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/membres/profil.php?id=<?= $m['id'] ?>">profil</a>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/galerie/galerie.php?id=<?= $m['id'] ?>">galerie</a>
                                </button>  
                                </div> 

                            <?php }?>
                </div>
            </div>
        </div>
                                       
                              
<?php }?>
                     
<?php }else{?>

    <div class="ng-user-box">
    <div class="media">
        <div class="media-left media-top">
            <img class="media-object" src="/membres/Avatar/90-90/ng.png" width="90" height="90">
        </div>
        <div class="media-body">
            <h4 class="media-heading"><?php if(isset($q)){ echo $q;}else{ echo "#Ngpictures ";} ?></h4>
            <?php if(isset($q)){echo "Aucun résultat pour ce membre";}else{ echo "Aucun membre";}?>
            <hr>
            <time><?= today_date() ?></time>
        </div>
    </div>
    </div>

<?php }?>



</div><!-- /membres -->
</div>

</section>

<?php include '../../require-files/footer.php';?>

<!-- script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
    </script>
    <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/ng-alert-V2.js"></script>
<!-- / script -->

</body>
</html>