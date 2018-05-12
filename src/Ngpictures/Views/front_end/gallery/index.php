<section class="section row container">
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
</section>
<div class="fixed-action-btn second">
    <a href="/gallery/slider" class="btn-floating btn-large blue dark-2 waves-effect shadow-4">
        <i class="icon icon-resize-full"></i>
    </a>
</div>
</main>
<script type="text/javascript" src="/assets/js/lib/jquery.min.js" ></script>
<script type="text/javascript" src="/assets/js/app/materialize.js" ></script>
<script type="text/javascript" src="/assets/js/app/app.init.js" ></script>
<script src="/assets/js/app.ajax.js"></script>
<script src="/assets/app/app.js"></script>