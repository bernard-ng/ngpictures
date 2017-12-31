<div class="card-panel z-depth-4  mt-30" id="loginBox" >
    <div class="page-content">
        <span class="section-title">Donner une idée</span>
        <p>
            Aidez ngpictures à aller de l'avant, donner une idée sur ce qui n'est pas disponible mais que vous voudriez
            Dites nous ce que nous pouvons améliorer pour votre bonne expériance.
        </p>

        <form method="POST" action="/ideas">
            <textarea name="ideas" id="ideas"><?= $post->get('ideas') ?></textarea>

            <div class="row">
                <div class="col s12" id="connectOptions">
                    <button type="submit" class="btn action-btn waves-effect waves-light" id="connect">envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>
