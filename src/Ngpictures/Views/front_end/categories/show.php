<div class="container row">
    <div class="col l12">
    <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= $category->url ?>"><?= $category->title ?></a></li>
                <li class="right"><a href="/categories">Toutes les Catégories</a></li>
            </ul>
        </div>
    </nav>
    </div>

    <div class="col s12">
        <h2>Blog</h2>
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
    </div>
    
    <div class="col s12">
        <h2>Articles</h2>
        <?php foreach ($articles as $article) : ?>
            <div class="col l3 m6 s12">
                <div class="card verse-panel">
                    <div class="card-content ng-contain">
                        <img src="<?= $article->thumbUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                        <span class="card-title"><?= $article->title ?></span>     
                    </div>
                    <div class="card-action">
                        <a href="<?= $article->Url ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
