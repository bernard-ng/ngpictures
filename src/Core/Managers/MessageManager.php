<?php
namespace Ng\Core\Managers;

/**
 * tous les messages
 */
abstract class MessageManager
{
    private static $msg = [

        //GENERAL
        //***************************************************************************************/
        "undefined_error" => "Ooups, une erreur s'est produite, veuillez réessayer",

        //IMAGE MANAGER
        //**************************************************************************************/
        'files_not_image' => 'Le fichier téléchargé doit être une image (jpg, jpeg, git, png)',
        'files_not_uploaded' => 'Une erreur est survenu lors du téléchargement de l\'image',
        'files_too_big' => 'Votre image est trop grande, elle ne doit pas dépasser 10 Mo',


        //VALIDATOR
        //***************************************************************************************
        "isKebabCase" => "Votre pseudo n'est pas valide",
        "isUnique" => "Cet information est deja utiliser",
        "isEmail" => "Cet adresse mail n'est pas valide",
        "isMatch" => "Les deux champs ne correspondent pas",
        "isEmpty" => "Complétez le champ"
       
    ];

    public static function get(string $key)
    {
        return self::$msg[$key] ?? null;
    }
}
