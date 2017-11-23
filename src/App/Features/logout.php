<?php
session_start();
setcookie("mdp"," ",time()-3600);
setcookie("pseudo"," ",time()-3600);

unset($_SESSION['id']); 
$_SESSION = array();
session_destroy();

header('location:/membres/login.php');
?>