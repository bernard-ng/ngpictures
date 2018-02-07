<?php
use Ng\Core\Managers\SessionManager;
use Ngpictures\Managers\PageManager;

$session = SessionManager::getInstance();
?>
<!--=============== NAVBAR ===================-->
<header>
    <div class="navbar-fixed z-depth-2">
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
                        <span id="menu-item-active" data-isActive="<?= PageManager::getActivePage() ?>"></span>

                        <?php if ($session->read('auth') && $session->getValue('auth', 'rank') == "admin") : ?>
                            <li><a href="<?= ADMIN ?>" class="ng-menu-item"> Admin</a></li>
                        <?php endif; ?>

                        <li id="Accueil"><a href="/home" class="ng-menu-item">Accueil</a></li>
                        <li id="Communauté"><a href="/community" class="ng-menu-item">Communauté</a></li>
                        <li id="Blog"><a href="/blog" class="ng-menu-item"> Blog</a></li>
                        <li id="Actualités"><a href="/articles" class="ng-menu-item"> Actualités</a></li>
                        <li id="Gallerie"><a href="/gallery" class="ng-menu-item"> Gallerie</a></li>

                        <?php if ($session->read('auth')) : ?>
                            <li>
                                <a href="<?= $session->read('auth')->accountUrl; ?>">
                                    <img src="<?= $session->read('auth')->avatarUrl; ?>" class="ng-menu-avatar" width="50" height="50">
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (!$session->read('auth')) : ?>
                            <li><a href="/sign" class="link-btn">Inscription</a></li>
                            <li><a href="/login" class="link-btn">Connexion</a></li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
