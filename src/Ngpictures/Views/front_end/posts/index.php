<main class="row container">

    <?php if ($activeUser) : ?>
    <nav class="nav z-depth-2">
            <div class="nav-wrapper">
                <ul>
                    <li><a href="/posts/following">Mes abonnements</a></li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <div class="col s12 m12 l9 xl9">
        <div id="dataContainer">
            <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
            <div class="ui card">
                <div class="content">
                    <div class="right floated meta">14h</div>
                    <img class="ui avatar image materialbox" href="<?= $post->userAvatarUrl ?>">
                    <a href="<?= $post->userAccountUrl ?>">
                        <?= $post->Username ?>
                    </a>
                </div>
                <div class="image">
                    <a href="<?= $post->url ?>">
                        <img src="<?= $post->thumbUrl ?>" alt="Article Image" title="<?= $post->title ?>">
                    </a>
                </div>
                <div class="content">
                    <span class="right floated">
                    <i class="icon icon-heart"></i>
                        <?php $post->likes; ?>
                    </span>
                    <i class="icon icon-comment"></i>
                    <?php $post->commentNumber; ?>
                </div>
                <div class="extra content">
                    <div class="ui large transparent left icon input">
                    <i class="heart outline icon"></i>
                    <input type="text" placeholder="Add Comment...">
                    </div>
                </div>
            </div>

                <article class="card" id="<?= $post->id ?>">
                    <header class="ng-news-card-header">
                        <span class="ng-news-card-image-profil">
                            <a href="<?= $post->userAvatarUrl ?>" class="zoombox">
                                <img src="<?= $post->userAvatarUrl ?>" alt="Profile <?= $post->username ?>">
                            </a>
                        </span>
                        <p class="ng-news-card-header-title">
                            <a href="<?= $post->userAccountUrl ?>">
                                <?= $post->Username ?>
                            </a>
                        </p>

                        <?php if ($post->thumb !== null) : ?>
                            <a id="saveBtn" class="ng-news-card-header-icon" href="<?= $post->downloadUrl ?>" title="Signaler Contenu indésirable">
                                <i class="icon icon icon-list"></i>
                            </a>
                            <a id="picBtn" class="ng-news-card-header-icon" href="<?= $post->userGalleryUrl ?>" title="toutes les publication">
                                <i class="icon icon icon-book"></i>
                            </a>
                            <a id="saveBtn" class="ng-news-card-header-icon" href="<?= $post->downloadUrl ?>" title="télécharger la photo">
                                <i class="icon icon icon-save"></i>
                            </a>
                        <?php endif; ?>
                    </header>

                    <?php if ($post->thumb !== null) : ?>
                        <div class="card-image">
                            <span class="ng-news-card-image-article">
                                <a href="<?= $post->url ?>">
                                    <img src="<?= $post->thumbUrl ?>" alt="Article Image" title="<?= $post->title ?>">
                                </a>
                            </span>
                        </div>
                    <?php endif; ?>

                    <main class="ng-news-card-content">
                        <section class="ng-news-card-title">
                            <?php if ($post->categories_id !== null) : ?>
                                <a href="<?= $post->categoryUrl ?>"><i class="icon icon-tags"></i></a>
                            <?php endif; ?>

                            <h2><?= $post->title ?>&nbsp;<small><?= $post->category ?></small></h2>
                        </section>
                        <section>
                            <p><?= $post->snipet ?></p>
                            <a href="<?= $post->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                        </section>
                        <section id="articleInfo">
                            <div class="ng-news-card-stat">
                                <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small>
                                    <a id="showLikes" href="<?= $post->likersUrl ?>"><?= $post->likes ?></a>
                                </small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-comment"></i>&nbsp;
                                <small>
                                    <?= $post->commentsNumber ?>
                                </small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-time"></i>&nbsp;
                                <small>
                                    <time id="date_created" data-time="<?= strtotime($post->date_created) ?>"><?= $post->date_created ?></time>
                                </small>
                            </div>
                        </section>
                    </main>
                    <footer class="ng-news-card-footer" id="articleOptions">
                        <a id="likeBtn" class="ng-news-card-footer-item <?= $post->isLike ?>" href="<?= $post->likeUrl ?>" title="aimer la publication">
                            <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                        </a>

                        <a id="commentBtn" class="ng-news-card-footer-item modal-trigger" href="#cmtAdd-<?= $post->id ?>">
                            <i class="icon icon-comment" ></i>&nbsp;Commenter
                        </a>
                        <div id="cmtAdd-<?= $post->id ?>" class="modal">
                            <div class="modal-content">
                                <span class="section-title-b mb-20">Commenter</span>
                                <form action="<?= $post->commentUrl ?>" method="POST">
                                    <div class="input-field">
                                        <textarea class="materialize-textarea" name="comment"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="modal-action btn primary-b">ok</button>
                                        <button id="cmtAdd-<?= $post->id ?>" type="reset" class="modal-action modal-close btn-flat">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <a id="shareBtn" class="ng-news-card-footer-item" href="/share/" title="partager la publication">
                            <i class="icon icon-share"></i>&nbsp;partager
                        </a>
                    </footer>
                </article>

            <?php endforeach; ?>
            <?php else : ?>
                <div class="card">
                    <div class="no-publication">
                        <div class="ng-cover"></div>
                        <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="feedMore" class="feed-btn" data-ajax="posts"><i class="icon icon-refresh rotate"></i> chargement</div>
    </div>

<?php include(APP."/Views/includes/menu-aside.php"); ?>
</main>
