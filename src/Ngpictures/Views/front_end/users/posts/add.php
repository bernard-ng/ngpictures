<section class="container row">
    <?php include(APP."/Views/includes/right-aside.php"); ?>
    <section class="col row l6 m12 s12">
        <div class="grey dark-4 col l12 m12 s12">
            <form action="" method="POST" enctype="multipart/form-data" data-action="upload">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="text">Nom</label>
                        <input type="text" id="title" autofocus name="title" class="validate <?= $errors->get('title')? 'invalid' : '' ?>" value="<?= $post->getSafe('title') ?>" data-length="255">
                        <span class="helper-text red-txt">
                        <?= $errors->get('title') ?>
                    </span>
                    </div>

                    <div class="file-field input-field col s12">
                    <span class="btn blue-grey darken-1 waves-effect waves-light col s3 m2 l2" style="display: inline-block;">
                        <span><i class="icon icon-picture"></i></span>
                        <input type="file" name="thumb">
                    </span>
                        <span class="file-path-wrapper col s9 l10 m10" style="display: inline-block;" >
                        <input class="file-path" placeholder="ajouter une photo" type="text">
                    </span>
                        <div data-action="show-uploaded-file">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <span class="col s12">
                        <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                        <label for="filled-in-box">Location</label>
                    </span>
                    <div class="input-field col s12">
                        <label for="content">Description</label>
                        <textarea id="content" name="content" class="mdz-textarea materialize-textarea validate <?= $errors->get('content')? 'invalid': '' ?>"><?= $post->getSafe('content') ?></textarea>
                        <span class="helper-text red-txt">
                        <?= $errors->get('content') ?>
                    </span>
                    </div>

                    <div class="submit-button col s12">
                        <button type="submit" class="btn btn-flat waves-effect">Publier&nbsp;<i class="icon icon-send"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php include(APP."/Views/includes/menu-aside.php"); ?>
</section>
