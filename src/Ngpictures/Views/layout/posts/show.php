<!DOCTYPE HTML>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?php echo $pageManager::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <meta name="canonical" content="<?php echo $article->Url ?>">

        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
    </head>
    </head>
    <body>
        <?php include(APP."/Views/includes/menu.php"); ?>
         <div class="jumbotron-small">
            <span class="ng-cover"></span>
            <div class="container row">
                <span class="ui header">
                    <i class="icon icon-paperclip"></i>&nbsp;Article <?= $article->id ?>
                </span>
                <span class="jumbotron-content">
                   Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                   tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                   quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                   consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                   proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </span>
            </div>
        </div>

        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $page_content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
    </body>
</html>
