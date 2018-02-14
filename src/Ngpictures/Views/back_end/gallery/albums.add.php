<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card">
            <div class="page-title section-title">Ajout d'un album<i class="icon icon-pencil right"></i></div>

            <form action="" method="POST" class="ml-10 mr-10 mb-30">

                <div class="col l12 m12 s12">
                    <input type="text" id="title" name="title" placeholder="titre" value="<?= $post->get('title') ?>">
                </div>

                <div class="input-field col l12 m12 s12">
                    <textarea id="content" name="description"><?= $post->get('description') ?></textarea>
                </div>

                <div class="submit-button">
                    <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
                </div>
            </form>
        </div>
    </section>
</main>
