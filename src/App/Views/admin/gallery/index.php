<?php include(APP."/Views/includes/default-slider.php"); ?>
        
        <section class="row container">
            <!-- ==================== PAGE ASIDE ==================== -->
            <?php include(APP."/Views/includes/left-aside.php"); ?>

            <!-- ==================== PAGE CONTAIN  ============================ -->
            <main class="col s12 m7">
                <!-- ==================== NG-NEWS-CARDS (BEGIN) ==================== -->
                    <div id="articlesContainer">
                        <?php foreach ($articles as $a) : ?>

                            <!-- CARD -->
                            <article class="card" id="<?= $a->id ?>">
                                <!-- CARD HEADER -->
                                <header class="ng-news-card-header">
                                    <span class="ng-news-card-image-profil">
                                        <img src="../Pictures/users/avatar/thumb/640-640/<?= $a->user_id ?>.jpg" alt="Profil Image" title="<?= $a->username ?>">
                                    </span>
                                    <p class="ng-news-card-header-title"><a href="/account/" title="voir le profil"><?= $a->username ?></a></p>
                                    <a id="picBtn" class="ng-news-card-header-icon" href="/galery/" title="voir la galery"><i class="icon icon icon-picture"></i></a>
                                    <a id="saveBtn" class="ng-news-card-header-icon" href="/download/" title="télécharger la photo"><i class="icon icon icon-save"></i></a>
                                </header>
                                <!-- /CARD HEADER END -->

                                <!-- CARD BODY -->
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
                                            <a href="<?= $a->likeUrl ?>" id="showMentions" title="Voir toutes les mentions"><i class="right icon icon-menu-down"></i></a>
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
                    </div>
                    <!-- ==================== /NG-NEWS-CARDS (END) ==================== -->

                <div id="feedMore" class="ng-btn-feed-more"> charger la suite</div>
            </main>

            <!-- ==================== PAGE ASIDE ==================== -->
            <aside class="hide-on-small-and-down col s12 m2">
                <div class="collection">
                    <a href="#!" class="collection-item">Alvin</a>
                    <a href="#!" class="collection-item ">Alvin</a>
                    <a href="#!" class="collection-item">Alvin</a>
                    <a href="#!" class="collection-item">Alvin</a>
                </div>
            </aside>
        </section>
