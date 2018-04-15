<style type="text/css">

.profile-img {
    background: #000;
    border-radius: 100%;
    width: 120px;
    height: 120px;
    overflow: hidden;
    margin: 10px;
    vertical-align: middle;
    display: inline-block;
}
.profile-content {
    width: calc(100% - 200px);
    vertical-align: middle;
    display: inline-block;
    position: relative;
    padding: 20px 5px 20px 5px;
}
.profile-title {
    margin: 0px;
}
.profile-subtitle {
    margin: 0px;
}
.profile-title {
    font-size: 2.2em;
    font-weight: 600;
    text-transform: capitalize;
}
.profile-subtitle {
    margin: 5px 0px;
    font-size: 14px;
    font-weight: 300;
    display: block;
}
.profile-links {
    color: #428bca;
    font-size: 14px;
}
.profile-link {
    color: inherit;
    text-decoration: none;
    margin-right: 10px;
    white-space: nowrap;
}


.profile-actions {
    top: 50%;
    text-align: right;
    right: -15px;
    margin-top: -20px;
    position: absolute;
}
.profile-action {
    padding: 0px;
    width: 60px;
    height: 40px;
    line-height: 40px;
    margin-left: 10px;
}

.user-position{
    margin-top: 50px;
    margin-right: -20px;
}

.bio{
    margin: 10px 20px 10px 20px;
    border-top: 1px solid rgba(244,244,244,0.4);
    padding: 20px !important;
    position: relative;
}


</style>
<div class="jumbotron-user">
    <div class="container">
        <img class="profile-img " alt="<?= $user->name; ?>"  src="<?= $user->avatarUrl ?>">
        <div class="profile-content row">
            <div class="row col lg6 m12">
            <h1 class="profile-title">
                <?= $user->name ?>
            </h1>
            <h2 class="profile-subtitle">
                <?= $user->email ?>
            </h2>

            <?php if ($activeUser && $activeUser->id == $user->id) : ?>
                <div class="profile-links">
                    <a class="profile-link" href="<?= $user->editUrl ?>">
                        <i class="icon icon-edit"></i>&nbsp;Editer le profil
                    </a>
                    <a class="profile-link" href="<?= $user->editUrl ?>">
                        <i class="icon icon-edit"></i>&nbsp;Paramètres
                    </a>
                </div>
            <?php endif; ?>

            </div>
            <?php if($activeUser && $activeUser->id != $user->id): ?>
                <div class="hide-on-med-and-down profile-actions">
                    <a class="profile-actions  btn blue-grey dark-2 right" title="Suivre cette personne" href="<?= $user->followingUrl; ?>">
                        Suivre
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="col l12 m12 s12 bio">
            <?= $user->bio ?>
        </div>
    </div>
</div>
<ul class="tabs transparent">
        <li class="tab"><a href="">test</a></li>
    </ul>
