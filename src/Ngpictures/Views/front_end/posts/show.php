<section class="section container row">
    <div class="col l8 m12 s12">
        <img src="<?= $article->thumbUrl ?>" alt="" class="responsive-img materialboxed">
        <h1 class="ui header"><?= $article->title ?></h1>
        <?= $article->content; ?>
    </div>
    <div class="section col l4 m12 s12 ">
        <div class="ui divided list animated slideInRight">
            <?php if (isset($categories) && !empty($categories)) : ?>
                <ul class="collection">
                    <?php foreach ($categories as $category) : ?>
                        <li class="collection-item dark waves-effect col s12 <?= ($category->title == $article->category)? 'active' : '' ?>">
                            <a href="<?= $category->url; ?>">
                                <div style="margin: 10px">
                                    <div class="collection-item-title">
                                        <?= $category->title; ?>
                                        <span class="secondary-content"><i class="icon icon-right-open"></i></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="jumbotron dark">
    <div class="container row">
        <?php include(APP."/Views/includes/comments.php"); ?>
    </div>
</section>
<section class="section container">
    <div class="ui divided items col l12 m12 s12 animated slideInLeft">
        <h2 class="ui header">A propos de l'auteur</h2>
        <div class="item">
            <div class="image"><img src="<?= CDN."/imgs/team/bernard.jpg" ?>"></div>
            <div class="content">
                <span class="header"><?= $activeUser->name ?></span>
                <div class="meta"><?= $activeUser->email ?></div>
                <div class="description">
                    <?= $activeUser->bio ?>
                </div>
            </div>
        </div>
    </div>
</section>