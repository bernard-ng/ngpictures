<?php
namespace Ng\Core\Generic;

use Intervention\Image\ImageManager;


Abstract class Image 
{

    /**
     * les differents messages d'erreur
     * @var array
     */
    private static $msg = [
        'not_image' => 'Le fichier téléchargé doit être une image',
        'error_upload' => 'Une erreur est survenu lors du téléchargement de l\'image',
        'bigger_than_max' => 'Votre image est trop grande, elle ne doit pas dépasser 15 Mo'
    ];


    /**
     * les differents chemins d'upload
     * @var array
     */
    private static $path = [
        'blog' => UPLOAD.'/blog',
        'blog-thumbs' => UPLOAD.'/blog/thumbs',

        'posts' => UPLOAD.'/posts',
        'posts-thumbs' => UPLOAD.'/posts/thumbs',

        'gallery' => UPLOAD.'/gallery',
        'gallery-thumbs' => UPLOAD.'/gallery/thumbs/',

        'avatars' => UPLOAD.'/avatars'
    ];


    /**
     * les formats de croppage disponible
     * @var array
     */
    private static $format = [
        'small' => 500,
        'medium' => 840,
        'ratio' => 1400
    ];


    /**
     * extension du fichier attendu
     * @var array
     */
    private static $extensions = ['jpg','jpeg','png','gif'];


    /**
     * taille maximal du fichier
     * @var int
     */
    private static $size_max = 15728640; // 15mb


    /**
     * verifi si un fichier est vraiment une image
     * @param string $file
     * @param string $type
     * @return bool
     */
    private static function checkExtension(string $file, string $type): bool
    {
        $ext = explode('.', $file);
        $ext = strtolower(end($ext));
        $expected_type = ['image/jpg','image/jpeg','image/png','image/gif'];

        if (in_array($ext, self::$extensions) && in_array($type, $expected_type)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * redimention et telecharge un fichier (une image precisement)
     * @param Collection $file
     * @param string $path
     * @param string $name
     * @param string $format
     * @return bool
     */
    public static function upload(Collection $file, string $path, string $name, string $format)#
    {
        $flash = new Flash(Session::getInstance());

        if (!empty($file->get('thumb.tmp_name'))) {
            $size = ($file->get('thumb.size'));
            $path = self::$path[$path];

            if (self::checkExtension($file->get('thumb.name'), $file->get('thumb.type'))) {
                if ($size <= self::$size_max) {
                    $manager = new ImageManager();
                    $image = $manager->make($file->get('thumb.tmp_name'));

                    switch ($format) :
                        case 'ratio' :
                            $image->resize(self::$format[$format], null, function($c){
                                $c->aspectRatio();
                            });
                            break;
                        case 'article' :
                            $image->resize(1400, null, function($c){
                                $c->aspectRatio();
                            });
                            break;
                        case 'small' :
                            $image->fit(self::$format[$format], self::$format[$format], function($c){
                                $c->upsize();
                            });
                            break;
                        case 'medium '|| 'large' :
                            $image->fit(self::$format[$format], self::$format[$format]);
                    endswitch;

                    $image
                        ->orientate()
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


    /**
     * cree un captcha
     */
    public static function generateCaptcha()
    {
        Session::getInstance()->write("captcha", mt_rand(1000,9999));
        $police = realpath(WEBROOT."/assets/fonts/28 Days Later.ttf");

        $manager = new ImageManager();
        $manager->canvas(100, 30, "#fff")
            ->text(Session::getInstance()->read(CAPTCHA_KEY), 25, 5, function($font) use ($police) {
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
