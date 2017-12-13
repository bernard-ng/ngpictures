<div class="parallax-container hide-on-small-and-down border-b">
    <span class="ng-cover"></span>
    <div class="parallax">
        <img src="/Pictures/articles/<?= $article->thumb ?>" alt="Article Image" title="<?= $article->title ?>">
    </div>
</div>
<div class="row container">
    <!-- ==================== PAGE CONTAIN ============================================ -->
    <div class="col m10 l10 offset-m1 offset-l1 " style="margin-top: -30%">
        <!-- ARTICLE -->
            <article class="card ng-neg-top" id="<?= $article->id ?>">
                <header class="card-image">
                    <span class="ng-article-category"><i class="icon icon-pencil"></i></span>
                    <span class="ng-news-card-image-article">
                        <img src="<?= $article->thumbUrl ?>" alt="Article Image" title="<?= $article->title ?>">
                    </span>
                </header>
                <main class="ng-news-card-content">
                    <span class="ng-news-card-title">
                            <h1><?= $article->title ?></h1>
                    </span>
                    <content class="article-content">
                        <?= $article->content ?>
                        &nbsp;
                    </content>
                    <section id="articleInfo">
                        <div class="ng-news-card-stat">
                            <i class="icon icon-user"></i>&nbsp;
                            <small id="poster_info">par <a href="/account/"><?= $article->username ?></a></small>
                        </div>
                        <div class="ng-news-card-stat">
                            <i class="icon icon-time"></i>&nbsp;
                            <small id="date_created" data-timestamp="<?= strtotime($article->date_created) * 1000 ?>"><?= $article->date_created ?></small>
                        </div>
                        <div class="ng-news-card-stat">
                            <i class="icon icon-thumbs-up"></i>&nbsp;
                            <small><a id="showLikes" href="/likes/<?= $article->SI ?>"><?= $article->likes ?></a></small>
                        </div>
                         <div class="ng-news-card-stat">
                            <i class="icon icon-thumbs-down"></i>&nbsp;
                            <small><a id="showLikes" href="/dislikes/<?= $article->SI ?>"><?= $article->dislikes ?></a></small>
                            <a id="showMentions" href="#"><i class="right icon icon-menu-down"></i></a>
                        </div>
                    </section>
                </main>
                <footer class="ng-news-card-footer" id="articleOptions">
                    <a href="<?= $article->likeUrl ?>" id="likeBtn" class="ng-news-card-footer-item <?= $article->ML ?>">
                        <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                    </a>
                    <a href="<?= $article->dislikeUrl ?>" id="dislikeBtn" class="ng-news-card-footer-item <?= $article->MD ?>">
                        <i class="icon icon-thumbs-down"></i>&nbsp;je n'aime pas
                    </a>
                    <a href="/share/<?= $article->SI ?>" id="shareBtn" class="ng-news-card-footer-item">
                        <i class="icon icon-share"></i>&nbsp;partager
                    </a>
                </footer>
            </article>

        <div class="card-panel row">
            <div class="col l6 m6 s12">
                <form>
                    <textarea placeholder="Votre commentaire"></textarea>
                </form>
            </div>
           
        </div>
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
    <!-- ==================== /PAGE CONTAIN (END) ===================================== -->
</div>

