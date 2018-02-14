<section class="row container">

<style type="text/css">






.tag-label {
    background: rgb(85, 85, 85); 
    padding: 2px 5px; 
    border-radius: 3px; 
    color: rgb(255, 255, 255); 
    font-size: 12px; 
    text-decoration: none; 
    margin-left: 5px; 
    vertical-align: middle; 
    display: inline-block;
}

.profile-header {
    
}
.profile-header__img {
    background: rgb(238, 238, 238);
    border-radius: 50%;
    width: 100px; 
    height: 100px; 
    overflow: hidden; 
    margin: 10px;
    vertical-align: middle; 
    display: inline-block;
}
.profile-header__content {
    width: calc(100% - 200px);
    vertical-align: middle;
    display: inline-block;
    position: relative;
    padding: 20px 5px 20px 5px;
}
.profile-header__title {
    margin: 0px;
}
.profile-header__subtitle {
    margin: 0px;
}
.profile-header__title {
    font-size: 2.2em;
    font-weight: 600;
    font-family: robot-title
}
.profile-header__subtitle {
    margin: 5px 0px; 
    color: #00695c; 
    font-size: 14px; 
    display: block;
}
.profile-header__links {
    color: rgb(85, 85, 85); 
    font-size: 14px;
}
.profile-header__link {
    color: inherit; 
    text-decoration: none; 
    margin-right: 10px; 
    white-space: nowrap;
}


.profile-header__actions {
    top: 50%; 
    text-align: right; 
    right: -15px; 
    margin-top: -20px; 
    position: absolute;
}
.profile-header__action {
    padding: 0px; 
    width: 60px; 
    height: 40px; 
    line-height: 40px; 
    margin-left: 10px;
}
.profile-header__facebook {
    background: rgb(59, 89, 152);
}

.user-position{
    margin-top: 50px;
    margin-right: -20px;
}

.bio{
    margin: -10px 20px 10px 20px;
    border: 2px solid #ccc;
    padding: 20px !important;
    border-radius: 3px;
    position: relative;
}
.bio:after{
    content: '';
    border: 15px solid #ccc;
    border-radius: 8px;
    border-right-color: transparent;
    border-left-color: transparent;
    border-top-color: transparent;
    position: absolute;
    bottom: 100%;
    left: 40px;
}



</style>
<div class="card col l12 s12 m12 profil-card">
    <img class="profile-header__img" alt="<?= $user->name; ?>"  src="<?= $user->avatarUrl ?>">
    <div class="profile-header__content row">
        <div class="row col lg6 m12">
        <h1 class="profile-header__title">
            <?= $user->name ?>
        </h1>
        <h2 class="profile-header__subtitle"><?= $user->email ?></h2>

        <?php if ($activeUser && $activeUser->id == $user->id) : ?>
            <div class="profile-header__links">
                <a class="profile-header__link" href="<?= $user->editUrl ?>">
                    <i class="icon icon-edit"></i>&nbsp;Editer le profil
                </a>
                <a class="profile-header__link" href="/logout/">
                    <i class="icon icon-off"></i>&nbsp;deconnexion
                </a>
            </div>
        <?php endif; ?>

        </div>
        <div class="hide-on-med-and-down profile-header__actions">
            <a class="profile-header__actions  btn primary-c right" title="Suivre cette personne" href="/leaderboard/">
                <i class="icon icon-plus"></i>
            </a>
            <a href="#" class="profile-header__actions profile-header__facebook btn" rel="nofollow" target="_blank" title="partager sur facebook">
                <i class="social social-facebook-1"></i>
            </a>
        </div>
    </div>

    <div class="col l12 m12 s12 bio">
        <?= $user->bio ?>       
    </div>
