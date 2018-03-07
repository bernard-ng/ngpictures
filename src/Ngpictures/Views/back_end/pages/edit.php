<main class="container row">
    <section class="col l12 m12 s12">
        <div class="card">
            <div class="page-title section-title">Edition : <?= $file_name ?> <i class="icon icon-pencil right"></i></div>

            <form action="#" method="POST" class="ml-10 mr-10 mb-30">
                <div class="col l12 m12 s12">
                    <textarea id="content" name="file_content"><?=  $post->get('file_content') ?? $file_content ?></textarea>
                </div>

                <div class="submit-button">
                    <button type="submit" class="ng-btn waves-effect waves-light">Modifier&nbsp;<i class="icon icon-send"></i></button>
                </div>
            </form>
        </div>
    </section>
</main>
