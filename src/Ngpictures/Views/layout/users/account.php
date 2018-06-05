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
        <?php include(APP . "/Views/includes/menu.twig"); ?>
        <main><?php echo $page_content; ?></main>
        <?php include(APP . "/Views/includes/footer.twig"); ?>
        <?php include(APP . "/Views/includes/default-script.twig"); ?>
        <?php include(APP . "/Views/includes/flash.twig"); ?>
    </body>
</html>
