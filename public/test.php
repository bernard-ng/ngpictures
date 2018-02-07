<?php

use Ng\Core\Managers\SitemapManager;
require dirname(__DIR__)."/src/Core/Managers/SitemapManager.php";

$sitename = "http://127.1.1.1/";

$sitemap = new SitemapManager($sitename);

// ADDING URL TO SITEMAPS.XML
$sitemap->addUrl("{$sitename}",                date('c'),  'daily',    '1');
$sitemap->addUrl("{$sitename}/community",          date('c'),  'daily',    '0.5');
$sitemap->addUrl("{$sitename}/gallery",          date('c'),  'daily');
$sitemap->addUrl("{$sitename}/blog",          date('c'));

// CREATING AND SUBMIT SITEMAPS.XML
$sitemap->createSitemap();
$sitemap->writeSitemap();
$sitemap->updateRobots();
$sitemap->submitSitemap();