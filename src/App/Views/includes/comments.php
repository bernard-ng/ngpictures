<div class="card-panel row comments-card">
    <div class="col l12 m12 s12">
        <span class="section-title"><i class="social social-comment"></i> Commentaire </span>
        
        <form method="POST" action="<?php echo $article->commentUrl; ?>"> 
            <div class="default-form">
                <textarea placeholder="Votre commentaire..." name="comment" ></textarea>
            </div>
            <button type="submit" class="ng-btn"> Envoyer</button>
        </form>
        
        <div class="mt-30">
            <span class="section-title"><i class="social social-chat"></i> Les commentaires </span>
            <span class="badge new"><?= $nb_comment ?></span>
        </div>
        
        <ul class="collection" id="commentContainer">
            <?php if (!empty($comments)): ?>
                <?php foreach($comments as $c) : ?>
                    <li class="collection-item avatar" id="<?= $c->id ?>">
                        <img src="/imgs/default.JPG" class="circle">
                        <span class="title">
                            <a href="<?= $user->find($c->user_id)->accountUrl; ?>">
                                    <?= $c->username; ?>
                            </a>
                        </span>
                        <p><?= $c->comment ?></p>
                        <p><time  class="secondary-content-b" data-time="<?= strtotime($c->date_created) ?>"><?= $c->time ?></time></p>   
                    
                        <?php if ($session->read('auth') && $session->getValue('auth','id') == $c->user_id): ?>
                            <a href="#cmtDel-<?= $c->id ?>" class="secondary-content modal-trigger">
                                <i class="icon icon-trash"></i>
                            </a>
                            <a href="#cmtEdit-<?= $c->id ?>" class="secondary-content mr-20 modal-trigger">
                                <i class="icon icon-edit"></i>
                            </a>

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
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="collection-item avatar">
                    <img src="/imgs/default.JPG" alt="" class="circle">
                    <span class="title"><b>Ngpictures</b></span>
                    <p>aucun commentaire, soyez la première personne à réagir</p>
                </li>
            <?php endif; ?>
        </ul>
        <?php if ($nb_comment > 3) : ?>
            <div class="feed-btn waves-effect waves-light hoverable" id="comments" data-type="3">Voir tout</div>
        <?php endif; ?>
    </div>
</div>