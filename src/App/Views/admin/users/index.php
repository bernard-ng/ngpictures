<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col s12 m12 l9">
        <div class="col l12">
            <div class="card no-padding col l12">
                <nav class="nav col l12 z-depth-2 mb-20">
                    <div class="nav-wrapper">
                    <ul>
                        <li><a href="<?= ADMIN."/file-browser/pictures/"  ?>">Photos membres</a></li>
                        <li><a href="<?= ADMIN."/file-browser/avatars/" ?>">Avatars membres</a></li>
                        <li class="right"><a href="<?= ADMIN."/users/bugs" ?>"> Bugs </a></li>
                        <li class="right"><a href="<?= ADMIN."/users/ideas" ?>"> Ideas </a></li>
                    </div>
                </nav>
                <?php if (!empty($user)): ?>
                    <article class="ng-article" id="<?= $user->id ?>">
                        <section class="ng-news-card-content">
                            <section class="ng-news-card-title">
                                <?php
                                    if ($user->rank === 'admin') {echo '<i id="category" class="icon icon-lock"></i>';}
                                    else { echo ' <i id="category" class="icon icon-user"></i>'; }
                                ?>
                                <h2><?= $user->name ?> <small><?= $user->rank ?></small></h2>
                            </section>
                            <main>
                                <?= $user->bio ?>
                                <br><a href="<?= $user->accountUrl ?>">Voir le profil</a>
                                <aside class="aside-imgs">
                                <div class="previous-imgs row" id="previousImgs">
                                    <span class="col l3 m6 s6">
                                        <img src="<?= $user->avatarUrl ?>" alt="<?= $user->name ?>">
                                    </span>
                                </div>
                            </main>
                            <div id="articleInfo">
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-time"></i>&nbsp;
                                    <time id="date_created" data-time="<?= strtotime($user->confirmed_at) ?>">
                                        <?= $user->confirmed_at ?>
                                    </time>
                                </div>
                                <div class="ng-news-card-stat">
                                    <i class="icon icon-envelope"></i>&nbsp;
                                    <span><?= $user->email ?></span>
                                </div>
                            </div>
                        </section>
                        <footer class="ng-news-card-footer" id="articleOptions">
                            <a id="likeBtn" class="ng-news-card-footer-item " href="<?= $user->followUrl ?>">
                                <i class="social social-users"></i>&nbsp;Follow
                            </a>
                            <a id="commentBtn" class="ng-news-card-footer-item" href="<?= $user->galleryUrl ?>">
                                <i class="icon icon-picture" ></i>&nbsp;Gallerie
                            </a>
                            <a id="shareBtn" class="ng-news-card-footer-item" href="<?= $user->shareUrl ?>">
                                <i class="icon icon-share"></i>&nbsp;Partager
                            </a>
                        </footer>
                    </article>
                <?php else: ?>
                    <div class="card col l12">
                        <div class="no-publication">
                            <div class="ng-cover"></div>
                            <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <div class="card col l12" id="users">
            <div class="section-title mb-20 mt-20 ml-10">
                <i class="icon icon-user"></i>&nbsp;Les Membres
                <span class="btn primary-b right"><?= count($users); ?></span>
            </div>
            <table class="card responsive-table bordered striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>avatar</th>
                        <th>name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>confirmed_at</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u) : ?>
                        <tr>
                            <td><b><?= $u->id ?></b></td>
                            <td>
                                <img src="<?= $u->avatarUrl?>" width="60" height="60">
                            </td>
                            <td><a href="<?= $u->accountUrl ?>"><?= $u->name ?></a></td>
                            <td><?= $u->email ?></td>
                            <td><?= $u->phone ?></td>
                            <td><time data-time="<?= strtotime($u->confirmed_at) ?>"><?= $u->confrimed_at ?></time></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $u->id?>" >
                                    <input type="hidden" name="type" value="5" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <?php if ($u->confirmed_at === null ): ?>
                                    <a href="<?= ADMIN."/confirm/5/{$u->id}" ?>" title="confirmer">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-cloud-upload" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
                                <?php if ($u->rank === "admin"): ?>
                                    <a href="<?= ADMIN."/users/permissions/{$u->id}" ?>" title="make simple user">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-user" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php else : ?>
                                    <a href="<?= ADMIN."/users/permissions/{$u->id}" ?>" title="make admin">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-lock" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </td>
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
