<div class="row container ">
    <div class="card">
         <section id="galery">
            <?php for($i = 1;$i < 120;$i++):  ?>
                <a class="photo zoombox" href="i/i (<?= $i ?>).jpg" title="Ng_sections">
                    <span class="photo-title">Ngsections</span>
                    <span class="photo-desc">manifestation du 30 juin 2018 a lubumashi</span>
                    <span class="photo-bg"></span>
                    <img src="i/i (<?= $i ?>).jpg" width="60" class="galery-item zoombox"/>
                </a>
            <?php endfor;?>
        </section>
    </div>
    <span class="col l6 m8 s8 offset-l3 offset-s2 offset-m2">
        <div id="feedMore" class="feed-btn waves-effect waves-teal waves-ripple"> charger la suite</div>
    </span>
</div>

<script src="/assets/js/lib/jquery.min.js"></script>
<script src="/assets/js/lib/masonry.js"></script>
<script src="/assets/js/zoombox/zoombox.js"></script>
<script type="text/javascript">
$("a.zoombox").zoombox();

$("#galery").masonry({
	itemSelector: ".photo",
	isAnimated: true,
	isFitWidth: true
});
</script>