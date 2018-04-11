<!-- =================  FOOTER   ====================== -->
<?php if ($activeUser) :?>
    <div class="fixed-action-btn toolbar">
        <a class="btn-floating btn-large blue-grey dark-4 shadow-4">
            <i class="icon icon-menu"></i>
        </a>
        <ul>
            <li class="waves-effect waves-light"><a href="/submit-photo"><i class="icon icon-upload"></i></a></li>
            <li class="waves-effect waves-light"><a href="<?= $activeUser->editUrl; ?>"><i class="icon icon-cog-alt"></i></a></li>
            <li class="waves-effect waves-light"><a href="<?= $activeUser->followersUrl; ?>"><i class="icon icon-users"></i></a></li>
        </ul>
    </div>
<?php endif; ?>

<footer class="page-footer jumbotron dark shadow-2">
    <div class="row container">
        <section class="col l12 m12 s12">
        <h2 class="ui header">
            A propos
        </h2>
        <p class="grey-txt">
       Ngpictures est une galerie d'art photographique et un mini résaux social où vous pouvez voir et partager vos propres photos,
       lire et écrire vos posts sur les sujets qui vous intéresses,
       étant chrétiens l'application vous propose une fonctionnalité incroyable,
       <a href="/godfirst">godfirst</a> : partagez et lisez la parole de Dieu avec plus de 500 versets choisis pour vous à l'avance.
        </p>
        <div class="ui horizontal bulleted list">
            <a class="item" href="/bugs">Signaler un Bug</a>
            <a class="item" href="/ideas">Votre avis</a>
            <a class="item" href="/contact">Contact</a>
        </div>
        </section>
    </div>
    <div class="footer-copyright black">
        <div class="container">
            <span class="right">Developped by <a href="http://ngpictures.pe.hu" class="grey-txt" target="_blank">Bernard ng</a>&nbsp;</span>
        </div>
    </div>
</footer>
