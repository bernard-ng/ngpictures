<div class="parallax-container hide-on-small-and-down border-b">
    <span class="ng-cover"></span>
    <div class="parallax">
        <img src="<?= $article->thumbUrl ?>" alt="Article Image" title="<?= $article->title ?>">
    </div>
</div>
<div class="row container">
    <!-- ==================== PAGE CONTAIN ============================================ -->
    <div class="col m10 l10 offset-m1 offset-l1">
        <!-- ARTICLE -->
            <article class="card ng-neg-top" id="<?= $article->id ?>">
                
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
                            <small><a id="showLikes" href="<?= $article->likeUrl ?>"><?= $article->likes ?></a></small>
                        </div>
                    </section>
                </main>
                <footer class="ng-news-card-footer" id="articleOptions">
                    <a href="<?= $article->likeUrl ?>" id="likeBtn" class="ng-news-card-footer-item <?= $article->ML ?>">
                        <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                    </a>
                    <a href="/share/<?= $article->SI ?>" id="shareBtn" class="ng-news-card-footer-item">
                        <i class="icon icon-share"></i>&nbsp;partager
                    </a>
                </footer>
            </article>
        <?php include(APP."/Views/includes/comments.php"); ?>
        
</div>

