<?php
namespace Ngpictures\Controllers\Admin;


use DirectoryIterator;
use Exception;
use Ng\Core\Managers\Collection;
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
