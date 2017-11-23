<?php

$time_actu = time();
$userID =$_SESSION['id'];
$verif = $base->prepare('SELECT * FROM online WHERE userID = ?');
$verif->execute(array($userID));
$user_online = $verif->rowcount();

	if($user_online == 0){

		$ins = $base->prepare("INSERT INTO online(time_actu,userID) VALUES(?,?) ");
		$ins->execute(array($time_actu,$userID));

	}else {

		$update = $base->prepare("UPDATE online SET time_actu = ?  WHERE userID = ?");
		$update->execute(array($time_actu,$userID));
	}

$online_session = time() - 20;

$del = $base->prepare("DELETE FROM online WHERE time_actu < ?");
$del->execute(array($online_session));

$online_users = $base->query("SELECT * FROM online");
$nb_online = $online_users->rowcount();

?>