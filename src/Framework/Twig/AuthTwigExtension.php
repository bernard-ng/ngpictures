<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Framework\Twig;


use Application\Auth\DatabaseAuth;

/**
 * Class AuthTwigExtension
 * @package Framework\Twig
 */
class AuthTwigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    /**
     * @var DatabaseAuth
     */
    private $auth;

    /**
     * AuthTwigExtension constructor.
     * @param DatabaseAuth $auth
     */
    public function __construct(DatabaseAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'currentUser' => $this->auth->getUser(),
            'csrf_token' => $this->auth->getToken()
        ];
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('csrf', [$this, 'csrf', ['is_safe' => ['html']]])
        ];
    }

    /**
     * @return string
     */
    public function csrf()
    {
        $token = $this->auth->getToken();
        echo "<input type='hidden' name='csrf_token' value='$token'>";
    }
}
