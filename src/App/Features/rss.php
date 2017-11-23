<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
	<channel>
		<title>Ngpictures</title>
		<description>Ceci est notre le flux rss de notre site</description>
		<lastBuildDate><?= date(DATE_RSS, strtotime($last)) ?></lastBuildDate>
		<link>http://ngpictures.dev</link>
		<?php foreach($articles as $article) : ?>
			<item>
				<title><?= $article->title ?></title>
				<description><?= $article->text ?></description>
				<pubDate><?= date(DATE_RSS, strtotime($article->date_created)) ?></pubDate>
				<link><?= $article->url ?></link>
				<image>
					<url><?= $article->thumbUrl ?></url>
					<link><?= $article->url ?></link>
				</image>
			</item>
		<?php endforeach; ?>
	</channel>
</rss>