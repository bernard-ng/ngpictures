<section class="section container row">
    <section class="section col l9 m12 s12">
        <h2 class="ui header">Publier une Photo</h2>
        <form action="" method="POST" class="card-panel grey dark-4" enctype="multipart/form-data" data-action="upload">
            <div class="file-field input-field ">
                <span class="btn blue-grey darken-1 waves-effect waves-light col s2 m2 l2" style="display: inline-block;">
                    <span><i class="icon icon-picture"></i></span>
                    <input type="file" name="thumb" required>
                </span>

                <span class="file-path-wrapper col s10 l10 m10" style="display: inline-block;" >
                    <input class="file-path" placeholder="ajouter une photo" type="text" required>
                </span>
                <div data-action="show-uploaded-file"></div>
            </div>

            <div class="col l12 m12 s12">
               <div class="input-field">
                   <label for="name">Name</label>
                   <input type="text" id="name" name="name" value="<?= $post->get('name') ?>">
               </div>
            </div>

            <div class="col l6 m6 s12">
                <div class="input-field">
                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" value="<?= $post->get('tags') ?>">
                </div>
            </div>

             <div class="col l6 m6 s12">
                <div class="input-field">
                    <select name="category">
                        <option disabled selected>choisissez une catégorie</option>
                        <?php foreach ($categories as $c) : ?>
                            <option value="<?= $c->id ?>"><?= $c->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col l12 m12 s12">
                <div class="input-field">
                    <label for="contents">Description</label>
                    <textarea id="contents" name="description" class="materialize-textarea mdz-textarea"><?= $post->get('description') ?></textarea>
                </div>
            </div>

            <div class="submit-button">
                <button type="submit" class="btn btn-flat waves-effect">Publier&nbsp;<i class="icon icon-send"></i></button>
            </div>
        </form>
    </section>
    <?php include(APP . "/Views/includes/left-aside.twig"); ?>
</section>

