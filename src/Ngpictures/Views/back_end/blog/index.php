<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card-panel no-padding">
            <nav class="nav z-depth-2 mb-20">
                <div class="nav-wrapper">
                <ul>
                    <li><a href="<?= ADMIN."/file-browser/blog" ?>">Photo blog</a></li>
                    <li class="right"><a href="<?= ADMIN."/blog/categories/"  ?>">Catégories</a></li>
                    <li class="right"><a href="<?= ADMIN."/blog/categories/add" ?>">Ajouter une Catégorie</a></li>
                </ul>
                </div>
            </nav>
            <div id="postsContainer">
                <?php if (!empty($article)) : ?>
                    <article class="ng-article" id="<?= $article->id ?>">
                        <section class="ng-news-card-content">
                            <section class="ng-news-card-title">
                                <i id="category" class="icon icon-pencil"></i>
                                <h2><?= $article->title ?></h2>
                            </section>
                            <main>
                                <?= $article->snipet ?>
                                <br><a href="<?= $article->url ?>">Voir plus</a>
                            </main>
                            <footer id="articleInfo">
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-time"></i>&nbsp;
                                    <time id="date_created" data-time="<?= strtotime($article->date_created) ?>">
                                        <?= $article->time ?>
                                    </time>
                                </div>
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-thumbs-up"></i>&nbsp;
                                    <small><a id="showLikes" href="/likes"><?= $article->Likes ?></a></small>
                                    <a href="<?= $article->likeUrl ?>" id="showMentions"><i class="right icon icon-menu-down"></i></a>
                                </div>
                            </footer>
                        </section>
                    </article>
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
        <div class="card-panel">
            <div class="section-title mb-20 mt-20 ml-10">
                Les posts
                <span class="btn primary-b right"><?= count($posts) ?></span>
                <a href="<?= ADMIN."/blog/add" ?>" class="right">
                    <button class="btn">
                        <i class="icon icon-plus" style="font-size: smaller !important;"></i>
                    </button>
                </a>
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
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $a) : ?>
                        <tr>
                            <td><b><?= $a->id ?></b></td>
                            <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <input type="hidden" name="type" value="3" >
                                    <button type="submit" class="btn waves-effect waves-light red" id="delete">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>

                                <a href="<?= ADMIN."/blog/edit/{$a->id}" ?>">
                                     <button class="btn waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                                <a href="<?= ADMIN."/confirm/3/{$a->id}" ?>" id="confirm">
                                    <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <?php if ($a->online) : ?>
                                            <i class="icon icon-cloud-download" style="font-size: smaller !important;"></i>
                                            <?php else : ?>
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                            <?php endif; ?>
                                    </button>
                                </a>
                                <a href="<?= ADMIN."{$a->watermarkUrl}" ?>">
                                     <button class="btn blue waves-effect waves-light">
                                        <i class="icon icon-copy" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                            </td>
                            <td><time><?= $a->time ?></time></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td><b>0</b></td>
                        <td>Aucun article pour l'instant</td>
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

    </section>
</main>
