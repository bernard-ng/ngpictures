<div class="slider">
    <ul class="slides">
    <?php if (isset($photos) && !empty($photos)) : ?>
        <?php foreach ($photos as $photo) : ?>
            <li>
                <img src="<?= $photo->thumbUrl; ?>">
                <div class="caption center-align">
                    <h3 class="ng-heading">DEEP SHOOTING</h3>
                    <h6 class="light grey-text text-lighten-3">
                    Découvrez la version 2.0 de ngpictures et toutes les nouvelles fonctionnalités.</h6>
                </div>
                <div class="bg"></div>
            </li>
        <?php endforeach; ?>
    <?php else : ?>
            <li>
                <img src="/imgs/outils.jpeg">
                <div class="caption center-align">
                    <h3 class="ng-heading">DEEP SHOOTING</h3>
                    <h6 class="light grey-text text-lighten-3">
                    Découvrez la version 2.0 de ngpictures et toutes les nouvelles fonctionnalités.</h6>
                </div>
                <div class="bg"></div>
            </li>
    <?php endif; ?>
    </ul>
</div>
