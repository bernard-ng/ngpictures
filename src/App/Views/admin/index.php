<div class="container row">
    <div class="col l3 hide-on-med-and-down">
        <div class="card col l12">
            <div class="section-title mb-20 mt-20 ml-10"> Espace sur le serveur</div>
            <div id="stat2" class="col l12 m12 s12 statistic"></div>
        </div>
        <div class="card col l12" id="sticky" data-offset="45">
            <div class="card-image">
                <img src="/imgs/ngpic.jpg">
            </div>
            <div class="ng-contain">
                <section class="description">
                    <blockquote>
                        The deep shooting, is not about what you see
                        is about what you feel, when looking at a picture.
                    </blockquote>
                </section>
            </div>
            <div class="aside-imgs">
                <div class="previous-imgs row" id="previousImgs">
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/balloy.jpg" alt="preso" title="Balloy fane" class="circle z-depth-1">
                    </span>
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/precylia.jpg" alt="preso" title="precylia felo" class="circle z-depth-1">
                    </span>
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/grey.jpg" alt="preso" title="gretta mpunga" class="circle z-depth-1">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <main class="col l9">
    <div class="card no-padding col l12 s12 m12">
        <nav class="nav z-depth-2 mb-20">
            <div class="nav-wrapper">
            <ul>
                <li><a href="<?= ADMIN."/blog/add"  ?>">Article</a></li>
                <li><a href="<?= ADMIN."/gallery/add" ?>">Photo</a> </li>
                <li><a href="<?= ADMIN."/gallery/albums/add" ?>">Albums</a></li>
                <li><a href="<?= ADMIN."/blog/categories/add" ?>">Catégorie</a></li>
            </ul>
            </div>
        </nav>
        <div class="section-title mb-20 mt-20 ml-10"> Statistiques</div>
        <div id="stat" class="col l12 m12 s12 statistic"></div>
    </div>
    <div class="card col l12 s12 m12">
        <div class="section-title mb-20 mt-20 ml-10">
            Les Derniers Articles
            <span class="btn primary-b right"><?= count($site_articles) ?></span>
        </div>
        <div class="col l6 m12 s12 mb-30 z-depth-2">
            <table class="responsive-table bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $a) : ?>
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
                                         <?php if ($a->online): ?>
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
                <b>Users posts</b> <a href="<?= ADMIN."/articles" ?>" class="right">see all</a>
            </div>
        </div>

        <div class="col l6 m12 s12 z-depth-2 mb-10">
            <table class="responsive-table bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($blog)): ?>
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
                                         <?php if ($a->online): ?>
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                         <?php else : ?>
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                         <?php endif; ?>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
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
    </main>
</div>

