<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Repositories\PostsRepository;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use Suin\RSSWriter\Channel;

/**
 * Class RssController
 * @package Application\Controllers
 */
class RssController extends Controller
{

    public function index()
    {
        $posts = $this->container->get(PostsRepository::class)->latest(10);
        $feed = new Feed();
        $channel = new Channel();

        $channel->title('Ngpictures feed')
            ->description($this->container->get('site.description'))
            ->url(SITE_NAME)
            ->feedUrl(SITE_NAME."/feed")
            ->language('fr-FR')
            ->copyright("Copyright ". date('Y') . " Ngpictures")
            ->pubDate(strtotime('Tue, 23 May 2018 19:50:37 +0900'))
            ->lastBuildDate(strtotime(date("D, d M Y H:i:s T", strtotime($posts[0]->createdAt))))
            ->ttl(60)
            ->appendTo($feed);

        foreach ($posts as $post) {
            (new Item())
                ->title($post->name)
                ->description($post->description)
                ->contentEncoded($post->description)
                ->url(SITE_NAME . $this->url("posts.show", ['id' => $post->id, 'slug' => $post->slug]))
                ->pubDate(strtotime(date("D, d M Y H:i:s T", strtotime($post->date_created))))
                ->guid(SITE_NAME . $this->url("posts.show", ['id' => $post->id, 'slug' => $post->slug]), true)
                ->preferCdata(true)
                ->appendTo($channel);
        }

        $this->turbolinksLocation("/feed");
        header("Content-type: application/xml");
        echo $feed;
        exit();
    }
}
