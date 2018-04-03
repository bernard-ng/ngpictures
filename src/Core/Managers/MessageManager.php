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
        "form_invalid_username" => "Votre pseudo n'est pas valide",
        "form_invalid_email" => "Cet adresse mail n'est pas valide",
        "form_invalid_password" => "les deux mdp ne correspondent pas",
        "form_empty_field" => "Complétez le champ"

    ];

    public static function get(string $key)
    {
        return self::$msg[$key] ?? null;
    }
}
