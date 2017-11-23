<?php 
session_start();
require "../fonction/functions.php";
$base = base_connexion("ngbdd");


	if(isset($_GET['type']) and !empty($_GET['type'])){


		switch ($_GET['type']) {

		case 'ngarticle':
				
			if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
			{
				$getID= (int) $_GET['id'];
				$getT= (int) $_GET['t'];
				$userID = $_SESSION['id'];
				$verif= $base->prepare("SELECT id FROM ngarticle WHERE id=? ");
				$verif->execute(array($getID));
				
				if($verif->rowcount() == 1)
				{
					if($_GET['t'] == 1)
					{
						$likeVERIF = $base ->prepare("SELECT id FROM nglikes WHERE articleID=? AND userID=? ");
						$likeVERIF->execute(array($getID,$userID));
						
						$DEL = $base ->prepare("DELETE FROM ngdislikess WHERE articleID=? AND userID=? ");
						$DEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM nglove WHERE articleID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($likeVERIF->rowcount()==1)
						{
							$likeDEL = $base ->prepare("DELETE FROM nglikes WHERE articleID=? AND userID=? ");
							$likeDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO nglikes (articleID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 2)
					{
						
						$dislikess = $base ->prepare("SELECT id FROM ngdislikess WHERE articleID=? AND userID=? ");
						$dislikess->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM nglikes WHERE articleID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM nglove WHERE articleID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($dislikess->rowcount()==1)
						{
							$DEL = $base ->prepare("DELETE FROM ngdislikess WHERE articleID=? AND userID=? ");
							$DEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO ngdislikess (articleID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 3)
					{
						
						$love = $base ->prepare("SELECT id FROM nglove WHERE articleID=? AND userID=? ");
						$love->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM nglikes WHERE articleID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$dislikeDEL = $base ->prepare("DELETE FROM ngdislikess WHERE articleID=? AND userID=? ");
						$dislikeDEL->execute(array($getID,$userID));
						
						if($love->rowcount()==1)
						{
							$loveDEL = $base ->prepare("DELETE FROM nglove WHERE articleID=? AND userID=? ");
							$loveDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO nglove (articleID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}else{  
							$_SESSION['msg'] = "Erreur !";
							$_SESSION['type'] = "alert-danger";
							header('500 internal server error' , true, 500) ;
							header("location:".$_SERVER['HTTP_REFERER']);
						}

				}else{  
						$_SESSION['msg'] = "Erreur !";
						$_SESSION['type'] = "alert-danger";
						header('500 internal server error' , true, 500) ;
						header("location:".$_SERVER['HTTP_REFERER']);
					}
				
			}else{  
					$_SESSION['msg'] = "Erreur !";
					$_SESSION['type'] = "alert-danger";
					header('500 internal server error' , true, 500) ;
					header("location:".$_SERVER['HTTP_REFERER']);
				}


		break;


		case 'article' :

			if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
			{
				$getID= (int) $_GET['id'];
				$getT= (int) $_GET['t'];
				$userID = $_SESSION['id'];
				$verif= $base->prepare("SELECT id FROM article WHERE id=? ");
				$verif->execute(array($getID));
				
				if($verif->rowcount() == 1)
				{
					if($_GET['t'] == 1)
					{
						$likeVERIF = $base ->prepare("SELECT id FROM likes WHERE articleID=? AND userID=? ");
						$likeVERIF->execute(array($getID,$userID));
						
						$DEL = $base ->prepare("DELETE FROM dislikes WHERE articleID=? AND userID=? ");
						$DEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM love WHERE articleID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($likeVERIF->rowcount()==1)
						{
							$likeDEL = $base ->prepare("DELETE FROM likes WHERE articleID=? AND userID=? ");
							$likeDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO likes (articleID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 2)
					{
						
						$dislikess = $base ->prepare("SELECT id FROM dislikes WHERE articleID=? AND userID=? ");
						$dislikess->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM likes WHERE articleID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM love WHERE articleID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($dislikess->rowcount()==1)
						{
							$DEL = $base ->prepare("DELETE FROM dislikes WHERE articleID=? AND userID=? ");
							$DEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO dislikes (articleID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 3)
					{
						
						$love = $base ->prepare("SELECT id FROM love WHERE articleID=? AND userID=? ");
						$love->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM likes WHERE articleID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$dislikeDEL = $base ->prepare("DELETE FROM dislikes WHERE articleID=? AND userID=? ");
						$dislikeDEL->execute(array($getID,$userID));
						
						if($love->rowcount()==1)
						{
							$loveDEL = $base ->prepare("DELETE FROM love WHERE articleID=? AND userID=? ");
							$loveDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO love (articleID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}else{  
							$_SESSION['msg'] = "Erreur !";
							$_SESSION['type'] = "alert-danger";
							header('500 internal server error' , true, 500) ;
							header("location:".$_SERVER['HTTP_REFERER']);
						}

				}else{  
						$_SESSION['msg'] = "Erreur !";
						$_SESSION['type'] = "alert-danger";
						header('500 internal server error', true ,500) ;
						header("location:".$_SERVER['HTTP_REFERER']);
					}
				
			}else{  
					$_SESSION['msg'] = "Erreur !";
					$_SESSION['type'] = "alert-danger";
					header('500 internal server error' , true ,500) ;
					header("location:".$_SERVER['HTTP_REFERER']);
				}

			break; 


		case 'photo' :

			if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
			{
				$getID= (int) $_GET['id'];
				$getT= (int) $_GET['t'];
				$userID = $_SESSION['id'];
				$verif= $base->prepare("SELECT id FROM galerie WHERE id=? ");
				$verif->execute(array($getID));
				
				if($verif->rowcount() == 1)
				{
					if($_GET['t'] == 1)
					{
						$likeVERIF = $base ->prepare("SELECT id FROM likes WHERE photoID=? AND userID=? ");
						$likeVERIF->execute(array($getID,$userID));
						
						$DEL = $base ->prepare("DELETE FROM dislikes WHERE photoID=? AND userID=? ");
						$DEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM love WHERE photoID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($likeVERIF->rowcount()==1)
						{
							$likeDEL = $base ->prepare("DELETE FROM likes WHERE photoID=? AND userID=? ");
							$likeDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO likes (photoID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 2)
					{
						
						$dislikess = $base ->prepare("SELECT id FROM dislikess WHERE photoID=? AND userID=? ");
						$dislikess->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM likes WHERE photoID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM love WHERE photoID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($dislikess->rowcount()==1)
						{
							$DEL = $base ->prepare("DELETE FROM dislikes WHERE photoID=? AND userID=? ");
							$DEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO dislikes (photoID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 3)
					{
						
						$love = $base ->prepare("SELECT id FROM love WHERE photoID=? AND userID=? ");
						$love->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM likes WHERE photoID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$dislikeDEL = $base ->prepare("DELETE FROM dislikes WHERE photoID=? AND userID=? ");
						$dislikeDEL->execute(array($getID,$userID));
						
						if($love->rowcount()==1)
						{
							$loveDEL = $base ->prepare("DELETE FROM love WHERE photoID=? AND userID=? ");
							$loveDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO love (photoID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}else{  
							$_SESSION['msg'] = "Erreur !";
							$_SESSION['type'] = "alert-danger";
							header('500 internal server error' , true ,500) ;
							header("location:".$_SERVER['HTTP_REFERER']);
						}

				}else{  
						$_SESSION['msg'] = "Erreur !";
						$_SESSION['type'] = "alert-danger";
						header('500 internal server error' , true ,500) ;
						header("location:".$_SERVER['HTTP_REFERER']);
					}
				
			}else{  
					$_SESSION['msg'] = "Erreur !";
					$_SESSION['type'] = "alert-danger";
					header('500 internal server error' , true ,500) ;
					header("location:".$_SERVER['HTTP_REFERER']);
				}



			break;


		case "ngphoto" : 

			if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
			{
				$getID= (int) $_GET['id'];
				$getT= (int) $_GET['t'];
				$userID = $_SESSION['id'];
				$verif= $base->prepare("SELECT id FROM nggalerie WHERE id=? ");
				$verif->execute(array($getID));
				
				if($verif->rowcount() == 1)
				{
					if($_GET['t'] == 1)
					{
						$likeVERIF = $base ->prepare("SELECT id FROM nglikes WHERE photoID=? AND userID=? ");
						$likeVERIF->execute(array($getID,$userID));
						
						$DEL = $base ->prepare("DELETE FROM ngdislikess WHERE photoID=? AND userID=? ");
						$DEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM nglove WHERE photoID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($likeVERIF->rowcount()==1)
						{
							$likeDEL = $base ->prepare("DELETE FROM nglikes WHERE photoID=? AND userID=? ");
							$likeDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO nglikes (photoID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 2)
					{
						
						$dislikess = $base ->prepare("SELECT id FROM ngdislikess WHERE photoID=? AND userID=? ");
						$dislikess->execute(array($getID,$userID));
						
						$likeDEL = $base ->prepare("DELETE FROM nglikes WHERE photoID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$loveDEL = $base ->prepare("DELETE FROM nglove WHERE photoID=? AND userID=? ");
						$loveDEL->execute(array($getID,$userID));
						
						if($dislikess->rowcount()==1)
						{
							$DEL = $base ->prepare("DELETE FROM ngdislikess WHERE photoID=? AND userID=? ");
							$DEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO ngdislikess (photoID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}
					elseif($_GET['t'] == 3)
					{
						
						$love = $base->prepare("SELECT id FROM nglove WHERE photoID=? AND userID=? ");
						$love->execute(array($getID,$userID));
						
						$likeDEL = $base->prepare("DELETE FROM nglikes WHERE photoID=? AND userID=? ");
						$likeDEL->execute(array($getID,$userID));
						
						$dislikeDEL = $base->prepare("DELETE FROM ngdislikess WHERE photoID=? AND userID=? ");
						$dislikeDEL->execute(array($getID,$userID));
						
						if($love->rowcount()==1)
						{
							$loveDEL = $base ->prepare("DELETE FROM nglove WHERE photoID=? AND userID=? ");
							$loveDEL->execute(array($getID,$userID));
						}
						else
						{
							$insert=$base->prepare("INSERT INTO nglove (photoID,userID) VALUES (?,?)");
							$insert->execute(array($getID,$userID));
						}
						header("location:".$_SERVER['HTTP_REFERER']);
						
						
					}else{  
							$_SESSION['msg'] = "Erreur !";
							$_SESSION['type'] = "alert-danger";
							header('500 internal server error' , true ,500) ;
							header("location:".$_SERVER['HTTP_REFERER']); 
						}

				}else{  
						$_SESSION['msg'] = "Erreur !";
						$_SESSION['type'] = "alert-danger";
						header('500 internal server error' , true ,500) ;
						header("location:".$_SERVER['HTTP_REFERER']); 
					}
				
			}else{  
					$_SESSION['msg'] = "Erreur !";
					$_SESSION['type'] = "alert-danger";
					header('500 internal server error' , true ,500) ;
					header("location:".$_SERVER['HTTP_REFERER']);
				}

			
			break;

		}//switch

	}else{  
			$_SESSION['msg'] = "Erreur !";
			$_SESSION['type'] = "alert-danger";
			header('500 internal server error' , true ,500) ;
			header("location:".$_SERVER['HTTP_REFERER']);
		}
?>