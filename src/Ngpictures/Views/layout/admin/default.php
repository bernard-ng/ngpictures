<!DOCTYPE HTML>
<?php include(APP."/Views/includes/ngpictures-watermark.txt"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?php echo $pageManager::getName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="tex/css" href="/assets/css/morris.css">
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
        <script type="text/javascript" src="/assets/js/lib/jquery.min.js" ></script>
        <script type="text/javascript" src="/assets/js/app/materialize.js" ></script>
        <script type="text/javascript" src="/assets/js/app/app.init.js" ></script>
        <script type="text/javascript" src="/assets/js/app/app.ajax.js"></script>
        <script type="text/javascript" src="/assets/js/app/admin.ajax.js"></script>
        <script type="text/javascript" src="/assets/js/app/app.js" ></script>
        <script  type="text/javascript" src="/assets/js/lib/raphael.js"></script>
        <script  type="text/javascript" src="/assets/js/lib/morris.min.js"></script>
        <script type="text/javascript" src="/assets/js/tinymce/tinymce.min.js"></script>
    </head>
    <body>
        <?php include(APP."/Views/includes/adm-mobile-menu.php"); ?>
        <?php include(APP."/Views/includes/admin-menu.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $page_content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <script  type="text/javascript">
            if (tinymce !== undefined) {
                tinymce.init({
                    selector:"textarea#content",
                    theme: "modern",
                    skin: "lightgray",
                    width: "100%",
                    height: 400,
                    file_browser_callback :  function (field_name, url, type, win) {
                        tinyMCE.activeEditor.windowManager.open({
                            file : "<?= ADMIN."/media-browser" ?>",
                            title : 'Photo picker',
                            width : 500,
                            height: 500,
                            resizable : "yes",
                            inline : "yes",
                            close_previous: "no"
                        },{
                            window : win,
                            input : field_name
                        });
                        return false;
                    },
                    statusbar: true,
                    relative_urls: false,
                    menubar: false,
                    toolbar: "styleselect |  bold italic  alignleft aligncenter alignright alignjustify  bullist numlist | link | image | preview ",
                    plugins: [ "link image lists preview inlinepopups" ],
                    style_formats: [
                        {title : "Titre", items: [
                            {title : "Niveau 1", format: "h2"},
                            {title : "Niveau 2", format: "h3"},
                            {title : "Niveau 3", format: "h4"}
                        ]},
                        {title: "Inline", items: [
                            {title: "Gras", icon: "bold", format: "bold"},
                            {title: "Italique", icon: "italic", format: "italic"},
                            {title: "Code", icon: "code", format: "code"}
                        ]},
                        {title: "Blocks", items: [
                            {title: "Paragraphe", format: "p"},
                            {title: "Citation", format: "blockquote"},
                            {title: "Div", format: "div"}
                        ]}
                    ]
                });
            }

            if (Morris !== undefined) {
                Morris.Donut({
                    element: 'stat2',
                    data: [
                        {value: <?= $used_space ?? 5 ?>, label: 'Utiliser'},
                        {value: <?= $total_space ?? 95 ?>, label: 'Libre'}
                    ],
                    formatter: function (x) { return x + "%"}
                });

                Morris.Bar({
                    element: 'stat',
                    data: [
                        {x: 'Users', y: <?= $users[0] ?? 0 ?>, z: <?= $users[1] ?? 0 ?>},
                        {x: 'posts', y: <?= $users_posts[0] ?? 0 ?>, z: <?= $users_posts[1] ?? 0?>},
                        {x: 'Online', y: <?= $users_online ?? 0 ?>},
                        {x: 'pictures', y: <?= $site_photos[0] ?? 0 ?>, z: <?= $site_photos[1] ?? 0 ?>},
                        {x: 'Blog', y: <?= $site_posts[0] ?? 0 ?>, z: <?= $site_posts[1] ?? 0 ?>},
                        {x: 'Categ.', y: <?= $site_categories ?? 0 ?>},
                        {x: 'Bugs', y: <?= $site_bugs  ?? 0 ?>},
                        {x: 'Ideas', y: <?= $site_ideas  ?? 0 ?>}
                    ],
                    xkey: 'x',
                    ykeys: ['y', 'z'],
                    labels: ['confirmed', 'not confirmed']
                });
            }
            </script>
    <?php include(APP."/Views/includes/flash.php"); ?>
    </body>
</html>
