<?php
namespace Ngpictures\Controllers;

use Ng\Core\Generic\{
    Collection, Image, Mailer\MailSender
};
use Ngpictures\Entity\UsersEntity;
use Ngpictures\Ngpic;
use Ngpictures\Util\Page;



class UsersController extends NgpicController
{

    /**
     * charge le model d'utilisateur
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('users');
    }


    /**
     * les differents models pour les publication des users
     * @var array
     */
    private $types = [1 => "articles","gallery"];


    /***************************************************************************
    *                    ACCOUNT CREATION && SETTINGS
    ****************************************************************************/
    /**
     * confirmation d'un utilisateur
     * @param $user_id
     * @param string $token
     */
    public function confirm($user_id, string $token)
    {
        $user_id = $this->str::escape($user_id);
        $user = $this->users->isNotConfirmed($user_id);
        
        if ($user && $user->confirmation_token === $token) {
            $this->users->unsetConfirmationToken($user->id);
            $this->connect($user);
            $this->login();
        } else {
            $this->flash->set('danger', $this->msg['user_confirmation_failed']);
            $this->login();
        }
    }


    /**
     * permet de reset un mot de pass pour un utilisateur
     * @param $id
     * @param string $token
     */
    public function reset($id, string $token)
    {
        $user = $this->users->find($id);

        if ($user && $user->reset_token == $token) {
            $post = new Collection($_POST);

            if (isset($_POST) and !empty($_POST)) {
                if (!empty($post->get('password')) && !empty($post->get('password_confirm'))) {
                    $validator = $this->validator;
                    $validator->isMatch('password','password_confirm', $this->msg['user_password_notMatch']);
                    if ($validator->isValid()) {
                        $password = $this->str::hashPassword($post->get('password'));
                        $this->users->resetPassword($password, $user->id);

                        $this->flash->set('success', $this->msg['user_reset_password_success']);
                        $this->connect($user);
                        Ngpic::redirect($user->accountUrl);
                    }
                } else {
                    $this->flash->set('danger', $this->msg['admin_all_fields']);
                }
            }

            Page::setName("Rénitialisation du mot de passe | Ngpictures");
            $this->setLayout('users/default');
            $this->viewRender('users/reset', compact('post'));
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }


    /**
     * mot de pass oubliee
     */
    public function forgot()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            if(!empty($post->get('email'))) {
                $email = $this->str::escape($post->get('email'));
                $user = $this->users->findWith('email',$email);

                if ($user && $user->confirmed_at != null) {
                    $this->users->setResetToken($this->str::setToken(60), $user->id);
                    $user = $this->users->find($user->id);

                    $link = "http://ngpictures.dev/reset/{$user->id}/{$user->reset_token}";
                    $mailer = new MailSender();
                    $mailer->resetPassword($link, $email);

                    //$this->flash->set('success',$this->msg['user_reset_mail_success']);
                    //Ngpic::redirect('/login');

                } else {
                    $this->flash->set('danger',$this->msg['user_email_notFound']);
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName('Mot de passe oublié | Ngpictures');
        $this->setLayout('users/default');
        $this->viewRender('users/forgot', compact('post'));
    }


    /**
     * cree un nouvel utilisateur
     * @param string $name
     * @param string $email
     * @param string $password
     */
    private function register(string $name, string $email, string $password)
    {
        $password = $this->str::hashPassword($password);
        $name = $this->str::escape($name);
        $email = $this->str::escape($email);
        $token = $this->str::setToken(60);
        $this->users->add($name,$email,$password,$token);

        $user_id = $this->users->lastInsertId();
        $link = "http://ngpictures.dev/confirm/{$user_id}/{$token}";

        $mailer = new MailSender();
        $mailer->accountConfirmation($link, $email);
        $this->flash->set('success', $this->msg['user_registration_success']);
        Ngpic::redirect('/login');
    }


    /**
     * creation d'un compte
     * page de vue
     */
    public function sign()
    {
        $validator = $this->validator;
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {

            $validator->iskebabCase("name");
            if ($validator->isValid()) {
                $validator->isUnique("name", $this->users, $this->msg['user_username_tokken']);
            }

            $validator->isEmail("email");
            if ($validator->isValid()) {
                $validator->isUnique("email", $this->users, $this->msg['user_mail_tokken']);
            }
            $validator->isMatch("password", "password_confirm", $this->msg['user_password_notMatch']);

            if ($validator->isValid()) {
                $this->register($post->get('name'), $post->get('email'), $post->get('password'));
                $this->flash->set('success', $this->msg['user_registration_success']);
                Ngpic::redirect("/login");
            } else {
                var_dump($this->validator->getErrors());
            }
        }
        Page::setName("Inscription | Ngpictures");
        $this->setLayout('users/default');
        $this->viewRender('users/sign', compact('post'));
    }


    
    /***************************************************************************
    *                   LOGIN SYSTEM && RESTRICTIONS
    ****************************************************************************/
    /**
     * interdire l'access a certaines pages
     * @param string|null $msg
     */
    public function restrict(string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->flash->set("danger", $msg ?? $this->msg["user_must_login"]);
            Ngpic::redirect(true);
        }
    }


    /**
     * admettre une action seulement pour un admin
     */
    public function isAdmin()
    {
        $this->restrict();
        if ($this->session->getValue(AUTH_KEY,'rank') !== 'admin') {
            $this->flash->set('warning', $this->msg['user_forbidden']);
            Ngpic::redirect(true);
        }
    }

    /**
     * permet de dire si un utilisateur est online
     * @return bool|mixed|null
     */
    private function isLogged()
    {
        if ($this->session->hasKey(AUTH_KEY)) {
            return $this->session->read(AUTH_KEY);
        }
        return false;
    }


    /**
     * permet de connecter un utilisateur
     * et de definir son token csrf
     * @param UsersEntity $user
     * @param string $msg
     */
    private function connect(UsersEntity $user, string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->session->write(AUTH_KEY, $user);
            $this->session->write('token', $this->str::setToken(60));
            $this->flash->set('success', $msg ?? $this->msg['user_login_success']);
        }
    }


