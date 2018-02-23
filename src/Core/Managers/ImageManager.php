<?php
namespace Ng\Core\Managers;

use Ng\Core\Managers\MessageManager;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager as InterventionImage;

abstract class ImageManager
{
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
        'gallery-thumbs' => UPLOAD.'/gallery/thumbs',

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
    private static $size_max = 10485760; // 10mb


    /**
     * verifie si un fichier est vraiment une image
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
    public static function upload(Collection $file, string $path, string $name, string $format)
    {
        $flash = new FlashMessageManager(SessionManager::getInstance());

        if (!empty($file->get('thumb.tmp_name'))) {
            $size = ($file->get('thumb.size'));
            $path = self::$path[$path];

            if (self::checkExtension($file->get('thumb.name'), $file->get('thumb.type'))) {
                if ($size <= self::$size_max) {
                    $manager = new InterventionImage();

                    try {
                        $image = $manager->make($file->get('thumb.tmp_name'));
                    } catch (NotReadableException $e) {
                        $flash->set('danger', MessageManager::get('files_not_image'));
                        return false;
                    }

                    switch ($format) :
                        case 'ratio':
                            $image->resize(self::$format[$format], null, function ($c) {
                                $c->aspectRatio();
                            });
                            break;
                        case 'article':
                            $image->resize(1400, null, function ($c) {
                                $c->aspectRatio();
                            });
                            break;
                        case 'small':
                            $image->fit(self::$format[$format], self::$format[$format], function ($c) {
                                $c->upsize();
                            });
                            break;
                        case 'medium '|| 'large':
                            $image->fit(self::$format[$format], self::$format[$format]);
                    endswitch;

                    $image
                        ->orientate()
                        ->interlace(true)
                        ->save("{$path}/{$name}.jpg")
                        ->destroy();

                    return true;
                } else {
                    $flash->set('danger', MessageManager::get('files_too_big'));
                    return false;
                }
            } else {
                $flash->set('danger', MessageManager::get('files_not_image'));
                return false;
            }
        } else {
            $flash->set('danger', MessageManager::get('files_not_uploaded'));
            return false;
        }
    }


    /**
     * cree un captcha
     */
    public static function generateCaptcha()
    {
        SessionManager::getInstance()->write(CAPTCHA_KEY, mt_rand(1000, 9999));
        $police = realpath(WEBROOT."/assets/fonts/28 Days Later.ttf");

        $manager = new InterventionImage();
        $manager->canvas(100, 30, "#fff")
            ->text(SessionManager::getInstance()->read(CAPTCHA_KEY), 25, 5, function ($font) use ($police) {
                $font->file($police);
                $font->size(23);
                $font->color('#000');
                $font->valign('top');
            })
            ->save(ROOT."/public/imgs/captcha.jpg")
            ->destroy();
        exit();
    }
}
