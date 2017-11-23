<section class="row container">
    <!-- ==================== PAGE ASIDE ===================================== -->
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <main class="col s12 l8 xl8 m9" role="main">
        <div class="card-panel no-padding">
            <div id="articlesContainer">
                <?php if (!empty($articles)) : ?>
                <?php foreach($articles as $a): ?>
                    <!-- CARD -->
                    <article class="ng-article" id="<?= $a->id ?>">
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
                                    <?= $a->text ?>
                                    <br><a href="<?= $a->url ?>">Voir plus</a>
                                </p>
                            </main>
                            <footer id="articleInfo">
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-time"></i>&nbsp;
                                    <time id="date_created" data-time="<?= strtotime($a->date_created) ?>">relative time here...</time>
                                </div>
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-thumbs-up"></i>&nbsp;
                                    <small><a id="showLikes" href="/likes"><?= $a->Likes ?></a></small>
                                    <a href="<?= $a->likeUrl ?>" id="showMentions"><i class="right icon icon-menu-down"></i></a>
                                </div>
                            </footer>
                        </section>
                    </article>
                    <!-- /CARD END -->
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
    <!-- ====================  ASIDE ===================================== -->
    <aside id="singleOptions">
        <span class="col  l1 xl1 hide-on-med-and-down">
            <div class="card-panel ng-more-options">
                <a href="/about/shooting">
                    <i class="icon icon-camera" title="Apropos des shoots"></i><br>Shoot
                </a>
            </div>
            <div class="card-panel ng-more-options">
                <a href="/contact">
                    <i class="icon icon-phone" title="Nous contacter"></i><br>phone
                </a>
            </div>
            <div class="card-panel ng-more-options">
                <a href="/about/event">
                    <i class="icon icon-calendar" title="Nos événements"></i><br>Event
                </a>
            </div>
            <div class="card-panel ng-more-options" data-sticky>
                <a href="/about/news">
                    <i class="icon icon-asterisk" title="Nouveauté du site"></i><br>News
                </a>
            </div>
        </span> 
    </aside>
</section>
