<div id="comments" class="card-panel transparent row">
    <div class="col l12 m12 s12">
        <form method="POST" action="<?= $article->commentUrl; ?>">
            <div class="input-field">
                <label for="comment">Commentaire</label>
                <textarea name="comment" id="comment" class="mdz-textarea"></textarea>
            </div>
            <button type="submit" class="btn"> Envoyer</button>
        </form>

        <ul class="collection section" id="commentContainer">
            <div class="ui comments">
            <?php if (!empty($comments)) : ?>
                <?php foreach ($comments as $c) : ?>
                    <div class="comment" id="<?= $c->id ?>">
                        <a class="avatar">
                            <img src="<?= $user->find($c->users_id)->avatarUrl ?>" class="circle responsive-img">
                        </a>
                        <div class="content">
                            <a class="author" href="<?= $user->find($c->users_id)->accountUrl; ?>"><?= $c->name; ?></a>
                            <div class="metadata">
                                <time data-time="<?= strtotime($c->date_created) ?>" class="date"><?= $c->time ?></time>
                            </div>
                            <div class="text">
                                <?= $c->comment ?>
                            </div>
                            <?php if ($activeUser && $activeUser->id == $c->users_id) : ?>
                               <div class="actions">
                                   <a href="#cmtDel-<?= $c->id ?>" class="reply modal-trigger">Supprimer</a>
                                   <a href="#cmtEdit-<?= $c->id ?>" class="reply modal-trigger">Editer</a>
                               </div>

                               <div id="cmtDel-<?= $c->id ?>" class="modal">
                                   <div class="modal-content">
                                       <span class="section-title-b mb-20">Supprimer</span>
                                       <p>Voulez vous vraiment supprimer ce commentaire ?</p>
                                   </div>
                                   <div class="modal-footer">
                                       <a href="<?= $c->deleteUrl ?>" class="modal-action btn primary-b">
                                           Oui
                                       </a>
                                       <button id="cmtDel-<?= $c->id ?>" class="modal-action modal-close btn-flat">
                                           Annuler
                                       </button>
                                   </div>
                               </div>
                               <div id="cmtEdit-<?= $c->id ?>" class="modal">
                                   <div class="modal-content">
                                       <span class="section-title-b mb-20">Editer</span>
                                       <form action="<?= $c->editUrl ?>" method="POST">
                                           <div class="input-field">
                                               <textarea class="materialize-textarea" name="comment_edit"><?= $c->comment ?></textarea>
                                           </div>
                                           <div class="modal-footer">
                                               <button type="submit" class="modal-action btn primary-b">ok</button>
                                               <button id="cmtEdit-<?= $c->id ?>" type="reset" class="modal-action modal-close btn-flat">
                                                   Annuler
                                               </button>
                                           </div>
                                       </form>
                                   </div>
                               </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
            <?php endif; ?>
            </div>
        </ul>
    </div>
</div>
