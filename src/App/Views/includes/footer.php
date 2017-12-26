<!-- =================  FOOTER   ====================== -->
<?php

use Ng\Core\Generic\Session;

if (Session::getInstance()->read('auth')):
    $user = Session::getInstance()->read('auth');
    ?>
    <div class="fixed-action-btn toolbar">
        <a class="btn-floating btn-large primary-c">
            <i class="icon icon-th"></i>
        </a>
        <ul>
            <li class="waves-effect waves-light"><a href="<?= $user->postUrl; ?>"><i class="icon icon-pencil"></i></a></li>
            <li class="waves-effect waves-light"><a href="<?= $user->editUrl; ?>"><i class="icon icon-edit"></i></a></li>
            <li class="waves-effect waves-light"><a href="<?= $user->galleryUrl; ?>"><i class="icon icon-picture"></i></a></li>
        </ul>
    </div>
<?php endif; ?>

<footer class="page-footer primary-c">
    <div class="row container">
        <section class="col l6 m4 s12">
        <h5 class="white-text page-footer-title">A propos</h5>
        <p class="grey-text text-lighten-4 page-footer-text">
       Ngpictures est une galerie d'art photographique et un mini résaux social où vous pouvez voir et partager vos propres photos, lire et écrire vos articles sur les sujets qui vous intéresses, étant chrétiens le site vous propose une fonctionnalité incroyable, "godfirst" : partagez et lisez la parole de Dieu avec plus de 500 versets choisis pour vous à l'avance.
        </p>
        </section>
        <section class="col l3 m4 s6">
            <h5 class="white-tex page-footer-title">Plus</h5>
            <ul>
                <li><a class="white-text page-footer-text" href="/ideas">
                    <i class="icon icon-chevron-right"></i> Donner une idée</a>
                </li>
                <li><a class="white-text page-footer-text" href="/bugs">
                    <i class="icon icon-chevron-right"></i> Signaler un problème</a>
                </li>
                <li><a class="white-text page-footer-text" href="/terms">
                    <i class="icon icon-chevron-right"></i> Conditions générales</a>
                </li>
            </ul>
        </section>
        <section class="col l3 m4 s6">
            <h5 class="white-tex page-footer-title">Résaux sociaux</h5>
            <ul>
                <li><a class="white-text page-footer-text" href="https://www.Facebook.com/wonderfulDP" target="_blank">
                    <i class="social social-facebook-1"></i>&nbsp;Facebook</a>
                </li>
                <li><a class="white-text page-footer-text" href="https://www.instagram.com/ngpictures_23" target="_blank">
                    <i class="social social-instagram"></i>&nbsp;Instagram</a></li>
                <li><a class="white-text page-footer-text" href="https://www.pexels.com/ngpictures_23" target="_blank">
                    <i class="social social-instagram-2"></i>&nbsp;Pexels</a>
                </li>
            </ul>
        </section>
         
    </div>
    <div class="footer-copyright primary-d">
        <div class="container">
            <span class="right page-footer-text">Developped by Bernard ng&nbsp;</span>
        </div>
    </div>
</footer>

