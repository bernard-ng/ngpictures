<div class="wrapper row3">
    <section class="hoc container clear">
        <div class="left btmspace-30">
            <h3 class="font-x2 nospace">Les derniers articles</h3>
            <p class="nospace">Retrouver l'integralité des nos articles sur le <a href="#">blog</a>.</p>
        </div>
        <div class="group center">

            <?php $class= ["first","",""]; foreach($last as $key => $article): ?>
            <article class="one_third <?= $class[$key&3] ?> ">
                <a href="<?= $article->url ?>">
                    <img class="btmspace-30" src="<?= $article->thumbUrl ?>" alt="<?= $article->title ?>" title="<?= $article->title ?>">
                </a>
                <time class="block font-xs" data-time="<?= strtotime($article->date_created); ?>"><?= $article->time ?></time>
                <h2 class="nospace font-x1 bold"><?= $article->title ?></h2>
                <p>
                    <?= $article->snipet ?>
                </p>
                <p class="nospace"><a href="<?= $article->url ?>">Voir plus &raquo;</a></p>
            </article>
            <?php endforeach; ?>

        </div>
    </section>
</div>

<div class="wrapper row">
    <section class="hoc container clear">
        <div class="center">
            <h3 class="font-x2 nospace">God First</h3>
            <small><?= $verse->reference ?></small>
            <p>
                <?= $verse->text ?>
            </p>
        </div>
    </section>
</div>


<div class="wrapper row3">
    <div class="hoc container clear">
        <div class="left btmspace-30">
            <h3 class="font-x2 nospace">Les dernières photos</h3>
            <p class="nospace">Retrouvez l'integralité de nos photos dans <a href="#">la gallerie</a>.</p>
        </div>
        <ul class="nospace group btmspace-50 elements">
            <?php $class = ["first","",""]; foreach($photos as $key => $photo): ?>
                <li class="one_third btmspace-30 <?= $class[$key%3] ?>">
                    <figure>
                        <a href="<?= $photo->url ?>">
                            <img src="<?= $photo->thumbUrl ?>" alt="<?= $photo->name ?>" title="<?= $photo->name ?>">
                        </a>
                        <figcaption>
                            <a href="<?= $photo->shareUrl ?>" class="fl_right"><i class="icon icon-thumbs-up"></i></a>
                            <a href="<?= $photo->likesUrl ?>" class="fl_right"><i class="icon icon-thumbs-up"></i> 4</a>
                            <a href="<?= $photo->commentUrl ?>" class="fl_right"><i class="icon icon-thumbs-up"></i> 34</a>
                        </figcaption>
                    </figure>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="nospace center"><a class="btn" href="#">Voir la gallerie</a></p>
        <div class="clear"></div>
    </div>
</div>
