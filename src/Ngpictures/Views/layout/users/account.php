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
        <div class="jumbotron">
            <?php include(APP."/Views/includes/menu.php"); ?>
            <div class="container row">
                <span class="jumbotron-title">
                    <i class="icon icon-user "></i>
                    &nbsp;Profile
                </span>
            </div>
        </div>

        <div class="row col s12"><?php echo $page_content; ?></div>

        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <?php include(APP."/Views/includes/flash.php"); ?>
    </body>
</html>
