<?php
namespace Ngpictures\Controllers;

use Ngpictures\Managers\API\NgpicturesAPI;
use Ngpictures\Exception\APIControllerException;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class APIController extends Controller
{
    
    private $clinet_app = null;

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);

        if (isset($_GET['app_key'], $_GET['secret_key']) && !empty($_GET['app_key'] && !empty($_GET['app_key']))) {
            $app_key = $this->str::escape($_GET['app_key']);
            $secret_key = $this->str::escape($_GET['secret_key']);
            $app = new NgpicturesAPI($app_key, $secret_key);

            if ($app->isValid()) {
                $this->client_app = $app;
            } else {
                throw new APIControllerException("Votre les clefs de votre application ne sont pas valide");
            }
        } else {
            throw new APIControllerException("Error Processing Request");
        }
    }

    public function upload()
    {
        if ($app !== null) {
            $file = new Collection($_FILES);

            if (!empty($_FILES)) {
                if (empty($this->str::escape($post->file('thumb.name')))) {
                    $name = strtolower(uniqid("ngpictures-"));
                } else {
                    $name = $this->str::escape("npgictures_".$post->file('thumb.name'));
                }

                if (!empty($file->get('thumb'))) {
                    $this->clientGallery->create(compact('name'));
                    $last_id = $this->gallery->lastInsertId();
                    $isUploaded = Image::upload($file, 'clientGallery', "{$name}-{$last_id}", 'ratio');

                    if ($isUploaded) {
                        Image::upload($file, 'clientGallery-thumb', "{$name}-{$last_id}", 'small');

                        $this->ClientGallery->update($last_id, ["thumb" => "{$name}-{$last_id}.jpg"]);
                        Ngpictures::redirect(true);
                    } else {
                        throw new APIControllerExecption("Votre image n'a pas été upload");
                    }
                } else {
                    throw new APIControllerExecption("Aucune Image Séléctionner");
                }
            }
            Ngpictures::redirect(true);
        } else {
            throw new APIControllerException("Error Processing Request");
        }
    }



    public function download(string $image_name)
    {
        if ($this->client_app !== null) {
            $downloadManager = Ngpictures::getInstance()->getController("download");
            $downloadManager->index(4, "{$image_name}.jpg", $this->client_app->namespace);
            $this->app::redirect(true);
        } else {
            throw new APIControllerException("Error Processing Request");
        }
    }


    public function get(string $image_name): string
    {
        if ($this->client_app !== null) {
            $filename = UPLOAD."/client/{$app->namespace}/{$image_name}.jpg";
            if (file_exists($filename)) {
                return $filename;
            }
            throw new APIControllerException("L'image n'existe plus ou pas");
        } else {
            throw new APIControllerException("Error Processing Request");
        }
    }
}
