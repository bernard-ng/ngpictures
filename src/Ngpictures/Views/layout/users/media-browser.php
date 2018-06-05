<!DOCTYPE html>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" >
    <head>
        <title><?= $pageManager::getName() ?></title>
        <?php require(APP . "/Views/includes/default-meta.twig"); ?>
        <?php include(APP . "/Views/includes/default-style.twig"); ?>
    </head>
    <body>
        <?php echo $page_content; ?>
    </body>
</html>
