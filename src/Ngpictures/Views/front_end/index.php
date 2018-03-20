<main>
    <section class="section row container animated slideInUp">
    <span class="row col l12 s12 m12">
        <h2 class="ui header"> Derniers Articles</h2>
    </span>
    <?php foreach ($last as $a) : ?>
        <div class="row col s12 m3 l3">
            <article class="ui link card hoverable">
                <div class="image waves-effect">
                    <a href="<?= $a->url; ?>"><img src="<?= $a->smallThumbUrl; ?>"></a>
                </div>
                <div class="content center">
                    <div class="header"><?= $a->title ?? $a->name; ?></div>
                    <div class="meta">
                        <a href="<?= $a->categoryUrl; ?>" class="category"><?= $a->category; ?></a>
                    </div>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
    </section>
    <section class="jumbotron dark col l12 s12 m12">
        <div class="container row">
            <div class="row col l7 s12 m12">
                <h2 class="ui header">A Propos De Nos Photos</h2>
                <div class="">
                    <p class="justify-align">
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
                <?php if ($article && !empty($article)): ?>
                    <div class="post-hoverable">
                        <a href="<?= $article->url; ?>" class="waves-effect">
                            <img src="<?=$article->thumbUrl ?>" alt="<?= $article->title ?>">
                        </a>
                        <span class="post-description">
                            <?= $article->snipet ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row col l5 s12 m12">
                <h2 class="ui header">Catégories</h2>
                <div class="ui relaxed divided list">
                    <?php foreach ($categories as $category) : ?>
                        <div class="item">
                            <i class="icon icon-tag"></i>
                            <div class="content">
                            <a class="header" href="<?= $category->url; ?>"><?= $category->title; ?></a>
                            <div class="description"><?= $category->description ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="/categories" class="btn btn-flat action blue-grey dark-1 waves-effect">
                        Voir Plus
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="section col l12 m12 s12">
        <div class="row container">
            <span class="row col l12 s12 m12">
                <h2 class="ui header"> Les Héros dans l'ombre</h2>
            </span>
            <div class="ui divided items col l6 m12 s12">
                <div class="item">
                    <div class="image"><img src="/imgs/team/bernard.jpg"></div>
                    <div class="content">
                        <a href="http://ngpictures.pe.hu" target="_blank" class="header">Bernard Ngandu</a>
                        <div class="meta">  Fondateur  - developpeur - Photographe </div>
                        <div class="description">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Eum quidem incidunt maiores asperiores consequuntur recusandae totam quo
                                consectetur assumenda nemo quia saepe nobis voluptatibus dolor
                                minus, corporis, illo, provident expedita...
                            </p>
                        </div>
                        <div class="extra">
                            <a href="http://ngpictures.pe.hu" target="_blank" class="btn blue-grey dark-1">
                                Portfolio
                            </a>
                            <a href="https://github.com/bernard-ng" target="_blank" class="btn blue-grey dark-1">
                                Github
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="image"><img src="/imgs/team/rapha.jpg"></div>
                    <div class="content">
                        <span class="header">Rapha Truck</span>
                        <div class="meta"> Design - Création</div>
                        <div class="description">
                            <p>
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                Aspernatur ullam natus harum distinctio molestiae, molestias nulla voluptates error alias,
                                 voluptate assumenda. Accusamus at quidem non quos laborum ea ex rem.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="image"><img src="/imgs/team/gael.jpg"></div>
                    <div class="content">
                        <a class="header">Gael Balo</a>
                        <div class="meta">Markerting - shooting model</div>
                        <div class="description">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Sint facilis nobis labore atque. Amet beatae a quidem consequuntur
                                aliquid dolores iste fugiat velit nemo nulla,
                                 suscipit delectus, fugit porro quae?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui divided items col l6 m12 s12">
                <div class="item">
                    <div class="image"><img src="/imgs/team/balloy.jpg"></div>
                    <div class="content">
                        <span class="header">Balloy Fane</span>
                        <div class="meta">Directrice de Publication</div>
                        <div class="description">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Eum quidem incidunt maiores asperiores consequuntur recusandae totam quo consectetur
                                assumenda nemo quia saepe nobis voluptatibus dolor minus, corporis, illo, provident expedita.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="image"><img src="/imgs/team/grey.jpg"></div>
                    <div class="content">
                        <span class="header">Gretta Mpunga</span>
                        <div class="meta">shooting model</div>
                        <div class="description">
                            <p>
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aspernatur ullam natus harum distinctio molestiae, molestias nulla voluptates error alias, voluptate assumenda. Accusamus at quidem non quos laborum ea ex rem.
                            </p>
                        </div>
                        <div class="extra">
                            <a href="https://instagram.com/grey" target="_blank" class="btn blue-grey dark-1">Instagram</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="image"><img src="/imgs/team/precylia.jpg"></div>
                    <div class="content">
                        <span class="header">Precylia Felo</span>
                        <div class="meta">shooting model</div>
                        <div class="description">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Sint facilis nobis labore atque. Amet beatae a quidem consequuntur
                                aliquid dolores iste fugiat velit nemo nulla, suscipit delectus, fugit porro quae?
                            </p>
                        </div>
                        <div class="extra">
                            <a href="https://instagram.com/grey" target="_blank" class="btn blue-grey dark-1">Instagram</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="jumbotron dark col l12 s12 m12">
        <div class="row container">
            <div class="col l4 m12 s12">
                <h2 class="ui header">Nous Rétrouver</h2>
                <address style="font-style: normal !important;">
                    République Démocratique du Congo<br>
                    Province du Haut-Katanga, Ville de Lubumbashi<br>
                    Commune Lubumbashi, Quartier Kalubwe<br>
                    Avenue Lackipopo, numéro 10465</br><br>
                </address>
                <p>
                    <a href="/contact" class="btn btn-flat blue-grey dark-1 action waves-effect">Nous Contacter</a>
                </p>
            </div>
            <div class="col l8 m12 s12 goole-maps">
                <iframe class="hoverable" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3907.669795348674!
                    2d27.466621714359682!3d-11.646862391734508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!
                    4f13.1!3m3!1m2!1s0x1972394d26719141%3A0xa8515a298fe31a63!2sAvenue+du+lac+Kipopo%2C+Lubumbashi!5e0!3m2!1sfr!2scd!4v1517072954604"
                    width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </section>
</main>
