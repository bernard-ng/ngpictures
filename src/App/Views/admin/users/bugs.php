<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col l9">
        <div class="card col l12" id ="bugs">
            <section class="ng-news-card-content">
                <section class="ng-news-card-title">
                    <h2>bugs</h2>
                </section>
                <main>
                    bugs found by users
                </main>
            </section>
            <table class="card responsive-table bordered striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>content</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($bugs)): ?>
                    <?php foreach ($bugs as $bug) : ?>
                        <tr>
                            <td><b><?= $bug->id ?></b></td>
                            <td>
                                <?= $bug->content; ?>
                            </td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $bug->id?>" >
                                    <input type="hidden" name="type" value="7" >
                                    <button type="submit" class="btn btn-small waves-effect waves-light red">
                                        <i class="icon icon-remove" style="font-size: smaller !important;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</section>

