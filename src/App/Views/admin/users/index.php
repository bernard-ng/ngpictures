<section class="row container">
    <!-- ==================== PAGE ASIDE ===================================== -->
    <aside class="col m1 hide-on-small-and-down" id="singleOptions">
        <div class="card-panel">
            <button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-save"></i>
            </button>
        </div>
        <div class="card-panel">
            <button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-picture"></i>
            </button>
        </div>
        <div class="card-panel">
            <button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-list"></i>
            </button>
        </div>
        <div class="card-panel">
            <button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-calendar"></i>
            </button>
        </div>
        <div class="card-panel">
            <button class="btn-floating waves-effect waves-light cyan darken-2">
                <i class="icon icon-tags"></i>
            </button>
        </div>
    </aside>
    <!-- ==================== PAGE MAIN ===================================== -->
    <main class="col s12 m8">
        <div class="card-panel no-padding">
            <!-- ===============================  NG-NEWS-CARDS (BEGIN) ============================= -->
                <div id="articlesContainer">
                    <?php foreach($articles as $a): ?>
                        <!-- CARD -->
                        <article class="ng-article" id="<?= $a->id ?>">
                            <header class="card-image">
                                <div class="ng-article-img">
                                    <img src="../Pictures/ngarticles/<?= $a->thumb ?>" alt="<?= $a->title ?>">
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
                                        <small id="date_created" data-time="<?= strtotime($a->date_created) ?>">relative time here...</small>
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
                </div>
            <!-- ===============================  NG-NEWS-CARDS (END) ============================= -->
            <div id="feedMore" class="ng-btn-feed-more"> charger la suite</div>
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
    <aside class="col s12 m3 l3 xl3">
        <!-- CORPORATION CARD -->
        <div class="card hide-on-small-only ">
            <div class="card-image">
                <img src="/imgs/moi.jpg">
                <span class="card-title">Ngpictures corps</span>
                <a class="btn-floating halfway-fab waves-effect waves-light cyan darken-2">
                    <i class="icon icon-user"></i>
                </a>
            </div>
            <div class="ng-contain">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>
        <!-- /CORPORATION CARD (end) -->

        <?php include(APP."/Views/includes/verset.php"); ?>
    </aside>
</section>
