<div class="card-panel z-depth-4  mt-30" id="loginBox" >
    <div class="page-content mb-20">
        <span class="section-title">Mot de passe oublié</span>
        <p>
            Veuillez renseigner l'adresse mail avec laquelle vous vous étiez inscrit,
            si vous l'aviez fait avec facebook, essayez de vous connecter avec facebook
        </p>

    </div>
    <form method="POST" action="">
        <input type="email" id="email" name="email" placeholder="adresse mail" value="<?= $post->get('email') ?>" >

        <div class="row">
            <div class="col s12" id="connectOptions">
                <button type="submit" class="btn action-btn waves-effect waves-light" id="connect">confirmer</button>
            </div>
        </div>
    </form>
</div>
