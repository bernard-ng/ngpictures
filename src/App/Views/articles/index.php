<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <main class="col s12 m7">
            <div id="articlesContainer">
                <?php if (!empty($articles)) : ?>
                <?php foreach ($articles as $a) : ?>

                    <!-- CARD -->
                    <article class="card" id="<?= $a->id ?>">
                        <header class="ng-news-card-header">
                            <span class="ng-news-card-image-profil">
                                <img src="/uploads/avatars/<?= $a->user_id ?>.jpg" alt="Profil Image" title="<?= $a->username ?>">
                            </span>
                            <p class="ng-news-card-header-title"><a href="/account/" title="voir le profil"><?= $a->username ?></a></p>
                            <a id="picBtn" class="ng-news-card-header-icon" href="/galery/" title="voir la galery"><i class="icon icon icon-picture"></i></a>
                            <a id="saveBtn" class="ng-news-card-header-icon" href="/download/" title="télécharger la photo"><i class="icon icon icon-save"></i></a>
                        </header>
                        <div class="card-image">
                            <span class="ng-news-card-image-article">
                                <a href="<?= $a->url ?>">
                                    <img src="<?= $a->thumbUrl ?>" alt="Article Image" title="<?= $a->title ?>">
                                </a>
                            </span>
                        </div>
                        <main class="ng-news-card-content">
                            <section class="ng-news-card-title">
                                <h2><?= $a->title ?></h2>
                            </section>
                            <content>
                                <p><?= $a->text ?></p>
                                <a href="<?= $a->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                            </content>
                            <section id="articleInfo">
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-time"></i>&nbsp;
                                    <time id="date_created" data-time="<?= strtotime($a->date_created) ?>"><?= $a->date_created ?></time>
                                </div>
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-thumbs-up"></i>&nbsp;
                                    <small>
                                        <a id="showLikes" href="/likes/"><?= $a->likes ?></a>
                                    </small>
                                    <a href="<?= $a->likeUrl ?>" id="showMentions" title="Voir toutes les mentions">
                                        <i class="right icon icon-menu-down"></i>
                                    </a>
                                </div>
                            </section>
                        </main>
                        <footer class="ng-news-card-footer" id="articleOptions">
                            <a id="likeBtn" class="ng-news-card-footer-item <?= $a->ML ?>" href="<?= $a->likeUrl ?>" title="aimer la publication">
                                <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                            </a>
                            <a id="commentBtn" class="ng-news-card-footer-item" href="/comments/" title="commenter la publication">
                                <i class="icon icon-comment" ></i>&nbsp;Commenter
                            </a>
                            <a id="shareBtn" class="ng-news-card-footer-item" href="/share/" title="partager la publication">
                                <i class="icon icon-share"></i>&nbsp;partager
                            </a>
                        </footer>
                    </article>
                    <!-- /CARD END -->
                <?php endforeach; ?>
                <div id="feedMore" class="ng-btn-feed-more"> charger la suite</div>

                <?php else : ?>
                    <div class="card">
                        <div class="no-publication">
                            <div class="ng-cover"></div>
                            <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
    </main>

    <!-- ==================== PAGE ASIDE ==================== -->
    <aside class="hide-on-small-and-down col s12 m2">
        <div class="page-title"><h1>Catégories</h1></div>
        <div class="collection">
            <a href="/gategory/famous" class="collection-item">
                Populaire <i class="icon icon-user right"></i>
            </a>
            <a href="/gategory/most-like" class="collection-item ">
                Aimer <i class="icon icon-thumbs-up right"></i>
            </a>
            <a href="#!" class="collection-item">
                Autre <i class="icon icon-plus right"></i>
            </a>
        </div>
        <div class="page-title"><h1>Suivez-nous</h1></div>
        <div class="collection">
            <a href="/rss-flux" class="collection-item">
                Flux rss <i class="social social-rss right"></i>
            </a>
            <a href="http://Instagram/ngpictures_23" target="_blank" class="collection-item" title="Dernières photos">
                Instagram <i class="social social-instagram right"></i>
            </a>
            <a href="http://www.Pexels.com/ngpictures_23" target="_blank" class="collection-item" title="Dernières photos">
                Pexels <i class="social social-instagram-2 right"></i>
            </a>
            <a href="http://www.Facebook.com/ngpictures_23" target="_blank" class="collection-item" title="Dernières photos">
                Facebook <i class="social social-facebook-1 right"></i>
            </a>
        </div>
    </aside>
</section>
