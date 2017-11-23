<section class="row container">
    <div class="page-title"><h1>Dernier Article</h1></div>
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <!-- ==================== PAGE CONTAIN ==================== -->
    <main class="col s12 m9 l8 xl8">
       <div id="articlesContainer">
            <!-- CARD -->
            <?php if (!empty($article)) : ?>

                <article class="card" id="<?= $article->id ?>">
                    <div class="card-image">
                        <span class="ng-news-card-image-article">
                            <a href="<?= $article->url ?>">
                                <img src=" <?= $article->thumbUrl ?>" alt="Article Image" title="<?= $article->title ?>">
                            </a>
                        </span>
                    </div>
                    <main class="ng-news-card-content">
                        <section class="ng-news-card-title">
                            <h2><?= $article->title ?></h2>
                        </section>
                        <content>
                            <?= $article->text ?>
                        </content>
                        <section id="articleInfo">
                            <div class="ng-news-card-stat">
                                <i class="icon icon-time"></i>&nbsp;
                                <small id="date_created" data-time="<?= strtotime($article->date_created) ?>">relative time here...</small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small>
                                    <a id="showLikes" href="/likes/"><?= $article->likes ?></a>
                                </small>
                                <a href="<?= $article->likeUrl ?>" id="showMentions"><i class="right icon icon-menu-down"></i></a>
                            </div>
                        </section>
                    </main>
                    <footer class="ng-news-card-footer" id="articleOptions">
                        <a id="likeBtn" class="ng-news-card-footer-item <?= $article->ML ?>" href="<?= $article->likeUrl ?>">
                            <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                        </a>
                        <a id="commentBtn" class="ng-news-card-footer-item" href="#"><i class="icon icon-comment"></i>&nbsp;Commenter</a>
                        <a id="shareBtn" class="ng-news-card-footer-item" href="#"><i class="icon icon-share"></i>&nbsp;Partager</a>
                    </footer>
                </article>

        <?php else : ?>
            <div class="card">
                <div class="no-publication">
                    <div class="ng-cover"></div>
                    <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                </div>
            </div>
        <?php endif; ?>

            <!-- /CARD END -->
        </div>
        
        <div class="hide-on-med-and-up">
            <?php include(APP."/Views/includes/verset.php"); ?>
        </div>
    </main>
    <?php include(APP."/Views/includes/right-aside.php"); ?>
    
</section>
<section class="row container">
    <div class="page-title"><h1>Dernières Photos</h1></div>
    <div class="images-panel ">
        <div class="col m6 no-padding">
             <section class="description">
                <blockquote>
                    l'ombre et la lumière surgissent de presque nul part, évanescentes elles apparaissent et disparaissent au gré du temps, elles sont par définition insaisissables et impalpables. seule la prise de vue photographique permet de monter la magie de cette dualité fraternelle. En effet l’ombre et la lumière sont les deux faces déterminantes de la photographie, souvent elles se font un face à face perpétuel dans des compositions surprenantes. Elles ne sont jamais neutres. Ainsi elle peuvent être une forme autonome se superposant à une réalité déjà présente. Nos  photos sont l'expression même de l'ombre sinueuse d'une personne.
                    <cite>&nbsp;&nbsp;— photophiles.com</cite>
                </blockquote>
                    
                    <br><br>
                    <span class="card-action">
                        <a href="#" class="see-more">Voir la gallerie</a>
                    </span>
                </p>
            </section>
            <aside class="aside-imgs hide-on-med-and-down">
                <!-- <div class="previous-imgs row" id="previousImgs">
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/2.jpg" alt="preso" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/96.jpg" alt="preso" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/63.jpg" alt="preso" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/45.jpg" alt="preso" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/47.jpg" alt="preso" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/47.jpg" alt="preso" title="preso">
                    </span>
                </div> -->
            </aside>
        </div>
        <div class="col m6 no-padding">
           <!--  <aside class="aside-imgs">
                 <div class="main-img" id="mainImg">
                    <img src="/imgs/banner-2.jpg" alt="Ngpictures bannière" title="ngpictures">
                </div>
                <div class="previous-imgs row" id="previousImgs">
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/2.jpg" alt="lol" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/96.jpg" alt="preso" title="preso">
                    </span>
                    <span class="col l4 s4 m4">
                        <img src="/Pictures/ngarticles/63.jpg" alt="preso" title="preso">
                    </span>
                </div>
            </aside> -->
        </div>
    </div>
</section>

