<div class="jumbotron-user">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab deleniti earum minima? Ab eveniet fugit ipsa nobis quaerat quod repellendus soluta velit voluptatibus. Cum doloribus iure, nam porro provident quasi!
</div>
<section class="section jumbotron dark row">
    <div class="container">
        <div class="carousel small">
            <?php foreach($posts as $post): ?>
                <a href="<?= $post->url ?>" class="carousel-item">
                    <img src="<?= $post->smallThumbUrl ?>" alt="<?= $post->title ?? 'publication' ?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="container">
    <div class="gallery gallery-container">
        <?php foreach ($posts as $post): ?>
            <article class="gallery-item" id="<?= $post->id; ?>">
                <a href="<?= $post->url ?>">
                    <img src="<?= $post->smallThumbUrl ?>" class="responsive-img" alt="">
                </a>
            </article>
        <?php endforeach; ?>
    </div>
</section>