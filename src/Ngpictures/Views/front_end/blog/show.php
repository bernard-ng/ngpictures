<section class="section container row">
    <div class="col l8 m12 s12">
        <img src="<?= $article->thumbUrl ?>" alt="" class="responsive-img materialboxed">
        <h1 class="ui header"><?= $article->title ?></h1>
        <?= $article->content; ?>
    </div>
    <div class="section col l4 m12 s12 ">
        <div class="ui divided list animated slideInRight">
            <ul class="collection grey dark-4 shadow-1">
                <li class="collection-item">
                    ISO  <span class="right">
                        <?php if(is_array($article->exifData->ISOSpeedRatings)): ?>
                            <?= $article->exifData->ISOSpeedRatings[0] ?? 'Indéfini' ?>
                        <?php else: ?>
                            <?= $article->exifData->ISOSpeedRatings ?? 'Indéfini' ?>
                        <?php endif; ?>
                    </span>
                </li>
                <li class="collection-item">
                    Flash  <span class="right">
                        <?php if(is_array($article->exifData->Flash)): ?>
                            <?= $article->exifData->Flash[0] ?? 'Indéfini' ?>
                        <?php else: ?>
                            <?= $article->exifData->Flash ?? 'Indéfini' ?>
                        <?php endif; ?>
                    </span>
                </li>
                <li class="collection-item">
                    Camera  <span class="right"><?= $article->exifData->Model ?? 'Indéfini' ?></span>
                </li>
                <li class="collection-item">
                    Dimension
                    <span class="right"><?= $article->exifData->COMPUTED->Height ?? '' ?> x
                    <?= $article->exifData->COMPUTED->Width ?? '' ?> pixels</span>
                </li>
                <li class="collection-item">
                    Distance Focale  <span class="right"><?= $article->exifData->FocalLength ?? 'Indéfini' ?></span>
                </li>
                <li class="collection-item">
                    Temps d'exposition  <span class="right"><?= $article->exifData->ExposureTime ?? 'Indéfini' ?></span>
                </li>
                <li class="collection-item">
                    Unité de Résolution <span class="right"><?= $article->exifData->ResolutionUnit ?? 'Indéfini' ?></span>
                </li>
            </ul>
            <a href="<?= $article->downloadUrl ?>" class="btn btn-flat">Télécharger</a>
        </div>
    </div>
</section>
<section class="jumbotron dark">
    <?php include(APP . "/Views/includes/comments.php"); ?>
</section>
<section class="section row">
    <div class="container">
        <div class="ui items col l12 m12 s12 animated slideInLeft">
            <div class="item">
                <div class="image"><img src="<?= CDN . "/imgs/team/balloy.jpg" ?>"></div>
                <div class="content">
                    <span class="header">Naomi Balloy</span>
                    <div class="meta">Directrice de publication</div>
                    <div class="description">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Delectus maxime porro voluptas beatae repudiandae
                        consectetur at ipsa. Aliquam, consectetur a itaque possimus,
                        ab, ex quae quia vitae sint voluptas vel!
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
