<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>

    <main class="col s12 m12 l9">
        <div id="articlesContainer">
            <?php if (!empty($article)): ?>
                <article class="card" id="<?= $article->id ?>">
                    <header class="ng-news-card-header">
                        <span class="ng-news-card-image-profil">
                            <img src="<?= $article->userAvatarUrl ?>" alt="Profile <?= $article->username ?>" title="<?= $article->username ?>">
                        </span>
                        <p class="ng-news-card-header-title">
                            <a href="<?= $article->userAccountUrl ?>" title="voir le profil"><?= $article->username ?></a>
                        </p>
                        <a id="picBtn" class="ng-news-card-header-icon" href="<?= $article->userGalleryUrl ?>" title="voir la gallery">
                            <i class="icon icon icon-picture"></i>
                        </a>
                        <a id="saveBtn" class="ng-news-card-header-icon" href="<?= $article->downloadUrl ?>" title="télécharger la photo">
                            <i class="icon icon icon-save"></i>
                        </a>
                    </header>

                    <Section class="ng-news-card-content">
                        <section class="ng-news-card-title">
                            <h2><?= $article->title ?></h2>
                        </section>
                        <main>
                            <p><?= $article->snipet ?></p>
                            <br>
                            <a href="<?= $article->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                        </main>
                        <section id="articleInfo">
                            <div class="ng-news-card-stat">
                                <i class="icon icon-time"></i>&nbsp;
                                <time id="date_created" data-time="<?= strtotime($article->date_created) ?>">
                                    <?= $article->date_created ?>
                                </time>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small>
                                    <a id="showLikes" href="<?= $article->showLikesUrl ?>"><?= $article->likes ?></a>
                                </small>
                            </div>
                        </section>
                    </Section>
                </article>

            <?php else: ?>
                <div class="card">
                    <div class="no-publication">
                        <div class="ng-cover"></div>
                        <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <div class="card-panel">
            <div class="section-title mb-20 mt-20 ml-10">
                <i class="icon icon-pencil"></i>&nbsp;Les Articles
                <span class="badge new"><?= count($articles); ?></span>
            </div>
            <table class="card responsive-table bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>action</th>
                        <th>date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $a) : ?>
                        <tr>
                            <td><b><?= $a->id ?></b></td>
                            <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <input type="hidden" name="type" value="1" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" >
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <?php if ($a->online): ?>
                                    <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="retirer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= ADMIN."/confirm/1/{$a->id}" ?>" title="confirmer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><time><?= $a->time ?></time></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td><b>0</b></td>
                        <td>Aucun article</td>
                        <td>
                            <button type="submit" class="btn btn-small waves-effect waves-light disabled">
                                <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>  
    </main>
</section>
