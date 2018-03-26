<section class="row container">
    <hearder class="col l12 m12 s12">
        <div class="ui pointing secondary menu">
            <a class="item active" data-tab="first">Tout</a>
            <a class="item" data-tab="second">Nouveaux</a>
            <a class="item" data-tab="third">Anciens</a>
        </div>
    </hearder>
    <section class="section col l9 m12 s12 animated slideInLeft" role="main">
        <div class="no-padding">
            <div class="ui divided items" id="dataContainer">
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $a) : ?>
                    <div class="item">
                        <div class="col l12 m12 s12">
                            <div class="image">
                                <div class="post-hoverable">
                                    <a href="<?= $a->url; ?>" class="waves-effect">
                                        <img src="<?=$a->thumbUrl ?>" alt="<?= $a->title ?>">
                                    </a>
                                    <span class="post-description">
                                        Publier le <?= $a->time; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col l11 m12 s12">
                            <div class="content">
                                <a class="ui header"><?= $a->title; ?></a>
                                <div class="meta">
                                    <span><?= $a->category; ?></span>
                                </div>
                                <div class="description">
                                    <p><?= $a->snipet ?></p>
                                </div>
                                <div class="ui horizontal list">
                                    <div class="item">
                                        <i class="icon icon-heart-empty"></i>
                                        <div class="content"> J'aime</div>
                                    </div>
                                    <div class="item">
                                        <i class="icon icon-comment"></i>
                                        <div class="content"> Commenter</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ; ?>
                <?php else : ?>
                    <div class="card">
                        <div class="no-publication">
                            <div class="ng-cover"></div>
                            <p><i class="icon icon-picture"></i> &nbsp;aucune publication pour l'instant</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div id="feedMore" class="btn btn-flat blue-grey dark-1 action waves-effect" data-ajax="blog">chargement</div>
        </div>
    </section>
    <?php require(APP."/Views/includes/menu-aside.php"); ?>
</section>
