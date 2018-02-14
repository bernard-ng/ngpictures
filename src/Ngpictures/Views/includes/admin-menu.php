<!--=============== NAVBAR ===================-->
<header>
    <div class="navbar-fixed">
        <nav class="ng-menu-reset">
            <div class="nav-wrapper ng-menu shrink" id="menu">
                <div class="row container">
                    <a href="<?= ADMIN ?>"" class="brand-logo ng-menu-title">
                       Administration
                    </a>
                    <a href="#" data-activates="mobile-side-nav" class="button-collapse btn primary-c">
                        <i class="social social-menu"></i>
                    </a>
                    <ul class="right hide-on-med-and-down links">
                        <span id="menu-item-active" data-isActive="<?= $pageManager::getActivePage() ?>"></span>
                        <li id="Accueil"><a href="/home" class="ng-menu-item"> front-end</a></li>
                        <li id="administration - blog"><a href="<?= ADMIN."/blog" ?>" class="ng-menu-item"> blog</a></li>
                        <li id="administration - actualités"><a href="<?= ADMIN."/posts" ?>" class="ng-menu-item"> posts</a></li>
                        <li id="administration - gallerie"><a href="<?= ADMIN."/gallery" ?>" class="ng-menu-item"> Gallerie</a></li>
                        <li id="administration - users"><a href="<?= ADMIN."/users" ?>" class="ng-menu-item"> membres</a></li>
                        <li><a href="#"> <icon class="icon icon-chevron-down"></icon></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

