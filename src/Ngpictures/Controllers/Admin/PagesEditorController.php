<?php
namespace Ngpictures\Controllers\Admin;


use Exception;
use DirectoryIterator;
use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Controllers\AdminController;


class PagesEditorController extends AdminController
{

    /**
     * affiche les page html static
     *
     * @return void
     */
    public function show()
    {
        $path = APP."/Views/frontend/static/";

        try {
            $files = new DirectoryIterator($path);
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }

        if (isset($_POST) && !empty($_POST)) {
            if (isset($_FILES) && !empty($_FILES)) {
                $file = new Collection($_FILES);
                $post = new Collection($_POST);

                $isUploaded = $this->container->get(ImageManager::class)::updateStatic($file, $post->get('thumb-for'));
                if ($isUploaded) {
                    $this->flash->set('success', $this->flash->msg['success'], false);
                    $this->redirect(true, false);
                } else {
                    $this->flash->set('danger', $this->flash->msg['files_not_uploaded'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['post_img_required'], false);
                $this->redirect(true, false);
            }
        }

        $this->turbolinksLocation(ADMIN . "/pages");
        $this->pageManager::setName("Adm - Les Pages");
        $this->view("backend/pages/pages", compact('files'));
    }


    /**
     * modifie une page html static
     *
     * @param string $page_name
     * @return void
     */
    public function edit(string $page_name)
    {
        $file_url   = APP."/Views/frontend/static/{$page_name}";
        $file_name  = $page_name;

        if (is_file($file_url)) {
            $post           = new Collection($_POST);
            $file_content   = file_get_contents($file_url);

            if (isset($_POST) && !empty($_POST)) {
                $file_content   = $post->get('file_content');
                $file           = fopen($file_url, 'w');
                fwrite($file, $post->get('file_content'));
                fclose($file);
            }

            $this->pageManager::setName("Adm - Modifier une page");
            $this->view("backend/pages/edit", compact('file_content', 'file_name', 'post'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }
}
