<section class="section col l6 m12 s12 animated slideInLeft">
    <div class="container row">
        <?php if (isset($users) && !empty($users)) : ?>
            <?php foreach ($users as $user) : ?>
                <div class="row nexted col l3 m6 s12">
                    <div class="card-user card transparent hovercard hoverable">
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
                            <div class="desc truncate"><?= $user->bio ?></div>
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
        <?php else: ?>
            <div class="col offset-l3 l6 m12 s12">
                <div class="section center-align">
                    <h2 class="icon icon-user-times red-txt center-align"></h2>
                    <h2 class="ui header divided center"> Aucun Membres pour l'instant</h2>
                    <p>
                        le site ne présente actuellement aucun membre disponible, ces derniers n'ont peut être pas encore
                        confirmer leur comptes, veuillez revenir plus tard.
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>