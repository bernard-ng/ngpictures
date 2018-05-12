<div class="gallery-container-details">
    <div class="col l6 m6 s12 gallery-details-img stagger3">
        <img src="<?= $photo->thumbUrl ?>" width="100%" alt="<?= $photo->name ?? $photo->title ?>" class="boxed">
    </div>
    <div class="col l6 m6 s12 gallery-details-text">
        <h2 class="ui header stagger1"><?= $photo->name ?? $photo->title ?></h2>
        <span class="gray-txt stagger2">
            <?= $photo->description ?>
        </span>
    </div>
</div>