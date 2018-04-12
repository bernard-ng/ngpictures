<main>
    <section class="row container">
        <hearder class="col l12 m12 s12">
            <div class="ui pointing secondary menu">
                <a class="item" href="/account/my-pictures/<?= $securityToken ?>">Mes Photos</a>
                <a class="item" href="/gallery/albums">Albums</a>
            </div>
        </hearder>
        <section id="gallery" class="gallery-container animated fast slideInLeft">
            <?php foreach ($photos as $key => $photo) :  ?>
                <article class="col l3 s3 m3" data-show="<?= $photo->url; ?>" id="pic-<?= $photo->id ?>">
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
<script type="text/javascript" src="/assets/js/app/activingScript.js" ></script>

<script>
    var $active = false
    $("#gallery .gallery-item").on("click", function(e){

        var $item = $(this)
        var $details = $item.parent().nextAll(".gallery-details:first")

        if ($item.hasClass("active")) {
            return true;
        }

        $(".gallery-item").removeClass("active")
        $(".gallery-details").removeClass('jumbotron jumbotron-img dark')
        $item.addClass("active")

        $.ajax(
            {url: $item.parent().attr('data-show')}
        ).then(
            function($detailsInfo) {

                $details.addClass('jumbotron jumbotron-img dark')
                $details.append($detailsInfo).slideDown()
                $work_details =  $details.find('.gallery-container-details')

                var $del = $active
                if ($active) {
                    $active.slideUp(300, function() {
                        $del.remove()
                    })
                }

                //animation
                for (var i = 1; i <= 3; i++)
                {
                    $(".stagger" + i, $work_details).css({
                        opacity:0, marginLeft:-30
                    }).delay(300 + 100 * i).animate({
                        opacity:1, marginLeft: 0
                    })
                }

                $active = $work_details;
                $active.find(".gallery-details-img").on("click", function() {
                    $(this).find('img').materialbox()
                })

                scrollTo($active);
            },
            function() {
                return Materialize.toast("Impossibe de charge l'Image", 5000, "danger")
            }
        )

        window.location.hash = $item.parent().attr('id')
    });

    if (window.location.hash) {
        var $target = $(window.location.hash + " img.gallery-item");
        if ($target.length > 0) {
            $target.trigger('click')
            scrollTo($target)
        }
    }

    var scrollTo = function(cible) {
        window.setTimeout(function(){
            $('html, boby').animate({scrollTop: cible.offset().top - 80 }, 750);
        }, 300)
    }

</script>
