<!DOCTYPE HTML>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
    </head>
    </head>
    <body>
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <div class="jumbotron">
            <?php include(APP."/Views/includes/menu.php"); ?>
            <div class="container row">
                <span class="jumbotron-title">
                    &nbsp;<?php echo $pageManager::getActivePage() ?>
                </span>
                <span class="jumbotron-content">
                   Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio quaerat possimus doloremque consequuntur temporibus incidunt cupiditate consectetur praesentium minus facere exercitationem, dicta iure porro, magni qui culpa. Nostrum, odit voluptate.
                </span>
            </div>
        </div>

        <?php include(APP."/Views/includes/flash.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $page_content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <script src="/assets/js/zoombox/zoombox.js"></script>
        <script>
            $("img.zoombox, a.zoombox").zoombox();

            tinymce.init({
                selector:"textarea#content"
            });
        </script>
    </body>
</html>
