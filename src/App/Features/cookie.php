<?php

if(
	!isset($_SESSION['id']) and 
	isset($_COOKIE['pseudo'],$_COOKIE['mdp']) and 
	!empty($_COOKIE['pseudo']) and 
	!empty($_COOKIE['mdp'])
){

	$verif= $base->prepare("

		SELECT * 
		FROM membres 
		WHERE pseudo = ? AND mdp = ? 
	");

    $verif->execute(array($_COOKIE['pseudo'],$_COOKIE['mdp']));
    $userExist = $verif -> rowCount();
    
    if($userExist == 1)
    {
        $userInfo = $verif->fetch();
        $_SESSION['id'] = $userInfo['id'];
        $_SESSION['pseudo'] = $userInfo['pseudo'];
                              
    }
}
?>