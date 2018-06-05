<section class="section container row">
    <section class="col l9 m12 s12">
        <h2 class="ui header">Editer Album : <?= $album->title ?></h2>
        <form action="" method="POST" class="card-panel grey dark-4">
            <div class="col l12 m12 s12">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= $album->title ?>">
            </div>

            <div class="col l12 m12 s12">
                <div class="input-field">
                    <label for="contents">Description</label>
                    <textarea id="contents" name="description" class="materialize-textarea"><?= $album->description ?></textarea>
                </div>
            </div>

            <div class="submit-buttons">
                <button type="submit" class="btn btn-flat waves-effect">Envoyer</button>
            </div>
        </form>
    </section>
    <?php include(APP . "/Views/includes/left-aside.twig"); ?>
</section>

