<?php
namespace Ngpictures\Managers\API;

class NgpicturesAPI
{

    /**
     * le client instancier
     *
     * @var NgpicturesClient
     */
    private $client;

    public function __construct(NgpicturesClient $client)
    {
        if ($client instanceof NgpicturesClient) {
            $this->client = $client;
        } else {
            throw \InvalidArgumentException("parametre n'est pas une instance de NgpicturesClient");
        }
    }
}
