<!--=============== NAVBAR ===================-->
<header>
    <div class="navbar-fixed">
        <nav class="shadow-3">
            <div class="nav-wrapper container" id="menu">
                <a href="<?= ADMIN ?>" class="brand-logo">
                    <img src="/imgs/admin-logo.png" class="logo" alt="logo">
                </a>
                <a href="#" data-activates="mobile-admin-menu" class="button-collapse btn blue-grey dark-3">
                    <i class="icon icon-th"></i>
                </a>
                <ul class="right hide-on-med-and-down links">
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

                    <li id="Accueil"><a href="/home"> <i class="icon icon-home"></i></a></li>
                    <li id="pages"><a href="<?= ADMIN."/pages" ?>">Pages</a></li>
                    <li id="logs"><a href="<?= ADMIN."/logs" ?>"> Logs</a></li>
                    <li id="blog"><a href="<?= ADMIN."/blog" ?>"> Blog</a></li>
                    <li id="users"><a href="<?= ADMIN."/users" ?>"> Users</a></li>
                    <li id="actualites"><a href="<?= ADMIN."/posts" ?>"> Users Posts</a></li>
                    <li id="gallerie"><a href="<?= ADMIN."/gallery" ?>"> Gallery</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
