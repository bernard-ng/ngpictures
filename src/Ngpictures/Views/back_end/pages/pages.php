<div class="container row">
    <?php include(APP . "/Views/includes/left-aside.twig"); ?>
    <?php if (isset($files) && !empty($files)) : ?>
        <?php foreach ($files as $file) : ?>
            <?php if ($file->getBaseName() != '.' && $file->getBaseName() != '.') : ?>
                <?php if (strtolower($file->getExtension()) == "html") : ?>
                    <div class="col l3 m6 s12">
                        <div class="card verse-panel">
                            <div class="card-content ng-contain">
                                <span class="card-title"><?= $file->getBaseName() ?></span></span>
                            </div>
                            <div class="card-action">
                               <a href="<?= ADMIN."/pages/{$file->getBaseName()} "?>">Editer</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
