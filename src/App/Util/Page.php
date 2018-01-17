<?php
namespace Ngpictures\Util;


use Ng\Core\Generic\{Collection,Str};



class Page {

    /**
     * les description des pages
     * @var array
     */
    private static $names = [
		"actualités" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",

		"blog" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation",

		"gallerie" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",

		"connexion" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",

		"inscription" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",

		"apropos" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
	];

    /**
     * les icons
     * @var array
     */
    private static $icons = [
		"actualités" => "icon-globe",
		"blog" => "icon-pencil",
		"gallerie" => "icon-picture",
		"connexion" => "icon-lock",
		"inscription" => "icon-user",
		"apropos" => "icon-info-sign"
	];

    /**
     * les metas qu'on peut ajouter
     * @var array
     */
    private static $meta = [];


    /**
     * le nom de la page
     * @var string
     */
    public static $pageName = "Ngpictures";


    /**
     * getter du nom de la page
     * @return string
     */
    public static function getName()
    {
        return self::$pageName;
    }


    /**
     * setter du nom de la page
     * @param string $name
     * @return string
     */
    public static function setName(string $name)
    {
        self::$pageName = $name;
        return self::getName();
    }


    /**
     * permet de recupere le nom de la page a travers son titre
     * @return string
     */
    public static function getTitle()
    {
        $title = explode('|', self::getName());
        return trim($title[0]);
    }


    /**
     * getter de la description de la page
     * @return null
     */
    public static function getDescription()
	{
		$pages = new Collection(self::$names);
		return $pages->get(strtolower(self::getTitle()));
	}


    /**
     * get de l'icon de la page
     * @return null
     */
    public static function getIcon()
	{
		$icons = new Collection(self::$icons);
		return $icons->get(strtolower(self::getTitle()));
	}


    /**
     * setter des metas sur une page
     * @param array $data
     */
    public static function setMeta(array $data = [])
	{
		self::$meta[] = $data;
	}

    /**
     * getter des metas sur une page
     */
    public static function getMeta()
	{
		foreach (self::$meta as $meta) {
            $array_meta = [];

            foreach ($meta as $k => $v) {
                $array_meta[] = "{$k} ='{$v}' ";
            }

            $data_meta = implode(' ',$array_meta);
            echo "<meta {$data_meta} >";
		}
	}
}

