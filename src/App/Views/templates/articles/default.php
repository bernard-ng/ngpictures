<?php use Ngpic\Pages; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?php echo Ngpic::getPageName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
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
                    <i class="icon <?php echo Pages::getIcon(Ngpic::getTitle()) ?> "></i>
                    &nbsp;<?php echo Ngpic::getTitle() ?>
                </span>
                <span class="jumbotron-content">
                    <?php echo Pages::getDescription(Ngpic::getTitle()) ?>
                </span>
            </div>
        </div>

        <?php include(APP."/Views/includes/flash.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <script src="/assets/js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector:"textarea#content"
            });
        </script>
    </body>
</html>
