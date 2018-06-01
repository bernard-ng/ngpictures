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
            $file_name  =   $this->str::escape($file_name);
            $file       =   self::$path[$type].$file_name;

            $posts = $this->loadModel($this->getAction($type));
            $post = $posts->findWith('thumb', $file_name);

            if ($post) {
                if (file_exists($file)) {
                    if(isset($_GET['option']) && !empty($_GET['option'])) {
                        $this->download($file);
                    } else {
                        $downloads = (int) $post->downloads + 1;
                        $posts->update($post->id, compact('downloads'));

                        if($this->isAjax()) {
                            $post = $posts->find($post->id);
                            echo (int) $post->downloads;
                            exit();
                        }

                        $this->download($file);
                    }
                } else {
                    ($this->isAjax()) ?
                        $this->ajaxFail($this->msg['files_not_found']) :
                        $this->flash->set('danger', $this->msg['files_not_found']);
                        $this->app::redirect(true);
                }
            } else {
                ($this->isAjax()) ?
                    $this->ajaxFail($this->msg['files_download_failed']) :
                    $this->flash->set('danger', $this->msg['files_download_failed']);
                    $this->app::redirect(true);
            }
        }
    }


    /**
     * telecharge un fichier
     * @param $file
     */
    private function download($file)
    {
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-Disposition: attachement; filename="'.basename($file).'"');
        echo readfile($file);
        exit();
    }
}
