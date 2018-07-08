<?php
namespace Ngpictures\Controllers;

use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use Suin\RSSWriter\Channel;
use Psr\Container\ContainerInterface;

class RssController extends Controller
{

    public function index()
    {
        $this->loadModel('blog');
        if ($this->blog->last()) {
            $posts = $this->blog->latest(0, 10);
            $feed = new Feed();
            $channel = new Channel();
            $channel->title('Ngpictures feed')
                ->description($this->container->get('site.description'))
                ->url(SITE_NAME)
                ->feedUrl(SITE_NAME."/feed")
                ->language('fr-FR')
                ->copyright("Copyright ". date('Y') . " Bernard Ng")
                ->pubDate(strtotime('Tue, 23 May 2018 19:50:37 +0900'))
                ->lastBuildDate(strtotime(date("D, d M Y H:i:s T", strtotime($posts[0]->date_created))))
                ->ttl(60)
                ->appendTo($feed);

            foreach ($posts as $post) {
                (new Item())
                    ->title($post->title)
                    ->description($post->snipet)
                    ->contentEncoded($post->snipet)
                    ->url(SITE_NAME."{$post->url}")
                    ->author("Bernard Ng")
                    ->pubDate(strtotime(date("D, d M Y H:i:s T", strtotime($post->date_created))))
                    ->guid(SITE_NAME."{$post->url}", true)
                    ->preferCdata(true)
                    ->appendTo($channel);
            }

            $this->turbolinksLocation("/feed");
            header("Content-type: application/xml");
            echo $feed;
            exit();
        } else {
            $this->flash->set('info', $this->flash->msg['rss_empty']);
            $this->redirect(true);
        }
    }
}
