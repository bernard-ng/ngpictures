<div class="col l3 m3 no-padding  hide-on-small-and-down">
    <ul class="collapsible" data-collapsible="expandable">
        <?php if (isset($last) && !empty($last)) : ?>
            <li>
                <div class="collapsible-header active">
                    <span class="section-title">
                        Récents
                    </span>
                </div>
                <div class="collapsible-body" style="padding: 10px;">
                    <ul class="no-pad">
                        <?php foreach ($last as $a): ?>
                            <li class="collection-item avatar" id="<?= $a->id ?>">
                                <a href="<?= $a->url ?>">
                                    <img src="<?= $a->thumbUrl ?>" title="<?= $a->title ?? $a->name ?>"  width="100%">
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
        <li>
            <div class="collapsible-header">
                <span class="section-title">
                    Catégories
                </span>
            </div>
            <div class="collapsible-body">
                <?php foreach ($categories as $c): ?>
                   <span>
                       <b><a href="<?= $c->url ?>" title="<?= $c->title ?>"><?= $c->title ?></a></b>
                   </span>
                   <br>
                <?php endforeach; ?>
                <br>
                <i class="icon icon-chevron-right"></i> <a href="/categories">voir tout</a>
            </div>
        </li>

    </ul>
    <?php include(APP."/Views/includes/verset.php"); ?>
</div>

