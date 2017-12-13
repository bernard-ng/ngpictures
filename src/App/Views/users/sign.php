<div class="jumbotron">
    <div class="container row">
        <span class="jumbotron-title"><i class="icon icon-user"></i> Inscription</span>
        <span class="jumbotron-content">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </span>
    </div>
</div>

<div class="row container">
<div class="col l6 s12 offset-m1 offset-l1">
    <div class="card-panel" id="signUpBox">
       <form method="POST" action="/sign">
            <div class="input-field" id="s2">
                <label for="name">Nom d'utilisateur (Pseudo)</label>
                <input type="text" required name="name" id="name" value="<?= $post->get('name') ?>">
            </div>

            <div class="input-field" id="s3">
                <label for="email">Adresse mail</label>
                <input type="email" required name="email"  id="email" value="<?= $post->get('email') ?>">
            </div>

            <div class="input-field" id="s4">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" required  name="password"  id="password">
            </div>

            <div class="input-field" id="s4">
                <label for="password_confirm">Confirmez le mot de passe</label>
                <input type="password" required name="password_confirm"  id="password_confirm">
            </div>

            <div class="input-field" id="s5">
                <img src="imgs/captcha.php">
                <input type="text" required placeholder="code captcha" name="captcha">
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
<div class="col xl4 l4 m12 s12 social-connect">
    <h3>Pourquoi avoir un compte ?</h3>
    Vous pouvez maintenant vous connecter rapidement et plus facilement avec un résaux social
    et profiter de la version 2.0 de ngpictures :) <br>
    </div>
</div>
</div>

