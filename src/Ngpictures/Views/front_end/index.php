<section class="row container">
    <div class="col l3 no-padding">
        <div class="card hide-on-med-and-down ">
            <div class="card-image">
                <img src="/imgs/wdp.png">
            </div>
            <div class="ng-contain">
                <section class="description">
                    <blockquote>
                        We make design and photography wonderful.
                        want to like or have something wonderful ?
                        you are at the right place.
                    </blockquote>
                </section>
            </div>
            <div class="aside-imgs">
                <div class="previous-imgs row" id="previousImgs">
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/bernard.jpg" alt="preso" title="Bernard - photographer" class="circle z-depth-1">
                    </span>
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/gael.jpg" alt="preso" title="Gaël - marketing" class="circle z-depth-1">
                    </span>
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/rapha.jpg" alt="preso" title="rapha - designer" class="circle z-depth-1">
                    </span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-image">
                <img src="/imgs/ngpic.jpg">
            </div>
            <div class="ng-contain">
                <section class="description">
                    <blockquote>
                        The deep shooting, is not about what you see
                        is about what you feel, when looking at a picture.
                    </blockquote>
                </section>
            </div>
            <div class="aside-imgs">
                <div class="previous-imgs row" id="previousImgs">
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/balloy.jpg" alt="preso" title="Balloy fane" class="circle z-depth-1">
                    </span>
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/precylia.jpg" alt="preso" title="precylia felo" class="circle z-depth-1">
                    </span>
                    <span class="col l4 m4 s4">
                        <img src="/imgs/team/grey.jpg" alt="preso" title="gretta mpunga" class="circle z-depth-1">
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== PAGE CONTAIN ==================== -->
    <main class="col s12 m9 l6 xl6">
       <div id="postsContainer">
            <!-- CARD -->
            <?php if (!empty($article)) : ?>
                <article class="card" id="<?=$article->id ?>">
                    <header class="card-image">
                        <div class="ng-article-img">
                            <img src="<?=$article->thumbUrl ?>" alt="<?=$article->title ?>">
                        </div>
                    </header>
                    <section class="ng-news-card-content">
                        <section class="ng-news-card-title">
                            <?php if ($article->category_id !== null) : ?>
                                <a href="<?= $article->categoryUrl ?>"><i class="icon icon-tags"></i></a>
                            <?php endif; ?>

                            <h2><?= $article->title ?>&nbsp;<small><?= $article->category ?></small></h2>
                        </section>
                        <main>
                            <p>
                                <?=$article->snipet ?>
                            </p>
                            <a href="<?=$article->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                        </main>
                        <footer id="articleInfo">
                            <div class="ng-news-card-stat">
                                <i class="icon icon-save"></i>&nbsp;
                                <a href="<?=$article->downloadUrl ?>" title="Télécharger la photo">Télécharger</a>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small><a id="showLikes" href="/likes/<?= $article->SI ?>"><?=$article->Likes ?></a></small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-comment"></i>&nbsp;
                                <small><?=$article->commentsNumber ?></small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-time"></i>&nbsp;
                                <small>
                                    <time id="date_created" data-time="<?= strtotime($article->date_created) ?>"><?=$article->time ?></time>
                                </small>
                            </div>
                        </footer>
                    </section>
                    <footer class="ng-news-card-footer" id="articleOptions">
                        <a id="likeBtn" class="ng-news-card-footer-item <?=$article->isLike ?>" href="<?=$article->likeUrl ?>">
                            <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                        </a>

                        <a id="commentBtn" class="ng-news-card-footer-item modal-trigger" href="#cmtAdd">
                            <i class="icon icon-comment" ></i>&nbsp;Commenter
                        </a>
                        <div id="cmtAdd" class="modal">
                            <div class="modal-content">
                                <span class="section-title-b mb-20">Commenter</span>
                                <form action="<?= $article->commentUrl ?>" method="POST">
                                    <div class="input-field">
                                        <textarea class="materialize-textarea" name="comment"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="modal-action btn primary-b">ok</button>
                                        <button id="cmtAdd" type="reset" class="modal-action modal-close btn-flat">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <a id="shareBtn" class="ng-news-card-footer-item" href="/share/">
                            <i class="icon icon-share"></i>&nbsp;partager
                        </a>
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
        <article class="card">
            <section class="ng-news-card-content">
                <section class="ng-news-card-title">
                    <i class="icon icon-picture"></i>
                    <h2>Nos photos</h2>
                </section>
                <div class="images-panel ">
                    <section class="description">
                        <blockquote>
                            l'ombre et la lumière surgissent de presque nul part, évanescentes elles apparaissent et disparaissent au gré du temps, elles sont par définition insaisissables et impalpables. seule la prise de vue photographique permet de monter la magie de cette dualité fraternelle. En effet l’ombre et la lumière sont les deux faces déterminantes de la photographie, souvent elles se font un face à face perpétuel dans des compositions surprenantes. Elles ne sont jamais neutres. Ainsi elle peuvent être une forme autonome se superposant à une réalité déjà présente. Nos  photos sont l'expression même de l'ombre sinueuse d'une personne.
                            <br><a href="/gallery" class="ng-news-card-seemore">Voir la gallerie</a>
                        </blockquote>
                    </section>
                    <aside class="aside-imgs">
                        <div class="previous-imgs row" id="previousImgs">
                            <span class="col l3 m3 s3">
                                <img src="/imgs/team/prisca.jpg" alt="banner image">
                            </span>
                            <span class="col l3 m3 s3">
                                <img src="/imgs/team/gael.jpg" alt="banner image" >
                            </span>
                            <span class="col l3 m3 s3">
                                <img src="/imgs/team/rapha.jpg" alt="banner image">
                            </span>
                            <span class="col l3 m3 s3">
                                <img src="/imgs/team/bernard.jpg" alt="banner image">
                            </span>
                        </div>
                    </aside>
                </div>
            </section>
        </article>
    </main>
    <?php include(APP."/Views/includes/menu-aside.php"); ?>

</section>
