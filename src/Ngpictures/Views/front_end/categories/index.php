 <?php include(APP."/Views/includes/mobile-menu.php"); ?>
 <div class="jumbotron">
    <?php include(APP."/Views/includes/menu.php"); ?>
    <div class="container row">
        <span class="jumbotron-title">
            <i class="icon icon-tags"></i> Catégories
        </span>
        <span class="jumbotron-content">
           les cates  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
           quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        </span>
    </div>
</div>

<div class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <?php foreach ($categories as $c) : ?>
        <div class="col l3 m6 s12">
            <div class="card verse-panel">
                <div class="card-content ng-contain">
                    <span class="card-title"><?= $c->title ?>  <span class="badge new right">123</span></span>
                    <p>
                        <?= $c->description ?>
                    </p>
                </div>
                <div class="card-action">
                    <a href="<?= $c->url ?>">Voir</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
