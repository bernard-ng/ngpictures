<div class="row container">
    <div class="col l6 s12">
        <div class="card-panel" id="signUpBox">
           <form method="POST" action="/sign">
                <div class="input-field" id="s2">
                    <label for="name">Nom d'utilisateur (Pseudo)</label>
                    <input type="text"  name="name" id="name" value="<?= $post->get('name') ?>">
                </div>

                <div class="input-field" id="s3">
                    <label for="email">Adresse mail</label>
                    <input type="email"  name="email"  id="email" value="<?= $post->get('email') ?>">
                </div>

                <div class="input-field" id="s4">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password"   name="password"  id="password">
                </div>

                <div class="input-field" id="s4">
                    <label for="password_confirm">Confirmez le mot de passe</label>
                    <input type="password"  name="password_confirm"  id="password_confirm">
                </div>

                <div class="input-field" id="s5">
                    <img src="/imgs/captcha.php">
                    <input type="text"  placeholder="code captcha" name="captcha">
                </div>

                <div class="row">
                    <div class="col s12">
                        <p> En créant votre compte vous affirmez avoir lu et accepter nos
                            <br><a href="/privacy">Conditions d'utilisation</a>
                        </p>
                    </div>
                    <div class="col s12" id="signOptions">
                        <button type="submit-sign" class="btn waves-effect waves-light" id="sign" >Créer un compte</button>
                        <a href="/login" class="btn waves-effect waves-light" name="connect" id="connect">J'ai déja un compte</a>
                    </div>
                </div>
           </form>
        </div>
    </div>
</div>


