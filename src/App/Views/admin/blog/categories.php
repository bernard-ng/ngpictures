<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col s12 m12 l9">
        <div class="card-panel">
            <div class="section-title mb-20 mt-20 ml-10">
                <i class="icon icon-tag"></i>&nbsp;Les Catégories
                <span class="btn primary-b right"><?= count($categories) ?></span>
                <a href="<?= ADMIN."/blog/categories/add" ?>" class="right">
                    <button class="btn">
                        <i class="icon icon-plus" style="font-size: smaller !important;"></i>
                    </button>
                </a>
            </div>
            <table class="card responsive-table bordered striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $c) : ?>
                        <tr>
                            <td><b><?= $c->id ?></b></td>
                            <td><a href="<?= $c->url ?>"><?= $c->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $c->id?>" >
                                    <input type="hidden" name="type" value="9" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" >
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <a href="<?= ADMIN."/blog/categories/edit/{$c->id}" ?>">
                                    <button class="btn btn-small waves-effect waves-light">
                                        <i class="icon icon-edit" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</section>
