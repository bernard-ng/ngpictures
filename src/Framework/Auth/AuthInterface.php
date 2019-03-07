<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Framework\Auth;

/**
 * describe how the authentication should work
 * Interface AuthInterface
 * @package Framework\Auth
 */
interface AuthInterface
{

    public function getUser(): ?User;
}
