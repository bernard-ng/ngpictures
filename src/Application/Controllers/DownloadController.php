<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Repositories\PostsRepository;

/**
 * Class DownloadController
 * @package Application\Controllers
 */
class DownloadController extends Controller
{
    /**
     * @var array
     */
    private static $path = [
        1 => UPLOAD . "/posts/",
        2 => UPLOAD . "/gallery/",
    ];


    /**
     * @param int $id
     */
    public function index($id)
    {
        $posts = $this->container->get(PostsRepository::class);
        $post = $posts->find(intval($id));

        if ($post) {
            $thumb = $post->thumb ?? $post->thumbOld;
            $file = self::$path[$post->type] . $thumb;

            if (file_exists($file)) {
                if (isset($_GET['option']) && !empty($_GET['option'])) {
                    $this->download($file);
                } else {
                    $downloads = (int)$post->downloads + 1;
                    $posts->update($post->id, compact('downloads'));

                    if ($this->request->ajax()) {
                        $post = $posts->find($post->id);
                        echo (int)$post->downloads;
                        exit();
                    }

                    $this->download($file);
                    $this->redirect();
                }
            } else {
                $this->flash->set('danger', 'files_not_found');
                $this->redirect();
            }
        } else {
            $this->flash->set('danger', 'files_download_failed');
            $this->redirect();
        }
    }

    /**
     * @param string $file
     */
    private function download(string $file): void
    {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . basename($file));
        header("Content-Type: image/jpg");
        header("Content-Transfer-Encoding: binary");
        readfile($file);
        exit;
    }
}
