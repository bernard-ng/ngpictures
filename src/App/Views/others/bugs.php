<div class="card-panel z-depth-4  mt-30" id="loginBox" >
    <div class="page-content">
        <span class="section-title">signaler un bug</span>
        <p>
            Vous avez rencontré un problème ? décrivez précisement ce que vous étiez en train de faire
            ou d'essayer de faire quand cela est arrivé.
        </p>

        <form method="POST" action="/bugs">
            <textarea name="bugs" id="bugs"><?= $post->get('bugs') ?></textarea>

            <div class="row">
                <div class="col s12" id="connectOptions">
                    <button type="submit" class="btn action-btn waves-effect waves-light" id="connect">envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>
