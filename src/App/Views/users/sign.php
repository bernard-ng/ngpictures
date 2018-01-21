<div class="card-panel mt-30" id="signUpBox">
    <div class="page-content mb-20">
        <div class="section-title">Inscription</div>
    </div>
   <form method="POST" action="/sign">
        <div class="input-field"">
            <input type="text"  name="name" placeholder="pseudo (nom d'utilisateur)" id="name" value="<?= htmlspecialchars($post->get('name')); ?>">
        </div>

        <div class="input-field"">
            <input type="email"  name="email" placeholder="adresse mail" id="email" value="<?= htmlspecialchars($post->get('email')); ?>">
        </div>

        <div class="input-field">
            <input type="password" name="password" placeholder="nouveau mot de passe" id="password">
        </div>

        <div class="input-field">
            <input type="password"  name="password_confirm" placeholder="confirmez le mot de passe" id="password_confirm">
        </div>

        <div class="row">
            <div class="col s12">
                <p> En créant votre compte vous affirmez avoir lu et accepter nos
                    <a href="/privacy">Conditions d'utilisation</a>
                </p>
            </div>
            <br>
            <div class="col s12" id="signOptions">
                <button type="submit-sign" class="ng-btn waves-effect waves-light" id="sign" >Inscription</button>
            </div>
        </div>
   </form>
    <div class="page-content" style="color:#fff" >
        <p>connectez-vous ou créez un compte rapidement en utlisant facebook, cela vous permettra
        de recevoir des notifications et de rester synchro avec Nous</p>
        <div class="mt-20" >
            <a class="link-btn" href="facebook/connect/">Inscription avec facebook &nbsp;<i class="social social-facebook-1"></i></a>
        </div>
    </div>

</div>