<ul id="mobile-side-nav" class="side-nav links">
    <li>
        <div class="user-view">
            <a href="<?= $activeUser->accountUrl; ?>"><img class="circle" src="<?= $activeUser->avatarUrl ?>"></a>
            <a href="<?= $activeUser->accountUrl; ?>" class="user-view-name">bernard_ng</a>
            <span class="user-view-name fullname">Bernard Tshabu ngandu</span>
        </div>
        <ul>
            <li id="Accueil"><a href="<?= ADMIN ?>"> front-end<i class="icon icon-home right"></i></a></li>
            <li id="administration - Blog"><a href="<?= ADMIN."/blog" ?>">blog <i class="icon icon-pencil right"></i></a></li>
            <li id="administration - Actualités"><a href="<?= ADMIN."/posts" ?>">posts <i class="icon icon-globe right"></i></a></li>
            <li id="administration - Gallerie"><a href="<?= ADMIN."/gallery" ?>">Gallerie <i class="icon icon-picture right"></i></a></li>
            <li id="administration - users"><a href="<?= ADMIN."/users" ?>" class="ng-menu-item"> membres</a></li>
            <li>
                <a href="#" class="dropdown-button" data-activites="mobile-dropdown">
                    Plus <i class="icon icon-plus right"></i>
                </a>
            </li>
            <li style="color:#fff !important;">
                <a href="/home">
                    Front-end <i class="icon icon-off right"></i>
                </a>
            </li>
        </ul>
    </li>
</ul>
<ul id="mobile-dropdown" class="dropdown-content">
    <li><a href="/help">Aide</a></li>
    <li><a href="/ideas">Donner une idee</a></li>
    <li><a href="/bugs">Signaler un probleme</a></li>
    <li><a href="/contact">contact</a></li>
    <li class="divider"></li>
    <li><a href="/about">A propos de nous</a></li>
    <li><a href="/privacy">Condition générales</a></li>
    <li class="divider"></li>
    <li><a href="/logout"></a>Déconnexion</li>
</ul>