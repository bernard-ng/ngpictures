<div class="container row col l12">
    <div class="card col l9 m12 s12">
        <div class="page-title section-title">Rédaction <i class="icon icon-pencil right"></i></div>

        <form action="#" method="POST" class="ml-10 mr-10 mb-30" enctype="multipart/form-data">

            <div class="col l6 m6 s12">
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    placeholder="titre"
                    value="<?= $post->getWhenSet('title') ?>" 
                    required
                >
            </div>

            <div class="col l6 m6 s12">
                <input 
                    type="text" 
                    id="slug" 
                    name="slug"
                    placeholder="slug" 
                    value="<?= $post->getWhenSet('slug') ?>" 
                    required
                >
            </div>

            <div class="file-field input-field ">
                <span class="btn blue-grey darken-1 waves-effect waves-light col s2 m2 l2" style="display: inline-block;">
                    <span><i class="icon icon-picture"></i></span>
                    <input type="file" name="thumb" required>
                </span>
                <span class="file-paht-wrapper col s10 l10 m10" style="display: inline-block;" >
                    <input 
                        class="file-path" 
                        placeholder="ajouter une photo" 
                        type="text" 
                        required
                    >
                </span>
            </div>

            <div class="input-field col l12 m12 s12">
                <textarea id="content" name="content"><?= $post->getWhenSet('content') ?></textarea>
            </div>

            <div class="submit-button">
                <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
            </div>
        </form>
    </div>
</div>

