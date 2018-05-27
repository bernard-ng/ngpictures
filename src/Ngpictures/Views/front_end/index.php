<section>
    <section class="section row container animated slideInUp">
        <span class="row col l12 s12 m12">
            <h2 class="ui header"> Derniers Articles</h2>
        </span>
        <?php foreach ($last as $a) : ?>
        <div class="row nexted col s12 m3 l3">
            <article class="card hoverable blue-grey dark-4">
                <div class="card-image">
                    <img src="<?= $a->smallThumbUrl; ?>" class="activator">
                </div>
                <div class="card-reveal">
                    <span class="card-title"><?= $a->title; ?><i class="icon icon-cancel right"></i></span>
                    <div class="truncate">
                        <?= $a->snipet; ?>
                    </div>
                    <a href="<?= $a->url ?>" class="btn btn-flat">Voir plus</a>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
    </section>
    <section class="jumbotron dark col l12 s12 m12">
        <div class="container row">
            <?php include(APP . "/Views/includes/right-aside.php"); ?>
            <div class="row col l6 s12 m12 animated slideInLeft">
                <h2 class="ui header">Nos photos</h2>
                <div class="">
                    <p>
                        l'ombre et la lumière surgissent de presque nul part,
                        évanescentes elles apparaissent et disparaissent au gré du temps,
                        elles sont par définition insaisissables et impalpables.
                        seule la prise de vue photographique permet de monter la magie de cette dualité fraternelle.
                        En effet l’ombre et la lumière sont les deux faces déterminantes de la photographie,
                        souvent elles se font un face à face perpétuel dans des compositions surprenantes.
                        Elles ne sont jamais neutres. Ainsi elle peuvent être une forme autonome se superposant à une réalité déjà présente.
                        Nos photos sont l'expression même de l'ombre sinueuse d'une personne.
                    </p>
                </div>
                <?php if ($article && !empty($article)) : ?>
                    <div class="post-hoverable">
                        <a href="<?= $article->url; ?>" class="waves-effect">
                            <img src="<?=$article->thumbUrl ?>" alt="<?= $article->title ?>">
                        </a>
                        <span class="post-description">
                            <?= $article->title ?>
                        </span>
                    </div>
                <?php else: ?>
                    <img src="/imgs/shooting.jpeg" class="responsive-img" alt="ngpictures shooting banner">
                <?php endif; ?>
            </div>
            <?php include(APP."/Views/includes/menu-aside.php"); ?>
        </div>
    </section>
    <section class="section col l12 m12 s12">
        <div class="row container">
            <span class="row col l12 s12 m12">
                <h2 class="ui header">Les Héros dans l'ombre</h2>
            </span>
            <div class="ui divided items col l6 m12 s12 animated slideInLeft">
                <div class="item">
                    <div class="image"><img src="<?= CDN."/imgs/team/bernard.jpg" ?>"></div>
                    <div class="content">
                        <a href="http://ngpictures.pe.hu" target="_blank" class="header">Bernard Ngandu</a>
                        <div class="meta">  Fondateur  - developpeur - Photographe </div>
                        <div class="description">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Eum quidem incidunt maiores asperiores consequuntur recusandae totam quo
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="image"><img src="<?= CDN."/imgs/team/gael.jpg" ?>"></div>
                    <div class="content">
                        <a class="header">Gael Balo</a>
                        <div class="meta">Markerting - shooting model</div>
                        <div class="description">
                            <p>
                                aliquid dolores iste fugiat velit nemo nulla,
                                 suscipit delectus, fugit porro quae?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui divided items col l6 m12 s12 animated slideInRight">
                <div class="item">
                    <div class="image"><img src="<?= CDN."/imgs/team/balloy.jpg" ?>"></div>
                    <div class="content">
                        <span class="header">Balloy Fane</span>
                        <div class="meta">Directrice de Publication</div>
                        <div class="description">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Eum quidem
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="image"><img src="<?= CDN."/imgs/team/grey.jpg" ?>"></div>
                    <div class="content">
                        <span class="header">Gretta Mpunga</span>
                        <div class="meta">shooting model</div>
                        <div class="description">
                            <p>
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aspernatur
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="jumbotron parallax-container col l12 s12 m12">
         <div class="row container">
            <div class="col l4 m12 s12">
                <h2 class="ui header">Nous Rétrouver</h2>
                <address style="font-style: normal !important;" class="grey-txt">
                    République Démocratique du Congo<br>
                    Province du Haut-Katanga, Ville de Lubumbashi<br>
                    Commune Lubumbashi, Quartier Kalubwe<br>
                    Avenue Lackipopo, numéro 10465</br>
                </address>
                <ul>
                <a href="https://www.Facebook.com/ngpictures23" target="_blank">
                    <i class="icon icon-facebook-rect"></i></a>
                <a class="white-text page-footer-text" href="https://www.instagram.com/ngpictures_23" target="_blank">
                    <i class="icon icon-instagram"></i></a>

                <a class="white-text page-footer-text" href="https://www.pexels.com/ngpictures_23" target="_blank">
                    <i class="icon icon-instagram-filled"></i></a>

                <a href="https://www.github.com/bernard-ng" target="_blank">
                    <i class="icon icon-github"></i>
                </a>

                <a href="https://www.twitter.com/bernardngandu">
                    <i class="icon  icon-twitter-bird"></i>
                </a>
            </ul>
                <p>
                    <a href="/contact" class="btn btn-flat blue-grey action waves-effect">Nous Contacter</a>
                </p>
            </div>
            <div class="col l8 m12 s12 goole-maps">
                <iframe class="hoverable" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3907.669795348674!
                    2d27.466621714359682!3d-11.646862391734508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!
                    4f13.1!3m3!1m2!1s0x1972394d26719141%3A0xa8515a298fe31a63!2sAvenue+du+lac+Kipopo%2C+Lubumbashi!5e0!3m2!1sfr!2scd!4v1517072954604"
                    width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="parallax">
            <img src="<?= CDN."/imgs/map-2.jpg" ?>" alt="">
        </div>
    </div>
</section>
