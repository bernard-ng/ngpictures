<ul class="side-nav" id="mobile-menu">
    <?php if ($activeUser) : ?>
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="/imgs/bgjumbo.jpeg" alt="bg">
                </div>
                <a href=""><img src="<?= $activeUser->avatarUrl; ?>" alt="bg2" class="circle"></a>
                <a href=""><span class="white-txt name"><?= $activeUser->name; ?></span></a>
                <a href=""><span class="email"><?= $activeUser->email; ?></span></a>
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
                <a href="/sign" class="btn btn-flat blue dark-3 waves-effect">Inscription</a>
                <a href="/login" class="btn btn-flat blue dark-3 waves-effect">Connexion</a>
            </li>
        <?php else: ?>
            <li>
                <a href="<?= $activeUser->postUrl; ?>" class="btn btn-flat blue dark-3 waves-effect">Poster</a>
                <a href="<?= $activeUser->postsUrl; ?>" class="btn btn-flat blue dark-3 waves-effect">Mes Publications</a>
            </li>
        <?php endif; ?>
    </div>
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
        <li><a href="<?= ADMIN ?>">Administration <i class="icon icon-code"></i></a></li>
    <?php endif; ?>


    <li><a href="/blog">Blog <i class="icon icon-quote-left"></i></a></li>
    <li><a href="/posts">Actualités </a></li>
    <li ><a href="/community">Communauté <i class="icon icon-users"></i></a></li>
    <li><a href="/gallery">Gallerie <i class="icon icon-picture"></i></a></li>
    <li>
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header waves-effect">Plus</a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="/bugs">Signaler un Bug <i class="icon icon-comment-empty"></i></a></li>
                        <li><a href="/ideas">Donner une idée <i class="icon icon-comment-empty"></i></a></li>
                        <li><a href="/privacy-terms">Mentions légales <i class="icon icon-plus"></i></a></li>
                        <li><a href="/about">A propos <i class="icon icon-star"></i></a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
</ul>
