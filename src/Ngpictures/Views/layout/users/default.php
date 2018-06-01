<!DOCTYPE html>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html>
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php include(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body id="particles-container">
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <?php echo $page_content; ?>
        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
    </body>
</html>
