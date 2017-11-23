<?php 
session_start();
require "../php/fonction/functions.php";
$base= base_connexion("ngbdd");
include_once("../php/script/cookie.php");


if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{

    $users = $base->prepare("SELECT * FROM membres WHERE id != ? ORDER BY date_ins DESC LIMIT 0,80");
    $users->execute(array($_SESSION['id']));

    $follower = $base->prepare("SELECT followerID FROM following WHERE followingID = ? ORDER BY id DESC");
    $follower->execute(array($_SESSION['id']));

    $fn = $follower->rowcount();


    $following = $base->prepare("SELECT followingID FROM following WHERE followerID = ? ORDER BY id DESC ");
    $following ->execute(array($_SESSION['id']));


    if(isset($_GET['q']) and !empty($_GET['q']))
    {
        $q = htmlspecialchars($_GET['q']);
        $users=$base->query("SELECT * FROM membres WHERE pseudo like '%".$q."%' ORDER BY id DESC");
    }

}else{

    header("location:/membres/login.php");
    $_SESSION['msg'] = "Vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger"; } 


?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width" />
        <?php include "../require-files/favicon.php";?>
        <?php include '../require-files/all-meta.php'; ?>
        <title>Membres</title>

        <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
        <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
        <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >

    </head>
<body>
<section class="ng-bloc-principal">

<?php include "../require-files/profil/menu.php"; ?>
<?php include "../require-files/flash.php";?>

<div class="jumbotron ng-margin-default">
    <div class="media">
        <div class="container">
            <div class="media-body" >
                <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Les membres</h2>
                Retrouve tout les nouveaux membres, vois tes followers et tes following...
            </div>
        </div>
    </div>
    <br>   
</div>
<?php include '../require-files/verset.php'; ?>
        

<div class="col-xs-12 col-lg-3 col-md-3 col-sm-3">
    <div class="row">

        <form class="input-group ng-panel-info" method="GET" action="">
            <input name="q" type="text" class="form-control" placeholder="Rechercher une personne... ">
            <span class="input-group-btn" >
            <button  type="submit" value="Go" class="btn btn-primary ng-input" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </form>


        <div class="ng-panel panel panel-primary">
            <div class="ng-panel panel-heading">MOI</div>
            <div class="panel-body">
                <?= nl2br(user_mention_verif(truncate_text(poster_statut($_SESSION['id'])))); ?>
            </div>

            <ul class="list-group">
            <li class="list-group-item">
                <span class="glyphicon glyphicon-user"></span>
                Follower
                <span class="ng-badge badge"><?= KM_format(check_follower_num($_SESSION['id']))?></span>
                </li>
                <li class="list-group-item">
                <span class="glyphicon glyphicon-user"></span>
                Following
                <span class="ng-badge badge"><?= KM_format(check_following_num($_SESSION['id']))?></span>
                </li>
                <li class="list-group-item">
                <span class="glyphicon glyphicon-user"></span>
                <a href="/membres/profil.php?id=<?=$_SESSION['id']?>">Mon profil</a>
            </li>
            </ul>
        </div>

    </div>
</div>


<div class="col-xs-12 col-lg-9 col-md-9 col-sm-9">
<div class="row">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#membres" id="membres-tab" role="tab" data-toggle="tab" aria-controls="membres" aria-expanded="true">
                Membres
            </a>
        </li>

        <li role="presentation" class="">
            <a  href="#followers" role="tab" id="followers-tab" data-toggle="tab" aria-controls="followers" aria-expanded="false">
                Followers
            </a>
        </li>
        <li role="presentation" class="">
            <a  href="#following" role="tab" id="following-tab" data-toggle="tab" aria-controls="following" aria-expanded="false">
                Following
            </a>
        </li>
    </ul>

