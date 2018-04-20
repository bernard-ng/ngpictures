<header>
    <div class="navbar-fixed">
        <nav class="shadow-3">
            <div class="nav-wrapper container " id="menu">
                <a href="/" class="brand-logo">
                    <img src="/imgs/logo-white.png" class="logo" alt="logo">
                </a>
                <a href="#" data-activates="mobile-menu" class="btn blue-grey dark-3 button-collapse">
                    <i class="icon icon icon-menu"></i>
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

                    <li id="acceuil"><a href="/">Acceuil</a></li>
                    <li id="blog"><a href="/blog"> Blog</a></li>
                    <li id="Gallerie"><a href="/gallery"> Gallerie</a></li>

                    <?php if ($activeUser) : ?>
                        <li id="posts"><a href="/posts"> Actualités</a></li>
                        <li id="La Communauté"><a href="/community">Communauté</a></li>
                        <li class="user-actions">
                            <a href="#" class="user-actions-sideNav show-on-large" data-activates="user-actions">
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
    <ul class="side-nav" id="user-actions">
        <?php if ($activeUser) : ?>
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="/imgs/bgjumbo.jpeg" alt="bg">
                    </div>
                    <a href="<?= $activeUser->accountUrl; ?>"><img src="<?= $activeUser->avatarUrl; ?>" alt="bg2" class="circle"></a>
                    <span class="white-txt name"><?= $activeUser->name; ?></span>
                    <span class="email"><?= $activeUser->email; ?></span>
                </div>
            </li>
        <?php else : ?>
            <li class="logo" style="margin: 20px 20px 30px 20px;">
                <a href="/" class="brand-logo" id="logo-container">
                    <img src="/imgs/logo-white.png" alt="" width="100%" height="auto">
                </a>
            </li>
        <?php endif; ?>

        <div class="user-action">
            <?php if (!$activeUser) : ?>
                <li>
                    <a href="/sign" class="btn action blue-grey dark-3 waves-effect">Inscription</a>
                    <a href="/login" class="btn action blue-grey dark-3 waves-effect">Connexion</a>
                </li>
            <?php else : ?>
                <li>
                    <a href="<?= $activeUser->postUrl; ?>" class="btn action blue-grey dark-3 waves-effect">Poster</a>
                    <a href="<?= $activeUser->postsUrl; ?>" class="btn action blue-grey dark-3 waves-effect">Mes Publications</a>
                </li>
            <?php endif; ?>
        </div>
        <?php if ($activeUser) : ?>
            <li><a href="<?= $activeUser->accountUrl; ?>">Profile <i class="icon icon-user"></i></a></li>
            <li><a href="<?= $activeUser->editUrl; ?>">Editer le Profile <i class="icon icon-cog-alt"></i></a></li>
            <li><a href="<?= $activeUser->followingUrl; ?>">Mes abonnements <i class="icon icon-users"></i></a></li>
            <li><a href="/logout">Déconnexion <i class="icon icon-off"></i></a></li>
        <?php endif; ?>
    </ul>
</header>
