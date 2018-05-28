<section class="section container row">
    <?php include(APP."/Views/includes/right-aside.php"); ?>
    <section class="section col nexted l6 m12 s12 animated fast slideInLeft">
        <div id="dataContainer">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $a) : ?>
                    <article class="card" id="<?= $a->id ?>" style="background: #100F0F">
                        <header class="news-card-header">
                            <span class="news-card-image-profil"></span>
                            <p class="news-card-header-title"></p>
                            <?php if ($a->thumb !== null) : ?>
                                <a href="#" class="dropdown-button news-card-header-icon" data-activates="options-list-<?= $a->id ?>">
                                    <i class="icon icon-down-open"></i>
                                </a>
                                <ul id="options-list-<?= $a->id ?>" class="dropdown-content grey dark-4">
                                    <li>
                                        <a href="<?= $a->categoryUrl ?>">
                                            <i class="icon icon-tag"></i>
                                            Catégories
                                        </a>
                                    </li>
                                    <li>
                                        <a data-action="report" class="news-card-header-icon modal-trigger" href="#report-<?= $a->id ?>">
                                            <i class="icon icon-attention"></i>
                                            Signaler
                                        </a>
                                    </li>
                                    <li>
                                        <a data-action="save" href="<?= $a->saveUrl ?>">
                                            <?php if($a->isSaved): ?>
                                                <i class="icon icon-bookmark"></i>
                                                Rétirer des Enr.
                                            <?php else: ?>
                                                <i class="icon icon-bookmark-empty"></i>
                                                Enregistrer
                                            <?php endif; ?>

                                        </a>
                                    </li>
                                    <li>
                                        <a data-action="download" href="<?= $a->downloadUrl ?>">
                                            <i class="icon icon-download"></i>
                                            Télécharger
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </header>
                        <div class="card-image news-card-image">
                            <a href="<?= $a->url ?>" class="waves-effect">
                                <img src="<?= $a->thumbUrl ?>" alt="<?= $a->title ?>">
                            </a>
                        </div>
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
                        <div id="cmtAdd-<?= $a->id ?>" class="modal grey dark-4 bottom-sheet">
                            <div class="modal-content">
                                <form action="<?= $a->commentUrl ?>" method="POST" data-action="comment">
                                    <div class="input-field">
                                        <label for="comment">Commentaire</label>
                                        <textarea class="materialize-textarea" name="comment" id="comment" data-length="255"></textarea>
                                    </div>
                                    <div class="modal-footer transparent comment">
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
                <div id="statusBar" class="btn ng-progress-indeterminate disabled" data-ajax="blog">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <br>
            <?php else : ?>
                <div class="section center-align">
                    <h2 class="icon icon-inbox red-txt center-align"></h2>
                    <h2 class="ui header divided center"> Aucune publication pour l'instant</h2>
                    <p>
                        le site ne présente actuellement aucune publication disponible, les publications sont peut être en évaluation,
                        ceci pourrait prendre du temps, veuillez revenir plus tard
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php require(APP."/Views/includes/menu-aside.php"); ?>
</section>
