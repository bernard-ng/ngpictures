<section class="section row container">
    <?php include(APP."/Views/includes/right-aside.php"); ?>
    <section class="col l6 m12 s12 nexted  animated fast slideInLeft">
        <div id="dataContainer">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $a) : ?>
                    <article class="card" id="<?= $a->id ?>" style="background: #100F0F">
                        <header class="news-card-header">
                            <span class="news-card-image-profil">
                                <img src="<?= $a->userAvatarUrl ?>" class="materialboxed" alt="photo de profile" title="<?= $a->username ?>">
                            </span>
                            <p class="news-card-header-title">
                                <a href="<?= $a->userAccountUrl ?>"><?= $a->Username ?> </a>
                            </p>

                            <?php if ($a->thumb !== null) : ?>
                                <a href="#" class="dropdown-button news-card-header-icon" data-activates="options-list-<?= $a->id ?>">
                                    <i class="icon icon-menu"></i>
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
                                            <i class="icon icon-bookmark-empty"></i>
                                            Enregistrer
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
                        <?php if ($a->thumb !== null) : ?>
                            <div class="card-image">
                                <span class="news-card-image-article">
                                    <a href="<?= $a->url ?>" class="waves-effect">
                                        <img src="<?= $a->thumbUrl ?>" alt="Image de l'article" title="<?= $a->title ?>">
                                    </a>
                                </span>
                            </div>
                        <?php endif; ?>
                        <main class="news-card-content">
                            <?php if ($a->title !== null && $a->title !== '') : ?>
                                <section class="news-card-title">
                                    <h2><?= $a->title ?>&nbsp;<small><?= $a->category ?></small></h2>
                                </section>
                            <?php endif; ?>
                            <?php if ($a->content !== null && $a->content !== '') : ?>
                                <section>
                                    <p><?= $a->snipet ?></p>
                                    <a href="<?= $a->url ?>" class="news-card-seemore right">Voir plus</a>
                                </section>
                            <?php endif; ?>

                            <section id="articleInfo">
                                <div class="news-card-stat">
                                <i class="icon icon-thumbs-up"></i>
                                    <small>
                                    <a data-action="showLikes" href="<?= $a->showLikesUrl ?>"><?= $a->likes ?></a>
                                    </small>
                                </div>
                                <div class="news-card-stat">
                                    <i class="icon icon-calendar"></i>
                                    <time data-time="<?= strtotime($a->date_created) ?>"><?= $a->time ?></time>
                                </div>
                            </section>
                        </main>
                        <footer class="news-card-footer" id="articleOptions">
                            <a data-action="like" class="news-card-footer-item <?= $a->isLike ?>" href="<?= $a->likeUrl ?>">
                                <?php if ($a->isLike == 'active') : ?>
                                    <i class="icon icon-heart red-txt"></i>&nbsp;
                                <?php else : ?>
                                    <i class="icon icon-heart-empty"></i>&nbsp;
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
                        <div id="share-<?= $a->id ?>" class="modal grey dark-4 bottom-sheet">
                            <div class="modal-content">
                                <div class="col l12 m12 s12">
                                    <div class="col l3 m3 s3">
                                        <button class="btn btn-flat waves-effect hoverable" style="background: #4c67a1" data-action="share-facebook" data-url="<?= $a->url ?>">
                                            <i class="icon icon-facebook"></i>
                                        </button>
                                    </div>
                                   <div class="col l3 m3 s3">
                                       <button class="btn btn-flat waves-effect hoverable" style="background: #55acee" data-action="share-twitter" data-url="<?= $a->url ?>">
                                           <i class="icon icon-twitter"></i>
                                       </button>
                                   </div>
                                    <div class="col l3 m3 s3">
                                        <button class="btn btn-flat waves-effect hoverable" style="background: #d23f31" data-action="share-google-plus" data-url="<?= $a->url ?>">
                                            <i class="icon icon-googleplus-rect"></i>
                                        </button>
                                    </div>
                                    <div class="col l3 m3 s3">
                                        <button class="btn btn-flat waves-effect hoverable" style="background: #11a84d" data-action="share-whatsapp" data-url="<?= $a->url ?>">
                                            <i class="icon icon-whatsapp"></i>
                                        </button>
                                    </div>
                                    <div class="modal-footer col s12 grey dark-4" style="margin-top: 10px;">
                                        <button class="btn transparent shadow-0 modal-action modal-close">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
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
    <?php if (isset($posts) && !empty($posts)) : ?>
        <?php foreach ($posts as $a) : ?>
            <div id="report-<?= $a->id ?>" class="modal grey dark-4">
                <div class="modal-content">
                    <p>Choissez un motif pour le signalement de cette publication</p>
                    <form action="<?= $a->watchoutUrl ?>" method="POST" data-action="watchout">
                            <p>
                                <input type="checkbox" class="filled-in" name="indesirable" id="indesirable">
                                <label for="indesirable">Contenu indésirable</label>
                            </p>
                            <p>
                                <input type="checkbox" class="filled-in" name="inappropriate" id="inappropriate">
                                <label for="inappropriate">Contenu inapproprié</label>
                            </p>
                        <div class="modal-footer transparent comment">
                            <button type="submit" class="modal-action btn blue-grey dark-2 waves-effect">
                                Envoyer
                            </button>
                            <button id="cmtAdd-<?= $a->id ?>" type="reset" class="btn btn-small transparent waves-effect modal-action modal-close">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php include(APP."/Views/includes/menu-aside.php"); ?>
</section>
