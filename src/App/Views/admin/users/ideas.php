<section class="row container">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <main class="col l9">
        <div class="card no-padding col l12" id="ideas">
            <nav class="nav col l12 z-depth-2 mb-20">
                <div class="nav-wrapper">
                    <ul>
                        <li><a href="<?= ADMIN."/file-browser/pictures/"  ?>">Photos membres</a></li>
                        <li><a href="<?= ADMIN."/file-browser/avatars/" ?>">Avatars membres</a></li>
                        <li class="right"><a href="<?= ADMIN."/users/bugs" ?>"> Bugs </a></li>
                </div>
            </nav>
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
                                    <button type="submit" class="btn btn-small waves-effect waves-light red" id="delete">
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