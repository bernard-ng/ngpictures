<main class="container row">
    <?php include(APP."/Views/includes/left-aside.php"); ?>
    <section class="col l9 m12 s12">
        <div class="card">
            <div class="page-title section-title">Edition <i class="icon icon-pencil right"></i></div>

            <form action="#" method="POST" class="ml-10 mr-10 mb-30">
                <div class="col l12 m12 s12">
                    <input type="text" id="title" name="title" value="<?= $post->get('title') ?? $article->title ?>">
                </div>

                <div class="col  l6 m6 s12">
                    <select name = "category">
                        <option selected value="<?=  $article->category_id ?>"><?= $article->category ?></option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col l12 m12 s12">
                    <textarea id="content" name="content"><?=  $post->get('content') ?? $article->content ?></textarea>
                </div>

                <div class="submit-button">
                    <button type="submit" class="ng-btn waves-effect waves-light">Publier&nbsp;<i class="icon icon-send"></i></button>
                </div>
            </form>
        </div>
    </section>
</main>


