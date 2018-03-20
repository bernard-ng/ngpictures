<ul id="mobile-admin-menu" class="side-nav links">
    <li>
        <div class="user-view">
            <?php if ($activeUser) : ?>
                <div class="background">
                    <img src="/imgs/bgjumbo.jpeg" alt="bg">
                </div>
                <a href="<?= $activeUser->accountUrl; ?>"><img src="<?= $activeUser->avatarUrl; ?>" alt="bg" class="circle"></a>
                <span class="white-txt name"><?= $activeUser->name; ?></span>
                <span class="email"><?= $activeUser->email; ?></span>
            <?php endif; ?>
        </div>
    </li>
    <div class="user-action">
        <?php if ($activeUser) : ?>
            <li>
                <a href="<?= ADMIN."/blog/add" ?>" class="btn blue dark-3 waves-effect">Article</a>
                <a href="<?= ADMIN."/gallery/add" ?>" class="btn blue dark-3 waves-effect">Photo</a>
                <a href="<?= ADMIN."/gallery/albums/add" ?>" class="btn blue dark-3 waves-effect">Albums</a>
                <a href="<?= ADMIN."/blog/categories/add" ?>" class="btn blue dark-3 waves-effect">Catégories</a>
            </li>
        <?php endif; ?>
    </div>
    <li>
        <ul>
            <li id="Accueil"><a href="/"> Front-end<i class="icon icon-home"></i></a></li>
            <li id="Blog"><a href="<?= ADMIN."/blog" ?>">Blog <i class="icon icon-quote-left "></i></a></li>
            <li id="users"><a href="<?= ADMIN."/users" ?>"> Users <i class="icon icon-users"></i></a></li>
            <li id="Actualités"><a href="<?= ADMIN."/posts" ?>">Users Posts <i class="icon icon-attach "></i></a></li>
            <li id="Gallerie"><a href="<?= ADMIN."/gallery" ?>">Gallerie <i class="icon icon-picture "></i></a></li>
        </ul>
    </li>
</ul>
