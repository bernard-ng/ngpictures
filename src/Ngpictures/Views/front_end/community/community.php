 <section class="section row col l12 m12 s12 animated fastg slideInRight">
    <div class="container row">
        <?php if (isset($users) && !empty($users)) : ?>
            <?php foreach ($users as $user) : ?>
                <div class="row nexted col l3 m6 s12">
                    <div class="card-user card hovercard hoverable">
                        <div class="cardheader" style="background: url('<?= $user->avatarUrl ?>')"></div>
                        <div class="avatar">
                            <a href="<?= $user->accountUrl ?>">
                                <img alt="" src="<?= $user->avatarUrl ?>">
                            </a>
                        </div>
                        <div class="info">
                            <div class="title">
                                <a href="<?= $user->accountUrl ?>"><?= $user->name ?></a>
                            </div>
                            <div class="desc"><?= $user->bio ?></div>
                            <div class="ui tiny horizontal divided list">
                                <div class="item">
                                    <div class="content">
                                    <div class="header">1,35k&nbsp;Posts</div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content">
                                    <div class="header">4,9k&nbsp;Abonnés</div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content">
                                    <div class="header">12&nbsp;Abonnement</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($user->id != $activeUser->id) : ?>
                            <a href="<?= $user->followingUrl ?>" class="btn btn-flat action blue-grey dark-1">
                                <?= $user->isFollowed ? "Se désabonner" : "S'abonner" ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

   <!--  <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<? // $activeUser->followersUrl; ?>">Mes abonnés</a></li>
                <li><a href="<? // $activeUser->followingsUrl; ?>">Mes abonnements</a></li>
            </ul>
        </div>
    </nav> -->
