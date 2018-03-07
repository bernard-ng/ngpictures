<!--=============== NAVBAR ===================-->
<header>
    <div class="navbar-fixed">
        <nav class="ng-menu-reset">
            <div class="nav-wrapper ng-menu shrink" id="menu">
                <div class="row container">
                    <a href="<?= ADMIN ?>" class="brand-logo ng-menu-title">
                       Administration
                    </a>
                    <a href="#" data-activates="mobile-side-nav" class="button-collapse btn primary-c">
                        <i class="social social-menu"></i>
                    </a>
                    <ul class="right hide-on-med-and-down links">
                        <span id="menu-item-active" data-isActive="<?= $pageManager::getActivePage() ?>"></span>
                        <li id="Accueil"><a href="/home" class="ng-menu-item"> Front-end</a></li>
                        <li id="Adm - pages"><a href="<?= ADMIN."/pages" ?>">Pages</a></li>
                        <li id="Adm - logs"><a href="<?= ADMIN."/logs" ?>" class="ng-menu-item"> <i class="icon icon-file"></i></a></li>
                        <li id="Adm - blog"><a href="<?= ADMIN."/blog" ?>" class="ng-menu-item"> <i class="icon icon-pencil"></i></a></li>
                        <li id="Adm - actualites"><a href="<?= ADMIN."/posts" ?>" class="ng-menu-item"> <i class="icon icon-edit"></i></a></li>
                        <li id="Adm - gallerie"><a href="<?= ADMIN."/gallery" ?>" class="ng-menu-item"> <i class="icon icon-picture"></i></a></li>
                        <li id="Adm - users"><a href="<?= ADMIN."/users" ?>" class="ng-menu-item"> <i class="icon icon-user"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
