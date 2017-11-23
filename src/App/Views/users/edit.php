<?php
session_start();
require "../php/fonction/functions.php";
$base = base_connexion("ngbdd");
include_once("../php/script/cookie.php");

if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{
	$verif = $base->prepare("SELECT * FROM membres WHERE id=? ");
	$verif->execute(array($_SESSION['id']));
	$user = $verif->fetch();

	if(isset($_POST['modifier']))
	{
		if(!empty($_POST))
		{
			if(isset($_POST['pseudoupdate']) and !empty($_POST['pseudoupdate']) and $_POST['pseudoupdate'] != $user['pseudo'])
			{
				$pseudoupdate = valid_userName($_POST['pseudoupdate']);

				if(preg_match("#([^\w]+)#", $pseudoupdate))
		        {
		            $msg="le Pseudo ne doit pas contenir des caratères spéciaux !";
		            $type = "alert-danger";

		        }else{

					$pseudoupdate = valide_userName($_POST['pseudoupdate']);

					$verif = $base->prepare("SELECT * FROM membres WHERE pseudo = ?");
					$verif->execute(array($pseudoupdate));
					$pseudoExist = $verif->rowCount();

					if($pseudoExist == 0)
					{
							$updateNAME = $base->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
							$updateNAME->execute(array($pseudoupdate,$_SESSION['id']));

							header("location:/membres/profil.php?id=".$_SESSION['id']);
							$_SESSION['msg'] = "Pseudo mis à jour !";
							$_SESSION['type'] = "alert-success";
							
							
					}else{

						$msg="Ce pseudo est dejà pris !";
						$type = "alert-danger"; } 
				}
			}
				
			if(isset($_POST['numupdate']) and !empty($_POST['numupdate']) and $_POST['numupdate'] != $user['num'])
			{
			
					$numupdate = str_replace("#\+#", "00", $_POST['numupdate'] );
					$numupdate= htmlspecialchars($numupdate);
					$updateNAME = $base->prepare("UPDATE membres SET num = ? WHERE id = ?");
					$updateNAME->execute(array($numupdate,$_SESSION['id']));

					header("location:/membres/profil.php?id=".$_SESSION['id']);
					$_SESSION['msg'] = "Numéro Mobile à jour";
					$_SESSION['type'] = "alert-success";
							
			}
				
			if(isset($_POST['mdpupdate']) and !empty($_POST['mdpupdate']) and isset($_POST['mdp1update']) and !empty($_POST['mdp1update']))
			{
					
				$mdpupdate = sha1($_POST['mdpupdate']);
				$mdp1update = sha1($_POST['mdp1update']);
				$mdp_len = iconv_strlen($_POST['mdp1update']);

				if($mdpupdate == $user['mdp'])
				{
					if($mdp_len >= 8)
					{
						$updatePASS = $base->prepare("UPDATE membres SET mdp = ? WHERE id= ?");
						$updatePASS->execute(array($mdp1update,$_SESSION['id']));
							
						header("location:/membres/profil.php?id=".$_SESSION['id']);
						$_SESSION['msg'] = "Mot de passe mis à jour !";
						$_SESSION['type'] = "alert-success";
						

					}else{
							$msg = "Votre mot de passe doit faire au moins 8 caratères";
							$type = "alert-danger"; }						
				}else{
						$msg="Mauvais mot de passe";
						$type = "alert-danger"; }					
			}

			if(isset($_FILES['avatar']) and !empty($_FILES['avatar']['name']))
			{
				$sizeMax = 10485760;
				$admitExt=array("jpg","jpeg");
					
				if($_FILES['avatar']['size'] <= $sizeMax)
				{
					$Extupload = strtolower(substr(strrchr($_FILES['avatar']['name'],"."),1));

					if(in_array($Extupload,$admitExt))
					{
						require '../php/class/imgClass.php';
						$img = '$_SESSION["id"]'.'.'.'$Extupload' ;
						$way = "Avatar/".$_SESSION['id'].".".$Extupload;
						$way2 = "Avatar/40-40/".$_SESSION['id'].".".$Extupload;
						$way3 = "Avatar/90-90/".$_SESSION['id'].".".$Extupload;
						$way4 = "Avatar/640-640/".$_SESSION['id'].".".$Extupload;

						$result = move_uploaded_file($_FILES['avatar']['tmp_name'],$way);
							
						if($result)
						{
							Img::creerMIn($way,$way2,$img,40,40);
							Img::creerMIn($way,$way3,$img,90,90);
							Img::creerMIn($way,$way4,$img,640,640);

							$update = $base->prepare("

								UPDATE membres 
								SET avatar = :avatar 
								WHERE id = :id
							");

							$update->execute(array(
							"avatar" => $_SESSION['id'].".".$Extupload,
							"id" => $_SESSION['id'] ));

							header("location:/membres/profil.php?id=".$_SESSION['id']);
							$_SESSION['msg'] = "Profil mis à jour !";
							$_SESSION['type'] = "alert-success";
							

						}else{

							$msg="Erreur dans l'importation de la photo !";
							$type="alert-danger"; 
						}

					}else{

						$msg="Votre photo doit être au format  jpg ou jpeg !";
						$type="alert-danger"; 
					}

				}else{

					$msg="Votre photo ne doit pas dépasser 10Mo";
					$type="alert-danger"; 
				}

			}

			if(isset($_POST['statut']) and  !empty($_POST['statut']))
			{
				if(preg_match("#^(.+)$#", $_POST['statut']))
				{
					$statut= htmlspecialchars($_POST['statut']);
					$Newstatut=$base->prepare("

						UPDATE membres 
						SET statut = ? 
						WHERE id = ?

					");

					$Newstatut->execute(array($statut,$_SESSION['id']));
					$userInfo = $Newstatut->fetch();

					header("location:/membres/profil.php?id=".$_SESSION['id']);
					$_SESSION['msg'] = "Statut mis à jour !";
					$_SESSION['type'] = "alert-success";
					

				}else{

					$msg ="Le statut ne doit pas commencer avec un retour à la ligne!";
					$type="alert-danger"; }
			}
		}
	}

}else{

	$_SESSION['msg'] = "Vous devez vous connecter !";
    $_SESSION['type'] = "alert-danger";
    header("location:/membres/login.php"); 
} 
    	
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <?php include "../require-files/favicon.php";?>
    <?php include '../require-files/all-meta.php'; ?>
	<title><?= "Edition profil | ".poster_pseudo($_SESSION['id']) ?></title>

	<link rel="stylesheet" href="/Mobile responsive/css/AdminLTE.min.css">
	<link href="/Mobile responsive/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
	<link href="/Mobile responsive/css/ng.css" rel="stylesheet" type="text/css" >

</head>
<body>
	<section class="ng-bloc-principal">

		<?php include "../require-files/profil/menu.php"; ?>
		<?php include "../require-files/flash.php"; ?>


		<div class="jumbotron ng-margin-default">
			<div class="container">
				<div class="media">
					<div class="media-left media-middle">
						<div class="media-body" >
							<h2 class="media-heading" style="color:#428bca;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edition du Profil</h2>
							    vous pouvez modifier les informations concernant votre compte ici...
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include '../require-files/verset.php'; ?>

		<div class="ng-article-img"> 
			<div class="hidden-xs col-lg-3 col-sm-3 col-md-3">
				<div class="row">
					<div class="ng-panel panel panel-primary">
						<div class="ng-panel panel-heading"><span class="glyphicon glyphicon-picture"></span>  PROFIL</div>
						<div class="ng-article-img"> 
							<div class="card--date">
								<div class="card--date--day"><?= ng_date(today_date())?></div>
								<div class="card--date--month"><?= ng_month(today_date());?></div>
							</div>

							<img class="img-circle" src="/membres/Avatar/640-640/<?= poster_profil($_SESSION['id']) ?>" width="200" />
			
						</div>
					</div>
				</div>
			</div>	
		</div>

		<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6" >
			<div class="row">

			<div class="box box-primary ng-panel-active">
			    <div class="box-header">      
			        <h3 class="box-title">Publier un statut</h3>

			        <?php if(isset($msg)){ echo "<p style='color:red;'>".$msg."</p>"; }else{ echo "<p>Edition du profil et publication statut </p>";}?>
				</div>

				<div class="box-body">
					<form method="post" action="<?= $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

				    <label for="statut">Statut</label>
				    <textarea type="text" class="textarea-default" name="statut" placeholder="nouveau statut..."><?php if(isset($_POST['statut'])){ echo $_POST['statut'];}?></textarea> 

				   <div class="form-group">
					   <label for="avatar" class="btn btn-primary btn-block btn-flat ng-file-label">Photo de profil</label>
					   <input type="file" name="avatar" class="ng-file-input" id="avatar"/>
				 	</div>

					<div class="form-group has-feedback">
					    <label for="pseudoupdate">Nouveau Pseudo</label>
					    <input type="text" name="pseudoupdate" class="form-control" id="pseudoupdate"
					     value="<?php if(isset($_POST['pseudoupdate'])){ echo $_POST['pseudoupdate'];}else{ echo $user['pseudo'];}?>">
					    <span class="glyphicon glyphicon-user form-control-feedback"></span>
				  	</div>


					<div class="form-group has-feedback">
					    <label for="numupdate">Nouveau Mobile</label>
					    <input type="number" class="form-control" id="numupdate" name="numupdate" 
					    value="<?php if(isset($_POST['numupdate'])){ echo $_POST['numupdate'];}else{ echo $user['num'];}?>">
					    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
					</div>


					<div class="form-group has-feedback">
					    <label for="mdpupdate">Ancien mot de passe</label>
					    <input type="Password" name="mdpupdate" class="form-control" id="mdpupdate" placeholder="Password">
					    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>

					<div class="form-group has-feedback">
					    <label for="mdp1update">Nouveau</label>
					    <input type="Password" name="mdp1update" class="form-control" id="mdp1update" placeholder="Password">
					    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>

					<div class="box-footer clearfix">

						<button  type="submit"  name="modifier" class="pull-right btn btn-primary btn-sm" role="button">Modifier</button>
						<button  type="reset"  name="reset" class="pull-right btn btn-default btn-sm" role="button">Annuler</button>
					</div>

					</form>
				</div>
			</div>

			</div>
		</div>

		<div class="col-xs-12 col-sm-3 col-md-3">
			<div class="row">
				<div class="ng-panel panel panel-primary">
					<div class="ng-panel panel-heading"><span class="glyphicon glyphicon-chevron-right"></span> STATUT</div>

					<div class="panel-body">	
						<?= valid_text($user['statut']) ?>
					</div>	
				</div>
			</div>
		</div>	

		<div class="col-xs-12 col-sm-3 col-md-3">
			<div class="row">
				<div class="ng-panel panel panel-primary ">
					<div class="ng-panel panel-heading ng-margin-default">
					<span class="glyphicon glyphicon-chevron-right"></span> PSEUDO ET AUTRE</div>

					<ul class="list-group">
		                <li class="list-group-item"><span class="glyphicon glyphicon-user"></span> 
		                    <?= poster_name($_SESSION['id'])?>     
		                </li>

		                <li class="list-group-item"><span class="glyphicon glyphicon-phone"></span>
		                    <?= poster_phone($_SESSION['id'])?>
		                </li>
		            </ul>
				</div>
			</div>
		</div>

		<div class="ng-espace-fantom"></div>
	</section>
	<?php include "../require-files/footer.php"; ?>

	<!-- script -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script>
		window.jQuery || document.write('<script src="/Mobile responsive/js/js+/jquery.min.js"><\/script>')
		</script>
		<script src="/Mobile responsive/js/bootstrap.min.js"></script>
		<script src="/Mobile responsive/js/ng-alert-v2.js"></script>
	<!-- / script -->

</body>
</html>