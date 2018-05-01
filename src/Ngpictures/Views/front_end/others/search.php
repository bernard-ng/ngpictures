<ul class="tabs blue-grey dark-4 shadow-2" style="margin-top: -16px;">
    <div class="container row">
        <li class="tab col s3">
            <a href="search?q=<?= $query ?>&tab=blog">
                <i class="icon icon-quote-left"></i>
            </a>
        </li>

        <li class="tab col s3">
            <a href="search?q=<?= $query ?>$tab=posts">
                <i class="icon icon-globe"></i></span>
            </a>
        </li>

        <li class="tab col s3">
            <a href="search?q=<?= $query ?>&tab=gallery">
                <i class="icon icon-picture"></i>
            </a>
        </li>

        <li class="tab col s3">
            <a href="search?q=<?= $query ?>&tab=community">
               <i class="icon icon-users"></i>
            </a>
        </li>
    </div>
</ul>
<div class="container row">
    <div class="col l12 m12 s12">


        <div class="col s12">
        <?php if (!empty($blog)) : ?>
        <h4>Blog</h4>
        <?php foreach ($blog as $b) : ?>
            <div class="col l3 m6 s12">
                <div class="card verse-panel">
                    <div class="card-content ng-contain">
                        <img src="<?= $b->thumbUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                        <span class="card-title"><?= $b->title ?></span>
                    </div>
                    <div class="card-action">
                        <a href="<?= $b->Url ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col s12">
    <?php if (!empty($posts)) : ?>
        <h4>posts</h4>
        <?php foreach ($posts as $post) : ?>
            <div class="col l3 m6 s12">
                <div class="card verse-panel">
                    <div class="card-content ng-contain">
                        <img src="<?= $post->thumbUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                        <span class="card-title"><?= $post->title ?></span>
                    </div>
                    <div class="card-action">
                        <a href="<?= $post->Url ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif;?>
    </div>

    <?php if (empty($post) && empty($blog)) : ?>
        <div class="col s12">
            <h4>Aucun résultats :(</h4>
        </div>
    <?php endif;?>
</div>
