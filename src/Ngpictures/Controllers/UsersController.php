<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Managers\PageManager;
use Ng\Core\Managers\Mailer\Mailer;
use Ngpictures\Ngpictures;
use ReCaptcha\ReCaptcha;


class UsersController extends Controller
{

    /**
     * charge le model d'utilisateur
     * UsersController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('users');
    }


    /**
     * confirmation d'un utilisateur
     * @param $users_id
     * @param string $token
     */
    public function confirm(int $users_id, string $token)
    {
        $this->authService->confirm($users_id, $token);
    }


    /**
     * permet de reset un mot de pass pour un utilisateur
     * @param $users_id
     * @param string $token
     * @return void
     */
    public function reset($users_id, string $token)
    {
        $user   =   $this->users->find(intval($users_id));
        $token  =   $this->str::escape($token);
        $errors =   new Collection();

        if ($user && $user->reset_token == $token) {
            $post = new Collection($_POST);

            if (isset($_POST) and !empty($_POST)) {
                $this->validator->setRule('password', ["must_match[password_confirm]", "min_length[6]"]);
                $this->validator->setRule('password_confirm', ["must_match[password]", "min_length[6]"]);

                if ($this->validator->isValid()) {
                    $password = $this->str::hashPassword($post->get('password'));
                    $this->users->resetPassword($password, $user->id);

                    $this->flash->set('success', $this->msg['users_reset_success']);
                    $this->authService->reConnect($user);
                    $this->app::redirect($user->accountUrl);
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->isAjax() ?
                        $this->ajaxFail($errors->asJson(), 403) :
                        $this->flash->set('danger', $this->msg['form_multi_errors']);
                }
            }

            $this->pageManager::setName("Rénitialisation du mot de passe");
            $this->viewRender('frontend/users/account/reset', compact('post','errors'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * mot de pass oubliee
     */
    public function forgot()
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('email', ['valid_email']);

            if ($this->validator->isValid()) {
                $email  =    $this->str::escape($post->get('email'));
                $user   =    $this->users->findWith('email', $email);

                if ($user && $user->confirmed_at != null) {
                    $this->users->setResetToken($this->str::setToken(60), $user->id);
                    $user   =   $this->users->find($user->id);
                    $link   =   SITE_NAME."/reset/{$user->id}/{$user->reset_token}";

                    (new Mailer())->resetPassword($link, $email);
                    $this->flash->set('success', $this->msg['users_reset_success']);
                    $this->isAjax()? $this->ajaxRedirect("/login") : $this->app::redirect('/login');
                } else {
                    $this->isAjax()?
                        $this->ajaxFail($this->msg['users_email_notFound']):
                        $this->flash->set('danger', $this->msg['users_email_notFound']);
                }
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->isAjax() ?
                    $this->ajaxFail($errors->asJson(), 403) :
                    $this->flash->set('danger', $this->msg['form_multi_errors']);
            }
        }

        $this->app::turbolinksLocation("/forgot");
        $this->pageManager::setName('Mot de passe oublié');
        $this->setLayout('users/default');
        $this->viewRender('frontend/users/account/forgot', compact('post', 'errors'));
    }


    /**
     * creation d'un compte
     * page de vue
     */
    public function sign()
    {
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule("email", 'valid_email', 'required');
            $this->validator->setRule("name", ['required', "alpha_dash", "min_length[3]"]);
            $this->validator->setRule("password", ['required', "must_match[password_confirm]", "min_length[6]"]);
            $this->validator->setRule('password_confirm', ['required', "must_match[password]", "min_length[6]"]);

            if (true) { //$this->validator->isValid()) {
                if(true) { //$post->get('g-recaptcha-response')) {
                   /* $recaptchaResponse = (new ReCaptcha(RECAPTCH_API_KEY))
                        ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);*/

                    if(true) {//$recaptchaResponse->isSuccess()) {
                        $this->validator->unique("name", $this->users, $this->msg['users_username_token']);
                        $this->validator->unique("email", $this->users, $this->msg['users_mail_token']);

                        if ($this->validator->isValid()) {
                            $this->authService->register($post->get('name'), $post->get('email'), $post->get('password'));
                            $this->flash->set('success', $this->msg['users_registration_success']);
                            $this->app::redirect("/login");
                        } else {
                            $errors = new Collection($this->validator->getErrors());
                            $this->flash->set("danger", $this->msg['form_multi_errors']);
                        }
                    } else {
                        $errors = new Collection($this->validator->getErrors());
                        $this->flash->set("danger", $this->msg['form_captcha_failed']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->flash->set("danger", $this->msg['form_captcha_not_set']);
                }
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->flash->set("danger", $this->msg['form_multi_errors']);
            }
        }

        $this->app::turbolinksLocation("/sign");
        $this->pageManager::setName("Inscription");
        $this->setLayout('users/default');
        $this->viewRender('frontend/users/sign', compact('post', 'errors'));
    }


    /**
     * permet de connecter un utilisateur
     * page de vue
     */
    public function login()
    {
        $this->authService->cookieConnect();
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if ($this->authService->isLogged()) {
            $this->flash->set('warning', $this->msg['users_already_connected']);
            $this->app::redirect($this->authService->isLogged()->accountUrl);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', 'required');
                $this->validator->setRule('password', 'required');

                if ($this->validator->isValid()) {
                    $name       =   $this->str::escape($post->get('name'));
                    $remember   =   intval($post->get('remember'));
                    $password   =   $post->get('password');

                    $user  = $this->users->findAlternative(['name','email'], $name);
                    if ($user) {
                        if ($user->confirmed_at !== null) {
                            if (password_verify($password, $user->password)) {
                                $this->authService->connect($user);
                                if ($remember) {
                                    $this->authService->remember($user->id);
                                }

                                $this->isAjax()?
                                    $this->ajaxRedirect($user->accountUrl):
                                    $this->flash->set('success', $this->msg['users_login_success']);
                                    $this->app::redirect($user->accountUrl);
                            } else {
                                $this->isAjax()?
                                    $this->ajaxFail($this->msg['users_bad_identifier']) :
                                    $this->flash->set('danger', $this->msg['users_bad_identifier']);
                            }
                        } else {
                            $this->isAjax()?
                                $this->ajaxFail($this->msg['users_not_confirmed']) :
                                $this->flash->set('warning', $this->msg['users_not_confirmed']);
                        }
                    } else {
                        $this->isAjax() ?
                            $this->ajaxFail($this->msg['users_bad_identifier']) :
                            $this->flash->set('danger', $this->msg['users_bad_identifier']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->isAjax() ?
                        $this->ajaxFail($errors->asJson(), 403) :
                        $this->flash->set('danger', $this->msg['form_multi_errors']);
                }
            }

            $this->app::turbolinksLocation("/login");
            $this->pageManager::setName('Connexion');
            $this->viewRender('frontend/users/login', compact('post', 'errors'));
        }
    }


    /**
     * permet de deconnecter un utilisateur
     */
    public function logout()
    {
        $this->cookie->delete(COOKIE_REMEMBER_KEY);
        $this->session->delete(AUTH_KEY);
        $this->session->delete(TOKEN_KEY);
        $this->flash->set('success', $this->msg['users_logout_success']);
        $this->app::redirect("/login");
    }



    // Account management
    //--------------------------------------------------------------------------


    /**
     *  permet de generer le profile d'un utilisateur
     *  page de vue
     * @param string $username
     * @param int $id
     */
    public function account(string $username, $id)
    {
        if (!empty($username)) {
            $user = $this->users->find(intval($id));

            if ($user) {
                $posts  =   $this->loadModel('posts')->findWith('users_id', $user->id, false);

                $this->app::turbolinksLocation($user->accountUrl);
                $this->pageManager::setName($user->name);
                $this->setLayout('users/account');
                $this->viewRender('frontend/users/account/account', compact( "user", "posts"));
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * permet de generer la page d'edition d'un utilisateur
     * @param string $token
     */
    public function edit(string $token)
    {
        $this->authService->restrict();
        if ($token === $this->authService->getToken()) {
            $user       =   $this->authService->isLogged();
            $post       =   new Collection($_POST);
            $file       =   new Collection($_FILES);
            $errors     =   new Collection();

            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', ['required', 'min_length[3]']);
                $this->validator->setRule('email', ['required', 'valid_email']);

                if ($this->validator->isValid()) {
                    if ($post->get('name') !== $user->name) {
                        $this->validator->unique('name', $this->users, $this->msg['users_username_token']);
                    } elseif ($post->get('email') !== $user->email) {
                        $this->validator->unique('email', $this->users, $this->msg['users_email_token']);
                    } elseif ($post->get('phone') !== $user->phone) {
                        $this->validator->unique('phone', $this->users, $this->msg['users_phone_token']);
                    }

                    if ($this->validator->isValid()) {
                        $name       =    $this->str::escape($post->get('name'));
                        $email      =    $this->str::escape($post->get('email'));
                        $bio        =    $this->str::escape($post->get('bio'))      ??  "Hey suis sur Ngpictures 2.0";
                        $phone      =    $this->str::escape($post->get('phone'))    ??  null;

                        $this->users->update($user->id, compact('name', 'email', 'phone', 'bio'));
                        $user = $this->users->find($user->id);
                        $this->authService->reConnect($user, $this->msg['users_edit_success']);
                        $this->app::redirect($user->accountUrl);
                    } else {
                        $this->isAjax()?
                            $this->ajaxFail($errors->asJson(), 403):
                            $this->flash->set('danger', $this->msg['form_multi_errors']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->isAjax()?
                        $this->ajaxFail($errors->asJson(), 403):
                        $this->flash->set('danger', $this->msg['form_multi_errors']);
                }
            } elseif (!empty($file->get('thumb'))) {
                $isUploaded = ImageManager::upload($file, 'avatars', "ngpictures-avatar-{$user->id}", 'medium');

                if ($isUploaded) {
                    $this->users->update($user->id, ['avatar' => "ngpictures-avatar-{$user->id}.jpg"]);
                    $user = $this->users->find($user->id);
                    $this->authService->reConnect($user, $this->msg['users_edit_success']);
                    $this->app::redirect($user->accountUrl);
                } else {
                    $this->isAjax()?
                        $this->ajaxFail($this->msg['files_not_uploaded']):
                        $this->flash->set('danger', $this->msg['files_not_uploaded']);
                }
            }

            $this->app::turbolinksLocation("/settings/{$token}");
            $this->pageManager::setName('Paramètres');
            $this->viewRender('frontend/users/account/edit', compact('user', 'errors'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}
