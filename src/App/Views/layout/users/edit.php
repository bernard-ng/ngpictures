<!DOCTYPE html>
<html>
    <head>
        <title><?= Ngpictures\Util\Page::getName() ?></title>
        <?php include(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php include(APP."/Views/includes/mobile-menu.php"); ?>
        <div class="jumbotron">
            <?php include(APP."/Views/includes/menu.php"); ?>
            <div class="container row">
                <span class="jumbotron-title">
                    <i class="icon icon-edit "></i>
                    &nbsp;Edition du profile
                </span>
            </div>
        </div>
        <?php include(APP."/Views/includes/flash.php"); ?>

        <div class="container row col s12">
            <?php echo $content; ?>
        </div>
        
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
    </body>
</html>