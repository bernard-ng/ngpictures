<div class="card-panel z-depth-4  mt-30" id="loginBox" >
    <div class="page-content mb-20">
        <span class="section-title">Connexion</span>
    </div>
    <form method="POST" action="/login">
        <input type="text" id="name" name="name" placeholder="Pseudo ou adresse mail" value="<?= htmlspecialchars($post->get('name')); ?>" >
        <input type="password" name="password" id="password" placeholder="Mot de passe" >
        
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
    <div class="page-content">
    </p>connectez-vous ou créez un compte plus rapidement en utlisant facebook, cela vous permettra
    de recevoir des notifications et de rester synchro avec Nous</p>
    <div class="mt-30" >
        <a class="link-btn" href="facebook/connect">Connexion avec facebook &nbsp;<i class="social social-facebook-1"></i></a>
    </div>
</div>
</div>    
