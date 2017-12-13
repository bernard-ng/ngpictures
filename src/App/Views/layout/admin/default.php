<?php use Ngpictures\Util\Page; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?php echo Page::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="tex/css" href="/assets/css/morris.css">
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
    </head>
    </head>
    <body>
        <?php include(APP."/Views/includes/adm-mobile-menu.php"); ?>
        <div class="jumbotron">
            <?php include(APP."/Views/includes/admin-menu.php"); ?>
            <div class="container row">
                <span class="jumbotron-title">
                    <i class="icon icon-lock"></i> <?php echo Page::getTitle() ?>
                </span>
                <span class="jumbotron-content">
                    Mon administration :)
                </span>
            </div>
        </div>

        <?php include(APP."/Views/includes/flash.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <script  type="text/javascript" src="/assets/js/lib/raphael.js"></script>
        <script  type="text/javascript" src="/assets/js/lib/morris.min.js"></script>
        <script  type="text/javascript">
            Morris.Bar({
              element: 'stat',
              data: [
                {x: 'janvier', y: 3, z: 2, a: 3},
                {x: 'fevrier', y: 2, z: 1, a: 5},
                {x: 'mars', y: 1, z: 2, a: 4},
                {x: 'avril', y: 2, z: 4, a: 3}
              ],
              xkey: 'x',
              ykeys: ['y', 'z', 'a'],
              labels: ['articles', 'blog', 'photos']
            });
    </script>
    
    </body>
</html>