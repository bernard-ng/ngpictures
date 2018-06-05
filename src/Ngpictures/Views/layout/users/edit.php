<!DOCTYPE html>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html>
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php include(APP . "/Views/includes/default-meta.twig"); ?>
        <?php include(APP . "/Views/includes/favicon.twig"); ?>
        <?php include(APP . "/Views/includes/default-style.twig"); ?>
    </head>
    <body>
        <?php include(APP . "/Views/includes/mobile-menu.twig"); ?>
        <div class="jumbotron">
            <?php include(APP . "/Views/includes/menu.twig"); ?>
            <div class="container row">
                <span class="jumbotron-title">
                    <i class="icon icon-edit "></i>
                    &nbsp;Edition du profile
                </span>
            </div>
        </div>

        <div class="container row col s12">
            <?php echo $page_content ?>
        </div>

        <?php include(APP . "/Views/includes/footer.twig"); ?>
        <?php include(APP . "/Views/includes/default-script.twig"); ?>
        <?php include(APP . "/Views/includes/flash.twig"); ?>
    </body>
</html>
