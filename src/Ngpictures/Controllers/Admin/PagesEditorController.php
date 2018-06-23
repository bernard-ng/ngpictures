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
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }

        if (isset($_POST) && !empty($_POST)) {
            if (isset($_FILES) && !empty($_FILES)) {
                $file = new Collection($_FILES);
                $post = new Collection($_POST);

                $isUploaded = ImageManager::updateStatic($file, $post->get('thumb-for'));
                if ($isUploaded) {
                    $this->flash->set('success', $this->msg['success']);
                    $this->app::redirect(true);
                } else {
                    $this->flash->set('danger', $this->msg['files_not_uploaded']);
                    $this->app::redirect(true);
                }

            } else {
                $this->flash->set('danger', $this->msg['post_img_required']);
                $this->app::redirect(true);
            }
        }

        $this->app::turbolinksLocation(ADMIN . "/pages");
        $this->pageManager::setName("Adm - Les Pages");
        $this->setLayout('admin/default');
        $this->viewRender("backend/pages/pages", compact('files'));
    }


    /**
     * modifie une page html static
     *
     * @param string $page_name
     * @return void
     */
    public function edit(string $page_name)
    {
        $file_url = APP."/Views/frontend/static/{$page_name}";
        $file_name = $page_name;

        if (is_file($file_url)) {
            $post = new Collection($_POST);
            $file_content = file_get_contents($file_url);

            if (isset($_POST) && !empty($_POST)) {
                $file_content = $post->get('file_content');
                $file = fopen($file_url, 'w');
                fwrite($file, $post->get('file_content'));
                fclose($file);
            }

            $this->setLayout("admin/default");
            $this->pageManager::setName("Adm - Modifier une page");
            $this->viewRender("backend/pages/edit", compact('file_content', 'file_name', 'post'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}
