<!DOCTYPE html>
<html>
    <head>
        <title><?= Ngpictures\Util\Page::getName() ?></title>
        <?php include(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php include(APP."/Views/includes/menu.php"); ?>
        <?php include(APP."/Views/includes/default-slider.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>

        <div class="row col s12"><?php echo $content; ?></div>
        
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
    </body>
</html>