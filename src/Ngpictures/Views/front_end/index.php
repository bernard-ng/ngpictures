<main>
    <div class="row container col l12 s12 m12">
        <h2 class="ui header">
            <div class="content">
                Dernières Photos
                <div class="sub header">Découvrez les nouveautés</div>
            </div>
        </h2>
    </div>
    <div class="row container">
    <?php foreach ($last as $a) : ?>
        <div class="row col s12 m3 l3">
            <article class="ui card shadow-2">
                <div class="image waves-effect">
                    <a href="#"><img src="<?= $a->smallThumbUrl; ?>"></a>
                </div>
                <div class="content">
                    <div class="header"><?= $a->title ?? $a->name; ?></div>
                    <div class="meta">
                        <a class="category"><?= $a->category; ?> </a>
                    </div>
                </div>
                <div class="extra content">
                    <span class="right floated">
                        <?= $a->time; ?>
                    </span>
                    <span>
                    <a href="<?= $a->likeUrl; ?>"><i class="icon icon-heart-empty"></i></a>
                        <?= $a->likes; ?>
                    </span>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="jumbotron dark col l12">
            <div class="container row">
            <div class="row col l8 s12 m12">
                <h2 class="ui dividing header">Nos Photos</h2>
                <div class="">
                    <p>
                        l'ombre et la lumière surgissent de presque nul part,
                        évanescentes elles apparaissent et disparaissent au gré du temps,
                        elles sont par définition insaisissables et impalpables.
                        seule la prise de vue photographique permet de monter la magie de cette dualité fraternelle.
                        En effet l’ombre et la lumière sont les deux faces déterminantes de la photographie,
                        souvent elles se font un face à face perpétuel dans des compositions surprenantes.
                        Elles ne sont jamais neutres. Ainsi elle peuvent être une forme autonome se superposant à une réalité déjà présente.
                        Nos photos sont l'expression même de l'ombre sinueuse d'une personne.
                    </p>
                </div>
                <?php if ($article && !empty($article)): ?>
                <div class="col l12 m12 s12">
                    <a href="<?= $article->url; ?>" class="waves-effect">
                        <img src="<?=$article->thumbUrl ?>" alt="<?=$article->title ?>" width="100%">
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="row col l4 s12 m12">
                <h2 class="ui header">Catégories</h2>
                <div class="ui relaxed divided list">

                <?php foreach ($categories as $category) : ?>
                    <div class="item">
                        <i class="icon icon-tag middle aligned"></i>
                        <div class="content">
                        <a class="header" href="<?= $category->url; ?>"><?= $category->title; ?></a>
                        <div class="description"><?= $category->description ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <center>
                <a href="/categories" class="btn btn-flat blue-grey dark-2 shadow waves-effect">
                    Toutes les Catégories
                </a>
                </center>

                </div>
                </div>
            </div>
        </div>
</main>
