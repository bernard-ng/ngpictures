<?php
require "../../Core/Session.php";
Core\Session::getInstance()->write("captcha",mt_rand(1000,9999));

$img = imagecreate(110,30);
$font = "/fonts/28 Days Later.ttf";
$bg = imagecolorallocate($img,251,251,251);
$textColor = imagecolorallocate($img,0,151,167);

imagettftext($img,23,0,25,30,$textColor,$font,$_SESSION['captcha']);

header("Content-Type:image/jpeg");
imagejpeg($img);
imagedestroy($img);
