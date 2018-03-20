<main>
<div class="container row">
   <!--  <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<? // $activeUser->followersUrl; ?>">Mes abonnés</a></li>
                <li><a href="<? // $activeUser->followingsUrl; ?>">Mes abonnements</a></li>
            </ul>
        </div>
    </nav> -->

    <section class="section row col l12 m12 s12">
    <?php if (isset($users) && !empty($users)) : ?>
        <?php foreach ($users as $user) : ?>
            <div class="row col l3 m6 s12">
                <div class="ui link card">
                    <a href="<?= $user->accountUrl; ?>" class="waves-effect image">
                        <img src="<?= $user->avatarUrl; ?>" alt="" width="100%">
                    </a>
                    <div class="content">
                        <?php if ($user->rank == 'admin' || $user->certified == 1): ?>
                            <div class="right floated meta"><i class="icon icon-ok-circled green-txt"></i></div>
                        <?php endif; ?>
                        <div class="header">
                            <?= $user->name ?>
                        </div>
                        <div class="meta">
                           <?= $user->bio ?>

                        </div>
                        <div class="description">
                            <div class="ui horizontal list">
                                <div class="item">
                                    <i class="icon icon-users"></i>
                                    <div class="middle aligned content">238</div>
                                </div>
                                <div class="item">
                                    <i class="icon icon-user"></i>
                                    <div class="middle aligned content">687</div>
                                </div>
                                <div class="item">
                                    <i class="icon icon-picture"></i>
                                    <div class="middle aligned content">589</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($user->id != $activeUser->id) : ?>
                        <a href="<?= $user->followingUrl ?>" class="btn btn-flat action blue-grey dark-1">
                            <?= $user->isFollowed ? "Unfollow" : "Follow" ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </section>
</div>
</main>
   <!--  <nav class="nav z-depth-2">
        <div class="nav-wrapper">
            <ul>
                <li><a href="<? // $activeUser->followersUrl; ?>">Mes abonnés</a></li>
                <li><a href="<? // $activeUser->followingsUrl; ?>">Mes abonnements</a></li>
            </ul>
        </div>
    </nav> -->
