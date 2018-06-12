<?php
namespace Ng\Core\Managers;

abstract class MessageManager
{
    private static $msg = [

        //GENERAL
        //***************************************************************************************/
        "undefined_error"           =>  "Ooups, une erreur s'est produite, veuillez réessayer",


        //IMAGE MANAGER
        //**************************************************************************************/
        'files_not_image'           =>  'Le fichier téléchargé doit être une image (jpg, jpeg, git, png)',
        'files_not_uploaded'        =>  'Une erreur est survenu lors du téléchargement de l\'image',
        'files_too_big'             =>  'Votre image est trop grande, elle ne doit pas dépasser 6 Mo',


        //VALIDATOR
        //***************************************************************************************
        "form_invalid_username"     =>  "Votre pseudo n'est pas valide",
        "form_invalid_username_num" => "Votre pseudo doit contenir au moins une lettre",
        "form_invalid_email"        =>  "Cet adresse mail n'est pas valide",
        "form_invalid_password"     =>  "les deux mdp ne correspondent pas",
        "form_invalid_data"         =>  "donnée invalide",
        "form_empty_field"          =>  "Complétez le champ"

    ];

    public static function get(string $key)
    {
        return self::$msg[$key] ?? null;
    }
}
