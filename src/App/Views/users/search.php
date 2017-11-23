<?php 
session_start();
require "../php/fonction/functions.php";
$base= base_connexion("ngbdd");
include_once("../php/script/cookie.php");

if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{

    $article=$base->query('SELECT * from article order by date_pub desc limit 0,20');
    $ngarticle=$base->query('SELECT * from ngarticle order by id desc  limit 0,20');

    if(isset($_GET['q']) and !empty ($_GET['q']))
    {
        $q = htmlspecialchars($_GET['q']);
        $article=$base->query('SELECT * from article where titre like "%'.$q.'%" order by date_pub desc');

        if($article->rowcount() == 0)
        {
            $article=$base->query('SELECT * from article where concat(titre,contenu,id,date_pub) like "%'.$q.'%" order by id desc');
        }

        $ngarticle=$base->query('SELECT * from ngarticle where titre like "%'.$q.'%" order by date_pub desc');
        if($article->rowcount() == 0)
        {
            $ngarticle=$base->query('SELECT * from ngarticle where concat(titre,contenu,id,date_pub) like "%'.$q.'%" order by id desc');
        }
    }

    if(isset($_GET['me']) and !empty($_GET['me'])){

        $me = htmlspecialchars($_GET['me']);
        $article=$base->prepare('SELECT * from article where posterID = ? order by date_pub desc');
        $article->execute(array($me));
    }


}else{

    header("location:login.php");
    $_SESSION['msg'] = "vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger"; } 

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../require-files/favicon.php";?>
    <?php include '../require-files/all-meta.php'; ?>
    <title>Recherches</title>

    <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
    <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
</head>

<body>
<section class="ng-bloc-principal">

<?php include "../require-files/menu.php";?>
<?php include "../require-files/flash.php";?>


<div class="jumbotron ng-margin-default">
    <div class="container">
        <div class="media">
            <div class="media-body" >
                <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Recherches</h2>
                vous pouvez rechercher un article ou un membre...
            </div>
        </div>
    </div>
</div>

<?php include '../require-files/verset.php'; ?>

<div class="col-xs-12 col-lg-3 col-md-3 col-sm-3">
    <div class="row">

        <form class="input-group ng-panel-info " method="get" action="">
            <input name="q" type="text" class="form-control" placeholder="Recherche...">
            <span class="input-group-btn" >
                <button  type="submit" value="Go" class="btn btn-primary ng-input" type="button">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                </button>
            </span>
        </form>

        <div class="ng-panel panel panel-primary">
            <div class="ng-panel panel-heading"><span class="glyphicon glyphicon-user"></span>  MOI</div>
                <div class="panel-body">
                    <?= valid_text(poster_statut($_SESSION['id'])); ?>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                    <span class="glyphicon glyphicon-user"></span>
                    <a>Follower</a>
                    <span class="ng-badge badge"><?= KM_format(check_follower_num($_SESSION['id']))?></span>
                    </li>

                    <li class="list-group-item">
                    <span class="glyphicon glyphicon-user"></span>
                    <a>Following</a>
                    <span class="ng-badge badge"><?= KM_format(check_following_num($_SESSION['id']))?></span>
                    </li>

                    <li class="list-group-item">
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="/membres/profil.php?id=<?=$_SESSION['id']?>">Mon profil</a>
                    </li>

                </ul>
        </div>

        <div class="hidden-xs">
            <?php include "../require-files/last-ngpictures.php"; ?>
        </div>
    </div>
</div>


