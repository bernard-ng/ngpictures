<div class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <?php foreach ($likers as $liker) : ?>
        <div class="col l3 m6 s12">
            <div class="card verse-panel">
                <div class="card-content ng-contain">
                    <img src="<?= $liker->avatarUrl ?>" width="100%" height="auto" alt="Photo de Profile">
                    <span class="card-title"><?= $liker->name ?></span>
                    <p><?= $liker->bio ?></p>
                    <a href="<?= $liker->followingUrl ?>"><span class="btn"><i class="icon icon-plus"></i></span></a>

                </div>
                <div class="card-action">
                    <a href="<?= $liker->accountUrl ?>">Voir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
