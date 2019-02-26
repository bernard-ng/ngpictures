<?php
namespace Application\Managers;

use Application\Application;

class PageManager
{
    /**
     * les metas qu'on peut ajouter
     * @var array
     */
    private static $meta = [];


    /**
     * le nom de la page
     * @var string
     */
    private static $pageTitle = "Ngpictures";


    /**
     * description of the page
     * @var string
     */
    private static $description =
        "L'expression de la photographie africaine, les meilleures photos partagées par des photographes talentueux. 
        Ngpictures est une galerie photo pour photographes et passionnés de la photographie,
        Nous vous proposons de découvrir la photographie africaine autrement.";

    /**
     * og url
     * @var string
     */
    private static $url = "https://larytech.com";

    /**
     * og image
     * @var string
     */
    private static $image = "/imgs/icon.png";

    /**
     * retourne la page active,
     * ce qui nous permet de faire un system de hover.
     *
     * @return string
     */
    public static function getActivePage(): string
    {
        return trim(explode("|", self::$pageTitle)[0]);
    }

    /**
     * definit le nom de la page courante
     *
     * @param string $name
     * @return string
     */
    public static function setTitle(string $name): string
    {
        self::$pageTitle = $name . " | " . Application::getDic()->get('site.name');
        return self::getTitle();
    }

    /**
     * retourne le nom de la page courante
     * @return string
     */
    public static function getTitle(): string
    {
        return self::$pageTitle;
    }

    /**
     * permet de generer des metas
     * dans les views
     * @return void
     */
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
     * defini des metas pour la page courante
     *
     * @param array $data
     * @return void
     */
    public static function setMeta(array $data = [])
    {
        self::$meta[] = $data;
    }

    /**
     * get description
     *
     * @return string
     */
    public static function getDescription()
    {
        return self::$description;
    }


    /**
     * Set the value of description
     * @param string $description
     * @return void
     */
    public static function setDescription(string $description)
    {
        self::$description = $description;
    }


    /**
     * Get the value of url
     * @return  string
     */
    public static function getUrl()
    {
        return self::$url;
    }


    /**
     * set url
     *
     * @param string $url
     * @return void
     */
    public static function setUrl(string $url)
    {
        self::$url = self::$url . $url;
    }


    /**
     * get image
     *
     * @return string
     */
    public static function getImage()
    {
        return self::$image;
    }


    /**
     * set image
     *
     * @param string $image
     * @return void
     */
    public static function setImage(string $image)
    {
        self::$image = $image;
    }
}