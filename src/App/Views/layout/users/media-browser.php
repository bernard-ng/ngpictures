<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" >
    <head>
        <title><?= Ngpictures\Util\Page::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>