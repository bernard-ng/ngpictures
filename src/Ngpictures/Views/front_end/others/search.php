<div class="container row">
    <div class="col l12">

    <h4>
        <?= count($blog) + count($posts) ?> Résultats pour: <?= $query ?>
    </h4>
    <hr>


    <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li class="right"><a href="/search/me">Moi</a></li>
                <li><a href="/categories">Categories</a></li>
                <li><a href="/community">Membres</a></li>
                <li><a href="/albums">Albums</a></li>
                <li><a href="/gallery/search">Photos</a></li>
            </ul>
        </div>
    </nav>
    </div>

    <form action="/search" method="GET">
        <div class="input-field">
            <span class=" col s10 l10 m10" style="display: inline-block;" >
                <input name="q" placeholder="recherches..." autofocus type="text">
            </span>
            <div>
            <button type="submit" value="rechercher" class="btn btn-large waves-effect waves-light col s2 m2 l2">
                <i class="icon icon-search"></i>
            </button>
            </div>
        </div>
    </form>

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