<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">
    <div class="row">
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#Article" id="Article-tab" role="tab" data-toggle="tab" aria-controls="Article" aria-expanded="true">
                    Article
                </a>
            </li>
            <li role="presentation" class=" ">
                <a href="#Ngpictures" id="Ngpictures-tab" role="tab" data-toggle="tab" aria-controls="Ngpictures" aria-expanded="true">
                    Ngpictures
                </a>
            </li>
        </ul>

        <br>
        <?php if(isset($q)){?>
        <div class="ng-user-box">
                <div class="media">
                    <div class="media-left media-top">
                        <img class="media-object" src="/membres/Avatar/90-90/ng.png" width="90" height="90">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $q ?></h4>
                        recherches-tu un membre ?
                        <hr>
                        <span class="pull-right">
                        <button type="button" class="btn btn-default btn-sm ">
                        <a href="/membres/users.php?q=<?= $q ?>">
                        <span class="glyphicon glyphicon-search"></span> Rechercher
                        </a>
                        </button>
                    </span>
                    <time><?= today_date() ?></time>
                </div>
            </div>
        </div>
        <?php }?>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade active in " role="tabpanel" id="Article" aria-labelledby="Article-tab">
    <!-- boucle article -->

        <?php $Na =$article->rowcount();  ?>
        <h2  id="articles">Article<?= $t = ($Na > 1) ? "s" : ""?> <span class="ng-badge badge"><?= $Na ?></span></h2>

        <?php if($article->rowcount() > 0 ){?>
        <?php while ($a = $article->fetch()) { ?>

        <div class="ng-user-box">
            <div class="media">
                <div class="media-left media-top">
                    <a href="/article/article.php?id=<?= $a['id'] ?>">
                    <img class="media-object" src="/article/miniature/90-90/<?= article_min($a['id']) ?>">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?= limit_text($a['titre'],20) ?></h4>
                    <?= nl2br(user_mention_verif(truncate_text($a['contenu']))) ?>
                    <hr>
                        
                    <time><?= temps($a['date_pub'])?></time>
                    <span class="pull-right">

                        <button type="button" class="btn btn-default btn-xs ng-btn">
                        <a href="/article/article.php?id=<?php echo $a['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                        </button>
                        <button type="button" class="btn btn-default btn-xs ng-btn">
                        <a href="/membres/profil.php?id=<?php echo $a['posterID']; ?>"><span class="glyphicon glyphicon-user"></span></a>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <?php }
        }else{?>

        <div class="ng-user-box">
            <div class="media">
                <div class="media-left media-top">
                    <img class="media-object" src="/Mobile responsive/imgs/rien.JPG" width="90" height="90">
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php if(isset($q)){ echo $q;}else{ echo "#Ngpictures ";} ?></h4>
                    <?php if(isset($q)){echo "Aucun résultat pour cet article";}else{ echo "Aucun article pour l'instant";}?>
                    <hr>
                    <time><?= today_date() ?></time>
                </div>
            </div>
        </div>

        <?php }?> 
    <!-- / boucle article -->
    </div>

    <div class="tab-pane fade active in " role="tabpanel" id="Ngpictures" aria-labelledby="Ngpictures-tab">
    <!--boucle ngarticles-->

        <?php $Nga =$ngarticle->rowcount();  ?>
        <h2 id="ngarticles">#Article<?= $t = ($Nga > 1) ? "s" : ""?> <span class="ng-badge badge"><?= $Nga ?></span></h2> 

        <?php if($ngarticle->rowcount() > 0 ){?>
        <?php while ($a1 = $ngarticle->fetch()) { ?>

        <div class="ng-user-box">
            <div class="media">
                <div class="media-left media-top">
                    <a href="/ngarticle/ngarticle.php?id=<?= $a1['id'] ?>">
                        <img class="media-object" src="/ngarticle/miniature/90-90/<?= ngarticle_min($a1['id']) ?>">
                    </a>
                </div>
            <div class="media-body">
                <h4 class="media-heading"><?= limit_text($a1['titre'],20) ?></h4>
                <?= limit_text(user_mention_verif($a1['contenu']),200) ?>
                <hr>
                <time><?= temps($a1['date_pub'])?></time>
                <span class="pull-right">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default btn-xs ng-btn">
                        <a href="ngarticle.php?id=<?php echo $a1['id']; ?>"><span class="glyphicon glyphicon-eye-open"></a>
                        </button>
                    </div> 
                </span>
            </div>
        </div>
    </div>              

        <?php } 
        }else{?>

        <div class="ng-user-box">
            <div class="media">
                <div class="media-left media-top">
                    <img class="media-object" src="/Mobile responsive/imgs/rien.JPG" width="90" height="90">
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php if(isset($q)){ echo $q;}else{ echo "#Ngpictures ";} ?></h4>
                    <?php if(isset($q)){echo "Aucun résultat pour cet article";}else{ echo "Aucun article pour l'instant";}?>
                    <hr>
                    <time><?= today_date() ?></time>
                </div>
            </div>
        </div>

        <?php }?>
        <!-- boucle ngarticle -->

    </div>
</div>

</div>
</div>

<div class="ng-espace-fantom"></div>
</section>

<?php include "../require-files/footer.php"; ?>

<!-- script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')</script>
    <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/ng-alert-v2.js"></script>
<!-- / script -->

</body>
</html>