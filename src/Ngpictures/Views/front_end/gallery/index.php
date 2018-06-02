<section class="section jumbotron dark hide-on-med-and-up">
    <div class="container animated slideInRight">
        <div class="carousel small">
            <?php foreach($photos as $photo): ?>
                <a href="<?= $photo->url ?>" class="carousel-item">
                    <img src="<?= $photo->smallThumbUrl ?>" alt="<?= $photo->name ?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section container row">
    <?php if (isset($photos) && !empty($photos)) : ?>
        <section id="gallery" class="gallery-container animated fast slideInLeft">
            <?php foreach ($photos as $key => $photo) :  ?>
                <article class="col l3 s3 m3" data-url="<?= $photo->url; ?>" id="<?= $photo->id ?>">
                    <img src="<?= $photo->smallthumbUrl ?>" class="gallery-item"/>
                </article>
                <?php if ($key % 4 === 0) : ?>
                    <div class="col l12 gallery-details"></div>
                <?php endif; ?>
            <?php endforeach;?>
            <div class="col l12 gallery-details"></div>
        </section>
        <div class="fixed-action-btn second">
            <a href="/gallery/slider" class="btn-floating btn-large blue dark-2 waves-effect shadow-4">
                <i class="icon icon-resize-full"></i>
            </a>
        </div>
    <?php else : ?>
        <div class="col offset-l3 l6 m12 s12 animated slideInRight">
            <div class="section center-align">
                <h2 class="icon icon-inbox red-txt center-align"></h2>
                <h2 class="ui header divided center"> Aucune publication pour l'instant</h2>
                <p>
                    le site ne présente actuellement aucune publication disponible, les publications sont peut être en évaluation,
                    ceci pourrait prendre du temps, veuillez revenir plus tard
                </p>
            </div>
        </div>
    <?php endif; ?>
</section>
