<div class="gallery-container-details">
    <div class="col l6 m6 s12 gallery-details-img stagger3">
        <img src="<?= $photo->thumbUrl ?>" width="100%" alt="<?= $photo->name ?? $photo->title ?>" class="boxed">
    </div>
    <div class="col l6 m6 s12 gallery-details-text">
        <h2 class="ui header stagger1"><?= $photo->name ?? $photo->title ?></h2>
        <span class="gray-txt stagger2">
            <?= $photo->description ?>
        </span>
    </div>
</div>
<article class="col l6 m6 s12" id="<?= $photo->id ?>" style="background: #100F0F">
    <section class="news-card-contents">
        <footer id="articleInfo">
            <div class="news-card-stat">
                <i class="icon icon-calendar"></i>&nbsp;
                <time id="date_created" data-time="<?= strtotime($photo->date_created) ?>"><?= $photo->time ?></time>
            </div>
            <div class="news-card-stat">
                <i class="icon icon-thumbs-up"></i>&nbsp;
                <small><a data-action="showLikes" href="<?= $photo->LikersUrl; ?>"><?= $photo->Likes ?></a></small>
            </div>
        </footer>
    </section>
    <footer class="news-card-footer" id="articleOptions">
        <a data-action="like" class="news-card-footer-item <?= $photo->isLike ?>" href="<?= $photo->likeUrl ?>">
            <?php if ($photo->isLike == 'active') : ?>
                <i class="icon icon-heart red-txt"></i>
            <?php else : ?>
                <i class="icon icon-heart-empty"></i>
            <?php endif; ?>
        </a>
        <a class="news-card-footer-item modal-trigger" href="#cmtAdd-<?= $photo->id ?>" data-action="showComment">
            <?php if ($photo->commentsNumber > 0) : ?>
                <i class="icon icon-comment" ></i>&nbsp;
            <?php else : ?>
                <i class="icon icon-comment-empty" ></i>&nbsp;
            <?php endif; ?>
            <span><?= $photo->commentsNumber ?></span>
        </a>
        <a data-action="share" class="news-card-footer-item modal-trigger" href="#share-<?= $photo->id ?>">
            <i class="icon icon-share"></i>
        </a>
    </footer>
    <div id="cmtAdd-<?= $photo->id ?>" class="modal dark bottom-sheet">
        <div class="modal-content">
            <form action="<?= $photo->commentUrl ?>" method="POST" data-action="comment">
                <div class="input-field">
                    <label for="comment">Commentaire</label>
                    <textarea class="mdz-textarea" name="comment" id="comment" data-length="255"></textarea>
                </div>
                <div class="modal-footer dark comment">
                    <button type="submit" class="modal-action btn waves-effect">Envoyer</button>
                    <button id="cmtAdd-<?= $photo->id ?>" type="reset" class="btn btn-small transparent waves-effect modal-action modal-close">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
    <p>
        <a href="<?= $photo->downloadUrl ?>" class="btn btn-flat">Télécharger</a>
    </p>
</article>
