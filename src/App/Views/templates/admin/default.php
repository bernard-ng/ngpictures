<?php use Ngpic\Pages; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title><?php echo Ngpic::getPageName() ?></title>
        <?php require(APP."/Views/includes/default-meta.php"); ?>
        <?php include(APP."/Views/includes/favicon.php"); ?>
        <?php include(APP."/Views/includes/default-style.php"); ?>
        <link rel="stylesheet" type="tex/css" href="/assets/css/morris.css">
        <link rel="stylesheet" type="text/css" href="/assets/js/zoombox/zoombox.css">
    </head>
    </head>
    <body>
        <div class="jumbotron">
            <?php include(APP."/Views/includes/admin-menu.php"); ?>
            <div class="container row">
                <span class="ng-cover"></span>
                <span class="jumbotron-title">
                    <i class="icon icon-lock"></i> admin
                </span>
                <span class="jumbotron-content">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </span>
            </div>
        </div>

        <?php include(APP."/Views/includes/flash.php"); ?>
        <div class="page-content" id="pageContent" data-ajax="true">
            <?php echo $content; ?>
        </div>
        <?php include(APP."/Views/includes/footer.php"); ?>
        <?php include(APP."/Views/includes/default-script.php"); ?>
        <script  type="text/javascript" src="/assets/js/lib/raphael.js"></script>
        <script  type="text/javascript" src="/assets/js/lib/morris.min.js"></script>
        <script  type="text/javascript">
            Morris.Bar({
              element: 'stat',
              data: [
                {x: '2011 Q1', y: 3, z: 2, a: 3},
                {x: '2011 Q2', y: 2, z: null, a: 1},
                {x: '2011 Q3', y: 0, z: 2, a: 4},
                {x: '2011 Q4', y: 2, z: 4, a: 3}
              ],
              xkey: 'x',
              ykeys: ['y', 'z', 'a'],
              labels: ['Y', 'Z', 'A']
            }).on('click', function(i, row){
              console.log(i, row);
            });

            
        /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
        var day_data = [
          {"period": "2012-10-01", "licensed": 3407},
          {"period": "2012-09-30", "sorned": 0},
          {"period": "2012-09-29", "sorned": 618},
          {"period": "2012-09-20", "licensed": 3246, "sorned": 661},
          {"period": "2012-09-19", "licensed": 3257, "sorned": null},
          {"period": "2012-09-18", "licensed": 3248, "other": 1000},
          {"period": "2012-09-17", "sorned": 0},
          {"period": "2012-09-16", "sorned": 0},
          {"period": "2012-09-15", "licensed": 3201, "sorned": 656},
          {"period": "2012-09-10", "licensed": 3215}
        ];
        Morris.Line({
          element: 'stat2',
          data: day_data,
          xkey: 'period',
          ykeys: ['licensed', 'sorned', 'other'],
          labels: ['Licensed', 'SORN', 'Other'],
          /* custom label formatting with `xLabelFormat` */
          xLabelFormat: function(d) { return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
          /* setting `xLabels` is recommended when using xLabelFormat */
          xLabels: 'day'
        });
    </script>
    </body>
</html>