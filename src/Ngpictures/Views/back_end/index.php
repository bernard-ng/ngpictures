<nav class="nav shadow-2">
    <div class="container">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= ADMIN."/blog/add"  ?>">Article</a></li>
                <li><a href="<?= ADMIN."/gallery/add" ?>">Photo</a> </li>
                <li><a href="<?= ADMIN."/gallery/albums/add" ?>">Albums</a></li>
                <li><a href="<?= ADMIN."/blog/categories/add" ?>">Catégorie</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container row">
    <section>
        <div class="col l9 m12 s12">
            <div class="card-panel grey dark-4 no-padding col l12 s12 m12">
                <h2 class="ui header" style="padding: 20px;">Statistiques</h2>
                <div id="stat" class="col l12 m12 s12 statistic"></div>
            </div>
        </div>
        <div class="col l3 hide-on-med-and-down">
            <div class="card-panel grey dark-4 col l12" style="padding: 20px;">
                <h2 class="ui header">Espace sur le serveur</h2>
                <div id="stat2" class="col l12 m12 s12 statistic"></div>
            </div>
        </div>
    </section>

    <div class="card-panel grey dark-3 col l12 s12 m12" style="padding: 20px;">
        <div class="section">
            <h2 class="ui header">
                Les Derniers posts
            </h2>
        </div>
        <div class="col l6 m12 s12">
            <table class="bordered card grey dark-4">
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
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;" data-action="ajax-delete">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <input type="hidden" name="type" value="1" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" title="supprimer" id="delete">
                                        <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="retirer" id="confirm">
                                    <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($a->online) : ?>
                                            <i class="icon icon-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                            <i class="icon icon-upload" style="font-size: smaller !important;"></i>
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
                                <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="col l6 m12 s12">
            <table class="bordered card grey dark-4">
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
                                <form method="POST" action="<?= ADMIN."/delete"  ?>" style="display: inline-block !important;" data-action="ajax-delete">
                                    <input type="hidden" name="id" value="<?= $b->id?>" >
                                    <input type="hidden" name="type" value="3" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" title="supprimer" id="delete">
                                        <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>

                                <a href="<?= ADMIN."/blog/edit/{$b->id}" ?>" title="editer">
                                     <button class="btn btn-small waves-effect waves-light">
                                        <i class="icon icon-plus-circled" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                                <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="retirer" id="confirm">
                                    <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($a->online) : ?>
                                            <i class="icon icon-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                            <i class="icon icon-upload" style="font-size: smaller !important;"></i>
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
                            <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;" data-action="ajax-delete">
                                <input type="hidden" name="id" value="0" >
                                <input type="hidden" name="type" value="1" >
                                <button type="submit" class="btn btn-small waves-effect waves-light disabled">
                                    <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col l12 m12 s12">
        <section id="gallery" class="gallery-container animated slideInLeft">
            <?php foreach ($photo as $key => $photo) :  ?>
                <article class="col l3 s3 m3" data-url="<?= $photo->url; ?>" id="<?= $photo->id ?>">
                    <img src="<?= $photo->smallthumbUrl ?>" class="gallery-item"/>
                </article>
                <div class="col l12 gallery-details"></div>
            <?php endforeach;?>
            <div class="col l12 gallery-details"></div>
        </section>
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
