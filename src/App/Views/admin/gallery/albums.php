<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col s12 m12 l9">
        <div class="card-panel">
            <div class="section-title mb-20 mt-20 ml-10">
                <i class="icon icon-tag"></i>&nbsp;Les Albums
                <span class="btn primary-b right"><?= count($albums) ?></span>
                <a href="<?= ADMIN."/gallery/albums/add" ?>" class="right">
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
                <?php if (!empty($albums)): ?>
                    <?php foreach ($albums as $a) : ?>
                        <tr>
                            <td><b><?= $a->id ?></b></td>
                            <td><a href="<?= $a->url ?>"><?= $a->title ?></a></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <input type="hidden" name="type" value="10" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" >
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <a href="<?= ADMIN."/gallery/albums/edit/{$a->id}" ?>">
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
