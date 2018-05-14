<nav class="nav col l12 z-depth-2 mb-20">
    <div class="container">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= ADMIN."/file-browser/posts/"  ?>">Photos membres</a></li>
                <li><a href="<?= ADMIN."/file-browser/avatars/" ?>">Avatars membres</a></li>
                <li class="right"><a href="<?= ADMIN."/users/bugs" ?>"> Bugs </a></li>
                <li class="right"><a href="<?= ADMIN."/users/ideas" ?>"> Ideas </a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="row container">
    <section class="section col s12 m12 l12">
        <div class="col l12">
            <?php if (!empty($user)) : ?>
                <article class="card-panel grey dark-3 ">
                    <section class="news-card-content">
                        <section class=news-card-title">
                            <h2 class="ui header"><?= $user->name ?> <small><?= $user->rank ?></small></h2>
                        </section>
                        <div>
                            <div class="row">
                                <div class="col l3 m6 s6">
                                    <img src="<?= $user->avatarUrl ?>" class="responsive-img materialboxed">
                                </div>
                                <div class="col l9">
                                    <?= $user->bio ?>
                                    <div class="btn ng-progress-indeterminate">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="responsive-table">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>email</th>
                                <th>date</th>
                                <th>pass</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= $user->id ?></td>
                                <td><?= $user->email; ?></td>
                                <td><?= date("d M Y", strtotime($user->confirmed_at)) ?></td>
                                <td><?= $user->password ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                </article>
            <?php else : ?>
                <div class="card col l12">
                    <div class="no-publication">
                        <div class="ng-cover"></div>
                        <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="col l12 m12 s12">
        <div class="card-panel grey dark-3 col l12" id="users">
            <div class="section">
                <span class="btn">Pages : 1/1</span>
                <span class="btn">Total :<?= count($users); ?></span>
                <a href="<?= ADMIN."/users?page=4"?>" class="btn"><i class="icon icon-left-open"></i></a>
                <a href="<?= ADMIN."/users?page=4"?>" class="btn"><i class="icon icon-right-open"></i></a>
            </div>
            <table class="card bordered grey dark-4">
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
                <?php if (!empty($users)) : ?>
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
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" id="delete">
                                        <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <?php if ($u->confirmed_at === null) : ?>
                                    <a href="<?= ADMIN."/confirm/5/{$u->id}" ?>" title="confirmer" id="confirm">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-upload" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php endif; ?>
                                <?php if ($u->rank === "admin") : ?>
                                    <a href="<?= ADMIN."/users/permissions/{$u->id}" ?>" title="make simple user">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-circle" style="font-size: smaller !important;"></i>
                                        </button>
                                    </a>
                                <?php else : ?>
                                    <a href="<?= ADMIN."/users/permissions/{$u->id}" ?>" title="make admin">
                                        <button class="btn btn-small blue-2 waves-effect waves-light">
                                            <i class="icon icon-circle-empty" style="font-size: smaller !important;"></i>
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
    </section>
</section>
