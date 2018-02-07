<div class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <?php foreach ($followers as $follower) : ?>
        <div class="col l3 m6 s12">
            <div class="card verse-panel">
                <div class="card-content ng-contain">
                    <img src="<?= $follower->avatarUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                    <span class="card-title"><?= $follower->name ?></span>
                    <p><?= $follower->bio ?></p>
                    <a href="<?= $follower->followingUrl ?>"><span class="btn"><i class="icon icon-plus"></i></span></a>
                    
                </div>
                <div class="card-action">
                    <a href="<?= $follower->accountUrl ?>">Voir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
