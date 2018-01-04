<section class="row container">

<style type="text/css">






.tag-label {
	background: rgb(85, 85, 85); padding: 2px 5px; border-radius: 3px; color: rgb(255, 255, 255); font-size: 12px; text-decoration: none; margin-left: 5px; vertical-align: middle; display: inline-block;
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

		<?php if (Ng\Core\Generic\Session::getInstance()->getValue('auth', 'id') == $user->id): ?>
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
<div class="col l9 s12 m12s">
    <nav class="nav z-depth-2 mb-20">
        <div class="nav-wrapper">
            <ul>
                <li><a href="/account/post">Poster</a></li>
                <li class="right"><a href="<?= $user->seePostUrl;  ?>">Mes publications</a></li>
                <li class="right"><a href="<?= $user->friendsUrl; ?>">Mes abonnés</a></li>
            </ul>
        </div>
    </nav>
</div>
