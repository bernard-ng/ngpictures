<?php
require("../../vendor/autoload.php");
use Intervention\Image\ImageManager;
use Core\Generic\Session;

Session::getInstance()->write("captcha", mt_rand(1000,9999));
$police = realpath("../assets/fonts/28 Days Later.ttf");

$manager = new ImageManager();
header("Content-Type: image/jpg");
return $manager->canvas(100, 30, "#fff") 
    ->text(Session::getInstance()->read('captcha'), 25, 5, function($font) use ($police) {
        $font->file($police); 
        $font->size(23);                  
        $font->color('#000');         
        $font->valign('top');
    })
    ->response("jpg")
    ->destroy();
exit();