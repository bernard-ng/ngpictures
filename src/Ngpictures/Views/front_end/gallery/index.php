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
<section class="section container">
    <div style="margin-bottom: 10px;" class="show-on-medium-and-down">
        <button class="btn"><i class="icon icon-th-large"></i></button>
        <button class="btn"><i class="icon icon-th-list"></i></button>
        <br>
    </div>
    <div class="gallery gallery-container" data-action="gallery">
        <?php foreach ($photos as $photo): ?>
            <article class="gallery-item" data-action="gallery-item" id="<?= $photo->id; ?>" data-url="<?= $photo->url ?>">
                <img src="<?= $photo->smallThumbUrl ?>" class="responsive-img" alt="" data-action="gallery-item-img">
                <div class="gallery-item-body section jumbotron dark" data-action="gallery-item-body">
                    <div class="row col l12 m12 s12">
                        <div class="col l6 m6 s12 pb10">
                            <img src="<?= $photo->thumbUrl ?>" class="responsive-img" alt="">
                        </div>
                        <div class="col l6 m6 s12">
                            <h2 class="ui header"><?= $photo->name ?></h2>
                             <p>
                                 <?= $photo->description ?>
                             </p>
                            <p>
                                <a href="<?= $photo->url ?>" class="btn btn-flat">Voir Plus</a>
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