<!-- Tab panes -->
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade active in " role="tabpanel" id="membres" aria-labelledby="membres-tab">

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
                                <li><a>Follower<?= $t=(Check_follower_num($m['id']) > 1) ? "s" : ""?>: 
                                <?= KM_format(Check_follower_num($m['id']))?></a></li>

                                <li role="separator" class="divider"></li>

                                <li><a>Following: <?= KM_format(Check_following_num($m['id']))?></a></li>
                                <li role="separator" class="divider"></li>

                                    <?php $poste = photo_info($m['id'],"nombre") + article_info($m['id'],"nombre") ?>         
                                <li><a>Poste<?= $test = ($poste > 1) ? "s" : "" ;?>: <?php echo KM_format($poste); ?> </a></li>

                            </ul>
                        </li>
                                                
                        <?php if(empty($m['statut'])){?><h5>Hey tout le monde, suis sur #Ngpictures...</h5><?php }?>
                        <h5><?= valid_text($m['statut'])?></h5>


                        <?php if($_SESSION['id'] != $m['id']){?>

                        <?php $photo= $base->prepare("SELECT * FROM galerie WHERE userID = ? ORDER BY date_pub DESC LIMIT 0,3");           
                        $photo->execute(array($m['id']));?>


                        <?php while($p = $photo->fetch()){ ?>
                                        
                            <?php
                            // les photo doit fit avec la taille d l'ecran c prkoi y a toute ces class la...
                            if($photo ->rowcount() >= 3){ $class ="col-lg-4 col-sm-4 col-md-4 col-xs-4 pull-left";
                            }elseif($photo ->rowcount() == 2){  $class="col-lg-6 col-sm-6 col-md-6 col-xs-6 pull-left";
                            }else{ $class="hidden-lg hidden-xs hidden-sm hidden-md";}
                            ?>

                            <div class="<?= $class ?>">
                                <div class="row">
                                    <div class="ng-img-default">
                                        <a href="/galerie/photo.php?type=user&id=<?= $p['id']; ?>">      
                                            <img class="img img-responsive" src="/galerie/images/640-640/<?= $p['nom'] ?>">
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php } // fin while ?>

                        <div class="btn-group btn-sm " role="group">
                           
                            <a href="/membres/profil.php?id=<?= $m['id']; ?>"><button type="button" class="btn btn-default btn-sm">Profil</button></a>
                            
                            
                            <a href="/php/script/following.php?followingID=<?= $m['id'] ?>">
                            <button type="button" class="btn btn-default btn-sm">
                                <?= check_following_statut($_SESSION['id'],$m['id']) ?>
                            </button>
                            </a>
                                                        
                            <a href="/galerie/galerie.php?id=<?= $m['id']; ?>">
                            <button type="button" class="btn btn-default btn-sm">
                            Galerie
                            </button> 
                            </a>

                        </div>

                        <?php } // fin du if ?>
                    </div>
                </div>
            </div>

    <?php } // fin if rowcount... ?>                      
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

    <div class="tab-pane fade " role="tabpanel" id="followers" aria-labelledby="followers-tab">
    <h2>Follower<?= $t = ($fn > 1) ? "s" : "" ;?> <span class="ng-badge badge"><?= KM_format($fn) ?></span></h2>           
    <?php if($follower->rowcount() > 0 ){?>

        <?php while ($f = $follower->fetch()){?>

            <div class="col-xs-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="ng-user-box">
                        <img src="/membres/Avatar/40-40/<?= poster_profil($f['followerID'])?>" width="40px" height="40px" class="img img-circle"/>
                        <?= poster_pseudo($f['followerID']) ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class=" glyphicon glyphicon-option-vertical pull-right"></span></a>

                            <span class="pull-right"><?= Check_user_online($f['followerID'])?></span>

                            <ul class="dropdown-menu panel-heading">
                                <li><a>Follower<?= $t=(Check_follower_num($f['followerID']) > 1) ? "s" : ""?>: <?= KM_format(Check_follower_num($f['followerID']))?></a></li>

                                <li role="separator" class="divider"></li>
                                <li><a>Following: <?= KM_format(Check_following_num($f['followerID']))?></a></li>
                                <li role="separator" class="divider"></li>


                                <?php $poste = photo_info($f['followerID'],"nombre") + article_info($f['followerID'],"nombre") ?>         
                                <li><a>Poste<?= $test = ($poste > 1) ? "s" : "" ;?>: <?php echo KM_format($poste); ?> </a></li>
                            </ul>
                        </li>
                                                         
                        <?php if(poster_statut($f['followerID']) == " "){?><h5>Hey tout le monde, suis sur #Ngpictures...</h5><?php }?>

                        <h5><?= nl2br(user_mention_verif(poster_statut($f['followerID']))) ?></h5>

                        <?php if($_SESSION['id'] != $f['followerID']){?> 

                        <?php $photo= $base->prepare("SELECT * FROM galerie WHERE userID = ? ORDER BY date_pub DESC LIMIT 0,3");           
                        $photo->execute(array($f['followerID']));?>

                        <?php while($p = $photo->fetch()){ ?>
                                        
                        <?php
                            // les photo doit fit avec la taille d l'ecran c prkoi y a toute ces class la...
                            if($photo ->rowcount() >= 3){ $class ="col-lg-4 col-sm-4 col-md-4 col-xs-4 pull-left";
                            }elseif($photo ->rowcount() == 2){  $class="col-lg-6 col-sm-6 col-md-6 col-xs-6 pull-left";
                            }else{ $class="hidden-lg hidden-xs hidden-sm hidden-md";}
                        ?>

                        <div class="<?= $class ?>">
                            <div class="row">
                                <div class="ng-img-default">
                                    <a href="/galerie/photo.php?type=user&id=<?= $p['id']; ?>">      
                                        <img class="img img-responsive" src="/galerie/images/640-640/<?= $p['nom'] ?>" alt="...">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php } // fin while ?>

                        <div class="btn-group btn-sm " role="group">
                            
                                <a href="/membres/profil.php?id=<?= $f['followerID']; ?>">
                                <button type="button" class="btn btn-default btn-sm">
                                Profil
                                </button>
                                </a>
                            
                            <a href="/php/script/following.php?followingID=<?= $f['followerID'] ?>">
                            <button type="button" class="btn btn-default btn-sm">
                                <?= check_following_statut($_SESSION['id'],$f['followerID']) ?>
                            </button>
                            </a>
                                                        
                            
                            <a href="/galerie/galerie.php?id=<?= $f['followerID']; ?>">
                            <button type="button" class="btn btn-default btn-sm">Galerie
                            </button>
                            </a>
                            

                        </div>

                            <?php } // fin if...?>
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

    </div><!-- /followers -->


    <div class="tab-pane fade " role="tabpanel" id="following" aria-labelledby="following-tab">
        <?php $fwn = $following->rowcount(); ?>
        <h2>Following <span class="ng-badge badge"><?= KM_format($fwn) ?></span></h2>
             

        <?php if($following->rowcount() > 0 ){?>
            <?php while ($fw = $following->fetch()){?>
                           
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="ng-user-box">
                            <img src="/membres/Avatar/40-40/<?= poster_profil($fw['followingID'])?>" width="40px" height="40px" class="img img-circle"/>
                                <?= poster_pseudo($fw['followingID']) ?>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                                <span class=" glyphicon glyphicon-option-vertical pull-right"></span></a>
                                <span class="pull-right"><?= Check_user_online($fw['followingID'])?></span>
                                    
                                <ul class="dropdown-menu panel-heading">

                                    <li><a>Follower<?= $t=(Check_follower_num($fw['followingID']) > 1) ? "s" : ""?>: <?= KM_format(Check_follower_num($fw['followingID']))?></a></li>

                                    <li role="separator" class="divider"></li>
                                    <li><a>Following: <?= KM_format(Check_following_num($fw['followingID']))?></a></li>
                                    <li role="separator" class="divider"></li>


                                    <?php $poste = photo_info($fw['followingID'],"nombre") + article_info($fw['followingID'],"nombre") ?>         
                                    <li><a>Poste<?= $test = ($poste > 1) ? "s" : "" ;?>: <?php echo KM_format($poste); ?> </a></li>

                                </ul>
                            </li>
                                                        
                            <?php if(poster_statut($fw['followingID']) == " "){?><h5>Hey tout le monde, suis sur #Ngpictures...</h5><?php }?>

                            <h5><?= valid_text(poster_statut($fw['followingID'])) ?></h5>

                            <?php if($_SESSION['id'] != $fw['followingID']){?>

                            <?php $photo= $base->prepare("SELECT * FROM galerie WHERE userID = ? ORDER BY date_pub DESC LIMIT 0,3");           
                            $photo->execute(array($fw['followingID']));?>
                                        
                            <?php while($p = $photo->fetch()){ ?>
                                            
                            <?php

                                // les photo doit fit avec la taille d l'ecran c prkoi y a toute ces class la...
                                if($photo ->rowcount() >= 3){ $class ="col-lg-4 col-sm-4 col-md-4 col-xs-4 pull-left";
                                }elseif($photo ->rowcount() == 2){  $class="col-lg-6 col-sm-6 col-md-6 col-xs-6 pull-left";
                                }else{ $class="hidden-lg hidden-xs hidden-sm hidden-md";}
                            ?>

                            <div class="<?= $class ?>">
                                <div class="row">
                                    <div class="ng-img-default">
                                        <a href="/galerie/photo.php?type=user&id=<?= $p['id']; ?>">      
                                            <img class="img img-responsive" src="/galerie/images/640-640/<?= $p['nom'] ?>" alt="...">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php } //fin while ?>

                            <div class="btn-group btn-sm " role="group">
                            <a href="/membres/profil.php?id=<?= $fw['followingID']; ?>">
                            <button type="button" class="btn btn-default btn-sm">
                            Profil
                            </button>
                            </a>
                                
                            <a href="/php/script/following.php?followingID=<?= $fw['followingID'] ?>">
                            <button type="button" class="btn btn-default btn-sm">
                            <?= check_following_statut($_SESSION['id'],$fw['followingID']) ?>
                            </button>
                            </a>

                            <a href="/galerie/galerie.php?id=<?= $fw['followingID']; ?>">
                            <button type="button" class="btn btn-default btn-sm">
                            Galerie
                            </button>
                            </a>
                                
                            </div>

                            <?php } //fin if... ?>
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

    </div><!-- /following -->
</div><!-- tab-content-->

</div><!-- row -->
</div><!-- container -->

<div class="ng-espace-fantom"></div>
</section>

<?php include '../require-files/footer.php'; ?>

<!-- script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
    </script>
    <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/ng-alert-v2.js"></script>
<!-- / script -->

</body>
</html>