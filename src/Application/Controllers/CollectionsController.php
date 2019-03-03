<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */


namespace Application\Controllers;

use Application\Entities\PostsEntity;
use Application\Managers\PageManager;
use Application\Repositories\CollectionsRepository;
use Application\Repositories\PostsRepository;
use Psr\Container\ContainerInterface;

/**
 * Class CollectionsController
 * @package Application\Controllers
 */
class CollectionsController extends Controller
{

    /**
     * @var CollectionsRepository|mixed
     */
    private $collections;

    /**
     * @var PostsRepository|mixed
     */
    private $posts;

    /**
     * CollectionsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->collections = $container->get(CollectionsRepository::class);
        $this->posts = $container->get(PostsRepository::class);
    }


    public function index()
    {
        $collections = $this->collections->get(8);

        foreach ($collections as $collection) {

            /** @var PostsEntity $thumb */
            $thumb = $this->posts->findWith('collections_id', $collection->id)[0];
            $collectionsThumbs[$collection->id] =
                (is_null($thumb)) ? "/imgs/default.jpeg" : $thumb->getSmallThumb();
        }

        foreach ($collections as $collection) {
            $collectionsCount[$collection->id] = $this->posts->countWith('collections_id', $collection->id);
        }

        $this->turbolinksLocation($this->url('collections'));
        PageManager::setTitle('Les Collections');
        PageManager::setDescription(
            "Rétrouvez facilement une photo en cliquant sur une collection"
        );
        $this->view("frontend/collections/index", compact('collections', 'collectionsCount', 'collectionsThumbs'));
    }

    /**
     * @param string $slug
     * @param $id
     */
    public function show(string $slug, $id)
    {
        $collection = $this->collections->find(intval($id));

        if ($collection) {
            /** @var PostsEntity[] $posts */
            $posts = $this->posts->findWith('collections_id', $collection->id);

            $this->turbolinksLocation($this->url('collections.show', compact('id', 'slug')));
            PageManager::setTitle($collection->name);
            PageManager::setDescription($collection->description);
            PageManager::setImage($posts[0]->getSmallThumb());
            $this->view('frontend/collections/show', compact('collection', 'posts'));
        } else {
            $this->notFound();
        }
    }
}