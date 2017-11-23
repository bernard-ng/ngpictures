<?php 
session_start();
require "../php/fonction/functions.php";
$base = base_connexion("ngbdd");

if(isset($_SESSION['id']) and !empty($_SESSION['id'])){

	if(isset($_GET['id']) and !empty($_GET['id']))
	{
		$getID=htmlspecialchars($_GET['id']);

		$news=$base->prepare("SELECT * FROM nggalerie WHERE id=?");
		$news->execute(array($getID));

		if($news->rowcount() ==1)
		{
			$news = $news->fetch();
			$tags= $news['tags'];
			$photoID= $news['id'];
			$posterID = ngphoto_info($photoID,"posterID");
			$date= $news['date_pub'];
			
			if(isset($_POST['cmtSubmit'])) 
			{
				
				if(isset($_POST['commentaire']) and !empty($_POST['commentaire']))
				{  
					$commentaire=htmlspecialchars($_POST['commentaire']);
					$ID=htmlspecialchars($getID);
					$userID= htmlspecialchars($_SESSION['id']);

					$insert= $base->prepare("INSERT into ngcommentaire (commentaire,photoID,userID,date_pub) values (?,?,?,now()) ");
					$insert->execute(array($commentaire,$ID,$userID));

					$msg="votre commentaire à bien été posté";
					$type="alert-success";
				
				}
				else{
					$msg="complétez le champ";
					$type= "alert-danger";
				}

			}//else{ rien a faire ;}

		}
		else{ header("location:../plus/erreur/404.php"); }

	}
	else{ header("location:../plus/erreur/500.php"); } 

}else{
   
    $_SESSION['msg'] = "vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger";
    header("location:../membres/login.php");} 	
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<?php include "../require-files/favicon.php";?>
	<?php include '../require-files/all-meta.php'; ?>
	<title>Commentaire</title>

	<link rel="stylesheet" href="../Mobile responsive/css/AdminLTE.min.css">
	<link href="../Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
	<link href="../Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >
	<title>PHOTO</title>
	<link rel="stylesheet" href="../Mobile responsive/css/AdminLTE.min.css">
	<link href="../Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
	<link href="../Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >

</head>
<body>
<section class="ng-bloc-principal">

<?php include "../require-files/menu.php";?>
<?php include "../require-files/flash.php";?>

<!-- article -->
<div class="ng-article">
	<div class="row" >
	<br>
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">               
		      <div class="media">
		            <div class="media-body">		                                       
		                  <p class="text-left"><?= valid_text($tags)?></p>
		            </div>
		      </div>
		</div>
		<br>
		<div class="ng-article-img"> 
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-md-8 col-lg-8">
				<div class="row">
					<div class="card--date">
						
						<div class="card--date--day"><?= ng_date($date)?></div>
						<div class="card--date--month"><?= ng_month($date);?></div>
					</div>
					<center>
					<img src="ngimages/640-640/<?= ngphoto_min($photoID)?>"/>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /article -->

<!-- commentaire system-->	
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
		<div class="row">	
			<div class=" ng-panel panel panel-primary ng-panel-active ">
		            <div class="ng-panel panel-heading ng-margin-default" role="tab" >                  
		                  <span class="glyphicon glyphicon-chevron-right"></span> MON AVIS               
		            </div>
		            
		            <ul class="list-group ng-margin-default">

		            <li class="list-group-item  ">
						<a class="btn btn-primary btn-xs ng-btn" href="../php/script/download.php?type=ngphoto&n=<?= ngphoto_min($photoID)?>" role="button"><span class="glyphicon glyphicon-save"></span></a> Télécharger

					</li>
		            <li class="list-group-item  ">
						<a class="btn btn-primary btn-xs ng-btn" href="../php/script/like.php?type=ngphoto&t=1&id=<?= $getID ?>" role="button"><span class="glyphicon glyphicon-thumbs-up"></span></a> <?= check_nglikep_statut($photoID,$_SESSION['id']) ?> 
						<span class="ng-badge badge"><?= KM_format(ngphoto_info($photoID,"like")) ?></span> 
					</li>
					<li class="list-group-item "> 
						<a class="btn btn-primary btn-xs ng-btn" href="../php/script/like.php?type=ngphoto&t=2&id=<?= $getID ?>" role="button"><span class="glyphicon glyphicon-thumbs-down"></span></a> <?= check_ngdislikep_statut($photoID,$_SESSION['id']) ?> 
						<span class="ng-badge badge"><?= KM_format(ngphoto_info($photoID,"dislike")) ?></span> 	
							
					</li>
					<li class="list-group-item ">
						 <a class="btn btn-primary btn-xs ng-btn" href="/php/script/like.php?type=ngphoto&t=3&id=<?= $getID ?>" role="button"><span class="glyphicon glyphicon-heart"></span></a> <?= check_nglovep_statut($photoID,$_SESSION['id']) ?> <span class="ng-badge badge"><?= KM_format(ngphoto_info($photoID,"love")) ?></span>    
						    
					</li>
					<li class="list-group-item ng-margin-default">	
                    <a  href="/galerie/mentions.php?type=ngphoto&id=<?= $getID ?>" role="button"><span class="glyphicon glyphicon-chevron-down"></span> voir les mentions</a>
					</li>
					
				</ul>
				
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
<!-- / fin comment et like systeme -->

