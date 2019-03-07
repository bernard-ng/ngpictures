<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Managers\PageManager;

/**
 * Class ErrorController
 * @package Application\Controllers
 */
class ErrorController extends Controller
{

    public function e404(): void
    {
        if ($this->request->ajax()) {
            http_response_code(404);
            exit();
        } else {
            http_response_code(404);
            $this->turbolinksLocation('/error/not-found');
            PageManager::setTitle("404 Page Introuvable");
            $this->view("frontend/error/404");
        }
    }

    public function e500(): void
    {
        if ($this->request->ajax()) {
            http_response_code(500);
            exit();
        } else {
            http_response_code(500);
            $this->turbolinksLocation('/error/internal');
            PageManager::setTitle("500 Erreur interne");
            $this->view("frontend/error/500");
        }
    }
}
