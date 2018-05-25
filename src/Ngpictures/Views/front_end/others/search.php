<section class="section container row">

    <?php if (empty($posts) && empty($blog)) : ?>
        <div class="col offset-l3 l6 m12 s12 animated slideInRight">
            <div class="section center-align">
                <h2 class="icon icon-search red-txt center-align"></h2>
                <h2 class="ui header divided center"> Aucun Résultat</h2>
                <p>
                    Aucun résultat pour "&nbsp;<?= $query ?>&nbsp;" actuellement, Vérifiez l'orthographe du mot puis réessayer.
                </p>
            </div>
        </div>
    <?php else: ?>
        <span class="row col l12 s12 m12">
            <h2 class="ui header"> Résultat pour :&nbsp;"&nbsp;<?= $query ?>&nbsp;"</h2>
        </span>

        <?php if (!empty($blog)) : ?>
            <?php foreach ($blog as $b) : ?>
                <div class="row nexted col s12 m3 l3">
                <article class="card hoverable blue-grey dark-4">
                    <div class="card-image">
                        <img src="<?= $b->smallThumbUrl; ?>" class="activator">
                    </div>
                    <div class="card-reveal">
                        <span class="card-title"><?= $b->title; ?><i class="icon icon-cancel right"></i></span>
                        <div class="truncate">
                            <?= $b->snipet; ?>
                        </div>
                        <a href="<?= $b->url ?>" class="btn btn-flat">Voir plus</a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($gallery)) : ?>
            <?php foreach ($gallery as $g) : ?>
                <div class="row nexted col s12 m3 l3">
                <article class="card hoverable blue-grey dark-4">
                    <div class="card-image">
                        <img src="<?= $g->smallThumbUrl; ?>" class="activator">
                    </div>
                    <div class="card-reveal">
                        <span class="card-title"><?= $g->title ?? $g->name; ?><i class="icon icon-cancel right"></i></span>
                        <div class="truncate">
                            <?= $g->snipet; ?>
                        </div>
                        <a href="<?= $g->url ?>" class="btn btn-flat">Voir plus</a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
                <div class="row nexted col s12 m3 l3">
                <article class="card hoverable blue-grey dark-4">
                    <div class="card-image">
                        <img src="<?= $post->smallThumbUrl; ?>" class="activator">
                    </div>
                    <div class="card-reveal">
                        <span class="card-title"><?= $post->title; ?><i class="icon icon-cancel right"></i></span>
                        <div class="truncate">
                            <?= $post->snipet; ?>
                        </div>
                        <a href="<?= $post->url ?>" class="btn btn-flat">Voir plus</a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</section>
