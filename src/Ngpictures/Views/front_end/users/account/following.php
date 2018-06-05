<div class="container row">
    <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= $activeUser->followersUrl; ?>">Mes abonnés</a></li>
                <li><a href="<?= $activeUser->followingsUrl; ?>">Mes abonnements</a></li>
            </ul>
        </div>
    </nav>
    <?php include(APP . "/Views/includes/left-aside.twig"); ?>
    <?php if (isset($followings) && !empty($followings)) : ?>
        <?php foreach ($followings as $following) : ?>
            <div class="col l3 m6 s12">
                <div class="card verse-panel">
                    <div class="card-content ng-contain">
                        <img src="<?= $following->avatarUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                        <span class="card-title"><?= $following->name ?></span>
                        <p><?= $following->bio ?></p>

                        <a href="<?= $following->followingUrl ?>" class="ng-btn mt-20">
                        <?= ($following->isFollowed) ? "UnFollow" : "Follow"; ?>
                        </a>

                    </div>
                    <div class="card-action">
                        <a href="<?= $following->accountUrl ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
