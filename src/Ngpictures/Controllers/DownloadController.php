<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Util\TypesActionTrait;

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
    ];


    use TypesActionTrait;


    /**
    * permet de telecharger un fichier a partir de son type et de son nom, c'est
    * specifique a notre application. on envoit des headers particulier pour forcer
    * le telechargement.
     * si on a l'option once. on telecharge just sans incrementer le compteur
     * @param int $type
     * @param string $file_name
    */
    public function index(int $type, string $file_name)
    {
        if (isset($type, $file_name) && !empty($type) && !empty($file_name)) {
            $type       =   intval($type);
            $file_name  =   $this->str->escape($file_name);
            $file       =   self::$path[$type].$file_name;

            $posts = $this->loadModel($this->getAction($type));
            $post = $posts->findWith('thumb', $file_name);

            if ($post) {
                if (file_exists($file)) {
                    if (isset($_GET['option']) && !empty($_GET['option'])) {
                        $this->download($file);
                    } else {
                        $downloads = (int) $post->downloads + 1;
                        $posts->update($post->id, compact('downloads'));

                        if ($this->isAjax()) {
                            $post = $posts->find($post->id);
                            echo (int) $post->downloads;
                            exit();
                        }

                        $this->download($file);
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['files_not_found']);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['files_download_failed']);
                $this->redirect(true, false);
            }
        }
    }


    /**
     * telecharge un fichier
     * @param $file
     */
    private function download($file)
    {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".basename($file));
        header("Content-Type: image/jpg");
        header("Content-Transfer-Encoding: binary");
        readfile($file);
        exit;
    }
}
