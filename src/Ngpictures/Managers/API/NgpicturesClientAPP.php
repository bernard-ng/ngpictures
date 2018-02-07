<?php
namespace Ngpictures\Managers\API;

class NgpicturesClientAPI
{
    

    private $app_key;
    private $app_secret;
    private $app_namespace;


    public function __construct($app_key, $app_secret)
    {
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;

        $model = Ngpictures::getInstance()->getModel("client_applications");
        $app = $model->findWith("app_key", $this->app_key);

        if ($app) {
            $this->app_namespace = $app->namespace;
        } else {
            throw new ApplicationNotFoundException("Aucune Application matched");
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
