<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <main class="col s12 l6 xl6 m9" role="main">
        <div class="no-padding">
            <div id="articlesContainer">
                <?php if (!empty($articles)) : ?>
                <?php foreach($articles as $a): ?>
                    <article class="card" id="<?= $a->id ?>">
                        <header class="card-image">
                            <div class="ng-article-img">
                                <img src="<?= $a->thumbUrl ?>" alt="<?= $a->title ?>">
                            </div>
                        </header>
                        <section class="ng-news-card-content">
                            <section class="ng-news-card-title">
                                <i id="category" class="icon icon-pencil"></i>
                                <h2><?= $a->title ?></h2>
                            </section>
                            <main>
                                <p>
                                    <?= $a->snipet ?>
                                </p>
                                <a href="<?= $a->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                            </main>
                            <footer id="articleInfo">
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-save"></i>&nbsp;
                                    <a href="<?= $a->downloadUrl ?>" title="Télécharger la photo">Télécharger</a>
                                </div>
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-time"></i>&nbsp;
                                    <time id="date_created" data-time="<?= strtotime($a->date_created) ?>"><?= $a->time ?></time>
                                </div>
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-thumbs-up"></i>&nbsp;
                                    <small><a id="showLikes" href="/likes"><?= $a->Likes ?></a></small>
                                </div>
                            </footer>
                        </section>
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
                <?php endforeach ; ?>
                <div id="feedMore" class="feed-btn waves-effect waves-teal waves-ripple hoverable"> charger la suite</div>

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
    </main>
    <section class="col s12 hide-on-med-and-up" id="singleOptions-mobile">
        <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-home"></i></button>
        </div>
        <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-globe"></i></button>
        </div>
        <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-picture"></i></button>
        </div>
        <div class="card-panel"><button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-user"></i></button>
        </div>
    </section>
    
    <?php include(APP."/Views/includes/menu-aside.php"); ?>
   
</section>
