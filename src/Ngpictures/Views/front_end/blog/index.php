<section class="row container">
    <?php require(APP . "/Views/includes/menu-aside.php"); ?>
    <section class="section col l6 m12 s12 animated slideInLeft" role="main">
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
                    <div class="full-infos">
                        Aucun Publication pour l'instant
                    </div>
                <?php endif; ?>
            </div>
            <div id="feedMore" class="btn btn-flat blue-grey dark-1 action waves-effect" data-ajax="blog">chargement</div>
        </div>
    </section>
    <?php require(APP."/Views/includes/menu-aside.php"); ?>
</section>
