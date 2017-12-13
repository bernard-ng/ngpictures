<?php
namespace Ngpictures\Controllers;

use Ng\Core\Controllers\Controller;
use Ngpictures\Ngpic;



class NgpicController extends Controller
{
    protected   $viewPath,
                $layout,
                $session,
                $cookie,
                $str,
                $validator;


    protected $msg = [

        //general messages
        "indefined_error" => "Désolé une erreur c'est produite, veuillez réessayer",

        //admin controller messages
        'admin_delete_success' => 'La publication a bien été supprimé',
        'admin_delete_failed' => 'Une erreur est survenue lors de la suppression',
        'admin_delete_notAllowed' => "Vous n'avez pas le droit de suppression",
        'admin_delete_notFound' => "La publication n'existe pas ou plus",
        'admin_all_fields' => "Complétez tous les champs",
        'admin_file_notPicture' => "Le fichier à télécharger doit être une image",
        'admin_modified_success' => "La publication a bien été modifier",
        'admin_post_success' => "La publication a bien été effectuée",
        'admin_picture_required' => "Ajouter une photo de couverture",
        'admin_confirm_success' => "Publication en ligne",
        'admin_remove_success' =>"Publication hors ligne",

        //comment controller messages
        'comment_post_notFound' => "Cette publication n'éxiste pas ou plus",
        'comment_notFound' => "Ce commentaire n'éxiste pas ou plus",
        'comment_success' => "Merci pour votre commentaire",
        'comment_delete_success' => "Votre commentaire a bien été supprimé",
        'comment_edit_success' => "Votre commentaire a bien été modifié",
        'comment_delete_notAllowed' => "Vous n'avez pas le droit de suppression sur ce commentaire",
        'comment_edit_notAllowed' => "Vous n'avez pas le droit d'édition sur ce commentaire",
        'comment_required' => "Complétez le champ commentaire",

        //following controller messages
        'user_notFound' => "l'utilisateur n'a pas été trouvé",

        //users controller messages
        "user_must_login" => "Connectez-vous pour effectuer cette action",
        "user_not_confirmed" => "Votre compte n'a pas encore été confirmé",
        "user_registration_succes" => "Un email de confirmation de compte vous a été envoyé",
        "user_email_notFound" => "Aucun compte ne correspond à cet email",
        "user_reset_mail_success" => "Les instructions de rappelle de mot de passe vous ont été envoyées par mail",
        "user_logout_success" => "Vous êtes déconnecté",
        "user_login_success" => "Vous êtes connecté",
        "user_already_connected" => "Vous êtes déjà connecté",
        "user_bad_identifier" => "Mauvais pseudo ou mot de passe",
        "user_password_notMatch" => "vos deux mots de passe ne correspondent pas",
        "user_reset_password_success" => "Votre mot de passe a bien été mis à jour",
        "user_dont_have_account" => "Vous n'avez pas de compte ? créez en un",
        'user_forbidden' => "Vous n'avez pas le droit d'access à cette page",
        "user_confirmation_failed" => "Une erreur est survenu lors de votre confirmation",
        "user_username_tokken" => "Ce pseudo est deja pris",
        "user_usermail_tokken" => "Cette adresse mail est deja prise"

    ];


    public function __construct()
    {
        $this->viewPath = APP."/Views/";
        $this->layout = 'default';

        $Ngpic = Ngpic::getInstance();

        $this->session = $Ngpic->getSession();
        $this->cookie = $Ngpic->getCookie();
        $this->str = $Ngpic->getStr();
        $this->validator = $Ngpic->getValidator();
        $this->flash = $Ngpic->getFlash();
    }


    protected function loadModel($model)
    {
        $Ngpic = Ngpic::getInstance();

        if (is_string($model)) {
            return $this->$model = $Ngpic->getModel($model);
        } elseif (is_array($model)) {
            foreach ($model as $m) {
                $this->$m =  $Ngpic->getModel($m);
            }
        } else {
            return null;
        }
    }

    protected function callController(string $name)
    {
        return Ngpic::getInstance()->getController($name);
    }


    protected function setLayout(string $layout)
    {
        $this->layout = $layout;
    }
}
