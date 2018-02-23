<div class="row container ">
<nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li class="right"><a href="/account/my-pictures/<?= $securityToken ?>">Mes photos</a></li>
                <li><a href="/categories">Categories</a></li>
                <li><a href="/gallery/albums">albums</a></li>
            </ul>
        </div>
    </nav>
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <div class="col l9 m12 s12">
        <div class="card col s12">
             <section id="gallery" style="margin: 0 auto;">
                <?php foreach ($photos as $photo) :  ?>
                    <a class="photo" href="<?= $photo->thumbUrl ?>" alt="<?= $photo->name ?>">
                        <span class="photo-title"><?= $photo->name ?></span>
                        <span class="photo-bg"></span>
                        <img src="<?= $photo->thumbUrl ?>" width="60" class="galery-item materialbox"/>
                    </a>
                <?php endforeach;?>
            </section>
        </div>
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
