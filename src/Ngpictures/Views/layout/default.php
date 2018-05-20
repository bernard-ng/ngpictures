<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" >
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/default-slider.php"); ?>
        <main class="page-content" id="pageContent" role="main">
            <?php echo $page_content; ?>
        </main>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
    </body>
</html>
