<?php
session_start();
require '../fonction/functions.php';
$base = base_connexion("ngbdd");

if(isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER']))
{
	if(isset($_SESSION['id']) and !empty($_SESSION['id']))
	{
		if(isset($_POST['commenter']))
		{
			if(!empty($_POST['commentaire']))
			{

				$userID = htmlspecialchars($_SESSION['id']);
	
				$commentaire = htmlspecialchars($_POST['commentaire']);

				$insert = $base->prepare('

					INSERT INTO livre_dor(userID,commentaire,date_pub) 
					VALUES(?,?,now())
				');

				$insert->execute(array($userID,$commentaire));

				$_SESSION['msg'] = "Nous avons reçu votre commentaire";
				$_SESSION['type'] = "alert-success";
				header('location:'.$_SERVER['HTTP_REFERER']);

			}else{

				$_SESSION['msg'] = "complétez le champ";
				$_SESSION['type'] = "alert-danger";
				header('location:'.$_SERVER['HTTP_REFERER']);
			}

		}else{

			$_SESSION['msg'] = "Erreur !";
			$_SESSION['type'] = "alert-danger";
			header('location:'.$_SERVER['HTTP_REFERER']);
		}

	}else{

		$_SESSION['msg'] = "Vous devez vous connectez !";
		$_SESSION['type'] = "alert-danger";
		header('location:/membres/login.php');
	}

}else{

	$_SESSION['msg'] = "Erreur !";
	$_SESSION['type'] = "alert-danger";
	header('location:/plus/erreur/500.php');
	header('500 internal server error', true , 500);
}

?>