<?php use Ngpictures\Util\Page; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?= Page::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
    </head>
    </head>
    <body>
        <div class="jumbotron">
            <?php include(APP."/Views/includes/menu.php"); ?>
            <div class="container row">
                <span class="jumbotron-title">
                    <i class="icon <?php echo Page::getIcon() ?> "></i>
                    &nbsp;<?php echo Page::getTitle() ?>
                </span>
                <span class="jumbotron-content">
                    <?php echo Page::getDescription() ?>
                </span>
            </div>
        </div>

        <?php include(APP."/Views/includes/flash.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <script src="/assets/js/zoombox/zoombox.js"></script>
        <script src="/assets/js/tinymce/tinymce.min.js"></script>
        <script>
            $("img.zoombox, a.zoombox").zoombox();

            tinymce.init({
                selector:"textarea#content"
            });
        </script>
    </body>
</html>
