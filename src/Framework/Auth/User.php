<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Framework\Auth;

/**
 * authenticated user
 * Interface User
 * @package Framework\Auth
 */
interface User
{

    /**
     * Retrieve the username
     * @return string
     */
    public function getUsername(): string;


    /**
     * Retrieve the roles/rank of the current user
     * @return array
     */
    public function getRoles(): array;
}
