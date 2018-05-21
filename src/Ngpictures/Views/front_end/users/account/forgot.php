<div class="card-panel z-depth-4 " id="loginBox" >
    <div class="row">
        <h2 class="ui header">Mot de passe oublié</h2>
        <p>
            Veuillez renseigner l'adresse mail avec laquelle vous vous étiez inscrit,
            afin d'obtenir les instruction de rappelle de mot de passe.
        </p>
    </div>
    <div class="row">
        <form method="POST" action="/forgot" data-action="forgot">
            <div class="input-field col s12">
                <label for="email">Votre adresse mail...</label>
                <input type="email" id="email" name="email" class="validate <?= $errors->get('email')? 'invalid' : '' ?>" value="<?= $post->get('email') ?>" >
                <span class="helper-text red-txt">
                    <?= $errors->get('email'); ?>
                </span>
            </div>

            <div class="col s12">
                <button type="submit" class="btn btn-flat waves-effect">Envoyer</button>
            </div>
        </form>
    </div>
</div>
