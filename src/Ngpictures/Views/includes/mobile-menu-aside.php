<div class="col s12 hide-on-med-and-up">
    <ul class="collapsible" data-collapsible="expandable">
        <li>
            <div class="collapsible-header active">
                <span class="section-title">
                    Catégories
                </span>
            </div>
            <div class="collapsible-body">
                <div>
                    Rétrouver nos posts dans les catégories suivantes
                </div>
                <br>
                 <ul>
                    <?php foreach ($categories as $c) : ?>
                       <span>
                           <i class="icon icon-chevron-right"></i>
                           <a href="<?= $c->url ?>" title="<?= $c->title ?>"><?= $c->title ?></a>
                       </span>
                       <br>
                    <?php endforeach; ?>
                    <br>
                    <i class="icon icon-chevron-right"></i> <a href="/categories">voir tout</a>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header active">
                <span class="section-title">
                    Derniers posts
                </span>
        </div>
            <div class="collapsible-body">
                <ul>
                    <?php if (isset($posts) && !empty($posts)) : ?>
                        <?php foreach ($posts as $a) : ?>
                           <i class="icon icon-globe"></i>&nbsp;<a href="<?= $a->url ?>" title="Voir plus"><?= $a->title ?></a><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header active">
                <span class="section-title">
                    Archives
                </span>
            </div>

            <div class="collapsible-body">
                <span>
                   Parcourez nos archives et rétrouver des anciens posts et photos
                </span><br>
                <ul>
                    <br><i class="icon icon-calendar"></i>&nbsp;<a href="/archives/decembre/2017">Décembre</a>
                    <br><i class="icon icon-calendar"></i>&nbsp;<a href="">Novembre</a>
                    <br><i class="icon icon-calendar"></i>&nbsp;<a href="">Octobre</a>
                    <br><i class="icon icon-chevron-right"></i>&nbsp;<a href="/archives">Plus d'archives</a>
                </ul>
            </div>
        </li>
    </ul>
</div>
