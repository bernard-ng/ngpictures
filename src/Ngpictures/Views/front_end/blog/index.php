<section class="section container row">
    <?php include(APP."/Views/includes/right-aside.php"); ?>
    <section class="section col nexted l6 m12 s12 animated fast slideInLeft">
        <div class="no-padding">
            <div class="ui divided items" id="dataContainer">
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $a) : ?>
                        <article class="card" id="<?= $a->id ?>" style="background: #100F0F">
                            <header class="card-image news-card-image">
                                <a href="<?= $a->url ?>" class="waves-effect">
                                    <img src="<?= $a->thumbUrl ?>" alt="<?= $a->title ?>">
                                </a>
                            </header>
                            <section class="news-card-content">
                                <section class="news-card-title">
                                    <h2><?= $a->title ?>&nbsp;<small><?= $a->category ?></small></h2>
                                </section>
                                <main>
                                    <p>
                                        <?= $a->snipet ?>
                                    </p>
                                    <a href="<?= $a->url ?>" class="news-card-seemore right">Voir plus</a>
                                </main>
                                <footer id="articleInfo">
                                    <div class="news-card-stat">
                                        <i class="icon icon-download"></i>&nbsp;
                                        <a href="<?= $a->downloadUrl ?>" title="Télécharger la photo">Télécharger</a>
                                    </div>
                                    <div class="news-card-stat">
                                        <i class="icon icon-calendar"></i>&nbsp;
                                        <time id="date_created" data-time="<?= strtotime($a->date_created) ?>"><?= $a->time ?></time>
                                    </div>
                                    <div class="news-card-stat">
                                        <i class="icon icon-thumbs-up"></i>&nbsp;
                                        <small><a data-action="showLikes" href="<?= $a->LikersUrl; ?>"><?= $a->Likes ?></a></small>
                                    </div>
                                </footer>
                            </section>
                            <footer class="news-card-footer" id="articleOptions">
                                <a data-action="like" class="news-card-footer-item <?= $a->isLike ?>" href="<?= $a->likeUrl ?>">
                                    <?php if ($a->isLike == 'active') : ?>
                                       <i class="icon icon-heart red-txt"></i>
                                    <?php else : ?>
                                       <i class="icon icon-heart-empty"></i>
                                    <?php endif; ?>
                                </a>
                                <a class="news-card-footer-item modal-trigger" href="#cmtAdd-<?= $a->id ?>" data-action="showComment">
                                    <?php if ($a->commentsNumber > 0) : ?>
                                        <i class="icon icon-comment" ></i>&nbsp;
                                    <?php else : ?>
                                        <i class="icon icon-comment-empty" ></i>&nbsp;
                                    <?php endif; ?>
                                    <span><?= $a->commentsNumber ?></span>
                                </a>
                                <a data-action="share" class="news-card-footer-item modal-trigger" href="#share-<?= $a->id ?>">
                                    <i class="icon icon-share"></i>
                                </a>
                            </footer>
                            <div id="cmtAdd-<?= $a->id ?>" class="modal dark bottom-sheet">
                                <div class="modal-content">
                                    <form action="<?= $a->commentUrl ?>" method="POST" data-action="comment">
                                        <div class="input-field">
                                            <label for="comment">Commentaire</label>
                                            <textarea class="mdz-textarea" name="comment" id="comment" data-length="255"></textarea>
                                        </div>
                                        <div class="modal-footer dark comment">
                                            <button type="submit" class="modal-action btn waves-effect">Envoyer</button>
                                            <button id="cmtAdd-<?= $a->id ?>" type="reset" class="btn btn-small transparent waves-effect modal-action modal-close">
                                                Annuler
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php endforeach ; ?>
                <?php else : ?>
                    <div class="full-infos">
                        Aucun Publication pour l'instant
                    </div>
                <?php endif; ?>
            </div>
            <div id="statusBar" class="btn btn-flat action waves-effect" data-ajax="blog">chargement...</div>
        </div>
    </section>
    <?php require(APP."/Views/includes/menu-aside.php"); ?>
</section>