</div>
<?php include(APP."/Views/includes/left-aside.php"); ?>
<div class="col l9 s12 m12 ">
    <?php if ($activeUser && $activeUser->id == $user->id) : ?>
        <nav class="nav z-depth-2">
            <div class="nav-wrapper">
                <ul>
                    <li><a href="/account/post">Poster</a></li>
                    <li class="right"><a href="<?= $user->postsUrl;  ?>">Mes publications</a></li>
                    <li class="right"><a href="<?= $user->friendsUrl; ?>">Mes abonnés</a></li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
        <div class="col s12 m12 l9">
        <div id="dataContainers">
            <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $a) : ?>
                <article class="card" id="<?= $a->id ?>">
                    <header class="ng-news-card-header">
                        <span class="ng-news-card-image-profil">
                            <a href="<?= $a->userAvatarUrl ?>" class="zoombox">
                                <img src="<?= $a->userAvatarUrl ?>" alt="Profile <?= $a->username ?>">
                            </a>
                        </span>
                        <p class="ng-news-card-header-title">
                            <a href="<?= $a->userAccountUrl; ?>">
                                <?= $a->Username; ?>
                            </a>
                        </p>

                        <?php if ($a->thumb !== null) : ?>
                            <a id="saveBtn" class="ng-news-card-header-icon" href="<?= $a->downloadUrl ?>" title="Signaler Contenu indésirable">
                                <i class="icon icon icon-list"></i>
                            </a>
                            <a id="picBtn" class="ng-news-card-header-icon" href="<?= $a->userGalleryUrl ?>" title="toutes les publication">
                                <i class="icon icon icon-book"></i>
                            </a>
                            <a id="saveBtn" class="ng-news-card-header-icon" href="<?= $a->downloadUrl ?>" title="télécharger la photo">
                                <i class="icon icon icon-save"></i>
                            </a>
                        <?php endif; ?>
                    </header>

                    <?php if ($a->thumb !== null) : ?>
                        <div class="card-image">
                            <span class="ng-news-card-image-article">
                                <a href="<?= $a->url ?>">
                                    <img src="<?= $a->thumbUrl ?>" alt="Article Image" title="<?= $a->title ?>">
                                </a>
                            </span>
                        </div>
                    <?php endif; ?>

                    <main class="ng-news-card-content">
                        <section class="ng-news-card-title">
                            <?php if ($a->category_id !== null) : ?>
                                <a href="<?= $a->categoryUrl ?>"><i class="icon icon-tags"></i></a>
                            <?php endif; ?>
                            
                            <h2><?= $a->title ?>&nbsp;<small><?= $a->category ?></small></h2>
                        </section>
                        <section>
                            <p><?= $a->snipet ?></p>
                            <a href="<?= $a->url ?>" class="ng-news-card-seemore right">Voir plus</a>
                        </section>
                        <section id="articleInfo">
                            <div class="ng-news-card-stat">
                                <i class="icon icon-thumbs-up"></i>&nbsp;
                                <small>
                                    <a id="showLikes" href="<?= $a->showLikesUrl ?>"><?= $a->likes ?></a>
                                </small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-comment"></i>&nbsp;
                                <small>
                                    <?= $a->commentsNumber ?>
                                </small>
                            </div>
                            <div class="ng-news-card-stat">
                                <i class="icon icon-time"></i>&nbsp;
                                <small>
                                    <time id="date_created" data-time="<?= strtotime($a->date_created) ?>"><?= $a->date_created ?></time>
                                </small>
                            </div>
                        </section>
                    </main>
                    <footer class="ng-news-card-footer" id="articleOptions">
                        <a id="likeBtn" class="ng-news-card-footer-item <?= $a->isLike ?>" href="<?= $a->likeUrl ?>" title="aimer la publication">
                            <i class="icon icon-thumbs-up"></i>&nbsp;J'aime
                        </a>

                        <a id="commentBtn" class="ng-news-card-footer-item modal-trigger" href="#cmtAdd-<?= $a->id ?>">
                            <i class="icon icon-comment" ></i>&nbsp;Commenter
                        </a>
                        <div id="cmtAdd-<?= $a->id ?>" class="modal">
                            <div class="modal-content">
                                <span class="section-title-b mb-20">Commenter</span>
                                <form action="<?= $a->commentUrl ?>" method="POST">
                                    <div class="input-field">
                                        <textarea class="materialize-textarea" name="comment"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="modal-action btn primary-b">ok</button>
                                        <button id="cmtAdd-<?= $a->id ?>" type="reset" class="modal-action modal-close btn-flat">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <a id="shareBtn" class="ng-news-card-footer-item" href="/share/" title="partager la publication">
                            <i class="icon icon-share"></i>&nbsp;partager
                        </a>
                    </footer>
                </article>
               
            <?php endforeach; ?>
            <?php else : ?>
                <div class="card">
                    <div class="no-publication">
                        <div class="ng-cover"></div>
                        <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
       <div id="feedMore" class="feed-btn" data-ajax="posts" data-user="<?= $user->id ?>"><i class="icon icon-refresh rotate"></i> chargement</div>
    </div>
    <?php include(APP."/Views/includes/verset.php"); ?>
    <?php include(APP."/Views/includes/right-aside.php"); ?>
</div>
