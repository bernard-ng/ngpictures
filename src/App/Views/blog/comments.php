<?php 
session_start();
require "../php/fonction/functions.php";
$base= base_connexion('ngbdd');


if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{
	if(isset($_GET['id']) and !empty($_GET['id']))
	{
		$getID=htmlspecialchars($_GET['id']);
		$news=$base->prepare("SELECT * FROM ngarticle WHERE id=?");
		$news->execute(array($getID));
		
		$verif =htmlspecialchars($_SESSION['id']);
		$user=$base->prepare("SELECT * FROM membres WHERE id=?");
		$user->execute(array($verif));
		$user= $user->fetch();
						
		if($news->rowcount() ==1)
		{
			$news = $news->fetch();
			$titre= $news['titre'];
			$contenu= $news['contenu'];
			$articleID= $news['id'];
			$poster= poster_pseudo($news['posterID']);
								 	
			if(isset($_POST['cmtSubmit'])) 
			{
				
				if(isset($_POST['commentaire'],$_SESSION['id']) and !empty ($_POST['commentaire']) and !empty($_SESSION['id']))
				{  						
					
					$commentaire=htmlspecialchars($_POST['commentaire']);
					$ID=htmlspecialchars($_GET['id']);
					$userID= htmlspecialchars($_SESSION['id']);
					
					
					$insert= $base->prepare("insert into ngcommentaire (commentaire,articleID,userID,date_pub) values (?,?,?,now()) ");
					$insert->execute(array($commentaire,$articleID,$userID));
					$msg="votre commentaire a bien ete poste";
					$type="alert-success";
												
				}
				else{
					$msg="completez le champ";
					$type="alert-danger";
				}
				
			}	
			$commentaire= $base->prepare("SELECT * FROM ngcommentaire WHERE articleID=? ORDER BY date_pub ASC ");
			$commentaire->execute(array($articleID));

			$comN = $base->prepare("SELECT * FROM ngcommentaire WHERE articleID= ? ");
			$comN->execute(array($articleID));
			$com = $comN ->rowcount();
							
		}
		else{
			$_SESSION['msg'] = "Cet article n'esxiste pas ou plus";
			$_SESSION['type'] = "alert-danger";
			header("location:/plus/erreur/404.php");
		}

	}else{
		$_SESSION['msg'] = "Erreur !";
		$_SESSION['type'] = "alert-danger";
		header("location:/plus/erreur/500.php"); } 

}else{

    header("location:/membres/login.php");
    $_SESSION['msg'] = "vous devez vous connecter!";
    $_SESSION['type'] = "alert alert-danger"; }

?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../require-files/favicon.php";?>
    <?php include '../require-files/all-meta.php'; ?>
	<title>Commentaire | <?= $titre ?></title>

	<link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
	<link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
	<link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
</head>
<body>
<section class="ng-bloc-principal">



<?php include "../require-files/ngarticle/menu.php"; ?>
<?php include "../require-files/flash.php"; ?>


<div class="jumbotron ng-margin-default">
    <div class="media">
        <div class="container">
            <div class="media-body" >
                <h2 id="page_title" class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Commentaires</h2>
                <span id="page_desc"> Salut <b><?= poster_pseudo($_SESSION['id']) ?></b>, voici les commentaires en rapport avec la publication que t'as choisi...
                </span>
            </div>
        </div>
    </div>
</div>



<?php include '../require-files/verset.php'; ?>

<div class="col-xs-12 col-sm-8 col-md-8 col-lg=8" >
	<div class="row">
		<div class="ng-panel panel-primary panel ng-panel-active">

		<div class="ng-panel panel-heading ng-margin-default">COMMENTAIRE<?= (ngarticle_info($articleID,"commentaire") > 1)? "S" : ""  ?> <span class="ng-badge badge"><?= $com ?></span></div>

		<ul class="list-group ng-margin-default">


			<?php while($c = $commentaire->fetch()) : ?>
				<li class="list-group-item"> 
					<div class="media">
					 	<div class="media-left media-top">
					    		<a href="/membres/profil.php?id=<?= $c['userID']?>">
					      		<img class="media-object img img-circle" src="/membres/Avatar/40-40/<?= poster_profil($c['userID'])?>" width="40" height="40">
					    		</a>
					  	</div>
					  	<div class="media-body">						  	
						    <a href="/membres/profil.php?id=<?= $c['userID']?>">
						    <h5 class="media-heading"><?= poster_pseudo($c['userID'])?></h5></a>
						    <h6><?= valid_text($c ['commentaire']) ?></h6>
						    <span class="pull-right">
						    <time>
						    <span class="glyphicon glyphicon-time"></span> <?= temps($c['date_pub'])?></time>
						    </span>
					  	</div>
					</div>
				</li>


			<?php endwhile; ?>
		</ul>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<div class="row">	
		<div class="ng-panel panel panel-primary">
			<div class="ng-panel panel-heading ng-margin-default" role="tab" >
				<span class="glyphicon glyphicon-comment"></span> REAGIR                                
		    </div>
	    	<div class="box box-primary ng-margin-default">
	            <div class="box-body">           
		            <form method="post" action="">
						<textarea class="textarea-default" rows="3" name="commentaire" placeholder="Votre commentaire"></textarea>

						<div class="box-footer clearfix">
							<span class="pull-right">
								<button type="submit" class="btn btn-primary btn-sm ng-btn-border" name="cmtSubmit" >Commenter</button>
								<button type="reset" class="btn btn-default btn-sm ng-btn-border" name="cmtSubmit" >Annuler</button>	
							</span>						
						</div>
					</form>
				</div>					
			</div>
		</div>  
	</div>
</div>

<div class="ng-espace-fantom"></div>
</section>
<?php include "../require-files/footer.php" ?>

<!--importation des script -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
	window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
	</script>
	<script src="/Mobile responsive/js/bootstrap.min.js"></script>
	<script src="/Mobile responsive/js/ng-alert-v2.js"></script>
	<script src="/Mobile responsive/js/velocity.min.js"></script>
    <script src="/Mobile responsive/js/ng-js/ng-app.js"></script>
<!-- /importation des script -->

</body>
</html>