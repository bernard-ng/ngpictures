<?php
namespace Ngpictures\Managers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ConfigManager;
use Ng\Core\Managers\StringManager;

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
    public static $pageTitle = "Ngpictures";


    /**
     * retourne le nom de la page courante
     * @return string
     */
    public static function getName(): string
    {
        return self::$pageTitle;
    }


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
     * @param string $name
     * @return string
     */
    public static function setName(string $name): string
    {
        $config = new ConfigManager(ROOT."/config/SystemConfig.php");
        self::$pageTitle = $name . " | " . $config->get('site.name');
        return self::getName();
    }


    /**
     * defini des metas pour la page courante
     * @param array $data
     */
    public static function setMeta(array $data = [])
    {
        self::$meta[] = $data;
    }


    /**
     * permet de generer des metas
     * dans les views
     */
    public static function getMeta()
    {
        foreach (self::$meta as $meta) {
            $array_meta = [];

            foreach ($meta as $k => $v) {
                $array_meta[] = "{$k} ='{$v}' ";
            }

            $data_meta = implode(' ', $array_meta);
            echo "<meta {$data_meta} >";
        }
    }
}
