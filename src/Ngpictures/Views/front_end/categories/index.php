<section class="section container row">
    <?php include(APP."/Views/includes/right-aside.php"); ?>
    <?php if(isset($categories) && !empty($categories)): ?>
        <div class="col l9 m12 s12">
            <?php foreach ($categories as $c) : ?>
                <div class="col nexted l3 m4 s12">
                    <div class="card" style="background-color: #100F0F">
                        <div class="card-image">
                            <a href="<?= $c->url ?>" class="waves-effect">
                            <?php foreach ($thumbs as $key => $value) : ?>
                                    <?php if ($key == $c->id) : ?>
                                        <img src="<?= $value ?>" alt="" class="responsive-img">
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            </a>
                        </div>
                        <div class="card-content">
                            <span class="card-title ui header">
                                <?= $c->title ?>  <span class="badge new right"><?= $nb[$c->id] ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="col l9 m12 s12 animated slideInRight">
            <div class="section center-align">
                <h2 class="icon icon-tag red-txt center-align"></h2>
                <h2 class="ui header divided center"> Aucune publication pour l'instant</h2>
                <p>
                    cette Catégorie ne présente actuellement aucune publication disponible, les publications sont peut être en évaluation,
                    ceci pourrait prendre du temps, veuillez revenir plus tard
                </p>
            </div>
        </div>
    <?php endif; ?>
</section>
