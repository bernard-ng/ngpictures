<div class="container row">
    <?php foreach ($albums as $album) : ?>
        <div class="col l3 m6 s12">
            <div class="card verse-panel ark-4">
                <div class="card-content ng-contain">
                    <span class="card-title"><?= $album->title ?>  <span class="badge new right">123</span></span>
                    <p>
                        <?= $album->description ?>
                    </p>
                </div>
                <div class="card-action">
                    <a href="<?= $album->url ?>">Voir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
