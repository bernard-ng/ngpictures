<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Application\Controllers;

use Application\Entities\UsersEntity;
use Application\Events\UserRegisterEvent;
use Application\Managers\PageManager;
use Application\Repositories\UsersRepository;
use Application\Repositories\Validators\UsersValidator;
use Awurth\SlimValidation\Validator;
use Framework\Auth\AuthInterface;
use Framework\Interfaces\CookieInterface;
use Framework\Managers\StringHelper;
use Psr\Container\ContainerInterface;

/**
 * Class AuthController
 * @package Application\Controllers
 */
class AuthController extends Controller
{

    /**
     * @var UsersRepository|mixed
     */
    private $users;

    /**
     * @var AuthInterface|mixed
     */
    private $auth;

    /**
     * @var CookieInterface
     */
    private $cookie;

    /**
     * AuthController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->users = $container->get(UsersRepository::class);
        $this->auth = $container->get(AuthInterface::class);
        $this->cookie = $container->get(CookieInterface::class);
    }

    /**
     * @param string $token
     */
    public function confirm(string $token): void
    {
        $user = $this->users->findWith('confirmation_token', $token);
        if ($user) {
            $this->users->update($user->id, ['confirmation_token' => ""]);
            $this->flash->success('users_confirmation_success');
            $this->auth->connect($user);
            $this->route('users.profile', ['slug' => $user->slug]);
        } else {
            $this->flash->set('danger', 'users_confirmation_failed');
            $this->route('auth.login');
        }
    }

    /**
     * @param string $token
     */
    public function reset(string $token): void
    {
        $user = $this->users->findWith('reset_token', $token);
        if ($user) {
            if ($this->request->is('post')) {
                $input = $this->request->input();
                $validator = $this->container->get(Validator::class);
                $validator->validate($input->toArray(), UsersValidator::getResetValidationRules());

                if ($validator->isValid()) {
                    if ($input->get('password') == $input->get('password_confirm')) {
                        $password = StringHelper::hashPassword($input->get('password'));
                        $this->users->update($user->id, compact('password'));

                        $this->auth->updateConnexion($user);
                        $this->flash->success('users_reset_success');
                        $this->redirect();
                    } else {
                        $errors = [
                            'password' => ['Les mot de passe doivent correspondre'],
                            'password_confirm' => ['Les mot de passe doivent correspondre']
                        ];
                        $this->flash->error('form_multi_errors');
                    }
                } else {
                    $errors = $validator->getErrors();
                    $this->flash->error('form_multi_errors');
                }
            }

            PageManager::setTitle("Rénitialisation du mot de passe");
            $this->view('frontend/users/account/reset', compact('input', 'errors'));
        } else {
            $this->flash->error('undefined_error');
            $this->redirect();
        }
    }

    public function forgot(): void
    {
        if ($this->request->is('post')) {
            $input = $this->request->input();
            $validator = $this->container->get(Validator::class);
            $validator->validate($input->toArray(), UsersValidator::getForgotValidationRules());

            if ($validator->isValid()) {
                $email = $input->get('email');
                $user = $this->users->findWithEmail($email);

                if ($user) {
                    $token = StringHelper::setToken(60);
                    $this->users->update($user->id, ['reset_token' => $token]);
                    $link = SITE_NAME . $this->url('auth.reset', compact('token'));
                    $email = $user->email;

                    $this->emitter->emit(UserRegisterEvent::class, compact('link', 'email'));
                    $this->flash->set('success', 'form_reset_submitted');
                    $this->route('auth.login');
                } else {
                    $this->flash->set('danger', 'users_email_notFound');
                }
            } else {
                $errors = $validator->getErrors();
                $this->flash->set('danger', 'form_multi_errors');
            }
        }

        $this->turbolinksLocation($this->url('auth.forgot'));
        PageManager::setTitle('Mot de passe oublié');
        $this->view('frontend/users/account/forgot', compact('input', 'errors'));
    }

