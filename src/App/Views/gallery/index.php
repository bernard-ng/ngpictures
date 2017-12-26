<div class="row container ">
<?php include(APP."/Views/includes/left-aside.php"); ?>
    <div class="col l9 m9 s12">
        <div class="card-panel col s12">
            <section class="ng-news-card-content">
                <section class="ng-news-card-title">
                    <i class="icon icon-picture"></i>
                    <h2>Photos Récentes</h2>
                </section>
                <?php foreach ($photo as $photo): ?>
                    <article class="card col l3 s12 m3" id="<?= $photo->id ?>">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img src="/uploads/ngpictures/thumbs/med/<?= $photo->thumb ?>" class="activator" alt="<?= $photo->name ?>" title="<?= $photo->name ?>">
                        </div>
                        <div class="card-reveal">
                            <span class="card-title"><i class="icon icon-chevron-down right"></i></span>
                            <?= $photo->name ?? "ngpictures-$photo->id" ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

            </section>
        </div>
    </div>
    <div class="col l9 m12 s12">
        <div class="card col s12">
             <section id="gallery" style="margin: 0 auto;">
                <?php foreach($photos as $p):  ?>
                    <a class="photo" href="<?= $p->thumbUrl ?>" alt="<?= $p->name ?>">
                        <span class="photo-title"><?= $p->name ?></span>
                        <span class="photo-bg"></span>
                        <img src="<?= $p->thumbUrl ?>" width="60" class="galery-item materialbox"/>
                    </a>
                <?php endforeach;?>
            </section>
        </div>
    <div id="feedMore" class="feed-btn waves-effect waves-teal waves-ripple"> <i class="icon icon-refresh rotate"></i> chargement</div>
    </div>
</div>

<script src="/assets/js/lib/jquery.min.js"></script>
<script src="/assets/js/lib/masonry.js"></script>
<script type="text/javascript">
$("#gallery").masonry({
	itemSelector: ".photo",
	isAnimated: true,
	isFitWidth: true
});
</script>