<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card-panel no-padding">
            <div id="articlesContainer">
                <?php if (!empty($photo)): ?>
                    <?php foreach ($photo as $photo): ?>
                        <article class="card col l6" id="<?= $photo->id ?>">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img src="/uploads/ngpictures/thumbs/med/<?= $photo->thumb ?>" class="activator" alt="<?= $photo->name ?>" title="<?= $photo->name ?>">
                            </div>
                            <div class="card-content">
                                <span class="card-title activator"><?= $photo->name ?> <i class="icon icon-chevron-up right"></i></span>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title">poster name<i class="icon icon-chevron-down right"></i></span>
                                <?= $photo->description ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card">
                        <div class="no-publication">
                            <div class="ng-cover"></div>
                            <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-panel col l12">
            <div class="section-title mb-20 mt-20 ml-10">
                Les Photos
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
                <?php if(!empty($photos)): ?>
                    <?php foreach ($photos as $p) : ?>
                        <tr>
                            <td><b><?= $p->id ?></b></td>
                            <td>
                                <a href="<?= $p->url ?>">
                                    <img src="/uploads/ngpictures/thumbs/small/<?= $p->thumb ?>" width="60" height="60">
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $p->id?>" >
                                    <input type="hidden" name="type" value="4" >
                                    <button type="submit" class="btn waves-effect waves-light red">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                               
                                <a href="<?= ADMIN."/blog/edit/{$p->id}" ?>">
                                     <button class="btn waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                                <?php if ($p->online): ?>
                                    <a href="<?= ADMIN."/remove/4/{$p->id}" ?>" title="retirer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= ADMIN."/confirm/4/{$p->id}" ?>" title="confirmer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><?= $p->name ?></td>
                            <td><time><?= $p->time ?></time></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
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