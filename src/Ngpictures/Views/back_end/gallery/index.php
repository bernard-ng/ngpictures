<nav class="nav">
    <div class="container">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= ADMIN."/file-browser/gallery/" ?>">Photo site</a></li>
                <li class="right"><a href="<?= ADMIN."/gallery/albums/"  ?>">Albums</a></li>
                <li class="right"><a href="<?= ADMIN."/gallery/albums/add" ?>">Ajouter un Album</a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="container row">
    <section class="col l12 m12 s12">
        <div class="col l12 m12 s12">
            <section id="gallery" class="gallery-container animated fast slideInLeft">
                <?php foreach ($photo as $key => $photo) :  ?>
                    <article class="col l3 s3 m3" data-url="<?= $photo->url; ?>" id="<?= $photo->id ?>">
                        <img src="<?= $photo->smallthumbUrl ?>" class="gallery-item"/>
                    </article>
                    <div class="col l12 gallery-details"></div>
                <?php endforeach;?>
                <div class="col l12 gallery-details"></div>
            </section>
        </div>
        <div class="col l12 m12 s12">
            <div class="card-panel grey dark-3 col l12" style="padding: 20px">
                <div class="section">
                    <a href="<?= ADMIN."/gallery/add" ?>" class="btn right"><i class="icon icon-plus" style="font-size: smaller !important;"></i></a>

                    <span class="btn">Page : <?= $currentPage ?>/<?= $totalPage ?></span>
                    <span class="btn">Total : <?= $total ?></span>
                    <a href="<?= ADMIN."/gallery?page={$prevPage}"?>" class="btn"><i class="icon icon-left-open"></i></a>
                    <a href="<?= ADMIN."/gallery?page={$nextPage}"?>" class="btn"><i class="icon icon-right-open"></i></a>
                </div>

                <table class="card grey dark-4 bordered">
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
                                    <img src="/uploads/gallery/thumbs/<?= $p->thumb ?>" width="60" height="60" class="materialboxed boxed">
                                </td>
                                <td>
                                    <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                        <input type="hidden" name="id" value="<?= $p->id?>" >
                                        <input type="hidden" name="type" value="4" >
                                        <button type="submit" class="btn waves-effect waves-light red" id="delete">
                                            <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                        </button>
                                    </form>

                                    <a href="<?= ADMIN."/gallery/edit/{$p->id}" ?>">
                                        <button class="btn waves-effect waves-light">
                                            <i class="icon icon-plus-circled" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                    <a href="<?= ADMIN."/confirm/4/{$p->id}" ?>" id="confirm">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($p->online) : ?>
                                                <i class="icon icon-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                                <i class="icon icon-upload" style="font-size: smaller !important;"></i>
                                            <?php endif; ?>
                                        </button>
                                    </a>
                                    <a href="<?= ADMIN."{$p->watermarkUrl}" ?>">
                                        <button class="btn btn-small blue wavs">
                                            <i class="icon icon-tag" style="font-size: smaller !important;"></i>
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
                            <td>Aucune photo pour l'instant</td>
                            <td>
                                <button type="submit" class="btn btn-small waves-effect waves-light disabled">
                                    <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                </button>
                            </td>
                            <td>n-a</td>
                            <td><?= date('d M Y') ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>