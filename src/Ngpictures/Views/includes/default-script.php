<script>
   /*if('serviceWorker' in navigator) {
        navigator.serviceWorker
            .register('/serviceworker.js')
            .then(function() {
                console.log("Service Worker Registered");
            });
   }*/
</script>
<script type="text/javascript" src="<?= CacheBusting("/assets/js/lib/jquery.min.js") ?>"></script>
<script type="text/javascript" src="<?= CacheBusting("/assets/js/app/materialize.js") ?>" ></script>
<script type="text/javascript" src="<?= CacheBusting("/assets/js/app/app.init.js") ?>" ></script>
<script type="text/javascript" src="<?= CacheBusting("/assets/js/app/app.ajax.js") ?>" ></script>
<script type="text/javascript" src="<?= CacheBusting("/assets/js/app/app.js") ?>"></script>
