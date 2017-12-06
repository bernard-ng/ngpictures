<main role="main" class="container row">
    <div class="section-title page-title">Admin - Blog</div>
    <?php include(APP."/Views/includes/right-aside.php"); ?>

    <section class="col s12 m8">
        <div class="card-panel no-padding">
            <div id="articlesContainer">
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
            </div>
        </div>

        <div class="card-panel">
            <div class="section-title mb-20 mt-20 ml-10">
                Les Articles
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
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($articles as $a) : ?>
                    <tr>
                        <td><b><?= $a->id ?></b></td>
                        <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                        <td>
                            <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                <input type="hidden" name="id" value="<?= $a->id?>" >
                                <input type="hidden" name="type" value="3" >
                                <button type="submit" class="btn waves-effect waves-light red">
                                    <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                </button>
                            </form>
                           
                            <a href="<?= ADMIN."/blog/edit/{$a->id}" ?>">
                                 <button class="btn waves-effect waves-light">
                                    <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
    <?php include(APP."/Views/includes/left-aside.php"); ?>
</main>