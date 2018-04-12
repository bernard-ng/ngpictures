<!DOCTYPE html>
<?php include(APP . "/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" >
<head>
    <title><?= $pageManager::getName() ?></title>
    <?php require(APP . "/Views/includes/default-meta.php"); ?>
    <?php include(APP . "/Views/includes/favicon.php"); ?>
    <?php include(APP . "/Views/includes/default-style.php"); ?>
</head>
<body>
<main class="page-content" id="pageContent">
    <?php echo $page_content; ?>
</main>
<?php include(APP . "/Views/includes/default-script.php"); ?>
</body>
</html>
