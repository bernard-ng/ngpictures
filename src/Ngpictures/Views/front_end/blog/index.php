<section class="section container row">
    <?php require(APP . "/Views/includes/menu-aside.php"); ?>
    <section class="section col l6 m12 s12 animated slideInLeft" role="main">
        <div class="no-padding">
            <div class="ui divided items" id="dataContainer">
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $a) : ?>
                        <article class="card" id="<?= $a->id ?>" style="background: #100F0F">
                            <header class="card-image news-card-image">
                                <img src="<?= $a->thumbUrl ?>" alt="<?= $a->title ?>">
                            </header>
                            <section class="news-card-content">
                                <section class="news-card-title">
                                    <h2><?= $a->title ?>&nbsp;<small><?= $a->category ?></small></h2>
                                </section>
                                <main>
                                    <p>
                                        <?= $a->snipet ?>
                                    </p>
                                    <a href="<?= $a->url ?>" class="news-card-seemore right">Voir plus</a>
                                </main>
                                <footer id="articleInfo">
                                    <div class="news-card-stat">
                                        <i class="icon icon-download"></i>&nbsp;
                                        <a href="<?= $a->downloadUrl ?>" title="Télécharger la photo">Télécharger</a>
                                    </div>
                                    <div class="news-card-stat">
                                        <i class="icon icon-calendar"></i>&nbsp;
                                        <time id="date_created" data-time="<?= strtotime($a->date_created) ?>"><?= $a->time ?></time>
                                    </div>
                                    <div class="news-card-stat">
                                        <i class="icon icon-thumbs-up"></i>&nbsp;
                                        <small><a id="showLikes" href="<?= $a->LikersUrl; ?>"><?= $a->Likes ?></a></small>
                                    </div>
                                </footer>
                            </section>
                            <footer class="news-card-footer" id="articleOptions">
                                <a id="likeBtn" class="news-card-footer-item <?= $a->isLike ?>" href="<?= $a->likeUrl ?>">
                                    <i class="icon icon-heart-empty"></i>
                                </a>
                                <a id="commentBtn" class="news-card-footer-item" href="<?= $a->commentUrl ?>">
                                    <i class="icon icon-comment-empty"></i>
                                </a>
                                <a id="shareBtn" class="news-card-footer-item" href="/share/">
                                    <i class="icon icon-share"></i>
                                </a>
                            </footer>
                        </article>
                    <?php endforeach ; ?>
                <?php else : ?>
                    <div class="full-infos">
                        Aucun Publication pour l'instant
                    </div>
                <?php endif; ?>
            </div>
            <div id="feed-more" class="btn btn-flat blue-grey dark-2 action waves-effect" data-ajax="blog">chargement</div>
        </div>
    </section>
    <?php require(APP."/Views/includes/menu-aside.php"); ?>
</section>
