<?php
session_start();
require "../../php/fonction/functions.php";
$base= base_connexion("ngbdd");

if(isset($_SESSION['id']) and !empty($_SESSION['id'])){

	$bleme = $base->query("SELECT * from problemes order by id desc");
	$Nb = $bleme->rowcount();

	if(isset($_GET['q']) and !empty($_GET['q'])){

		$q = htmlspecialchars($_GET['q']);
		$bleme = $base->query("SELECT * from problemes where concat(userID,probleme,date_pub,statut) like '%".$q."%' order by id desc ");
		$Nb = $bleme->rowcount();
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

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../../require-files/favicon.php";?>
	
    <title>Gestion problemes</title>
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
			    <h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>  Problèmes</h2>
			    disfoctionnement, bug et autres...
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
			PROBLEME<?= $t = ($Nb > 1)? "S" : " "  ?> 
			<span class="ng-badge badge"><?= $Nb ?></span></div>

			<?php if($bleme->rowcount() == 0){ ?>

			<div class="media">
				<div class="media-left media-top">
					<img src="/article/miniature/rien.jpg" class="img-responsive" > 
				</div>

				<div class="media-body">
					<h5 class="media-heading">aucun problème</h5>
					<h6>cool il y a aucun problème pour l'instant</h6>
					<span class="pull-right">
					<time><span class="glyphicon glyphicon-time"></span> <?= today_date() ?></time></span>
				</div>
			</div>
			                               
			<?php } else{ ?>


			<ul class="list-group ng-margin-default">
			<?php while($b = $bleme->fetch()){ ?>

			<li class="list-group-item"> 
				<div class="media">
					<div class="media-left media-top">
						<a href="/membres/profil.php?id=<?= $b['userID']?>">
							<img class="media-object img img-circle" src="/membres/Avatar/40-40/<?= poster_profil($b['userID'])?>" width="40" height="40">
						</a>
					</div>
					<div class="media-body">
						<a href="/membres/profil.php?id=<?= $b['userID']?>">
						<h5 class="media-heading"><?= poster_pseudo($b['userID'])?></h5></a>
						<h6><?= nl2br(user_mention_verif($b ['probleme'])) ?></h6>
						<span class="pull-right">
						<time><span class="glyphicon glyphicon-time"></span> <?= temps($b['date_pub'])?></time></span>
					</div>
				</div>

				<div class="btn-group btn-sm " role="group">
					<?php if($b['statut'] == 0 ){?>
					<button type="button" class="btn btn-default btn-sm">
						<a href="/admin/index.php?type=probleme&regler=<?= $b['id']; ?>">Règler</a>
					</button> 
					<?php }?>

					<button type="button" class="btn btn-default btn-sm">
						<a href="/admin/index.php?type=probleme&supprime=<?= $b['id']; ?>">supprimer</a>
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