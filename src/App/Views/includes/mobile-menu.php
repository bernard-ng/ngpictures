<?php 
use Ng\Core\Generic\Session; 
use Ngpictures\Util\Page; 
$session = Session::getInstance();
?>
<ul id="mobile-side-nav" class="side-nav links">
    <li>
        <?php if($session->read('auth')): ?>
            <div class="user-view">
                <a href="<?= $session->read('auth')->accountUrl; ?>">
                    <img class="ng-menu-avatar circle" src="<?= $session->read('auth')->avatarUrl ?>">
                </a>
                <a href="<?= $session->read('auth')->accountUrl; ?>" class="user-view-name">
                    <?= $session->read('auth')->name; ?>
                </a>
                <span class="user-view-name fullname">
                    <?= $session->read('auth')->email; ?>
                </span>
            </div>
        <?php endif; ?>

        <ul>
            
            <?php if(!$session->read('auth')): ?>
                <div class="user-view">
                    <li><a class="link-btn primary-c" href="/login">Connexion<i class="icon icon-lock"></i></a></li>
                    <br>
                    <li><a class="link-btn primary-c" href="/sign">Inscription<i class="icon icon-lock"></i></a></li>
                </div>
            <?php endif; ?>
            
            <?php if($session->read('auth')): ?>
                <li>
                    <a href="#" class="dropdown-button ng-menu-more" data-activites="mobile-dropdown">
                        Mon Compte <i class="icon icon-user right"></i>
                    </a>
                </li>
            <?php endif;?>

            <?php if($session->read('auth') && $session->getValue('auth','rank') == "admin"): ?>
                <li><a href="<?= ADMIN ?>"> Admin&nbsp;<i class="icon icon-lock"></i></a></li>
            <?php endif; ?>
            
            <li id="Accueil"><a href="/home">Accueil&nbsp;<i class="icon icon-home"></i></a></li>
            <li id="Blog"><a href="/blog">Blog&nbsp;<i class="icon icon-pencil"></i></a></li>
            <li id="Actualités"><a href="/articles">Actualités&nbsp;<i class="icon icon-globe"></i></a></li>
            <li id="Gallerie"><a href="/gallery">Gallerie&nbsp;<i class="icon icon-picture"></i></a></li>
            
        </ul>
    </li>
    <li>
        <?php if($session->read('auth')): ?>
            <li>
                <a href="/logout" class="ng-menu-logout">
                    Déconnexion <i class="icon icon-off right"></i>
                </a>
            </li>
        <?php endif; ?>
    </li>
</ul>
<ul id="mobile-dropdown" class="dropdown-content">
    <li><a href="/help"></a></li>
    <li><a href="/ideas">Donner une idee</a></li>
    <li><a href="/bugs">Signaler un probleme</a></li>
    <li><a href="/contact">contact</a></li>
    <li class="divider"></li>
    <li><a href="/about">A propos de nous</a></li>
    <li><a href="/privacy">Condition générales</a></li>
</ul>