<!-- affichage des 3 dernier commentaire -->
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<div class="row">
		<div class="ng-panel panel panel-primary">
			<div class="ng-panel panel-heading ng-margin-default" role="tab" >		                                     
		            <span class="glyphicon glyphicon-chevron-right"></span>  COMMENTAIRE<?= $t = (photo_info($photoID,"commentaire") > 1)? "S" : "" ?> 
		            <span class="ng-badge badge"><?= KM_format(ngphoto_info($photoID,"commentaire"))?></span>		                                
		    	</div>
		<?php 

			$commentaire= $base->prepare("SELECT * from ngcommentaire where photoID= ? order by date_pub desc limit 0,3");
			$commentaire->execute(array($photoID));
			$Nc = $commentaire->rowcount(); ?>
		 

<?php if($Nc >= 1){

	while($c = $commentaire->fetch()){ ?>

		<ul class="list-group">

			<li class="list-group-item ng-border"> 
				<div class="media">
				 	<div class="media-left media-top">
				    		<a href="/membres/profil.php?id=<?= $c['userID']?>">
				      		<img class="media-object img img-circle" src="/membres/Avatar/40-40/<?= poster_profil($c['userID'])?>" width="40" height="40">
				    		</a>
				  	</div>
				  	<div class="media-body">

				  	
					    <a href="/membres/profil.php?id=<?= $c['userID']?>">
					  	
					    <h5 class="media-heading"><?= poster_pseudo($c['userID'])?></h5></a>

					    <h6><?= nl2br(user_mention_verif($c ['commentaire'])) ?></h6>

					    <span class="pull-right">
					    <time><span class="glyphicon glyphicon-time"></span> <?= temps($c['date_pub'])?></time></span>

				  	</div>
				</div>
			</li>
		<?php }?>
		<?php if(ngphoto_info($photoID,"commentaire") > 3){?>
			<li class="list-group-item ng-margin-default">
			<a href="ngcomment.php?id=<?= $_GET['id']?>"><center>Voir plus</center></a>
			</li>
		</ul>
		<?php }
}
else{?>

<ul class="list-group">
	<li class="list-group-item ng-border"> 
		<div class="media">
			<div class="media-left media-top"> 		
				<img class="media-object img img-circle" src="/Mobile responsive/imgs/rien.JPG" width="40" height="40">
				    		
			</div>
			<div class="media-body">					    
				<h5 class="media-heading">aucun commentaire</h5>
				<h6>Soyez la première personne à reagir.</h6>
				<time><h6><span class="pull-right"><?= today_date()?></span></h6></time>
			</div>
		</div>
	</li>
</ul>
<?php } ?>


		</div>  
	</div>
</div>
<!-- / commentaire -->

<div class="ng-espace-fantom"></div>
</section>
<?php include '../require-files/footer.php'; ?>

<!-- script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="../Mobile responsive/js/js+/jquery.min.js"><\/script>')
    </script>
    <script src="../Mobile responsive/js/bootstrap.min.js"></script>
    <script src="../Mobile responsive/js/ng-alert-V2.js"></script>
<!-- / script -->

</body>
</html>