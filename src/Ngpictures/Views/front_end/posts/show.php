<section class="section container row">
    <div class="col l8 m12 s12">
        <img src="<?= $article->thumbUrl ?>" alt="" class="responsive-img materialboxed">
        <h1 class="ui header"><?= $article->title ?></h1>
        <?= $article->content; ?>
    </div>
    <div class="ui divided items col l4 m12 s12 animated slideInLeft">
        <h2 class="ui header">A propos de l'auteur</h2>
        <div class="item">
            <div class="image"><img src="<?= $user->find($article->users_id)->avatarUrl ?>"></div>
            <div class="content">
                <span class="header"><?= $user->find($article->users_id)->name ?></span>
                <div class="meta"><?= $user->find($article->users_id)->email ?></div>
                <div class="description">
                    <?= $user->find($article->users_id)->bio ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="jumbotron dark">
    <div class="container row">
        <?php include(APP."/Views/includes/comments.php"); ?>
    </div>
</section>