    /**
     * permet de connecter un utilisateur a partir d'un cookie
     */
    public function cookieConnect()
    {        if ($this->cookie->hasKey("rembember") && !$this->isLogged()) {
            $remember_token = $this->cookie->read("remember");
            $parts = explode(".", $remember_token);
            $user = $this->users->find($parts[2]);
            
            if ($user) {
                $expected = "NG.23.".$user->id.".".$user->remember_token;
                if ($expected === $remember_token) {
                    $this->connect($user);
                    $this->cookie->write("remember", $remember_token);
                } else {
                   $this->cookie->delete("remember");
                }
            } else {
                $this->cookie->delete("remember");
            }
        }
    }

    /**
     * definit un remember token
     * @param int $user_id
     */
    private function remember(int $user_id)
    {
        $remember_token = $this->str::cookieToken();
        $this->users->setRememberToken($remember_token, $user_id);
        $this->cookie->write("remember","NG.23.{$user_id}.{$remember_token}");
    }


    /**
     * permet de connecter un utilisateur
     * page de vue
     */
    public function login()
    {
        $this->cookieConnect();
        $post = new Collection($_POST);

        if ($this->isLogged()) {
            $this->flash->set('warning', $this->msg['user_already_connected']);
            Ngpic::redirect($this->isLogged()->accountUrl);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $password = $post->get('password');
                $name = $this->str::escape($post->get('name'));
                $remember = intval($post->get('remember'));

                if ($post->has('password') && $post->has('name')) {
                    $user  = $this->users->findAlternative(['name','email'], $name);
                    if($user) {
                        if ($user->confirmed_at !== null) {
                            if (password_verify($password, $user->password)) {
                                $this->connect($user);
                                if ($remember) {
                                    $this->remember($user->id);
                                }
                                $this->flash->set('success', $this->msg['user_login_success']);
                                Ngpic::redirect($user->accountUrl);
                            } else {
                                $this->flash->set('danger', $this->msg['user_bad_identifier']);
                            }
                        } else {
                            $this->flash->set('warning', $this->msg['user_not_confirmed']);
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['user_bad_identifier']);
                    }
                }
            }

            Page::setName('Connexion | Ngpictures');
            $this->setLayout('users/default');
            $this->viewRender('users/login',compact('post')); 
        }
    }


    /**
     * permet de deconnecter un utilisateur
     */
    public function logout()
    {
        $this->cookie->delete("remember");
        $this->session->delete(AUTH_KEY);
        $this->session->delete("token");
        $this->flash->set('success', $this->msg['user_logout_success']);
        Ngpic::redirect("/login");
    }


    /***************************************************************************
    *                         ACCOUNT MANAGEMENT
    ****************************************************************************/
    /**
     *  permet de generer le profile d'un utilisateur
     *  page de vue
     * @param $username
     * @param $id
     */
    public function account($username, $id)
    {
        if (!empty($username) && !empty($id)) {

            $user = $this->users->find(intval($id));
        
            if ($user && $this->str::checkUserUrl($username, $user->name) == true ) {

                $verse = $this->callController('verses')->index();
                Page::setName($user->name . " | Ngpictures");
                $this->setLayout('users/account');
                $this->viewRender('users/account', compact("verse","user"));
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }


    /**
     * permet de generer la page d'edition d'un utilisateur
     * @param string $username
     * @param $id
     * @param string $token
     */
    public function edit(string $username, $id, string $token)
    {
        if ($token === $this->session->read('token')) {
            $user = $this->users->find($id);
            
            if ($user && $this->str::checkUserUrl($username, $user->name) == true  ) {
                $post = new Collection($_POST);
                $file = new Collection($_FILES);

                if (isset($_POST) && !empty($_POST)) {
                    $bio = $this->str::escape($post->get('bio')) ?? $user->bio;

                    if ($post->get('name') && $post->get('name') !== $user->name) {
                        $this->validator->isKebabCase('name');
                        if ($this->validator->isValid()) {
                            $this->validator->isUnique('name', $this->users, $this->msg['user_username_tokken']);
                            $name = $this->str::escape($post->get('name'));
                        }
                    } else {
                        $name = $user->name;
                    }

                    if ($post->get('email') && $post->get('email') !== $user->email) {
                        $this->validator->isEmail('email');
                        if ($this->validator->isValid()) {
                            $this->validator->isUnique('email', $this->users, $this->msg['user_mail_tokken']);
                            $email = $this->str::escape($post->get('email'));
                        }
                    }

                    if ($post->get('phone') && $post->get('phone') !== $user->phone) {
                        $this->validator->isUnique('phone', $this->users, $this->msg['user_phone_tokken']);
                        $phone = $this->str::escape($post->get('phone'));
                    } else {
                        $phone = $user->phone;
                    }

                    if ($this->validator->isValid()) {
                        $this->users->update($user->id, compact('name','email','phone','bio'));
                        $user = $this->users->find($user->id);
                        $this->session->write(AUTH_KEY, $user);
                        $this->flash->set('success', $this->msg['user_edit_success']);
                        Ngpic::redirect($user->accountUrl);
                    }
                } elseif (!empty($file->get('thumb'))) {

                    $name = "{$user->name}-{$id}";
                    $isUploaded = Image::upload($file, 'avatars', "ngpictures-{$name}", 'medium');

                    if ($isUploaded) {
                        $this->users->update($user->id, ['avatar' => "ngpictures-{$name}.jpg"]);
                        $user = $this->users->find($user->id);
                        $this->session->write(AUTH_KEY, $user);
                        $this->flash->set('success', $this->msg['user_edit_success']);
                        Ngpic::redirect($user->accountUrl);
                    }
                }
                Page::setName('Edition du profile | Ngpictures');
                $this->setLayout('users/edit');
                $this->viewRender('users/edit', compact('user'));
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }


    /***************************************************************************
     *                         USERS POSTS MANAGEMENT
     ****************************************************************************/

    /**
     * index pour les publications
     */
    public function post()
    {
        Page::setName("Publier un article ou une photo | Ngpictures");
        $this->setLayout("users/account");
        $this->viewRender("users/posts/index");
    }


    public function postArticle()
    {
        $this->restrict();
        $this->loadModel('articles');
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('title')) && !empty($post->get('content')) && !empty($file->get('thumb.name'))) {

                $title = $this->str::escape($post->get('title'));
                $content = $this->str::escape($post->get('content'));
                $slug = $this->str::slugify($title);
                $category_id = ($post->get('category') == 0) ? 1 : $post->get('category');
                $user_id = (int) $this->session->getValue(AUTH_KEY,'id');

                if (isset($_FILES) && !empty($_FILES)) {
                    if (!empty($file->get('thumb.name'))) {
                        if ($this->validator->isValid()) {
                            $this->articles->create(compact('user_id', 'title', 'content', 'slug', 'category_id'));

                            $last_id = $this->articles->lastInsertId();
                            $isUploaded = Image::upload($file, 'articles', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                $this->articles->update($last_id, ['thumb' => "ngpictures-{$slug}-{$last_id}.jpg"]);
                                $this->flash->set('success', $this->msg['admin_post_success']);
                                Ngpic::redirect("/account/post");
                            } else {
                                $this->flash->set('danger', $this->msg['admin_file_notUploaded']);
                                $this->articles->delete($last_id);
                            }
                        } else {
                            var_dump($this->validator->getErrors());
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['admin_picture_required']);
                    }
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName("Publier un article | Ngpictures");
        $this->viewRender("users/posts/article.add",compact('post','categories'));
    }


    public function editArticle($slug , $id, $token)
    {
        $this->restrict();
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC');

       if ($token == $this->session->read('token')) {
           $post = new Collection($_POST);
           $article = $this->articles->find(intval($id));
           $post = new Collection($data ?? $_POST);

           if (isset($_POST) && !empty($_POST)) {
               if (!empty($post->get('content')) && !empty($post->get('title'))) {

                   $this->validator->isEmpty('title', $this->msg['admin_all_fields']);
                   $this->validator->isEmpty('content', $this->msg['admin_all_fields']);

                   if ($this->validator->isValid()) {
                       $title = $this->str::escape($post->get('title'));
                       $content = $post->get('content');
                       $slug = $this->str::slugify($title);
                       $category_id = (int) $post->get('category') ?? 1;

                       $this->articles->update($id, compact('title', 'content', 'slug', 'category_id'));
                       $this->flash->set("success", $this->msg['admin_modified_success']);
                       Ngpic::redirect("/account/post");
                   } else {
                       var_dump($this->validator->getErrors());
                   }
               } else {
                   $this->flash->set('danger', $this->msg['admin_all_fields']);
               }
           }

           Page::setName("Publier un article | Ngpictures");
           $this->viewRender("users/posts/article.edit",compact('post','categories'));
       }
    }


    public function postGallery()
    {
        $this->restrict();
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC');

        if (!empty($_FILES)) {
            $this->loadModel('gallery');
            if (empty($post->get('name'))) {
                $name = strtolower(uniqid("ngpictures-"));
            } else {
                $name = $this->str::escape($post->get('name'));
            }
            $description = $this->str::escape($post->get('description')) ?? null;
            $tags = $this->str::escape($post->get('tags')) ?? null;
            $category_id = (int)$post->get('category') ?? 1;
            $slug = $this->str::slugify($name);
            $user_id = $this->session->getValue(AUTH_KEY, 'id');

            if (!empty($file->get('thumb'))) {
                $this->gallery->create(compact('user_id', 'name', 'description', 'tags', 'category_id', 'slug'));
                $last_id = $this->gallery->lastInsertId();
                $isUploaded = Image::upload($file, 'pictures', "{$name}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    Image::upload($file, 'pictures-thumbs', "{$name}-{$last_id}", 'medium');

                    $this->gallery->update($last_id, ["thumb" => "{$name}-{$last_id}.jpg"]);
                    $this->flash->set('success', $this->msg['admin_post_success']);
                    Ngpic::redirect("/account/post");

                } else {
                    $this->flash->set('danger', $this->msg['admin_file_notUploaded']);
                    $this->gallery->delete($last_id);
                }
            } else {
                $this->flash->set('danger', $this->msg['admin_picture_required']);
                Ngpic::redirect(true);
            }
        }

        Page::setName("Publier un article | Ngpictures");
        $this->viewRender("users/posts/gallery.add",compact('post', 'categories'));
    }


    /**
     * edition des information d'une photo de gallery
     * @param string $slug
     * @param int $id
     * @param string $token
     */
    public function editGallery($slug, $id, $token)
    {
        $this->restrict();
        if ($token == $this->session->read('token')) {
            $photo = $this->gallery->find(intval($id));
            $post = new Collection($_POST);
            $categories = $this->loadModel('categories')->orderBy('title', 'ASC');
            if ($photo && $photo->id == $this->session->getValue(AUTH_KEY,'id')) {
                if (isset($_POST) && !empty($_POST)) {
                    $name = $this->str::escape($post->get('name')) ?? $post->name;
                    $description = $this->str::escape($post->get('description')) ?? $post->description;
                    $tags = $this->str::escape($post->get('tags')) ?? $post->tags;
                    $category_id = (int) $post->get('category') ?? $post->category_id;
                    $slug = $this->str::slugify($name);
                }
            } else {
                if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }

            Page::setName("Edition photo | Ngpictures");
            $this->viewRender("/users/posts/gallery.edit", compact('post', 'categories'));

        } else {
            if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }


    /**
     * suppression des publications des users
     * @param int $t
     * @param int $id
     * @param string $token
     */
    public function delete($t, $id, $token)
    {
        $this->restrict();
        $model = $this->loadModel($this->types[intval($t)]);
        $post = $model->find(intval($id));

        if ($this->session->read('token') == $token) {
            if ($post && $post->user_id == $this->session->getValue(AUTH_KEY,'id')) {
                $model->delete($post->id);
                if ($this->isAjax()) {
                    exit();
                }
                $this->flash->set('success', $this->msg['admin_delete_success']);
                Ngpic::redirect(true);
            } else {
                if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            if ($this->isAjax()) $this->ajaxFail($this->msg['admin_delete_notAllowed']);
            $this->flash->set('danger', $this->msg['admin_delete_notAllowed']);
            Ngpic::redirect(true);
        }
    }
}

