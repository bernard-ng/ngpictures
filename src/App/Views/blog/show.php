<div class="row container">
    <?php include(APP."/Views/includes/sharer.php"); ?>
    <div class="col 18 l8 s12">
        <!-- ARTICLE -->
            <article class="card ng-neg-top" id="<?= $article->id ?>">
                <main class="ng-news-card-content">
                    <content class="article-content">
                        <h1 style="margin-top: 0 !important;text-transform: uppercase;font-size: 2.3em"><?= $article->title ?></h1>
                        <p>
                            <img src="<?= $article->thumbUrl;?>" alt="Article Image" title="<?= $article->title ?>" class="align-center" width="100%">
                        </p>
                        <?= $article->fullText ?>
                        &nbsp;
                    </content>
                    <section id="articleInfo">
                        <div class="ng-news-card-stat">
                            <i class="icon icon-time"></i>&nbsp;
                            <time id="date_created" data-time="<?= strtotime($article->date_created) ?>">
                                <?= $article->time ?>
                            </time>
                        </div>
                        <div class="ng-news-card-stat">
                            <i class="icon icon-thumbs-up"></i>&nbsp;
                            <small><a id="showLikes" href="/likes/<?= $article->SI ?>"><?= $article->likes ?></a></small>
                        </div>
                         <div class="ng-news-card-stat">
                            <i class="icon icon-thumbs-down"></i>&nbsp;
                            <small><a id="showLikes" href="/dislikes/<?= $article->SI ?>"><?= $article->dislikes ?></a></small>
                            <a id="showMentions" href="/likes/show/<?= $article->SI ?>"><i class="right icon icon-menu-down"></i></a>
                        </div>
                    </section>
                </main>
                <footer class="ng-news-card-footer" id="articleOptions">
                    <a href="<?= $article->likeUrl ?>" id="likeBtn" class="ng-news-card-footer-item <?= $article->ML ?>">
                        <i class="social social-heart"></i>&nbsp;J'aime
                    </a>
                    <a href="<?= $article->dislikeUrl ?>" id="dislikeBtn" class="ng-news-card-footer-item <?= $article->MD ?>">
                        <i class="social social-heart-broken"></i>&nbsp;je n'aime pas
                    </a>
                    <a href="/share/<?= $article->SI ?>" id="shareBtn" class="ng-news-card-footer-item">
                        <i class="icon icon-share"></i>&nbsp;partager
                    </a>
                </footer>
            </article>
            <?php include(APP."/Views/includes/comments.php"); ?>

        <div class="col s12 hide-on-med-and-up" id="singleOptions-mobile">
            <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-save"></i></button>
            </div>
            <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-tags"></i></button>
            </div>
            <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                    <i class="icon icon-picture"></i></button>
            </div>
            <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                    <i class="icon icon-user"></i></button>
            </div>
        </div>
    </div>
    <?php include(APP."/Views/includes/left-aside.php"); ?>
</div>

