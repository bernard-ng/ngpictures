<div class="slider fullscreen">
    <ul class="slides">
        <?php if (isset($photos) && !empty($photos)) : ?>
            <?php foreach ($photos as $photo) : ?>
                <li id="<?= $photo->id; ?>">
                    <img src="<?= $photo->thumbUrl; ?>">
                    <?php if (!empty($photo->description)) : ?>
                        <div class="caption left-align">
                            <h2 class="ui header white-txt"><?= strtoupper($photo->name ?? $photo->title); ?></h2>
                            <p class=""><?= $photo->description ?></p>
                        </div>
                    <div class="bg"></div>
                    <?php endif; ?>
                </li>
                <?php $lastId = $photo->id; ?>
            <?php endforeach; ?>
            <div class="fixed-action-btn">
                <a href="/gallery/slider?last_id=<?= $lastId ?? null; ?>" class="btn-floating btn-large blue-grey dark-2 waves-effect shadow-4">
                    <i class="icon icon-fast-fw"></i>
                </a>
            </div>
        <?php else : ?>
            <li id="reset">
                <img src="/imgs/outils.jpeg">
                <div class="caption center-align">
                    <h3 class="ng-heading">DEEP SHOOTING</h3>
                    <h6 class="light grey-text text-lighten-3">Aucune photo disponible pour l'instant</h6>
                </div>
                <div class="bg"></div>
            </li>
            <div class="fixed-action-btn">
                <a href="/gallery/slider" class="btn-floating btn-large blue-grey dark-2 waves-effect shadow-4">
                    <i class="icon icon-retweet"></i>
                </a>
            </div>
        <?php endif; ?>
    </ul>
</div>
<div class="fixed-action-btn second">
    <a href="/gallery" class="btn-floating btn-large blue dark-2 waves-effect shadow-4">
        <i class="icon icon-th-large"></i>
    </a>
</div>
