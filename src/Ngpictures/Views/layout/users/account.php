<!DOCTYPE html>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html>
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php include(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <main><?php echo $page_content; ?></main>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
    </body>
</html>
