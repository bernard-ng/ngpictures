<section class="section row container">
    <section class="col s12 m12 l9">
        <h2 class="ui header col s12">Les Albums</h2>
        <div class="col l12 m12 s12 grey dark-3">
            <div class="section">
                <a href="<?= ADMIN."/gallery/albums/add" ?>" class="right btn">
                    <i class="icon icon-plus" style="font-size: smaller !important;"></i>
                </a>

                <span class="btn">Page : <?= $currentPage ?>/<?= $totalPage ?></span>
                <span class="btn"> Total : <?= $total ?></span>
                <a href="<?= ADMIN."/gallery/albums?page={$prevPage}"?>" class="btn"><i class="icon icon-left-open"></i></a>
                <a href="<?= ADMIN."/gallery/albums?page={$nextPage}"?>" class="btn"><i class="icon icon-right-open"></i></a>
            </div>
            <table class="card bordered grey dark-4">
                <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($albums)) : ?>
                    <?php foreach ($albums as $a) : ?>
                        <tr>
                            <td><b><?= $a->id ?></b></td>
                            <td><?= $a->title ?></td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $a->id?>" >
                                    <input type="hidden" name="type" value="10" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" id="delete">
                                        <i class="icon icon-cancel" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                                <a href="<?= ADMIN."/gallery/albums/edit/{$a->id}" ?>">
                                    <button class="btn btn-small waves-effect waves-light">
                                        <i class="icon icon-plus-circled" style="font-size: smaller !important;"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php include(APP."/Views/includes/left-aside.php"); ?>
</section>
