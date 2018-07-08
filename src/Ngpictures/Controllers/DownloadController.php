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
        if (ini_get('zlib.output_compression')) {
            init_set('zlib.output_compression', 'off');
        }

        switch (strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
            case 'pdf':
                $mine = 'application/pdf';
                break;
            case 'zip':
                $mine = 'application/zip';
                break;
            case 'jpg' || 'jpeg':
                $mine = 'image/jpg';
                break;
            default:
                $mine = 'application/force-download';
                break;
        }

        header('Pragma: public');
        header('Expires : 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', filemtime($file)));
        header("Cache-Control: private", false);
        header('Content-Type: '.$mine);
        header('Content-Disposition: attachement; filename="'.basename($file).'"');
        header('Content-Transfer-Encoding: Binary');
        header('Content-Length: '.filesize($file));
        header('Connection: close');
        echo readfile($file);
        exit();
    }
}
