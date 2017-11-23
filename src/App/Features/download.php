<?php
session_start();

if(isset($_SESSION['id']) and !empty($_SESSION['id']))
{
	if(isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER'])){

		if(isset($_GET['type']) and !empty($_GET['type'])){

			switch ($_GET['type'])
			{

				case 'photo':
					
				$file = htmlspecialchars($_GET['n']);
				$file_tmp = "../../galerie/images/miniature/"."$file";

				header('Content-Type: application/octet-stream');
				header('Content-Transfer-Encoding: Binary');
				header('content-disposition: attachement; filename="'.basename($file_tmp).'"');
				echo readfile($file_tmp);

				break;

				case 'ngphoto' : 

				$file = htmlspecialchars($_GET['n']);
				$file_tmp = "../../galerie/ngimages/miniature/"."$file";

				header('Content-Type: application/octet-stream');
				header('Content-Transfer-Encoding: Binary');
				header('content-disposition: attachement; filename="'.basename($file_tmp).'"');
				echo readfile($file_tmp);

				break;

			}//switch


		}else{

			$_SESSION['msg'] = "Erreur !";
			$_SESSION['type'] = "alert-danger";
			header('location:'.$_SERVER['HTTP_REFERER']);
		}


	}else{

		$_SESSION['msg'] = "Erreur !";
		$_SESSION['type'] = "alert-danger";
		header('location:/galerie/galerie.php');
	}

}else{

	$_SESSION['msg'] = "vous devez vous connecter !";
	$_SESSION['type'] = "alert-danger";
	header('location:/membres/login.php');
}
?>