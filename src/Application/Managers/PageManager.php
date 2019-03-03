<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Managers;


/**
 * Class PageManager
 * @package Application\Managers
 */
class PageManager
{

    /**
     * added meta data
     * @var array
     */
    private static $meta = [];

    /**
     * default page title
     * @var string
     */
    private static $pageTitle = "Ngpictures";

    /**
     * default page description
     * @var string
     */
    private static $description =
        "L'expression de la photographie africaine, les meilleures photos partagées par des photographes talentueux. 
        Ngpictures est une galerie photo pour photographes et passionnés de la photographie,
        Nous vous proposons de découvrir la photographie africaine autrement.";


    /**
     * default page url
     * @var string
     */
    private static $url = "https://larytech.com";

    /**
     * OG image
     * @var string
     */
    private static $image = "/imgs/icon.png";

    /**
     * @return string
     */
    public static function getActivePage(): string
    {
        return trim(explode("|", self::$pageTitle)[0]);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function setTitle(string $name): string
    {
        self::$pageTitle = $name . " | Ngpictures";
        return self::getTitle();
    }

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return self::$pageTitle;
    }


    public static function getMeta()
    {
        foreach (self::$meta as $meta) {
            $array_meta = [];

            foreach ($meta as $k => $v) {
                $array_meta[] = "{$k} ='{$v}' ";
            }

            $data_meta = implode(' ', $array_meta);
            echo "<meta {$data_meta} > \n";
        }
    }

    /**
     * @param array $data
     */
    public static function setMeta(array $data = [])
    {
        self::$meta[] = $data;
    }

    /**
     * @return string
     */
    public static function getDescription()
    {
        return self::$description;
    }

    /**
     * @param string|null $description
     */
    public static function setDescription(?string $description)
    {
        if(!is_null($description)) {
            self::$description = $description;
        }
    }

    /**
     * @return string
     */
    public static function getUrl()
    {
        return self::$url;
    }

    /**
     * @param string|null $url
     */
    public static function setUrl(?string $url)
    {
        if(!is_null($url)) {
            self::$url = self::$url . $url;
        }
    }

    /**
     * @return string
     */
    public static function getImage()
    {
        return self::$image;
    }

    /**
     * @param string|null $image
     */
    public static function setImage(?string $image)
    {
        if(!is_null($image)) {
            self::$image = $image;
        }
    }
}
