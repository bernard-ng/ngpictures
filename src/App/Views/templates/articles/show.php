<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?php echo Ngpic::getPageName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <meta name="canonical" content="<?php echo $article->Url ?>">

        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
    </head>
    </head>
    <body>
         <div class="jumbotron">
            <?php include(APP."/Views/includes/menu.php"); ?>
            <span class="ng-cover"></span>
            <div class="container row">
                <span class="jumbotron-title">
                    <i class="icon icon-paperclip"></i>&nbsp;Article <?= $article->id ?>
                </span>
                <span class="jumbotron-content">
                   Voici l'article "<?= $article->title ?>" dans son intégralité. 
                   merci de le lire, de laisser un commentaire,
                   de laisser un like si vous l'avez trouver intéressant ou de le partager sur les résaux sociaux.
                </span>
            </div>
        </div>

        <?php include(APP."/Views/includes/flash.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
    </body>
</html>
