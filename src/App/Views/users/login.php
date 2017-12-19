
<!-- ==================== LOGIN BOX ============================== -->
<div class="card-panel z-depth-4" id="loginBox" >
    <form method="POST" action="/login">
        <input 
            type="text" 
            id="name" 
            name="name"
            placeholder="Pseudo ou adresse mail"
            value="<?= isset($post)? $post->getWhenSet('name') : null ?>"  
            required 
        >
    
        <input 
            type="password" 
            name="password" 
            id="password" 
            placeholder="Mot de passe"
            required 
        >
        
        <div class="row">
            <div class="col s12" id="cookieOptions">
                <input type="checkbox" class="filled-in cyan darken-2" id="remember" name="remember" value='1' />
                <label for="remember">Restez connecté</label>
            </div>

            <div class="col s12" id="connectOptions">
                <button type="submit" class="btn action-btn waves-effect waves-light" id="connect">Connexion</button>
                <a class="btn waves-effect waves-light feed-btn blue" href="facebook/connect/" id="connect">se connecter avec Facebook</a>
                <a href="/forgot" class="forgot">Mot de passe oublié</a>
            </div>
        </div>
    </form>
</div>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1951395041776982',
      cookie     : true,
      xfbml      : true,
      version    : '2.11'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>