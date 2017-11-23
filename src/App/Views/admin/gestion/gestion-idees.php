<?php
session_start();
require "../../php/fonction/functions.php";
$base= base_connexion("ngbdd");

if(isset($_SESSION['id']) and !empty($_SESSION['id'])){

	$idee = $base->query("SELECT * from idees order by id desc");
	$Nb = $idee->rowcount();

	if(isset($_GET['q']) and !empty($_GET['q'])){

		$q = htmlspecialchars($_GET['q']);
		$idee = $base->query("SELECT * from idees where concat(userID,idee,date_pub,confirme) like '%".$q."%' order by id desc ");
		$Nb = $idee->rowcount();
	}

}
else{

	$_SESSION['msg'] = "vous devez vous connecter !";
	$_SESSION['type'] = "alert-danger";
	header("location:/membres/login.php");
}
?>
<!DOCTYPE html>
<html>
<head>

	<?php include '../../require-files/favicon.php';?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />

	<title>Gestion idees</title>
	
	<link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
	<link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
	<link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
</head>
<body>
<section class="ng-bloc-principal">

<?php include '../../require-files/admin/menu.php'; ?>
<?php include '../../require-files/flash.php'; ?>

<div class="jumbotron ng-margin-default">
<div class="media">
	<div class="container">
		<div class="media-body" >
		    <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Idées</h2>
		    les idées pour les prochaines versions...
		</div>
	</div>
</div>     
</div>

<div class="col-lg-4 col-md-4 col-xs-12 col-sm-4">
<div class="row">
	<div class="container-fluide">
		<form class="input-group ng-panel-info " method="get" action=" ">
			<input name="q" type="text" class="form-control" placeholder="Recherche...">
			<span class="input-group-btn" >
				<button  type="submit" value="Go" class="btn btn-primary ng-input" type="button">
				<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
				</button>
			</span>
		</form>
	</div>
</div>
</div>

<div class="col-xs-12 col-sm-8 col-md-8 col-lg=8" >
<div class="row">
	<div class="ng-panel panel-default panel ng-panel-active">
		<div class="ng-panel panel-heading ng-margin-default">
		IDEE<?= $t = ($Nb > 1)? "S" : " "  ?> <span class="ng-badge badge"><?= $Nb ?></span></div>

		<?php if($idee->rowcount() == 0){ ?>

		<div class="media">
				<div class="media-left media-top">
					<img src="/article/miniature/rien.jpg" class="img-responsive" > 
				</div>
				<div class="media-body">
					<h5 class="media-heading">aucune idée</h5>
					<h6>ils manquent d'inspiration :)</h6>
					<span class="pull-right">
					<time><span class="glyphicon glyphicon-time"></span> <?= today_date() ?></time></span>
				</div>
		</div>
		                               
		<?php } else{ ?>

		<ul class="list-group ng-margin-default">
		<?php while($ids = $idee->fetch()){ ?>

		<li class="list-group-item ng-margin-default"> 
			<div class="media">
				<div class="media-left media-top">
					<a href="/membres/profil.php?id=<?= $ids['userID']?>">
						<img class="media-object img img-circle" src="/membres/Avatar/40-40/<?= poster_profil($ids['userID'])?>" width="40" height="40">
					</a>
				</div>
				<div class="media-body">
					<a href="/membres/profil.php?id=<?= $ids['userID']?>">
					<h5 class="media-heading"><?= poster_pseudo($ids['userID'])?></h5></a>
					<h6><?= nl2br(user_mention_verif($ids ['idee'])) ?></h6>
					<span class="pull-right">
					<time><span class="glyphicon glyphicon-time"></span> <?= temps($ids['date_pub'])?></time></span>
				</div>
			</div>
			<div class="btn-group btn-sm " role="group">

		        <?php if($ids['confirme'] == 0 ){?>
		        <button type="button" class="btn btn-default btn-sm">
		                    <a href="/admin/index.php?type=idee&confirme=<?= $ids['id']; ?>">confirme</a>
		        </button> 
		        <?php }?>

		        <button type="button" class="btn btn-default btn-sm">
		                    <a href="/admin/index.php?type=idee&supprime=<?= $ids['id']; ?>">supprimer</a>
		        </button>

		        </div>  
		        
		</li>

		<?php } ?>
		</ul>
		<?php } ?>


	</div>
</div>
</div>

</section>

<?php include "../../require-files/footer.php" ?>


<!--importation des script -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script>
      window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
      </script>
      <script src="/Mobile responsive/js/bootstrap.min.js"></script>
      <script src="/Mobile responsive/js/ng-alert-V2.js"></script>
<!-- /importation des script -->

</body>
</html>