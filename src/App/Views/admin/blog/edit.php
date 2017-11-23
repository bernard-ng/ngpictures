<div class="container row">
    <form action="" method="POST" class="col l12">
        <div class="default-form col l6 m6 s12">
            <input type="text" id="title" name="title" value="<?= $article->title ?>">
            <label for="title">Titre</label>
        </div>

        <div class="default-form col l6 m6 s12">
            <input type="text" id="slug" name="slug" value="<?= $article->slug ?>">
            <label for="slug">slug</label>
        </div>

        <div class="default-form col l12 m12 s12">
            <textarea id="content" name="content"><?= $article->content ?></textarea>
            <label for="content">Contenu - Markdown</label>
        </div>

        <div class="col l12 m12 s12">
            <button type="submit" class="btn waves-effect waves-light">
                Poster <i class="icon icon-send"></i>
            </button>
        </div>
        
    </form>
</div>


