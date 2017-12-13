<div class="container row">

    <div class="card col l12 s12 m12">
        <div class="section-title mb-20 mt-20 ml-10">
            Les Derniers Articles
            <span class="badge new"><?= count($blog) ?></span>
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
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" title="supprimer">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <?php if ($a->online): ?>
                                    <a href="<?= ADMIN."/remove/1/{$a->id}" ?>" title="retirer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="confirmer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
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
                        <tr>
                            <td><b><?= $b->id ?></b></td>
                            <td><a href="<?= $b->url ?>"><?= $b->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete"  ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $b->id?>" >
                                    <input type="hidden" name="type" value="3" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" title="supprimer">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                               
                                <a href="<?= ADMIN."/blog/edit/{$b->id}" ?>" title="editer">
                                     <button class="btn btn-small waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                                <?php if (!$b->online): ?>
                                    <a href="<?= ADMIN."/confirm/3/{$b->id}" ?>" title="confirmer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= ADMIN."/remove/3/{$b->id}" ?>" title="retirer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
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

    <div class="col l3 m12 s12">
        <div class="card col l12 m6 s12">
            <div class="section-title mb-10 mt-20 ml-10">Ajouter au site</div>
            <ul class="collection">
                <li class="collection-item">
                    <a href="<?= ADMIN."/blog/add"  ?>">Nouvel Article</a>
                </li>
                <li class="collection-item">
                    <a href="<?= ADMIN."/nggallery/add" ?>">Nouvel Photo</a>
                </li>
                <li class="collection-item">
                    <a href="<?= ADMIN."/godfirst/add" ?>">Nouveau Verset</a>
                </li>
                <li class="collection-item">
                    <a href="<?= ADMIN."/category/add" ?>">Nouvelle catégorie</a>
                </li>
            </ul>
        </div>

        <div class="card col l12 m6 s12">
            <div class="section-title mb-10 mt-20 ml-10">Pages modifiable</div>
            <ul class="collection">
                <li class="collection-item">
                    <a href="<?= ADMIN."/blog/add"  ?>">About.html</a>
                </li>
                <li class="collection-item">
                    <a href="<?= ADMIN."/nggalery/post" ?>">About-shooting.html</a>
                </li>
                <li class="collection-item">
                    <a href="<?= ADMIN."/godfirst/post" ?>">About-contact.html</a>
                </li>
                <li class="collection-item">
                    <a href="<?= ADMIN."/event/post" ?>">About-us.html</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card col l9 s12 m12">
        <div class="section-title mb-20 mt-20 ml-10"> Statistiques</div>
        <div id="stat" class="col l12 m12 s12 statistic"></div>
    </div>
</div>

