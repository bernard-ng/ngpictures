<div class="row col l4 m4 s12">
    <div class="card-panel hoverable" id="loginBox">
        <form method="POST" action="" data-action="login">
            <div class="row">
                <div class="input-field col s12">
                    <label for="name">Pseudo ou adresse mail</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($post->get('name')); ?>" class="validate <?= $errors->get('name')? 'invalid' : '' ?>">
                    <span class="helper-text red-txt">
                        <?= $errors->get('name') ?>
                    </span>
                </div>

                <div class="input-field col s12">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="valiate <?= $errors->get('password')? 'invalid' : '' ?>">
                    <span class="helper-text red-txt">
                        <?= $errors->get('password'); ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col s12" id="cookieOptions">
                    <input type="checkbox" class="filled-in cyan darken-2" id="remember" name="remember" value='1' />
                    <label for="remember">Restez connecté</label>
                </div>

                <div class="col s12" id="connectOptions">
                    <button type="submit" class="btn btn-flat waves-effect" id="connect">Connexion</button>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <a href="/forgot" class="forgot">Mot de passe oublié</a>
                </div>
            </div>
        </form>
    </div>
</div>
