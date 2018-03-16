<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card no-padding col l12 m12 s12">
            <nav class="nav z-depth-2 mb-20">
                <div class="nav-wrapper">
                <ul>
                    <li><a href="<?= ADMIN."/file-browser/gallery/" ?>">Photo site</a></li>
                    <li class="right"><a href="<?= ADMIN."/gallery/albums/"  ?>">Albums</a></li>
                    <li class="right"><a href="<?= ADMIN."/gallery/albums/add" ?>">Ajouter un Album</a></li>
                </ul>
                </div>
            </nav>
            <?php if (!empty($photo)) : ?>
                <?php foreach ($photo as $photo) : ?>
                    <article class="card col l3" id="<?= $photo->id ?>">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img src="/uploads/gallery/thumbs/<?= $photo->thumb ?>" class="activator" alt="<?= $photo->name ?>" title="<?= $photo->name ?>">
                        </div>
                        <div class="card-reveal">
                            <span class="card-title"><i class="icon icon-chevron-down right"></i></span>
                            <?= $photo->description ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="card">
                    <div class="no-publication">
                        <div class="ng-cover"></div>
                        <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-panel col l12">
            <div class="section-title mb-20 mt-20 ml-10">
                Les Photos
                <span class="btn primary-b right"><?= count($photos) ?></span>
                <a href="<?= ADMIN."/gallery/add" ?>" class="right">
                    <button class="btn">
                        <i class="icon icon-plus" style="font-size: smaller !important;"></i>
                    </button>
                </a>
            </div>

            <table class="card responsive-table bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>thumb</th>
                        <th>action</th>
                        <th>name</th>
                        <th>date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($photos)) : ?>
                    <?php foreach ($photos as $p) : ?>
                        <tr>
                            <td><b><?= $p->id ?></b></td>
                            <td>
                                <a href="<?= $p->url ?>">
                                    <img src="/uploads/gallery/thumbs/<?= $p->thumb ?>" width="60" height="60">
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $p->id?>" >
                                    <input type="hidden" name="type" value="4" >
                                    <button type="submit" class="btn waves-effect waves-light red" id="delete">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>

                                <a href="<?= ADMIN."/gallery/edit/{$p->id}" ?>">
                                     <button class="btn waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                                <a href="<?= ADMIN."/confirm/4/{$p->id}" ?>" title="retirer" id="confirm">
                                    <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($p->online) : ?>
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                            <?php endif; ?>
                                    </button>
                                </a>
                                <a href="<?= ADMIN."{$p->watermarkUrl}" ?>">
                                    <button class="btn btn-small blue wavs">
                                        <i class="icon icon-copy" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                            </td>
                            <td><?= $p->name ?></td>
                            <td><time><?= $p->time ?></time></td>
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
        </div>
    </section>
</main>
