<!DOCTYPE html>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html>
    <head>
        <title><?= Ngpictures\Managers\PageManager::getName() ?></title>
        <?php include(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body class="login-bg">
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
            <?php echo $page_content; ?>        
        <?php include(APP."/Views/includes/default-script.php"); ?>
    </body>
</html>
