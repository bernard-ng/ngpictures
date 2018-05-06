<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssController extends Controller
{
 
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('blog');
    }

    public function index()
    {
        if ($this->blog->last()) {
            $posts = $this->blog->latest(0, 20);
            $feed = new Feed();
            $channel = new Channel();
            $channel->title('Ngpictures feed')
                ->description('Galerie, Entreprise d\'art photographique et mini résaux social où vous pouvez voir et partager vos propres photos')
                ->url(SITE_NAME)
                ->feedUrl(SITE_NAME."/rss")
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
                    ->url(SITE_NAME."/{$post->url}")
                    ->author("Bernard Ng")
                    ->pubDate(strtotime(date("D, d M Y H:i:s T", strtotime($post->date_created))))
                    ->guid(SITE_NAME."/{$post->url}", true)
                    ->preferCdata(true)
                    ->appendTo($channel);
            }

            $this->app::turbolinksLocation("/feed");
            header("Content-type: application/rss+xml");
            require WEBROOT."/feed.xml";
            exit();
        } else {
            $this->flash->set('info', $this->msg['rss_empty']);
            $this->app::redirect(true);
        }
    }
}
