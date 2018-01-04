<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col l9">
        <div class="card no-padding col l12" id ="bugs">
            <nav class="nav col l12 z-depth-2 mb-20">
                <div class="nav-wrapper">
                    <ul>
                        <li><a href="<?= ADMIN."/file-browser/pictures/"  ?>">Photos membres</a></li>
                        <li><a href="<?= ADMIN."/file-browser/avatars/" ?>">Avatars membres</a></li>
                        <li class="right"><a href="<?= ADMIN."/users/ideas" ?>"> Ideas </a></li>
                </div>
            </nav>
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

