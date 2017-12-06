<main class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <div class="col s12 m9 l6 xl6">
        <div id="articlesContainer">
            <?php if (!empty($articles)) : ?>
            <?php foreach ($articles as $a) : ?>

                <article class="card" id="<?= $a->id ?>">
                    <header class="ng-news-card-header">
                        <span class="ng-news-card-image-profil">
                            <a href="<?= $a->userAvatarUrl ?>" class="zoombox">
                                <img src="<?= $a->userAvatarUrl ?>" alt="Profile <?= $a->username ?>" title="<?= $a->username ?>">
                            </a>
                        </span>
                        <p class="ng-news-card-header-title">
                            <a href="<?= $a->userAccountUrl ?>" title="voir le profil">
                                <?= $a->username ?>        
                            </a>
                        </p>

                        <?php if($a->thumb !== null): ?>
                            <a id="picBtn" class="ng-news-card-header-icon" href="<?= $a->userGalleryUrl ?>" title="voir la galery">
                                <i class="icon icon icon-picture"></i>
                            </a>
                            <a id="saveBtn" class="ng-news-card-header-icon" href="<?= $a->downloadUrl ?>" title="télécharger la photo">
                                <i class="icon icon icon-save"></i>
                            </a>
                        <?php endif; ?>
                    </header>

                    <?php if($a->thumb !== null): ?>
                        <div class="card-image">
                            <span class="ng-news-card-image-article">
                                <a href="<?= $a->url ?>">
                                    <img src="<?= $a->thumbUrl ?>" alt="Article Image" title="<?= $a->title ?>">
                                </a>
                            </span>
                        </div>
                    <?php endif; ?>

                    <main class="ng-news-card-content">
                        <section class="ng-news-card-title">
                            <h2><?= $a->title ?></h2>
                        </section>
                        <section>
                            <p><?= $a->snipet ?></p>
                            <a href="<?= $a->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                        </section>
                        <section id="articleInfo">
                            <div class="ng-news-card-stat">
                                <i class="icon icon-time"></i>&nbsp;
                                <time id="date_created" data-time="<?= strtotime($a->date_created) ?>"><?= $a->date_created ?></time>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small>
                                    <a id="showLikes" href="<?= $a->showLikesUrl ?>"><?= $a->likes ?></a>
                                </small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="social social-chat"></i>&nbsp;
                                <small>
                                    <a id="showComments" href="<?= $a->showCommentsUrl ?>"><?= count($a->comments); ?> commentaires</a>
                                </small>
                            </div>
                        </section>
                    </main>
                    <footer class="ng-news-card-footer" id="articleOptions">
                        <a id="likeBtn" class="ng-news-card-footer-item <?= $a->isLike ?>" href="<?= $a->likeUrl ?>" title="aimer la publication">
                            <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                        </a>
                        <a id="commentBtn" class="ng-news-card-footer-item" href="<?= $a->commentUrl ?>" title="commenter la publication">
                            <i class="icon icon-comment" ></i>&nbsp;Commenter
                        </a>
                        <a id="shareBtn" class="ng-news-card-footer-item" href="/share/" title="partager la publication">
                            <i class="icon icon-share"></i>&nbsp;partager
                        </a>
                    </footer>
                </article>
               
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
    </div>

    <?php include(APP."/Views/includes/menu-aside.php"); ?>
</main>
