<section class="section container row">
    <section class="col l9 m12 s12">
        <h2 class="ui header col s12 l12 m12">Editer une photo</h2>
        <form action="" method="POST">
            <div class="col l12 m12 s12">
                <div class="input-field">
                    <label for="name">name</label>
                    <input type="text" id="name" name="name" value="<?= $photo->name ?>">
                </div>
            </div>

            <div class="col l6 m6 s12">
                <div class="input-field">
                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" value="<?= $photo->tags ?>">
                </div>
            </div>

            <div class="col l6 m6 s12">
               <div class="input-field">
                   <select name="category" id="category" class="select-dropdown">
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
                    <textarea id="contents" name="description" class="mdz-textarea materialize-textarea"><?= $photo->description ?></textarea>
                </div>
            </div>

            <div class="input-field col l12 m12 s12">
                <button type="submit" class="btn btn-flat">Publier&nbsp;<i class="icon icon-send"></i></button>
            </div>
        </form>
    </section>
    <?php include(APP."/Views/includes/menu-aside.php"); ?>
</section>

