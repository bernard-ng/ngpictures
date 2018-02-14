<!DOCTYPE html>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" >
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
        <?php include(APP."/Views/includes/default-slider.php"); ?>
        <div class="page-content" id="pageContent">
            <?php echo $page_content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
    </body>
</html>