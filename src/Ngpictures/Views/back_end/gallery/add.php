<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card">
             <div class="page-title section-title">Poster une photo <i class="icon icon-picture right"></i></div>

            <form action="" method="POST" class="ml-10 mr-10 mb-30" enctype="multipart/form-data">

                <div class="file-field input-field ">
                    <span class="btn blue-grey darken-1 waves-effect waves-light col s2 m2 l2" style="display: inline-block;">
                        <span><i class="icon icon-picture"></i></span>
                        <input type="file" name="thumb" required>
                    </span>

                    <span class="file-path-wrapper col s10 l10 m10" style="display: inline-block;" >
                        <input class="file-path" placeholder="ajouter une photo" type="text" required>
                    </span>
                </div>

                <div class="col l12 m12 s12">
                    <input type="text" id="name" name="name" placeholder="name" value="<?= $post->get('name') ?>">
                </div>

                <div class="col l6 m6 s12">
                    <input type="text" id="tags" name="tags" placeholder="tags someone" value="<?= $post->get('tags') ?>">
                </div>

                 <div class="col l6 m6 s12">
                    <select name = "category">
                        <option disabled selected>choisissez une catégorie</option>
                        <?php foreach ($categories as $c) : ?>
                            <option value="<?= $c->id ?>"><?= $c->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                

                <div class="input-field col l12 m12 s12">
                    <textarea id="content" name="description" placeholder="description..."><?= $post->get('description') ?></textarea>
                </div>

                <div class="submit-button">
                    <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
                </div>
            </form>
        </div>
    </section>
</main>

