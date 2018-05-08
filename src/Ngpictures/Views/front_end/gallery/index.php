<section class="section row container">
    <section id="gallery" class="gallery-container animated fast slideInLeft">
        <?php foreach ($photos as $key => $photo) :  ?>
            <article class="col l3 s3 m3" data-show="<?= $photo->url; ?>" id="<?= $photo->id ?>">
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
let $active = false;
$("#gallery .gallery-item").on("click", function(){

    let $item = $(this)
    let $details = $item.parent().nextAll(".gallery-details:first")

    if ($item.hasClass("active")) {
        return true;
    }

    $(".gallery-item").removeClass("active");
    $(".gallery-details").removeClass('jumbotron jumbotron-img dark');
    $item.addClass("active");


    $details.addClass('jumbotron jumbotron-img dark').html("<span class='center-align'>Chargement...</span>");
    $.ajax(
        {url: $item.parent().attr('data-show')}
    ).then(
        function($detailsInfo) {
            $details.addClass('jumbotron jumbotron-img dark').html('');
            $details.append($detailsInfo).slideDown();
            $work_details =  $details.find('.gallery-container-details');

            let $del = $active;
            if ($active) {
                $active.slideUp(300, function() {
                    $del.remove()
                })
            }

            //animation
            for (let i = 1; i <= 3; i++)
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
            });

            scrollTo($active);
        },
        function() {
            return Materialize.toast("Impossibe de charge l'Image", 5000, "danger")
        }
    );

    window.location.hash = $item.parent().attr('id')
});

let scrollTo = function(cible) {
    window.setTimeout(function(){
        $('html, boby').animate({scrollTop: $(cible).offset().top - 80 }, 750);
    }, 300)
}

if (window.location.hash) {
    let $target = $(window.location.hash + " img.gallery-item");
    if ($target.length > 0) {
        $target.trigger('click')
        scrollTo($target)
    }
}



</script>
