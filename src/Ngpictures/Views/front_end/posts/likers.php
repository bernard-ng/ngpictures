<div class="container row">
    <?php include(APP . "/Views/includes/right-aside.twig"); ?>
    <?php foreach ($likers as $liker) : ?>
        <div class="row nexted col l3 m6 s12">
            <div class="card-user card transparent hovercard hoverable">
                <div class="cardheader" style="background: url('<?= $liker->avatarUrl ?>')"></div>
                <div class="avatar">
                    <a href="<?= $liker->accountUrl ?>">
                        <img alt="" src="<?= $liker->avatarUrl ?>">
                    </a>
                </div>
                <div class="info">
                    <div class="title">
                        <a href="<?= $liker->accountUrl ?>"><?= $liker->name ?></a>
                    </div>
                    <div class="desc truncate"><?= $liker->bio ?></div>
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
                <?php if ($liker->id != $activeUser->id) : ?>
                    <a href="<?= $liker->followingUrl ?>" class="btn btn-flat action blue-grey dark-1">
                        <?= $liker->isFollowed ? "Se désabonner" : "S'abonner" ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
