<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<head>
    <title><?= $pageManager::getName() ?></title>
    <?php require(APP."/Views/includes/default-meta.php"); ?>
    <?php include(APP."/Views/includes/favicon.php"); ?>
    <?php include(APP."/Views/includes/default-style.php"); ?>
</head>
<body>
<?php include(APP."/Views/includes/mobile-menu.php"); ?>
<?php include(APP."/Views/includes/menu.php"); ?>
<div class="jumbotron-small">
    <div class="container row">
        <span class="ui header title col l12 m12 s12">
            <h3><?php echo $pageManager::getActivePage() ?></h3>
        </span>

        <form action="/search" method="GET">
            <div class="input-field">
                <span class=" col l12 m12 s12" style="display: inline-block;" >
                    <input name="q" class="transparent" placeholder="recherches..." autofocus type="search" data-length="255">
                </span>
            </div>
        </form>
    </div>
</div>
<main class="page-content" id="pageContent" data-ajax="true" role="main">
    <?php echo $page_content; ?>
</main>
<?php include(APP."/Views/includes/footer.php"); ?>
<?php include(APP."/Views/includes/default-script.php"); ?>
<?php include(APP."/Views/includes/flash.php"); ?>
</body>
</html>
