<?php 
session_start();
require "../../php/fonction/functions.php";
$base= base_connexion("ngbdd");


if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{

    $ngarticle=$base->query('SELECT * from ngarticle order by id desc');

    if(isset($_GET['q']) and !empty ($_GET['q']))
    {
        $q = htmlspecialchars($_GET['q']);
        $ngarticle=$base->query('SELECT * from ngarticle where titre like "%'.$q.'%" order by id desc');
        if($ngarticle->rowcount() == 0)
        {
            $ngarticle=$base->query('SELECT * from ngarticle where concat(titre,contenu,id,date_pub) like "%'.$q.'%" order by id desc');
        }
    }

}else{
        header("location:/membres/login.php");
        $_SESSION['msg'] = "vous devez vous connecter !";
        $_SESSION['type'] = "alert-danger"; } 

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../../require-files/favicon.php";?>

    <title>Gestion-article</title>
    <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
    <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >

</head>

<body>
<section class="ng-bloc-principal">


<?php include "../../require-files/admin/menu.php";?>
<?php include "../../require-files/flash.php";?>


<div class="jumbotron ng-margin-default">
<div class="media">
    <div class="container">
        <div class="media-body" >
            <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Gestion article</h2>
            mes articles, confirmation, suppression,edition... <br>les articles non confirmés ne s'afficherons pas dans le "home"
        </div>
    </div>
</div>
</div>


<div class="col-xs-12 col-lg-3 col-md-3 col-sm-3">
    <div class="row">
        <form class="input-group ng-panel-info " method="get" action="">
            <input name="q" type="text" class="form-control" placeholder="recherche">
            <span class="input-group-btn" >
                <button  type="submit" value="Go" class="btn btn-primary ng-input" type="button">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                </button>
            </span>
        </form>
        <?php include '../../require-files/last-ngpictures.php'; ?>
    </div>
</div>


<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">
    <div class="row">

        <ul class="nav nav-tabs ng-margin-default">
            <li role="presentation"><a href="#">#Articles</a></li>
        </ul>

        <!--boucle ngarticles-->
        <?php $Nga =$ngarticle->rowcount();  ?>

            <h2 id="ngarticles">#Article<?= $t = ($Nga > 1) ? "s" : ""?> <span class="ng-badge badge"><?= $Nga ?></span></h2>


        <?php if($ngarticle->rowcount() > 0 ){?>
        <?php while ($a = $ngarticle->fetch()) { ?>

            <div class="ng-user-box">
                <div class="media">
                    <div class="media-left media-top">
                        <a href="/ngarticle/ngarticle.php?id=<?= $a['id'] ?>">
                        <img class="media-object" src="/ngarticle/miniature/90-90/<?= ngarticle_min($a['id']) ?>">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?= limit_text($a['titre'],25) ?></h4>
                        <?= limit_text(user_mention_verif($a['contenu']),200) ?>
                        <hr>
                        <time><?= temps($a['date_pub'])?></time>
                        <span class="pull-right">
                           <div class="btn-group btn-sm " role="group">

                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/ngarticle/ngarticle.php?id=<?= $a['id']?>">voir</a>
                                </button> 


                                <?php if($a['confirme'] == 0){?>
                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/admin/index.php?type=article&aprouve=<?= $a['id'] ?>">confirmer</a>
                                </button>
                                <?php }?>



                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/admin/index.php?type=article&supprime=<?= $a['id']; ?>">supprimer</a>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                            <a href="/admin/index.php?edit=<?=$a['id']?>">Editer</a>
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
                            <img class="media-object" src="/ngarticle/miniature/90-90/rien.jpg" width="90" height="90">
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

</section>

<?php include '../../require-files/footer.php'; ?>

<!-- script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')</script>
    <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/ng-alert-V2.js"></script>
<!-- / script -->

</body>
</html>