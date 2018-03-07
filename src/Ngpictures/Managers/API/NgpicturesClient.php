<?php
namespace Ngpictures\Managers\API;

use Ngpictures\Ngpictures;

class NgpicturesClient
{
    private $app_key;
    private $app_secret;
    private $app_namespace;


    public function __construct(string $app_key, string $app_secret)
    {
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;

        $model = Ngpictures::getInstance()->getModel("api");
        $app = $model->findWith("app_key", $this->app_key);

        if ($app) {
            $this->app_namespace = $app->namespace;
        } else {
            throw new \RuntimeException("Aucune Application matched");
        }
    }


    public function getKey(): string
    {
        return $this->app_key;
    }


    public function getSecret(): string
    {
        return $this->app_secret;
    }


    public function getNamespace(): string
    {
        return $this->app_namespace;
    }
}
