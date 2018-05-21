<div class="card-panel z-depth-4" id="loginBox" >
    <div class="row">
        <h2 class="ui header">Signaler un Bug</h2>
        <p>
            Vous avez rencontré un problème ? décrivez précisement ce que vous étiez en train de faire
            ou d'essayer de faire quand cela est arrivé.
        </p>

        <form method="POST" action="/bugs" data-action="bugs">
            <div class="input-field">
                <label for="bugs">Votre Bug...</label>
                <textarea name="bugs" id="bugs" class="mdz-textarea materialize-textarea validate <?= $errors->get('bugs')? 'invalid' : '' ?>"><?= $post->get('bugs') ?></textarea>
                <span class="helper-text red-txt">
                    <?= $errors->get('password'); ?>
                </span>
            </div>
            <button type="submit" class="btn btn-flat waves-effect">Envoyer</button>
        </form>
    </div>
</div>
