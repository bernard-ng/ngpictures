<div class="container row">
    <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<?= $activeUser->friendsUrl; ?>">Mes abonnés</a></li>
                <li class="right"><a href="/community/designers">Les Designers</a></li>
                <li class="right"><a href="/community/photographers">Les Photographes</a></li>
            </ul>
        </div>
    </nav>
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    
    <?php foreach ($users as $user) : ?>
        <div class="col l3 m6 s12">
            <div class="card verse-panel">
                <img src="<?= $user->avatarUrl ?>" width="100%" height="auto" alt="">
                <div class="card-content ng-contain">
                    <span class="card-title"><?= $user->name ?>  <span class="badge new right"><?= $user->id ?></span></span>
                    <p>
                        <?= $user->bio ?>
                    </p>
                    <a href="<?= $user->followingUrl ?>" class="ng-btn mt-20">Follow</i></span></a>
                </div>
                <div class="card-action">
                    <a href="<?= $user->url ?>">Voir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
