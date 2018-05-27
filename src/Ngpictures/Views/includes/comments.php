<div id="comments" class="section container row">

    <?php include(APP."/Views/includes/right-aside.php"); ?>
    <div class="col l6 m12 s12">
        <form method="POST" action="<?= $article->commentUrl; ?>">
            <div class="input-field">
                <label for="comment">Commentaire</label>
                <textarea name="comment" id="comment" class="materialize-textarea"></textarea>
            </div>
            <button type="submit" class="btn btn-flat"> Envoyer</button>
        </form>

        <ul class="section" id="commentContainer">
            <?php if(isset($comments) && !empty($comments)): ?>
                <div class="ui comments">
                    <?php foreach ($comments as $c): ?>
                        <div class="comment">
                            <a class="avatar">
                                <img src="<?= $user->find($c->users_id)->avatarUrl ?>">
                            </a>
                            <div class="content">
                                <a class="author"><?= $user->find($c->users_id)->name ?></a>
                                <div class="metadata">
                                    <time class="date" data-time="<?= strtotime($c->date_created) ?>"><?= $c->time ?></time>
                                </div>
                                <div class="text">
                                    <?= $c->comment ?>
                                </div>
                                <div class="actions">
                                    <a href="/watchout/comments/<?= $c->id ?>">Signaler</a>
                                    <?php if($activeUser && $c->users_id == $activeUser->id): ?>
                                        <a href="#cmtDelete-<?= $c->id ?>" class="">Supprimer</a>
                                        <a href="#cmtEdit-<?= $c->id ?>" class="">Editer</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="section center-align">
                    <h2 class="icon icon-comment-empty red-txt center-align"></h2>
                    <h2 class="ui header divided center"> Aucun commentaire pour l'instant</h2>
                    <p>
                        le site ne présente actuellement aucun commentaire disponible pour cette publication, soyez la première
                        personne à partager votre commentaire.
                    </p>
                </div>
            <?php endif; ?>
        </ul>
    </div>
    <?php include(APP."/Views/includes/menu-aside.php"); ?>
</div>
