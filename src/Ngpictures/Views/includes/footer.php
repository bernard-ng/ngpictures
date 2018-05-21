<!-- =================  FOOTER   ====================== -->
<?php if ($activeUser) :?>
    <div class="fixed-action-btn toolbar">
        <a class="btn-floating btn-large blue-grey dark-4 shadow-4">
            <i class="icon icon-menu"></i>
        </a>
        <ul>
            <li class="waves-effect"><a href="/submit-photo"><i class="icon icon-plus"></i></a></li>
            <li class="waves-effect"><a href="<?= $activeUser->editUrl; ?>"><i class="icon icon-cog"></i></a></li>
            <li class="waves-effect"><a href="<?= $activeUser->followersUrl; ?>"><i class="icon icon-users"></i></a></li>
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
            <a class="item" href="/bugs">Un bug ?</a>
            <a class="item" href="/ideas">Votre avis</a>
            <a href="/privacy" class="item">Politiques d'utilisation</a>
            <a class="item" href="/contact">Contact</a>
        </div>
        </section>
    </div>
    <div class="footer-copyright black">
        <div class="container row">
            <span class="right">Copyrights &copy; <?= date('Y') ?></span>
            <span >
                With <i class="icon icon-heart red-txt"></i> by <a href="http://ngpictures.pe.hu" target="_blank">Bernard ng</a>
            </span>
        </div>
    </div>
</footer>
