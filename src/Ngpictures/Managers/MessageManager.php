<?php
namespace Ngpictures\Managers;

use \ArrayAccess;

class MessageManager implements ArrayAccess
{

    /**
     * gestionnaire de message flash par rapport au action
     * de l'application
     *
     * @var array
     */
    private $messages = [

        //GENERAL
        //***************************************************************************************/
        "undefined_error" => "Ooups, une erreur s'est produite, veuillez réessayer",
        "success" => "Action effectuée",
        "delete_not_allowed" => "Vous n'avez pas le droit de suppression",
        "edit_not_allowed" => "Vous n'avez pas le droit d'édition",
        "rss_empty" => "Notre flux RSS est actuellement vide",


        //PUBLICATIONS
        //****************************************************************************************/
        'post_delete_success' => 'Votre publication a bien été supprimée',
        'post_delete_failed' => 'Ooups, une erreur est survenue lors de la suppression',
        'post_edit_success' => "Votre publication a bien été édité",
        'post_not_found' => "Ooups, cette publication n'existe pas ou plus",
        'post_requires_picture' => "Ajouter une photo de couverture pour votre publication",
        'post_online_success' => "Votre publication est désormais publique",
        'post_already_online' => "Votre publication est déjà publique",
        'post_offline_success' => "Votre publication est désormais privée",
        'post_not_liked' => "Aucune mention j'aime pour cette publication",
        'post_remove_save' => "Publication Rétirée des enregistrerments",
        'post_saved' => "Publication ajoutée aux enregistrements",
        "post_htag_empty" => "Aucune publication pour ce Htag",
        "post_img_required" => "Veuillez choisir une photo",


        //FORM
        //**************************************************************************************** */
        'form_all_required' => "Tous les champs doivent être compléter",
        "form_multi_errors" => "Le formulaire a été mal rempli",
        'form_field_required' => "Le champ doit être complété",
        'form_bad_slug' => 'Le slug ne doit contenir que des chiffres, des lettres et des tirés',
        'form_idea_submitted' => "Ola, nous avons bien reçu votre idée",
        'form_comment_submitted' => "Votre commentaire a bien été posté",
        "form_post_submitted" => "Votre publication a bien été effectuée",
        'form_bug_submitted' => "Nous avons bien reçu votre message et comptons régler le bug dans le plus bref délais",
        "form_reset_submitted" => "Les instructions de rappel de mot de passe vous ont été envoyées par mail",
        "form_registration_submitted" => "Un email de confirmation de compte vous a été envoyé, veuillez le confirmer pour continuer",
        'form_contact_submitted' => 'Nous avons bien reçu votre message et comptons vous répondre dans le plus bref délais',
        'form_captcha_not_set' => "Confirmer que vous n'êtes pas un robot",
        'form_captcha_failed' => 'La validation du captcha a échoué, veuillez réessayer',


        //FILES
        //***************************************************************************************** */
        'files_not_image' => "Le fichier à télécharger doit être une image (jpg, jpeg, png, gif)",
        'files_not_uploaded' => "Ooups, votre image n'a pas pu être télécharger",
        'files_not_directory' => "Impossibe d'ouvrir le dossier demandé, veuillez réessayer",
        "files_download_failed" => "Ooups, une Erreur s'est produite lors du téléchargement",
        "files_not_found" => "La photo que vous désirer télécharger n'est plus disponible",


        //ADMIN
        //****************************************************************************************** */
        'admin_removed_admin' => "Suppression d'un administrateur",
        'admin_added_admin' => "Ajout d'un administrateur",



        //COMMENTS
        //******************************************************************************************* */
        'comment_not_found' => "Ce commentaire n'éxiste pas ou plus",
        'comment_delete_success' => "Votre commentaire a bien été supprimé",
        'comment_edit_success' => "Votre commentaire a bien été édité",


        'category_not_found' => "Cette catégorie n'éxiste pas ou plus",

        //USERS
        //******************************************************************************************* */
        'users_not_found' => "Cet utilisateur n'a pas été trouvé",
        "users_not_logged" => "Connectez-vous pour continuer",
        "users_not_confirmed" => "Ooups, votre compte n'a pas encore été confirmé",
        "users_email_notFound" => "Cette adresse mail ne correspond à aucun compte",
        "users_logout_success" => "Vous êtes maintenant déconnecté",
        "users_login_success" => "Vous êtes maintenant connecté",
        "users_already_connected" => "Ola, vous êtes déjà connecté",
        "users_bad_identifier" => "Vos identifiants sont incorrectes",
        "users_bad_password" => "Vos deux mots de passe ne correspondent pas",
        "users_short_password" => "Votre mot de passe doit faire au moins 8 caratères",
        "users_reset_success" => "Votre mot de passe a bien été changé",
        "users_propose_account" => "Vous n'avez pas de compte ? créez en un",
        'users_forbidden' => "Ooups, vous n'avez pas le droit d'access à cette page",
        "users_confirmation_failed" => "Aîe, une erreur est survenue lors de la confirmation de votre compte, veuillez réessayer plus tard",
        "users_username_token" => "Ce pseudo est déjà utilisé par un autre compte",
        "users_mail_token" => "Cette adresse mail est déjà utilisée par un autre compte",
        "users_phone_token" => "Ce numéro de mobile est déjà utilisé par un autre compte",
        "users_edit_success" => "Vos informations ont été mises à jour",
        "users_unfollowing_success" => "Vous ne suivez plus cet utilisateur",
        "users_following_success" => "Vous suivez cet utilisateur",
    ];


    public function offsetExists($offset)
    {
    }


    /**
     * renvoi la valeur de la key voulu
     *
     * @param string $offset
     * @return string|null
     */
    public function offsetGet($offset)
    {
        return $this->messages[$offset] ?? null;
    }


    public function offsetSet($offset, $value)
    {
    }


    public function offsetUnset($offset)
    {
    }
}
