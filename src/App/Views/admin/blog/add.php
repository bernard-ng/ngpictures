<div class="container row">
    <form action="" method="POST" class="col l12" enctype="multipart/form-data">
        <div class="input-field col l6 m6 s12">
            <input type="text" id="title" name="title" value="<?= $post->getWhenSet('title') ?>" required>
            <label for="title">Titre</label>
        </div>

        <div class="input-field col l6 m6 s12">
            <input type="text" id="slug" name="slug" value="<?= $post->getWhenSet('slug') ?>" required>
            <label for="slug">slug</label>
        </div>

        <div class="file-field input-field ">
            <span class="btn blue-grey darken-1 waves-effect waves-light col s2 m2 l2" style="display: inline-block;">
                <span><i class="icon icon-picture"></i></span>
                <input type="file" name="thumb" required>
            </span>
            <span class="file-paht-wrapper col s10 l10 m10" style="display: inline-block;" >
                <input class="file-path" placeholder="cliquer pour choisir une photo" type="text" required>
            </span>
        </div>

        <div class="input-field col l12 m12 s12">
            <textarea id="content" name="content"><?= $post->getWhenSet('content') ?></textarea>
        </div>

        <br>
        <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
        
    </form>
</div>

