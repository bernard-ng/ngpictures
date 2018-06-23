<?php
namespace Ng\Core\Managers;

use Throwable;
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

        'avatars' => UPLOAD.'/avatars',
        'imgs' => WEBROOT. '/imgs'
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
    private static $size_max = 5242880; // 5mb


    /**
     * verifie si un fichier est vraiment une image
     * @param string $file
     * @param string $type
     * @return bool
     */
    private static function checkFile(string $file, string $type): bool
    {
        $ext = explode('.', $file);
        $ext = strtolower(end($ext));
        $expected_type = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

        if (in_array($ext, self::$extensions) && in_array($type, $expected_type)) {
            return true;
        }
        return false;
    }


    /**
     * recupere les donnees exif d'une image et retourne un json
     * pour permettre le stockage dans la base de donnee
     *
     * @param Collection $file
     * @return string|null
     */
    public static function getExif(Collection $file)
    {
        try {
            $image = (new InterventionImage())->make($file->get('thumb.tmp_name'));
            return  json_encode([
                'ISOSpeedRatings'    => $image->exif('ISOSpeedRatings') ?? null,
                'Flash'              => $image->exif('Flash') ?? null,
                'Model'              => $image->exif('Model') ?? null,
                'ExposureTime'       => $image->exif('ExposureTime') ?? null,
                'FocalLength'        => $image->exif('FocalLength') ?? null,
                'ResolutionUnit'     => $image->exif('ResolutionUnit') ?? null,
                'COMPUTED'           => $image->exif('COMPUTED') ?? null
            ]);
        } catch(NotReadableException $e) {
            LogMessageManager::register(__class__, $e);
            return null;
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

            if (self::checkFile($file->get('thumb.name'), $file->get('thumb.type'))) {
                if ($size <= self::$size_max) {
                    $manager = new InterventionImage();

                    try {
                        $image = $manager->make($file->get('thumb.tmp_name'));

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
                        case 'medium ' || 'large':
                            $image->fit(self::$format[$format], self::$format[$format]);
                        endswitch;

                        $image
                            ->orientate()
                            ->interlace(true)
                            ->save("{$path}/{$name}.jpg")
                            ->destroy();

                        return true;
                    } catch (NotReadableException $e ) {
                        LogMessageManager::register(__class__, $e);
                        $flash->set('danger', MessageManager::get('files_not_image'));
                        return false;
                    } catch (Exception $e) {
                        LogMessageManager::register(__class__, $e);
                        $flash->set('danger', MessageManager::get('undefined_error'));
                        return false;
                    }
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


    public static function updateStatic(Collection $file, string $name)
    {
        $flash = new FlashMessageManager(SessionManager::getInstance());

        if (!empty($file->get('thumb.tmp_name'))) {
            $path = self::$path['imgs'];
            if (self::checkFile($file->get('thumb.name'), $file->get('thumb.type'))) {
                $manager = new InterventionImage();
                $sizes = getimagesize($file->get('thumb.tmp_name'));

                try {
                    $image = $manager->make($file->get('thumb.tmp_name'));
                    if ($name != 'slider') {
                        $bg = $manager
                            ->make(WEBROOT . '/imgs/bg.png')
                            ->resize($sizes[0] * 2, $sizes[1] * 2);
                        $image->resize(1400, null, function ($c) {
                            $c->aspectRatio();
                        });

                        $image
                            ->orientate()
                            ->interlace(true)
                            ->insert($bg, 'bottom-right', 0, 0)
                            ->save("{$path}/{$name}.jpg")
                            ->destroy();
                    } else {
                        $image->resize(1400, null, function ($c) {
                            $c->aspectRatio();
                        });

                        $image
                            ->orientate()
                            ->interlace(true)
                            ->save("{$path}/{$name}.jpg")
                            ->destroy();
                    }

                    return true;
                } catch (NotReadableException $e) {
                    LogMessageManager::register(__class__, $e);
                    $flash->set('danger', MessageManager::get('files_not_image'));
                    return false;
                } catch (Exception $e) {
                    LogMessageManager::register(__class__, $e);
                    $flash->set('danger', MessageManager::get('undefined_error'));
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
     * ajout d'un logo sur les images
     *
     * @param string $filename
     * @param string $text
     * @param string $type
     * @param string $color
     * @return bool
     */
    public static function watermark(string $filename, string $text, string $type, string $color)
    {
        $flash = new FlashMessageManager(SessionManager::getInstance());
        $police = realpath(WEBROOT."/assets/fonts/Mechanic.ttf");
        $manager = new InterventionImage();

        try {
            $manager->make(self::$path[$type]."/{$filename}")
                ->text(
                    $text,
                    20,
                    20,
                    function ($font) use ($police, $color) {
                        $font->file($police);
                        $font->size(24);
                        $font->color($color);
                        $font->align('left');
                        $font->valign("middle");
                    }
                )
                ->save(self::$path[$type]."/{$filename}")
                ->destroy();

            return true;
        } catch (NotReadableException $e) {
            LogMessageManager::register(__class__, $e);
            $flash->set('danger', MessageManager::get('files_not_image'));
            return false;
        }
    }


    public static function logoWatermark(string $filename, string $logo, string $type)
    {
        $flash = new FlashMessageManager(SessionManager::getInstance());
        $manager = new InterventionImage();

        try {
            $logo = $manager->make(WEBROOT."/imgs/logo/{$logo}.png");
        } catch (NotReadableException $e) {
            LogMessageManager::register(__class__, $e);
            $flash->set('danger', 'logo '. MessageManager::get('files_not_image'));
            return false;
        }

        try {
            $manager = $manager
                ->make(self::$path[$type]."/{$filename}")
                ->orientate()
                ->insert($logo, 'bottom-right', 30, 30);

            if (file_exists(self::$path[$type]."/{$filename}")) {
                $manager
                    ->save(self::$path[$type]."/{$filename}")
                    ->destroy();

                return true;
            }
        } catch (NotReadableException $e) {
            LogMessageManager::register(__class__, $e);
            $flash->set('danger', 'image '. MessageManager::get('files_not_image'));
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
