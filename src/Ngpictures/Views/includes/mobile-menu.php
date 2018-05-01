<span id="menu-mobile-item-active" data-active="<?= $pageManager::getActivePage() ?>"></span>
<ul class="side-nav mobile-links" id="mobile-menu">
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

    <?php if (!$activeUser) : ?>
        <div class="user-action">
            <li>
                <a href="/sign" class="btn waves-effect">Inscription</a>
                <a href="/login" class="btn waves-effect">Connexion</a>
            </li>
        </div>
    <?php endif; ?>
    <?php if ($activeUser) : ?>
        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header waves-effect">Mon compte</a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="<?= $activeUser->accountUrl; ?>">Profile <i class="icon icon-user"></i></a></li>
                            <li><a href="<?= $activeUser->editUrl; ?>">Editer le Profile <i class="icon icon-cog-alt"></i></a></li>
                            <li><a href="<?= $activeUser->followingUrl; ?>">Mes abonnements <i class="icon icon-users"></i></a></li>
                            <li><a href="/logout">Déconnexion <i class="icon icon-off"></i></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if ($activeUser && $activeUser->rank == "admin") : ?>
        <li><a href="<?= ADMIN ?>">Administration <i class="icon icon-code right"></i></a></li>
    <?php endif; ?>

    <li id="Ngpictures"><a href="/">Accueil <i class="icon icon-home"></i></a></li>
    <li id="Blog"><a href="/blog">Blog <i class="icon icon-quote-left"></i></a></li>
    <?php if ($activeUser): ?>
        <li id="Communauté"><a href="/community">Communauté <i class="icon icon-users"></i></a></li>
        <li id="Posts"><a href="/posts">Actualités </a></li>
    <?php endif; ?>
    <li id="Galerie"><a href="/gallery">Galerie <i class="icon icon-picture"></i></a></li>
</ul>
