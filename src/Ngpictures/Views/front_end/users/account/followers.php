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
    <?php if (isset($followers) && !empty($followers)) : ?>
        <?php foreach ($followers as $follower) : ?>
            <div class="col l3 m6 s12">
                <div class="card verse-panel">
                    <div class="card-content ng-contain">
                        <img src="<?= $follower->avatarUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                        <span class="card-title"><?= $follower->name ?></span>
                        <p><?= $follower->bio ?></p>

                        <?php if ($follower->id != $activeUser->id) : ?>
                            <a href="<?= $follower->followingUrl ?>" class="ng-btn mt-20">
                                <?= $follower->isFollowed ? "Unfollow" : "Follow" ?>
                            </a>
                        <?php endif; ?>

                    </div>
                    <div class="card-action">
                        <a href="<?= $follower->accountUrl ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
