<div class="container row">
    <?php if(!empty($blog) || !empty($posts) || !empty($gallery)) : ?>
        <div class="col s12">
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
        <?php foreach ($gallery as $photo) : ?>
            <div class="row nexted col s12 m3 l3">
                <article class="card hoverable blue-grey dark-4">
                    <div class="card-image">
                        <img src="<?= $photo->smallThumbUrl; ?>" class="activator">
                    </div>
                    <div class="card-reveal">
                        <span class="card-title"><?= $photo->title; ?><i class="icon icon-cancel right"></i></span>
                        <div class="truncate">
                            <?= $photo->snipet; ?>
                        </div>
                        <a href="<?= $photo->url ?>" class="btn btn-flat">Voir plus</a>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
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
    </div>
    <?php else: ?>
        <div class="col offset-l3 l6 m12 s12 animated slideInRight">
            <div class="section center-align">
                <h2 class="icon icon-tag red-txt center-align"></h2>
                <h2 class="ui header divided center"> Aucune publication pour l'instant</h2>
                <p>
                    cette Catégorie ne présente actuellement aucune publication disponible, les publications sont peut être en évaluation,
                    ceci pourrait prendre du temps, veuillez revenir plus tard
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="fixed-action-btn second">
    <a href="/categories" class="btn-floating btn-large blue dark-2 waves-effect shadow-4">
        <i class="icon icon-tags"></i>
    </a>
</div>
