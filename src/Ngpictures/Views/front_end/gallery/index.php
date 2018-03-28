<div class="row container">
    <hearder class="col l12 m12 s12">
        <div class="ui pointing secondary menu">
            <a class="item" href="/account/my-pictures/<?= $securityToken ?>">Mes Photos</a>
            <a class="item" href="/gallery/albums">Albums</a>
        </div>
    </hearder>
    <div class="row col l12 m12 s12">
        <section id="gallery">
            <?php foreach ($photos as $photo) :  ?>
                <div class="row col l3 s6 m4">
                    <img src="<?= $photo->thumbUrl ?>" width="100%" class="materialbox"/>
                </div>
            <?php endforeach;?>
        </section>
    </div>
</div>
