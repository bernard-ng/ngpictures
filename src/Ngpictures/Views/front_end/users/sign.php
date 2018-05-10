<div class="row col l4 m4 s12">
    <div class="card-panel hoverable" id="signUpBox">
        <form method="POST" action="">
            <div class="row">
                <div class="input-field col s12">
                    <label for="name">pseudo (nom d'utilisateur)</label>
                    <input type="text"  name="name" id="name" class="validate <?= $errors->get('name')? 'invalid' : '' ?>" value="<?= $post->getSafe('name') ?>">
                    <span class="helper-text red-txt">
                        <?= $errors->get('name') ?>
                    </span>
                </div>

                <div class="input-field col s12">
                    <label for="email">adresse mail</label>
                    <input type="text"  name="email" id="email" class="validate <?= $errors->get('email')? 'invalid' : '' ?>" value="<?= $post->getSafe('email') ?>">
                    <span class="helper-text red-txt">
                        <?= $errors->get('email') ?>
                    </span>
                </div>

                <div class="input-field col s12">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="validate <?= $errors->get('password')? 'invalid' : '' ?>">
                    <span class="helper-text red-txt">
                        <?= $errors->get('password') ?>
                    </span>
                </div>

                <div class="input-field col s12">
                    <label for="password_confirm">Mot de passe (confirmer)</label>
                    <input type="password"  name="password_confirm" id="password_confirm" class="<?= $errors->get('password_confirm')? 'invalid' : '' ?>">
                    <span class="helper-text red-txt">
                        <?= $errors->get('password_confirm') ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <p> En créant votre compte vous affirmez avoir lu et accepter nos
                        <a href="/privacy">Conditions d'utilisation</a>
                    </p>
                </div>
                <div class="input-field col s12">
                    <button type="submit-sign" class="btn btn-flat" id="sign" >Inscription</button>
                </div>
            </div>
        </form>
    </div>
</div>