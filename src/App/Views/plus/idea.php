<?php 
session_start();
require '../php/fonction/functions.php';
$base = base_connexion('ngbdd');

  if(isset($_SESSION['id']) and !empty($_SESSION['id'])){

    if(isset($_POST['submit_idee'])){

      if(!empty($_POST['idee'])){

        $userID = htmlspecialchars($_SESSION['id']);
        $idee = htmlspecialchars($_POST['idee']);
        $insert = $base->prepare('INSERT into idees(userID,idee,date_pub) values(?,?,now())');
        $insert->execute(array($userID,$idee));

        $_SESSION['msg'] = "Nous avons reçu votre idée";
        $_SESSION['type'] = "alert-success";
        header('location:/home.php');

      }else{
        $msg = "complétez le champ";
        $type = "alert-danger";
      }

    }

}else{

    $_SESSION['msg'] = "vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger";
    header('location:/membres/login.php');
}
  
?>
<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include '../require-files/favicon.php';?>
    <?php include '../require-files/all-meta.php'; ?>
    <title>Idees</title>

    <link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
    <link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/ng-style.css" rel="stylesheet" type="text/css" >
    <link href="/Mobile responsive/css/plus/idees.css" rel="stylesheet" type="text/css" >

</head>
<body>
<section class="ng-bloc-principal">

<?php include '../require-files/menu.php'; ?>
<?php include '../require-files/flash.php'; ?>



<!--BANNER -->
    <div class="banner">
        <div class="banner-black">
            <div class="media">
                <div class="media-body">
                    <h1 id="page_title" class="media-heading">Donner Une idée</h1>
                    <span id="page_desc">
                    <p>Salut <i><?= poster_pseudo($_SESSION['id']) ?></i>, Nous avons besoin de tes idées pour améliorer notre site, et pour faire des mis à jour</p>
                    </span> 
                </div>
            </div>              
        </div>
    </div>
<!-- /BANNER -->

<?php include '../require-files/verset.php'; ?>

<div class="container">
    <form action="#" method="POST">

        <div class="form-group">
            <textarea type="text" class="ng-textarea-default" id="idee" name="idee" placeholder="Votre idée..."><?php if(isset($_POST['id'])){ echo $_POST['id']; }?></textarea> 
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="reg-full-btn" name="submit_idee">Envoyer</button>
            </div>
        </div>

    </form>
</div>

<div class="ng-espace-fantom"></div>
</section>

<?php include '../require-files/footer.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
        window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
</script>
<script src="/Mobile responsive/js/bootstrap.min.js"></script>
<script src="/Mobile responsive/js/ng-alert-v2.js"></script>
<script src="/Mobile responsive/js/velocity.min.js"></script>
<script src="/Mobile responsive/js/ng-js/ng-app.js"></script>


</body>
</html>