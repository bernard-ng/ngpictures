<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" >
<head>
    <title><?= Ngpictures\Util\Page::getName() ?></title>
    <?php require(APP."/Views/includes/default-meta.php"); ?>
    <?php include(APP."/Views/includes/favicon.php"); ?>
    <?php include(APP."/Views/includes/default-style.php"); ?>
</head>
<body>

<div class="page-content" id="pageContent">
    <?php echo $content; ?>
</div>
<?php include(APP."/Views/includes/footer.php"); ?>
<?php include(APP."/Views/includes/default-script.php"); ?>
</body>
</html>