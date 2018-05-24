<?php require(CORE."/Helpers/CacheBusting.php"); ?>
<link rel="stylesheet" type="text/css" href="<?= CacheBusting("/assets/css/style.css") ?>">
<style type="text/css">
    .turbolinks-progress-bar {
        position: fixed;
        display: block;
        top: 0;
        left: 0;
        height: 4px;
        background: #0076ff;
        z-index: 9999;
        transition: width 300ms ease-out, opacity 150ms 150ms ease-in;
        transform: translate3d(0, 0, 0);
    }
</style>
<script type="text/javascript" src="<?= CacheBusting("/assets/js/lib/turbolinks.js") ?>"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110487894-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-110487894-1');
</script>
