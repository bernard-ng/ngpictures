<div class="container row">
    <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= $activeUser->followersUrl; ?>">Mes abonnés</a></li>
                <li><a href="<?= $activeUser->followingsUrl; ?>">Mes abonnements</a></li>
            </ul>
        </div>
    </nav>
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <?php if (isset($users) && !empty($users)) : ?>
        <?php foreach ($users as $user) : ?>
            <div class="col l3 m6 s12">
                <div class="card verse-panel">
                    <img src="<?= $user->avatarUrl ?>" width="100%" height="auto" alt="">
                    <div class="card-content ng-contain">
                        <span class="card-title"><?= $user->name ?>  <span class="badge new right"><?= $user->id ?></span></span>
                        <p>
                            <?= $user->bio ?>
                        </p>
                        <?php if ($user->id != $activeUser->id) : ?>
                            <a href="<?= $user->followingUrl ?>" class="ng-btn mt-20">
                                <?= $user->isFollowed ? "Unfollow" : "Follow" ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-action">
                        <a href="<?= $user->accountUrl ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
