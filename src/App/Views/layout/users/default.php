<!DOCTYPE html>
<html>
    <head>
        <title><?= Ngpictures\util\Page::getName() ?></title>
        <?php include(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body class="login-bg">
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
            <?php echo $content; ?>        
        <?php include(APP."/Views/includes/default-script.php"); ?>
    </body>
</html>