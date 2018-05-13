<div class="container row">
    <div class="col l3 hide-on-med-and-down">
        <div class="card  dark-2 col l12">
            <div class="ui divided header">Espace sur le serveur</div>
            <div id="stat2" class="col l12 m12 s12 statistic"></div>
        </div>
    </div>
    <main class="col l9 m12 s12">
    <div class="card  dark-2 no-padding col l12 s12 m12">
        <nav class="nav shadow-2">
            <div class="nav-wrapper">
                <ul>
                    <li><a href="<?= ADMIN."/blog/add"  ?>">Article</a></li>
                    <li><a href="<?= ADMIN."/gallery/add" ?>">Photo</a> </li>
                    <li><a href="<?= ADMIN."/gallery/albums/add" ?>">Albums</a></li>
                    <li><a href="<?= ADMIN."/blog/categories/add" ?>">Catégorie</a></li>
                </ul>
            </div>
        </nav>
        <div class="ui divided header">Statistiques</div>
        <div id="stat" class="col l12 m12 s12 statistic"></div>
    </div>
    <div class="card-panel teal dark-4 col l12 s12 m12">
        <div class="ui header">
            Les Derniers posts
            <span class="btn blue-grey dark-3 right"><?= count($site_posts) ?></span>
        </div>
        <div class="col l6 m12 s12 mb-30 shadow-2">
            <table class=" bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $a) : ?>
                        <tr>
                            <td><b><?= $a->id ?></b></td>
                            <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <input type="hidden" name="type" value="1" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" title="supprimer" id="delete">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="retirer" id="confirm">
                                    <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($a->online) : ?>
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                            <?php endif; ?>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td><b>0</b></td>
                        <td>Aucun article pour l'instant</td>
                        <td>
                           <button type="submit" class="btn btn-small waves-effect waves-light disabled">
                                <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="card-action">
                <b>Users posts</b> <a href="<?= ADMIN."/posts" ?>" class="right">see all</a>
            </div>
        </div>

        <div class="col l6 m12 s12 shadow-2 mb-10">
            <table class=" bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($blog)) : ?>
                    <?php foreach ($blog as $b) : ?>
                        <tr id="<?= $b->id ?>">
                            <td><b><?= $b->id ?></b></td>
                            <td><a href="<?= $b->url ?>"><?= $b->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete"  ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $b->id?>" >
                                    <input type="hidden" name="type" value="3" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" title="supprimer" id="delete">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>

                                <a href="<?= ADMIN."/blog/edit/{$b->id}" ?>" title="editer">
                                     <button class="btn btn-small waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                                <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="retirer" id="confirm">
                                    <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($a->online) : ?>
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                            <?php endif; ?>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td><b>0</b></td>
                        <td>Aucun article pour l'instant</td>
                        <td>
                            <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                <input type="hidden" name="id" value="0" >
                                <input type="hidden" name="type" value="1" >
                                <button type="submit" class="btn btn-small waves-effect waves-light disabled">
                                    <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="card-action">
                <b>Sites posts</b> <a href="<?= ADMIN."/blog" ?>" class="right">see all</a>
            </div>
        </div>
    </div>
</div>
<script  type="text/javascript">
    if (Morris !== 'undefined') {
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
