<header>
    <div class="navbar-fixed">
        <nav class="shadow-3">
            <div class="nav-wrapper container " id="menu">
                <a href="/" class="brand-logo">
                    <img src="/imgs/logo-white.png" class="logo" alt="logo">
                </a>
                <a href="#" data-activates="mobile-menu" class="btn blue-grey dark-3 button-collapse">
                    <i class="icon icon icon-th"></i>
                </a>
                <ul class="right hide-on-med-and-down">
                    <span id="menu-item-active" data-isActive="<?= $pageManager::getActivePage() ?>"></span>

                    <li class="search">
                        <div class="search">
                            <form action="/search" method="get" class="ui icon input">
                                <input name="q" type="text" placeholder="Recherches...">
                                <i class="icon icon-search"></i>
                                <input type="submit" value="send">
                            </form>
                        </div>
                    </li>

                    <?php if ($activeUser && $activeUser->rank == "admin") : ?>
                        <li><a href="<?= ADMIN ?>"> <i class="icon icon-code"></i></a></li>
                    <?php endif; ?>

                    <?php if ($activeUser) : ?>
                        <li id="La Communauté"><a href="/community">Communauté</a></li>
                    <?php endif; ?>

                    <li id="blog"><a href="/blog"> Blog</a></li>
                    <li id="posts"><a href="/posts"> Actualités</a></li>
                    <li id="Gallerie"><a href="/gallery"> Gallerie</a></li>

                    <?php if ($activeUser) : ?>
                        <li class="user-actions">
                            <a href="#" class="dropdown-button" data-activates="user-dropdown">
                                <img src="<?= $activeUser->avatarUrl; ?>" class="user" width="50" height="50">
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="action"><a href="/sign" class="btn blue-grey waves-effect dark-3">Inscription</a></li>
                        <li class="action"><a href="/login" class="btn blue-grey waves-effect dark-3">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
    <ul id="user-dropdown" class="dropdown-content">
        <li><a href="<?= $activeUser->accountUrl; ?>">Profile</a></li>
        <li><a href="<?= $activeUser->editUrl; ?>">Editer le Profile</a></li>
        <li><a href="<?= $activeUser->postUrl; ?>">Poster Une photo</a></li>
        <li><a href="<?= $activeUser->postUrl; ?>">Mes Publications</a></li>
        <li><a href="<?= $activeUser->followingUrl; ?>">Mes abonnements</a></li>
        <li><a href="/logout">Déconnexion</a></li>
    </ul>
</header>
