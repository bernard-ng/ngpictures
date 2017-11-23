<?php 

session_start();
require "../php/fonction/functions.php";
$base = base_connexion("ngbdd");
include("../php/script/cookie.php");

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include '../require-files/favicon.php';?>
    <?php include '../require-files/all-meta.php'; ?>
    <title>A propos de nous</title>

    <link href="/Mobile responsive/css/normalise.css" rel="stylesheet" type="text/css">
    <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng-style.css" rel="stylesheet" type="text/css">
    <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/plus/about-us.css" rel="stylesheet" type="text/css">


</head>
<body >
<section class="ng-main-contain">

    <?php include "../require-files/plus/menu.php"; ?>
    <?php include "../require-files/flash.php"; ?>

    <!--BANNER -->
    <div class="banner">
        <div class="banner-black">
            <div class="media">
                <div class="media-body">
                    <h1 id="page_title" class="media-heading">A propos de nous</h1>
                    <span id="page_desc">
                    <p>Retrouvez toutes les photos par Bernard ng, postez vos plus belles photos, publiez vos articles, exprimez vous en long et en large, partagez des sentiments avec vos amis, profitez de la première galerie d'art photographique de la RD congo.</p>

                    </span> 
                </div>
            </div>
            <br>

            <p class="fixed-bottom">
            <span class="loader loader-circles"></span>
            <br>
            <br>
                <a href="/membres/signup.php" class="reg-flat-btn" role="button">Inscription</a>
                <a href="/membres/login.php" class="reg-flat-btn" role="button">Connexion</a>
            </p>                  
        </div>
    </div>
    <!-- /BANNER -->

    <!--PRESENTATION TEAM-->
    <div class="container">
        <div class="container-fluide">
            <div class="ng-text-1">
                <div class="col-lg-12">
                    <h1 class="page-header" id="qui-nous-sommes">Qui nous sommes ?</h1>
                </div>

                <p>
                Nous sommes une galerie d'art photographique, nous nous intéressons à tous les meilleurs instants de la vie.
                la photographie est une technique qui permet de créer des images sans l'action de la main, par l'action de la lumière, ce terme désigne également une branche d'arts graphiques qui utilise cette technique, dont le nom signifie étymologiquement "écriture de la lumière"
                </p>  
                        
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="/membres/team/bernard (1).jpg" width="64" height="64">
                        </div>
                        <div class="media-body text-justify">
                            <h4 class="media-heading">Bernard Ng<br><small>ngandubernard@gmail.com</small></h4>
                            <p>
                            Salut, c'est Bernard ng, j'ai toujours voulu partager ma passion pour la photographie avec le reste du monde, voilà qu'aujourd'hui cela est possible grâce au site <b>#Ngpictures</b>, je me suis intéressé à la photographie car elle m'a permis de m'exprimer sans l'usage des mots.
                            sa fait presqu'une année que je me suis lancé dans cet aventure, "la photographie" et une année et demi pour la programmation web.
                            vous verrez plus bas qui nous sommes et ce que nous vous proposons comme services.
                            vous en savez déjà beaucoups sur moi, je vous propose comme vous le savez sûrement, un service de shooting photo, et programmation de site web, en collaboration avec mon frère et mon ami joseph tshishi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="../membres/team/balloy (2).jpg" width="64" height="64">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Naomi Balloy Fane<br><small>naomiballoy0041@gmail.com</small></h4>
                            <p>
                            je suis rédactrice en chef des articles publier sur ngpictures, en outre j'offre le même service, c'est à dire la rédaction de vos différent annonce et article
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="../membres/team/Precylia (2).jpg" width="64" height="64">
                        </div>
                        <div class="media-body text-justify">
                            <h4 class="media-heading">Precylia Felo<br><small>alvinsjeyzmine70@gmail.com</small></h4>
                            <p>
                            je suis sociale, amusante, photogénique, je suis un model, vous pouvez faire appel à mes services en me contactant sur l'adresse email ci-dessus...
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="../membres/team/sabin.jpg" alt="..." width="64" height="64">
                        </div>
                        <div class="media-body text-justify">
                            <h4 class="media-heading">Joseph Tshishi <br><small>Sabinkabamba@gmail.com</small></h4>
                            <p>
                            je suis un web programmeur , je travaille avec bernard ng pour ses différents projet, je vous offre aussi un service de prograamation de site web...
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="../membres/team/prisca.jpg" alt="..." width="64" height="64">
                        </div>
                        <div class="media-body text-justify">
                            <h4 class="media-heading">Prisca Felo <br><small>wasokadioprisca@gmail.com</small></h4>
                            <p>
                            je suis amusante, gentille, j'aime la photographie et les arts graphiques, je vous propose un service de modification de photo avec applications mobiles.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="../membres/team/gretta (1).jpg" alt="..." width="64" height="64">
                        </div>
                        <div class="media-body text-justify">
                            <h4 class="media-heading">Gretta mpunga <br><small>grettampungasubila@gmail.com</small></h4>
                            <p>
                            je suis sociale, amusante, photogénique, je suis un model, vous pouvez faire appel à mes services en me contactant sur l'adresse email ci-dessus...
                            </p> 
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="media">
                        <div class="media-left media-top">
                            <img class="media-object img-circle" src="../membres/team/joelle.jpg" alt="..." width="64" height="64">
                        </div>
                        <div class="media-body text-justify">
                            <h4 class="media-heading">Joelle Kitume <br><small>joellekitumenyota@gmail.com</small></h4>
                            <p>
                            je suis une fille ambitieuse et qui veut atteindre tout ses objectifs. En soutenant l'organisation Ngpictures qui est constitué des jeunes ambitieux comme moi, je vous propose tous les versets bibliques sur le site...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- BANNER-2 -->
    <div class="banner-2">
        <div class="banner-black-2">
            <div class="media">
                <div class="media-body">
                    <h1 id="page_title" class="media-heading">Enjoy our services</h1>
                    <span id="page_desc">
                    <p>
                    <span class="glyphicon glyphicon-camera"></span>
                    <br>
                    Retrouvez toutes les photos par Bernard ng, postez vos plus belles photos, publiez vos articles, exprimez vous en long et en large, partagez des sentiments avec vos amis, profitez de la première galerie d'art photographique de la RD congo.</p>
                    </span> 
                </div>
            </div>        
        </div>
    </div>
    <!-- /BANNER-2 -->

    <!-- SERVICE -->
    <div class="container">
        <div class="container-fluide">
            <div class="ng-text-1">
                <div class="col-lg-12">
                    <h1 class="page-header" id="nos-services">Nos services</h1>
                </div>

                <div class="row">
                    <div class="container">
                        <div class="col-sm-4 col-md-4 col-lg-4 col-xs-12">
                            <article>
                                <div class="media-body">
                                    <h4 class="media-heading">SHOOTING</h4>

                                    <p> Nous sommes disponbile à immortaliser vos instants magiques à moindre coût: $25 pour les manifestations et $15 pour des shooting. 
                                    </p>

                                    <div class="container-viewport">   
                                        <button type="button" class="btn btn-default btn-xs tooltip-viewport-bottom" title="Bernard Ng &nbsp; Contact : +243973141132">
                                        Info 
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        </button>   
                                    </div>
                                </div>
                            </article>
                        </div>

                        <div class="col-sm-4 col-md-4 col-lg-4 col-xs-12"> 
                            <article>
                                <div class="media-body">
                                    <h4 class="media-heading">SHOOTING MODEL</h4>

                                    <p> Ngpictures vous fournie aussi des models pour vos séances shooting et publicités , vous pouvez aussi vous enregistré en tant que model... </p>

                                    <div class="container-viewport">   
                                        <button type="button" class="btn btn-default btn-xs tooltip-viewport-bottom" title="Bernard Ng &nbsp; Contact : +243973141132">
                                        Info 
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        </button>
                                    </div>
                                </div>
                            </article>
                            <br>
                        </div>

                        <div class="col-sm-4 col-md-4 col-lg-4 col-xs-12">
                            <article>
                                <div class="media-body">
                                    <h4 class="media-heading">ART-MODIFICATION</h4>

                                    <p> Salut c'est Prisca felo, je vous fournie un service de Modification et amélioration de vos photos avec applications mobile  à moindre coût...
                                    </p>  

                                    <div class="container-viewport">   
                                        <button type="button" class="btn btn-default btn-xs tooltip-viewport-bottom" title="Prisca felo &nbsp; Contact : +243994398276">
                                        Info 
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        </button>
                                    </div>                           
                                </div>
                            </article>
                            <br>    
                        </div>

                    </div>

                    <div class="col-lg-12">
                        <div class="ng-well well well-xs">
                        NB: Les services proposés ne sont disponibles que pour la ville de lubumbashi, RD congo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / SERVICE -->

    <!-- BANNER-3 -->
    <div class="banner-3">
        <div class="banner-black-3">
            <div class="media">
                <div class="media-body">

                    <h1 id="page_title" class="media-heading">Deep Shooting</h1>
                    <span id="page_desc">
                    <p>
                    <span class="glyphicon glyphicon-camera"></span>
                    <br>
                    Retrouvez toutes les photos par Bernard ng, postez vos plus belles photos, publiez vos articles, exprimez vous en long et en large, partagez des sentiments avec vos amis, profitez de la première galerie d'art photographique de la RD congo.</p>

                    </span> 
                </div>
            </div>        
        </div>
    </div>
    <!-- /BANNER-3 -->

    <!-- NOS PHOTOS -->
    <div class="container">
    <div class="row container-fluide">
            <div class="ng-text-1">
                <div class="col-lg-12">
                    <h1 class="page-header" id="nos-photos">Nos Photos</h1>
                </div>

                <p>
                    l'ombre et la lumière surgissent de presque nul part, évanescentes elles apparaissent et disparaissent au gré du temps, elles sont par définition insaisissables et impalpables. seule la prise de vue photographique permet de monter la magie de cette dualité fraternelle. En effet l’ombre et la lumière sont les deux faces déterminantes de la photographie, souvent elles se font un face à face perpétuel dans des compositions surprenantes. Elles ne sont jamais neutres. Ainsi elle peuvent être une forme autonome se superposant à une réalité déjà présente. Nos  photos sont l'expression même de l'ombre sinueuse d'une personne.
                </p>

                    <?php $photo = $base->query("

                        SELECT nom 
                        FROM nggalerie
                        ORDER BY rand() DESC 
                        LIMIT 0,12
                    ");

                    while($p = $photo->fetch()) : ?>

                        <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                            <div class="row">
                                <div class="img ng-thumbnail">
                                    <img class="img img-responsive" src="/galerie/ngimages/640-640/<?= $p['nom'] ?>">    
                                </div>
                            </div>
                        </div>

                   <?php endwhile ; ?>
            </div>

            <div class="ng-well well well-xs">
                Retrouvez le reste dans notres
                <a href="/galerie/galerie.php">Galerie</a> 
            </div>
        </div>    
    <!-- /NOS PHOTOS -->
          
            

            <div class="col-xs-12 col-lg-8 col-md-8 col-sm-8">
                <div class="row">
                    <div class="ng-text-1">

                        <div class="container">
                            <h1>Contactez-nous</h1>
                        </div>

                        <ul class=" nav nav-tabs navbar-inverse ">
                                <li role="presentation"><img src="../Mobile responsive/icons/face.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/phone.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/twitter.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/insta.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/youtube.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/messenger.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/1487339227_Skype_icon.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/chat.png" width="21px"/></li>
                                <li role="presentation"><img src="../Mobile responsive/icons/user.png" width="21px"/></li>
                        </ul> 

                        <blockquote>
                            <p class="small">facebook: Bernard Ng</p>
                            <p class="small">whatsapp: +243973141132</p>
                            <p class="small">insta: Ngpicture_23</p>
                            <p class="small">ngandubernard@gmail.com</p>
                        </blockquote>

                        <div class="container-fluide">
                            <p class="text-justify">
                            Hey tout le monde c'est encore Bernard ng, président fondateur de Ngpictures, j'espère que vous vous plaisez ici et que vous aimez nos photos, mon equipe et moi nous nous donnons à fond pour fournir un travail bien fait...<br>
                            ♥la capture du sentiment♥<br>
                            ♥Deep sooting♥<br><br>
                            </p>
                        </div> 
                    </div>
                </div>
            </div>
                <div class="hidden-xs col-lg-4 col-md-4 col-sm-4">
                    <div class="row">
                        <div class="ng-text-1">

                            <div class="container-fluide" id="pic">
                                <h1>Navigation</h1>
                            </div>
                            <div class="navbar navbar-default">
                                <ul class="nav ">
                                    <li><a href="#qui-nous-sommes">Qui nous sommes?</a></li>
                                    <li><a href="#nos-services">Nos services</a></li>
                                    <li><a href="#nos-photos">Nos photos</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
</section>

<?php include "../require-files/footer.php"; ?>


<!-- importation Des script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="../Mobile responsive/js/js+/jquery.min.js"><\/script>')
    </script>
    <script src="/Mobile responsive/js/bootstrap.min.js"></script>
    <script src="/Mobile responsive/js/velocity.min.js"></script>
    <script src="/Mobile responsive/js/ng-js/ng-app.js"></script>
    <script src="/Mobile responsive/js/tooltip-viewport.js"></script> 
<!-- / importation Des script -->

</body>
</html>