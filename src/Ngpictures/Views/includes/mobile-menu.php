<ul id="mobile-side-nav" class="side-nav links">
    <li>
        <?php if ($activeUser) : ?>
            <div class="user-view">
                <a href="<?= $activeUser->accountUrl; ?>">
                    <img class="ng-menu-avatar circle" src="<?= $activeUser->avatarUrl ?>">
                </a>
                <a href="<?= $activeUser->accountUrl; ?>" class="user-view-name">
                    <?= $activeUser->name; ?>
                </a>
                <span class="user-view-name fullname">
                    <?= $activeUser->email; ?>
                </span>
            </div>
        <?php endif; ?>

        <ul>
            
            <?php if (!$activeUser) : ?>
                <div class="user-view">
                    <li><a class="link-btn primary-c" href="/login">Connexion<i class="icon icon-lock"></i></a></li>
                    <br>
                    <li><a class="link-btn primary-c" href="/sign">Inscription<i class="icon icon-lock"></i></a></li>
                </div>
            <?php endif; ?>
            
            <?php if ($activeUser) : ?>
                <li>
                    <a href="#" class="dropdown-button ng-menu-more" data-activites="mobile-dropdown">
                        Mon Compte <i class="icon icon-user right"></i>
                    </a>
                </li>
            <?php endif;?>

            <?php if ($activeUser && $activeUser->rank == "admin") : ?>
                <li><a href="<?= ADMIN ?>"> Admin&nbsp;<i class="icon icon-lock"></i></a></li>
                <li><a href="/community">Communauté&nbsp;<i class="social social-users"></i></a></li>
            <?php endif; ?>
            
            <li id="Accueil"><a href="/home">Accueil&nbsp;<i class="icon icon-home"></i></a></li>
            <li id="Blog"><a href="/blog">Blog&nbsp;<i class="icon icon-pencil"></i></a></li>
            <li id="Actualites"><a href="/posts">Actualités&nbsp;<i class="icon icon-globe"></i></a></li>
            <li id="Gallerie"><a href="/gallery">Gallerie&nbsp;<i class="icon icon-picture"></i></a></li>
            
        </ul>
    </li>
    <li>
        <?php if ($activeUser) : ?>
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
