<?php
session_start();
require "../fonction/functions.php";
$base = base_connexion("ngbdd");

if(isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER'])){


	if(isset($_GET['followingID']))
	{

		$getfollowedID = htmlspecialchars(intval($_GET['followingID']));
		if(isset($_SESSION['id']) and !empty($_SESSION["id"]))
		{

			if($getfollowedID != $_SESSION['id']) 
			{
				$followed = $base->prepare("

					SELECT * 
					FROM following 
					WHERE followerID = ? AND followingID = ?

				");

				$followed->execute(array($_SESSION['id'],$getfollowedID));
				$followed = $followed->rowcount();

				if($followed == 0)
				{
					$addFollowed = $base->prepare("

						INSERT INTO following(followerID,followingID) 
						VALUES (?,?)
					");

					$addFollowed->execute(array($_SESSION['id'],$getfollowedID));

					$user = poster_pseudo($getfollowedID);
					$_SESSION['msg'] = "Vous suivez ".$user." !";
					$_SESSION['type'] = "alert-info";

				}
				else if ($followed == 1) 
				{
					$delFollowed = $base->prepare("
						DELETE FROM following 
						WHERE followerID = ? AND followingID = ? 
					");

					$delFollowed->execute(array($_SESSION["id"],$getfollowedID));

					$user = poster_pseudo($getfollowedID);
					$_SESSION['msg'] = "Vous ne suivez plus ". $user." !";
					$_SESSION['type'] = "alert-info";
				}
			}
			header('location:'.$_SERVER['HTTP_REFERER']);


		}else{

			$_SESSION['msg'] = "Vous devez vous connecté !";
			$_SESSION['type'] = "alert-danger";
			header('location:/membres/login.php');
		}

	}else{ 

		$_SESSION['msg'] = "Erreur !";
		$_SESSION['type'] = "alert-danger";
		header('location:/plus/erreur/500.php') ;
		header('500 internal server error', true , 500) ;
	}

}else{ 

	$_SESSION['msg'] = "Erreur !";
	$_SESSION['type'] = "alert-danger";
	header('location:/plus/erreur/500.php') ;
	header('500 internal server error', true , 500) ;
}

?>