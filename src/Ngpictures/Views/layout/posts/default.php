<!DOCTYPE HTML>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <div class="jumbotron-small">
            <div class="container row">
                <span class="ui header">
                    <h4><?php echo $pageManager::getActivePage() ?></h4>
                </span>
                <span class="jumbotron-content">
                   Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio quaerat possimus doloremque consequuntur temporibus incidunt cupiditate consectetur praesentium minus facere exercitationem, dicta iure porro, magni qui culpa. Nostrum, odit voluptate.
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
