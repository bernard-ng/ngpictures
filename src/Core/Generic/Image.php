<?php
namespace Ng\Core\Generic;

use Intervention\Image\ImageManager;

use Ng\Core\Generic\{
    Session, Str, Flash
};

use Ngpictures\Ngpic;

Abstract class Image 
{

    private static $msg = [
        'not_image' => 'Le fichier téléchargé doit être une image',
        'error_upload' => 'Une erreur est survenu lors du téléchargement de l\'image',
        'bigger_than_max' => 'Votre image est trop grande, elle ne doit pas dépasser 15 Mo'
    ];

    private static $path = [
        'blog' => UPLOAD.'/blog',
        'articles' => UPLOAD.'/articles',
        'ngpictures' => UPLOAD.'/ngpictures',
        'pictures' => UPLOAD.'/pictures',
        'avatars' => UPLOAD.'/avatars'
    ];

    private static $format = [
        'small' => 350,
        'medium' => 700,
        'large' => 1400,
        'ratio' => 500
    ];

    private static $extensions = ['jpg','jpeg','png','gif'];
    private static $size_max = 15728640; // 15mb

    private static function extension(string $file, string $type): bool
    {
        $ext = explode('.', $file);
        $ext = strtolower(end($ext));
        $expected_type = "image/{$ext}";
        $extensions = self::$extensions;

        if (in_array($ext, $extensions) && $expected_type === strtolower($type) ) {
            return true;
        } else {
            return false;
        }
    }


    public static function upload(Collection $file, string $path, string $name, string $format)
    {
        $flash = new Flash(Session::getInstance());

        if (!empty($file->get('thumb.tmp_name'))) {
            $size = ($file->get('thumb.size'));
            $path = self::$path[$path];

            if (self::extension($file->get('thumb.name'), $file->get('thumb.type'))) {
                if ($size <= self::$size_max) {
                    $manager = new ImageManager();
                    $image = $manager->make($file->get('thumb.tmp_name'));
    
                    if ($format === 'ratio') {
                        $image->fit(self::$format[$format], null, function($c){
                            $c->aspectRatio();
                        });
                    } else {
                        $image->fit(self::$format[$format], self::$format[$format]);
                    }
                       
                    $image
                        ->interlace(true)
                        ->save("{$path}/{$name}.jpg")
                        ->destroy();
                        
                    return true;    
                } else {
                    $flash->set('danger', self::$msg['bigger_than_max']);
                    return false;
                }
            } else {
                $flash->set('danger', self::$msg['not_image']);
                return false;
            }
        } else {
            $flash->set('danger', self::$msg['error_upload']);
            return false;
        }
    }


    public static function generateCaptcha()
    {
        Session::getInstance()->write("captcha", mt_rand(1000,9999));
        $police = realpath(ROOT."/Public/assets/fonts/28 Days Later.ttf");

        $manager = new ImageManager();
        $img = $manager->canvas(100, 30, "#fff") 
            ->text(Session::getInstance()->read('captcha'), 25, 5, function($font) use ($police) {
                $font->file($police); 
                $font->size(23);                  
                $font->color('#000');         
                $font->valign('top');
            })
            ->save(ROOT."/Public/imgs/captcha.jpg")
            ->destroy();
        exit();
    }

}