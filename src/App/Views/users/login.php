<div class="jumbotron">
    <div class="ng-cover"></div>
    <div class="container row">
        <span class="jumbotron-title"><i class="icon icon-lock"></i> Connexion</span>
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
    <!-- ==================== LOGIN BOX ============================== -->
    <div class="card-panel z-depth-4" id="loginBox">
        <form method="POST" action="/login">
            <div class="input-field" id="l1">
                <label for="name">Pseudo ou email</label>
                <input type="text" id="name" name="name" required="required" value="<?= isset($post)? $post->getWhenSet('name') : null ?>">
            </div>

            <div class="input-field" id="l2">
                <label for="password">Mot de passe </label>
                <input type="password" name="password" id="password" required="required">
            </div>

            <div class="row">
                <div class="col s12" id="cookieOptions">
                    <input type="checkbox" class="filled-in cyan darken-2" id="remember" name="remember" value='1' />
                    <label for="remember">Restez connecté</label>
                </div>

                <div class="col s12" id="connectOptions">
                    <button type="submit" class="btn action-btn waves-effect waves-light" id="connect">Connexion</button>
                    <a href="/forgot" class="forgot">Mot de passe oublié</a>
                </div>
            </div>
        </form>
    </div>
    <!-- ==================== LOGIN BOX ============================== -->
</div>
<div class="col xl4 l4 m12 s12 social-connect">
    <h3 >Se connecter avez un résaux social</h3>
    Vous pouvez maintenant vous connecter rapidement et plus facilement avec un résaux social
    et profiter de la version 2.0 de ngpictures :) <br>
        <button class="btn waves-effect waves-light feed-btn blue" id="connect">se connecter avec Facebook</button>
        <button class="btn waves-effect waves-light feed-btn red " id="connect">se connecter avec Gmail</button>
    </div>
</div>
</div>