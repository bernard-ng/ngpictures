<?php
session_start();
require "../fonction/functions.php";
$base = base_connexion('ngbdd');

if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{
	if(isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER']))
	{

		if(isset($_GET['type']) and !empty($_GET['type']))
		{


			switch ($_GET['type'])
			{

				case 'article':
					
				if(isset($_GET['id']) and !empty($_GET['id']))
				{

					$deleteID= htmlspecialchars($_GET['id']);
					
					if(article_info($deleteID,"nb_article") == 1){

						if(article_info($deleteID,"posterID") == $_SESSION['id']){

							$delete=$base->prepare("DELETE FROM article WHERE id=?");
							$delete->execute(array($deleteID));

							header('location:'.$_SERVER['HTTP_REFERER']);
							$_SESSION['msg'] = "votre article a bien été supprimé !";
							$_SESSION['type'] = "alert-success";

						}else{
								header('location:'.$_SERVER['HTTP_REFERER']);
								$_SESSION['msg'] = "Vous ne pouvez pas supprimer cet article";
								$_SESSION['type'] = "alert-danger"; 
							}

					}else{

						header('location:'.$_SERVER['HTTP_REFERER']);
						$_SESSION['msg'] = "Cet Article n'existe pas";
						$_SESSION['type'] = "alert-danger";
					}

				}else{
						header('location:'.$_SERVER['HTTP_REFERER']);
						$_SESSION['msg'] = "Erreur dans la suppression !";
						$_SESSION['type'] = "alert-danger";
					}		
			

				break;


				case 'photo':
					
				if(isset($_GET['id']) and !empty($_GET['id']))
				{

					$deleteID= htmlspecialchars($_GET['id']);
					
					if(photo_info($deleteID,"nb_photo") == 1){

						if(photo_info($deleteID,"posterID") == $_SESSION['id']){

							$delete=$base->prepare("DELETE FROM galerie WHERE id = ? ");
							$delete->execute(array($deleteID));

							header('location:'.$_SERVER['HTTP_REFERER']);
							$_SESSION['msg'] = "Votre photo a bien été supprimé !";
							$_SESSION['type'] = "alert-success";

						}else{
								header('location:'.$_SERVER['HTTP_REFERER']);
								$_SESSION['msg'] = "Vous ne pouvez pas supprimer cette photo";
								$_SESSION['type'] = "alert-danger"; 
							}

					}else{

						header('location:'.$_SERVER['HTTP_REFERER']);
						$_SESSION['msg'] = "Cette photo n'existe pas";
						$_SESSION['type'] = "alert-danger";
					}

				}else{
						header('location:'.$_SERVER['HTTP_REFERER']);
						$_SESSION['msg'] = "Erreur dans la suppression !";
						$_SESSION['type'] = "alert-danger";
					}		
			

				break;


			}//switch

		}else{
				header("location:/membres/profil.php?id=".$_SESSION['id']);
				$_SESSION['msg'] = "Erreur !";
				$_SESSION['type'] = "alert-danger"; 
		}


	}else{
			header("location:/membres/profil.php?id=".$_SESSION['id']);
			$_SESSION['msg'] = "Erreur !";
			$_SESSION['type'] = "alert-danger"; 
		}
		
}else{

	header("location:/membres/login.php");
	$_SESSION['msg'] = "Vous devez vous connecter !";
	$_SESSION['type'] = "alert-danger"; 
}

?>