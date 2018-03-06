<?php
namespace Ngpictures\Controllers;

class DownloadController extends Controller
{

    /**
    * les chemain dans lequel se trouve les fichier
    * telechargable.
    */
    private static $path = [
        1 => UPLOAD."/posts/",
        UPLOAD."/gallery/",
        UPLOAD."/blog/",
        UPLOAD."/client/"
    ];


    /**
    * permet de telecharger un fichier a partir de son type et de son nom, c'est
    * specifique a notre application. on envoit des headers particulier pour forcer
    * le telechargement.
     * @param int $type
     * @param string $file_name
    */
    public function index(int $type, string $file_name, $namespace = null)
    {
        if (isset($type, $file_name) && !empty($type) && !empty($file_name)) {
            $type = intval($type);
            $file_name = $this->str::escape($file_name);

            if ($namespace !== null) {
                $file = self::$path[$type].$namespace.$filename;
            } else {
                $file = self::$path[$type].$file_name;
            }

            if (file_exists($file)) {
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: Binary');
                header('Content-Disposition: attachement; filename="'.basename($file).'"');
                echo readfile($file);
                exit();
            } else {
                $this->flash->set('danger', $this->msg['files_not_found']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['files_download_failed']);
            $this->app::redirect(true);
        }
    }



    public function show(int $type, string $file_name, $namespace = null)
    {
        $type = intval($type);
            $file_name = $this->str::escape($file_name);

            if ($namespace !== null) {
                $file = self::$path[$type].$namespace.$filename;
            } else {
                $file = self::$path[$type].$file_name;
            }

            $this->pageManager::setName("Télécharger");
            $this->setLayout("posts/default");
            $this->viewRender("front_end/others/download");
        }
}
