<div class="card-panel dark z-depth-4  mt-30" id="loginBox" >
    <div class="container row">
        <h2 class="ui header">Donner votre avis</h2>
        <p>
            Aidez ngpictures à aller de l'avant, donner une idée sur ce qui n'est pas disponible mais que vous voudriez
            Dites nous ce que nous pouvons améliorer pour votre bonne expériance.
        </p>

        <form method="POST" action="/ideas" data-action="ideas">
            <div class="input-field">
                <label for="ideas">Votre Avis</label>
                <textarea name="ideas" id="ideas" class="mdz-textarea materialize-textarea validate <?= $errors->get('ideas')? 'invalid': '' ?>"><?= $post->get('ideas') ?></textarea>
                <span class="helper-text red-txt" style="padding-top: -25px;"><?= $errors->get('ideas'); ?></span>
            </div>

            <button type="submit" class="btn btn-flat waves-effect">envoyer</button>
        </form>
    </div>
</div>
