<?php 
use Ng\Core\Generic\Session; 
use Ngpictures\Util\Page; 

$session = Session::getInstance();
?>
<!--=============== NAVBAR ===================-->
<header>
    <div class="navbar-fixed">
        <nav class="ng-menu-reset">
            <div class="nav-wrapper ng-menu shrink" id="menu">
                <div class="row container">
                    <a href="/home" class="brand-logo left ng-menu-title">
                        Ngpictures
                    </a>
                    <a href="#" data-activates="mobile-side-nav" class="button-collapse btn primary-c right">
                        <i class="social social-menu"></i>
                    </a>
                    <ul class="right hide-on-med-and-down links">
                        <span id="menu-item-active" data-isActive="<?= Page::getTitle() ?>"></span>

                        <?php if($session->read('auth') && $session->getValue('auth','rank') == "admin"): ?>
                            <li><a href="<?= ADMIN ?>" class="ng-menu-item"> Admin</a></li>
                        <?php endif; ?>

                        <li id="Accueil"><a href="/home" class="ng-menu-item">Accueil</a></li>
                        <li id="Blog"><a href="/blog" class="ng-menu-item"> Blog</a></li>
                        <li id="Actualités"><a href="/articles" class="ng-menu-item"> Actualités</a></li>
                        <li id="Gallerie"><a href="/gallery" class="ng-menu-item"> Gallerie</a></li>

                        <?php if($session->read('auth')): ?>
                            <li>
                                <a href="<?= $session->read('auth')->accountUrl; ?>">
                                    <img src="<?= $session->read('auth')->avatarUrl; ?>" class="ng-menu-avatar" width="50" height="50">
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(!$session->read('auth')): ?>
                            <li><a href="/sign" class="link-btn">Inscription</a></li>
                            <li><a href="/login" class="link-btn">Connexion</a></li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
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
</header>