    public function register(): void
    {
        $input = $this->request->input();

        if ($this->auth->getUser()) {
            $this->flash->set('warning', 'users_already_connected');
            $this->redirect();
        } else {
            if ($this->request->is('post')) {
                $validator = $this->container->get(Validator::class);
                $validator->validate($input->toArray(), UsersValidator::getValidationRules());

                if ($validator->isValid()) {
                    $isUniqueName = $this->users->isUniqueWith('name', $input->get('name'));
                    $isUniqueEmail = $this->users->isUniqueWith('email', $input->get('email'));

                    if ($isUniqueName && $isUniqueEmail) {
                        $name = $input->get('name');
                        $slug = StringHelper::slugify($name);
                        $email = $input->get('email');
                        $confirmation_token = StringHelper::setToken(60);
                        $password = StringHelper::hashPassword($input->get('password'));
                        $this->users->create(compact('name', 'slug', 'email', 'password', 'confirmation_token'));

                        $link = SITE_NAME . $this->url('auth.confirmation', ['token' => $confirmation_token]);
                        $this->emitter->emit(UserRegisterEvent::class, [
                            'link' => $link,
                            'email' => $input->get('email')
                        ]);
                        $this->flash->success('form_registration_submitted');
                        $this->route('auth.login');
                    } else {
                        $errors['email'] = (!$isUniqueName) ? [$this->flash->msg['users_email_used']] : null;
                        $errors['name'] =  (!$isUniqueEmail) ? [$this->flash->msg['users_username_used']] : null;
                        $this->flash->error('form_multi_errors');
                    }
                } else {
                    $errors = $validator->getErrors();
                    $this->flash->error('form_multi_errors');
                }
            }

            $this->turbolinksLocation($this->url('auth.register'));
            PageManager::setTitle("Inscription");
            $this->view('frontend/users/sign', compact('input', 'errors'));
        }
    }

    public function login(): void
    {
        $this->auth->cookieConnect();
        $user = $this->auth->getUser();
        $idErrors = [
            'name' => [$this->flash->msg['users_bad_identifier']],
            'password' =>  [$this->flash->msg['users_bad_identifier']]
        ];

        if ($user) {
            $this->flash->set('warning', 'users_already_connected');
            $this->redirect();
        } else {
            if ($this->request->is('post')) {
                $input = $this->request->input();
                $validator = $this->container->get(Validator::class);
                $validator->validate($_POST, UsersValidator::getLoginValidationRules());

                if ($validator->isValid()) {
                    $name = $input->get('name');
                    $password = $input->get('password');

                    /** @var UsersEntity */
                    $user = $this->users->findWithEmailOrName($name);
                    if ($user) {
                        if (password_verify($password, $user->password)) {
                            if ($user->confirmedAt !== null) {
                                $this->auth->connect($user);
                                $this->auth->remember($user->id);
                                $this->route('users.profile', ['slug' => $user->slug]);
                            } else {
                                $this->flash->error('users_not_confirmed');
                            }
                        } else {
                            $errors = $idErrors;
                            $this->flash->error('users_bad_identifier');
                        }
                    } else {
                        $errors = $idErrors;
                        $this->flash->error('users_bad_identifier');
                    }
                } else {
                    $errors = $validator->getErrors();
                    $this->flash->error('form_multi_errors');
                }
            }

            $this->turbolinksLocation($this->url('auth.login'));
            PageManager::setTitle('Connexion');
            $this->view('frontend/users/login', compact('input', 'errors'));
        }
    }

    public function logout(): void
    {
        if ($this->request->is('post')) {
            $this->cookie->delete(COOKIE_REMEMBER_KEY);
            $this->session->delete(AUTH_KEY);
            $this->session->delete(TOKEN_KEY);
            $this->flash->set('success', 'users_logout_success');
            $this->route('auth.login');
        }
    }
}
