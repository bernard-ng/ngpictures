<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col l9">
        <div class="card col l12" id="ideas">
            <section class="ng-news-card-content">
                <section class="ng-news-card-title">
                    <h2>ideas</h2>
                </section>
                <main>
                    ideas given by users
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
                <?php if (!empty($ideas)): ?>
                    <?php foreach ($ideas as $idea) : ?>
                        <tr>
                            <td><b><?= $idea->id ?></b></td>
                            <td>
                                <?= $idea->content ?>
                            </td>
                            <td>
                                <form method="POST" action="<?= ADMIN."/delete" ?>" style="display: inline-block !important;">
                                    <input type="hidden" name="id" value="<?= $idea->id?>" >
                                    <input type="hidden" name="type" value="6" >
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