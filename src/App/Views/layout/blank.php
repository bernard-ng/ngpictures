<?php
    use Ngpictures\Util\Page;
?>
<!DOCTYPE html>
<!--
Template Name: Pesaton
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->
<html>
    <head>
        <title><?= Page::getName(); ?></title>
        <?php require(APP."/Views/production/includes/meta.php"); ?>
        <?php require(APP."/Views/production/includes/styles.php");?>
    </head>
    <body id="top">
        <?php include(APP."/Views/includes/flash.php"); ?>
        <?php include(APP."/Views/production/includes/header.php"); ?>
        <?php echo $content; ?>
        <?php include(APP."/Views/production/includes/footer.php"); ?>
        <?php include(APP."/Views/production/includes/scripts.php"); ?>
    </body>
</html>
