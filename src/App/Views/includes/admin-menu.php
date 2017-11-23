<!--=============== NAVBAR ===================-->
<header>
    <div class="navbar-fixed">
        <nav class="ng-menu-reset">
            <div class="nav-wrapper ng-menu shrink" id="menu">
                <div class="row container">
                    <a href="/adm" class="brand-logo">
                       Administartion
                    </a>
                    <a href="#" data-activates="mobile-side-nav" class="button-collapse btn primary-c">
                        <i class="social social-menu"></i>
                    </a>
                    <ul class="right hide-on-med-and-down links">
                        <span id="menu-item-active" data-isActive="<?= Ngpic::getTitle() ?>"></span>
                        <li id="Accueil"><a href="/home" class="ng-menu-item"> front-end</a></li>
                        <li id="Blog"><a href="/adm/blog" class="ng-menu-item"> blog</a></li>
                        <li id="Actualités"><a href="/adm/articles" class="ng-menu-item"> articles</a></li>
                        <li id="Galerie"><a href="/adm/galery" class="ng-menu-item"> Galerie</a></li>
                        <li id="users"><a href="/adm/users" class="ng-menu-item"> membres</a></li>
                        <li><a href="#"> <icon class="icon icon-chevron-down"></icon></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
    <ul id="mobile-side-nav" class="side-nav links">
        <li>
            <div class="user-view">
                <a href="/account/bernard-ng-89"><img class="circle" src="/imgs/moi.jpg"></a>
                <a href="/account/bernard-ng-89" class="user-view-name">bernard_ng</a>
                <span class="user-view-name fullname">Bernard Tshabu ngandu</span>
            </div>
            <ul>
                <li id="Accueil"><a href="/adm">Accueil <i class="icon icon-home right"></i></a></li>
                <li id="Blog"><a href="/adm/blog">blog <i class="icon icon-pencil right"></i></a></li>
                <li id="Actualités"><a href="/adm/articles">articles <i class="icon icon-globe right"></i></a></li>
                <li id="Galerie"><a href="/adm/galery">Galerie <i class="icon icon-picture right"></i></a></li>
                <li id="users"><a href="/adm/users" class="ng-menu-item"> membres</a></li>
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
</header>

