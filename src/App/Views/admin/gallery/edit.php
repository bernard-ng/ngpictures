<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card">
            <div class="page-title section-title">Edition <i class="icon icon-pencil right"></i></div>

            <form action="#" method="POST" class="ml-10 mr-10 mb-30">
                <div class="col l12 m12 s12">
                    <input type="text" id="name" name="name" placeholder="name" value="<?= $photo->name ?>">
                </div>

                <div class="col l6 m6 s12">
                    <input type="text" id="tags" name="tags" placeholder="tags someone" value="<?= $photo->tags ?>">
                </div>

                <div class="col l12 m12 s12">
                    <textarea id="content" name="description"><?= $photo->description ?></textarea>
                </div>

                <div class="col l6 m6 s12">
                    <select name = "category">
                        <option selected value="<?= $photo->category_id ?>"><?= $photo->category ?></option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="submit-button">
                    <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
                </div>
            </form>
        </div>
    </section>
</main>


