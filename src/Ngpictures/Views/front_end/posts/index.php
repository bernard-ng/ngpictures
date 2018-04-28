<section class="section row container">
    <section class="col l6 m12 s12 nexted  animated fast slideInLeft">
        <div id="dataContainer">
            <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $a) : ?>
                <article class="card" id="<?= $a->id ?>" style="background: #100F0F">
                    <header class="news-card-header">
                        <span class="news-card-image-profil">
                            <img src="<?= $a->userAvatarUrl ?>" class="materialboxed" alt="photo de profile" title="<?= $a->username ?>">
                        </span>
                        <p class="news-card-header-title">
                            <a href="<?= $a->userAccountUrl ?>"><?= $a->Username ?> </a>
                        </p>

                        <?php if ($a->thumb !== null) : ?>
                            <a href="<?= $a->categoryUrl ?>" class="news-card-header-icon">
                                <i class="icon icon-tag"></i>
                            </a>
                            <a data-action="report" class="news-card-header-icon">
                                <i class="icon icon-bell-alt"></i>
                            </a>
                            <a data-action="download" class="news-card-header-icon" href="<?= $a->downloadUrl ?>">
                                <i class="icon icon icon-download"></i>
                            </a>
                        <?php endif; ?>
                    </header>
                    <?php if ($a->thumb !== null) : ?>
                        <div class="card-image">
                            <span class="news-card-image-article">
                                <a href="<?= $a->url ?>" class="waves-effect">
                                    <img src="<?= $a->thumbUrl ?>" alt="Image de l'article" title="<?= $a->title ?>">
                                </a>
                            </span>
                        </div>
                    <?php endif; ?>
                    <main class="news-card-content">
                        <?php if ($a->title !== null && $a->title !== ''): ?>
                            <section class="news-card-title">
                                <h2><?= $a->title ?>&nbsp;<small><?= $a->category ?></small></h2>
                            </section>
                        <?php endif; ?>
                        <?php if ($a->content !== null && $a->content !== ''): ?>
                            <section>
                                <p><?= $a->snipet ?></p>
                                <a href="<?= $a->url ?>" class="news-card-seemore right">Voir plus</a>
                            </section>
                        <?php endif; ?>

                        <section id="articleInfo">
                            <div class="news-card-stat">
                            <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small>
                                <a data-action="showLikes" href="<?= $a->showLikesUrl ?>"><?= $a->likes ?></a>
                                </small>
                            </div>

                            <div id="cmtAdd-<?= $a->id ?>" class="modal">
                                <div class="modal-content">
                                    <form action="<?= $a->commentUrl ?>" method="POST">
                                        <div class="materialize-textarea">
                                            <label for="comment">Commenter...</label>
                                            <textarea class="materialize-textarea" name="comment" id="comment"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="modal-action btn waves-effect">Envoyer</button>
                                            <button id="cmtAdd-<?= $a->id ?>" type="reset" class="btn waves-effect modal-action modal-close">
                                                Annuler
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="share-<?= $a->id ?>" class="modal">
                                <div class="modal-content">
                                    <form action="<?= $a->commentUrl ?>" method="POST">
                                        <div class="materialize-textarea">
                                            <label for="comment">Commenter...</label>
                                            <textarea class="materialize-textarea" name="comment" id="comment"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="modal-action btn waves-effect">Envoyer</button>
                                            <button id="cmtAdd-<?= $a->id ?>" type="reset" class="btn waves-effect modal-action modal-close">
                                                Annuler
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="news-card-stat">
                                <i class="icon icon-calendar"></i>&nbsp;
                                <time data-time="<?= strtotime($a->date_created) ?>"><?= $a->time ?></time>
                            </div>
                        </section>
                    </main>
                    <footer class="news-card-footer" id="articleOptions">
                        <a data-action="like" class="news-card-footer-item <?= $a->isLike ?>" href="<?= $a->likeUrl ?>">
                            <?php if ($a->isLike == 'active'): ?>
                                <i class="icon icon-heart red-txt"></i>
                            <?php else: ?>
                                <i class="icon icon-heart-empty"></i>
                            <?php endif; ?>
                        </a>
                        <a data-action="comment" class="news-card-footer-item modal-trigger" href="#cmtAdd-<?= $a->id ?>">
                            <?php if ($a->commentsNumber > 0 ): ?>
                                <i class="icon icon-comment" ></i>&nbsp;
                            <?php else: ?>
                                <i class="icon icon-comment-empty" ></i>&nbsp;
                            <?php endif; ?>
                            <?= $a->commentsNumber ?>
                        </a>
                        <a data-action="share" class="news-card-footer-item modal-trigger" href="#share-<?= $a->id ?>">
                            <i class="icon icon-share"></i>
                        </a>
                    </footer>
                </article>
            <?php endforeach; ?>
            <?php else : ?>
                <div class="card">
                    <div class="no-publication">
                        <div class="ng-cover"></div>
                        <p><i class="icon icon-picture"></i>aucune publication pour l'instant</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="statusBar" class="feed-btn" data-ajax="posts">chargement</div>
    </section>

<?php include(APP."/Views/includes/menu-aside.php"); ?>
</section>
